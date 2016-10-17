<?php
require_once ('../fonctions.inc.php');
require_once ('orangeAPI.php');

$_POST['requete'] = array (
	'date'=> '16/12/2016',
	'firstName'=> 'lansana',
	'lastName'=> 'sylla',
	'number' => '620259513',
	'locationID' => '001',
	'amount'=> '500000'
);

 require_once("../db_access/connection_bd.php");

  if(isset($_POST['requete']) && !empty($_POST['requete'])){
    
	//on encode et on decode pour l'exemple
	$_POST['requete'] = json_encode($_POST['requete']);
	$requete = json_decode($_POST['requete'],true);
	
	$response = "";
	
	$date = $requete['date'];
	$firsName = $requete['firstName'];
	$lastName = $requete['lastName'];
	$number = $requete['number'];
	$locationID = $requete['locationID'];
	$amount = $requete['amount'];
	
	//print_r($requete);
	
   $number = formatTelephoneNumber($number);
  // echo ( "numero formate " .$number);
	
   try{ 
	    $insert = $bdd->prepare('INSERT INTO Contributors (Date_Contributors,First_Name,Last_Name,Number,Amount,Receiver) 
							     VALUES(:dat, :first_name,:last_name,:number,:amount,:receiver)
							    ');
         $insert->execute(array('dat' =>$date,
						       'first_name' => $firsName,
						       'last_name' => $lastName,
						       'number' => $number,
						       'amount' => $amount,
						       'receiver' => $locationID	   
					));
					
		
     //envoi du msg
	    $msg ="Bonjour " . $firsName .
		" votre dons de ". $amount .
		" a bien ete recu, Merci pour votre generosite ";
		
		$orangeAPI = new orangeAPI();
		$response = $orangeAPI->sendSms(
			// expediteur
			'tel:+'.$number ,
			// receiver
			'tel:+'.$number,
			$msg,
			'eHAG'
		);

	if (empty($response['error'])) {
		
	 $response = array ('code' => '200',
		                'message' => 'Contribution enregistree avec succes, le contributeur recevra un message :'
					);
	} else {
		$response = array ('code' => '500',
		                'message' => 'Contribution enregistree avec succes,mais le message n\'a pas ete envoye :'
		);
	}		
									
	echo json_encode ($response);
		
	
	  }catch(Exception $e){ 
	      die('Erreur : '.$e->getMessage());
		  
		  $response = array ('code' => '501',
		                    'message' => 'Une erreur avec la base de donnees :'
						    );
		  echo json_encode ($response);
	  }	

 }else {
	$response = array ('code' => '403',
		                 'message' => 'vous ne devrez pas acceder a cette page directement !'
						 );
	echo json_encode ($response);
 }


?>
