<?php

require_once("../db_access/connection_bd.php");
 
$_POST['requete'] = array (
	'login'=> 'lansana',
	'passwd'=> 'lansana123'
);

  
 
  if(isset($_POST['requete']) && !empty($_POST['requete'])){
    
	$response = "";
	
	//pour l'exemple on encode et on decoude apres
	 $_POST['requete'] = json_encode($_POST['requete']);
	 $requete = json_decode($_POST['requete'],true);
 
	$login = $requete['login'];
	$pass = $requete['passwd'];
	
  try{ 
  
	$requete = $bdd->prepare('SELECT * FROM login 
								WHERE login LIKE :login AND passwd LIKE :pass
								LIMIT 1');
	$requete->execute(array('login'=>$login,
							'pass'=>$pass,
					));
		
	if($requete->rowCount() > 0){
		//c'est bon 
		$response = array ('code' => '200',
		                'message' => 'connection effectue avec succes'
		);
		}else {
		//login ou mot de passe errone
		$response = array ('code' => '406',
		                   'message' => 'mot de passe ou login invalide'
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
	
 }


?>
