<?php
 if(isset($_POST['dat']) && !empty($_POST['dat'])){
		if(isset($_POST['firstName']) && !empty($_POST['firstName'])){
			if(isset($_POST['lastName']) && !empty($_POST['lastName'])){
				if(isset($_POST['numbers']) && !empty($_POST['numbers'])){
					if(isset($_POST['location']) && !empty($_POST['location'])){
						if(isset($_POST['amount']) && !empty($_POST['amount'])){
							
							$date = htmlspecialchars($_POST['dat']);
							$firsName = htmlspecialchars($_POST['firstName']);
							$lastName = htmlspecialchars($_POST['lastName']);
							$numbers = htmlspecialchars($_POST['numbers']);
							$locationID = htmlspecialchars($_POST['location']);
							$amount = htmlspecialchars($_POST['amount']);
							
							$numbers = formatTelephoneNumber($numbers);
							// echo ( "numero formate " .$number);
							
							try{
								$insert = $bdd->prepare('INSERT INTO contributors (Date_Contributors,First_Name,Last_Name,Numbers,Amount,Receiver,collector) 
														 VALUES(:dat, :first_name,:last_name,:numbers,:amount,:receiver,:collector)
														');
								 $insert->execute(array('dat' =>$date,
													   'first_name' => $firsName,
													   'last_name' => $lastName,
													   'numbers' => $numbers,
													   'amount' => $amount,
													   'receiver' => $locationID,
													   'collector' => $_SESSION['login']	   
											));
											
								
							   //envoi du msg
								$msg ="Bonjour " . $firsName .
								", votre contribution de ". $amount ." a bien été reçu pour le compte de ".$locationID.
								", Merci pour votre appui.";
								
								$config = array(
									'token' => '7Bfodsjoi4CKYcyzoALSBUgMGgSP'
								);

								$orangeAPI = new orangeAPI($config);
								$response = $orangeAPI->sendSms('tel:'.$firsName ,'tel:+'.$numbers,$msg,'eHAG');
								

							if (empty($response['error'])) {
								echo 'Contribution enregistree avec succes, 
								le contributeur recevra un message ';
								
							} else {
									$smsqueens = $bdd->prepare('INSERT INTO MessaginQueens (first_name,numbers,amount,	location) 
															VALUES(:first_name,:numbers,:amount,:location)
															');
									$smsqueens->execute(array(
													'first_name' => $firsName,
													'numbers' => $numbers,
													'amount' => $amount,
													'location' => $locationID,	   
												));
							       echo'Contribution enregistree avec succes,mais le message n\'a pas ete envoye :';
							}	
						}catch(Exception $e){ 
							  die('Erreur : '.$e->getMessage());
						 }
							
							
						} else { echo"amount n'est pas fourni ";}
					}else { echo"location n'est pas fourni ";}
				}else { echo"number n'est pas fourni ";}
			}else { echo"last name n'est pas fourni ";}
		}else { echo"first name n'est pas fourni ";}
	 }else { echo"date n'est pas fourni ";} 
?>