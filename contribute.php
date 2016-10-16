<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contribution App</title>
    <!--bootstrap css file-->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--custom css file-->
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>  
      <!--header-->
	<?php  // require_once('inc/header.inc.php'); ?>
	
	<?php  
	// on teste s'il est connecte
	if(isset($_SESSION['isConnected']) && $_SESSION['isConnected'] ==true){
	require_once("api/db_access/connection_bd.php");
	require_once("api/contribute/orangeapi.php");
	require_once("api/fonctions.inc.php");
	
     if(isset($_POST['dat']) && !empty($_POST['dat'])){
		if(isset($_POST['firstName']) && !empty($_POST['firstName'])){
			if(isset($_POST['lastName']) && !empty($_POST['lastName'])){
				if(isset($_POST['number']) && !empty($_POST['number'])){
					if(isset($_POST['location']) && !empty($_POST['location'])){
						if(isset($_POST['amount']) && !empty($_POST['amount'])){
							
							$date = htmlspecialchars($_POST['dat']);
							$firsName = htmlspecialchars($_POST['firstName']);
							$lastName = htmlspecialchars($_POST['lastName']);
							$number = htmlspecialchars($_POST['number']);
							$locationID = htmlspecialchars($_POST['location']);
							$amount = htmlspecialchars($_POST['amount']);
							
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
								$response = $orangeAPI->sendSms('tel:+'.$number ,'tel:+'.$number,$msg,'eHAG');
								
							if (empty($response['error'])) {
								
								echo 'Contribution enregistree avec succes, 
								le contributeur recevra un message ';
								
							} else {
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

    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#Contribution" data-toggle="tab">Contribution</a></li>
            <li class="nav"><a href="#Contributors-List" data-toggle="tab">Contributors List</a></li>
        </ul>
         <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="Contribution">
                <form class="form-contribute" action="contribute.php" method='POST'>
                    <h2 class="form-contribute-heading">Contribution Froms</h2>

                    <div><span>Date (jj/mm/aaaa):</span>
                        <input type="date" name='dat'  class="form-control" required autofocus>
                    </div>
                    
                    <div><span>Contributor First Name:</span>
                        <input type="text" name='firstName' class="form-control"  required>
                    </div>
                    
                    <div><span>Contributor Last Name:</span>
                        <input type="text" name='lastName' class="form-control"  required>
                    </div>

                    <div><span>Contributor Number:</span>
                        <input type="text" name='number' class="form-control"  required>
                    </div>
                    
                    <div><span>Location:</span>
                        <select name="location" class="form-control">
                            <option value="Pita">Pita</option>
                            <option value="Timbi Touni">Timbi Touni</option>
                        </select>
                    </div>
                    
                    <div><span>Amount:</span>
                        <input type="number" name='amount' class="form-control"  required>
                    </div>
                            

                    <button class="btn btn-lg btn-cancel" type="reset">Cancel</button>
                    <button class="btn btn-lg btn-success" type="submit">Validate</button>
                </form>
            </div>

            <div class="tab-pane fade" id="Contributors-List">
                <h2 class="list-header">Contributors List</h2>
                <div class="table-responsive">
                    <div class="pull-right">
                        Filter   
                        <input type="search" >
                    </div>
                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th>Date</th>
                        <th>Names</th>
                        <th>Number</th>
                        <th>Amount</th>
                        <th>Receiver</th>
                        </tr>
                    </thead>
					
					<?php 
					
					 try{ 
						   $debut = 0;
						   $fin = 50;
						   $select = $bdd-> prepare('SELECT * FROM  contributors 
													  LIMIT :debut, :fin');
						   $select->bindParam("debut",$debut,PDO::PARAM_INT);
						   $select->bindParam("fin",$fin,PDO::PARAM_INT);
						   $select->execute();
						   
							if($select->rowCount()>0){
							 echo " <tbody> ";
							 
							 while($tmp = $select ->fetch()){
								 echo"<tr>
									<td>$tmp[Date_Contributors]</td>
									<td>$tmp[First_Name] $tmp[Last_Name]</td>
									<td>$tmp[Number]</td>
									<td>$tmp[Amount]</td>
									<td>$tmp[Receiver]</td>
								</tr> ";
								 
							    }
							echo"</tbody> ";
								
							
						  
						}else{
							echo"aucun contributeur pour le moment ";
							}
						}catch(Exception $e){ 
							die('Erreur : '.$e->getMessage());
						  }
					?>
					</table>
                </div>
                <div class="pull-right">
                    <a href="#"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span></a>
                    <a href="#"><span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span></a>
                </div>
            </div>
        </div>
     
    </div>
	<?php
	} else {
	   echo"vous devez etre connecte pour acceder a cette page<br/>";	
	   header('location:index.php');
	}
     ?>

     <!--footer-->
	 <?php
     require_once('inc/footer.inc.php');
     ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>