<?php

$_POST['requete'] = array (
	'date'=> '16/12/2016',
	'firstName'=> 'lansana',
	'lastName'=> 'sylla',
	'number' => '224620259513',
	'locationID' => '001',
	'amount'=> '500000'
);

 require_once("../db_access/connection_bd.php");
 $response = "";
  if(isset($_POST['requete']) && !empty($_POST['requete'])){
    
   
   try{ 
       $debut = 0;
	   $fin = 50;
       $select = $bdd-> prepare('SELECT * FROM  contributors 
								LIMIT :debut, :fin');
	   $select->bindParam("debut",$debut,PDO::PARAM_INT);
	   $select->bindParam("fin",$fin,PDO::PARAM_INT);
	   $select->execute();
	   
		if($select->rowCount()>0){
		  $res = array ('code' => '200','response'=> array());
			$i = 0;
		//while($tmp = $select ->fetch()){
	    //will come back to finalise this one 
			$tmp = $select ->fetch();
		for($i= 0; $i< count($tmp);$i++){
		     $res['response'].$i = array (
					'date'=> $tmp['Date_Contributors'],
					'firstName'=> $tmp['First_Name'],
					'lastName'=> $tmp['Last_Name'],
					'number' => $tmp['Number'],
					'amount'=> $tmp['Amount'],
					'receiver'=> $tmp['Receiver']
			);
			 $i++;
			 
			echo "$tmp[Number] <br/>";
		}
		print_r($res);
	  //on envoi maintenenant les données
	  
	  $response = json_encode($res);	
      echo $response ;
	  
	  
	  
	}else{
		$res = array ('code' => '202',
			              'message'=>'aucune information dans la base de donnee'
					);
		echo json_encode ($res);
	}
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
