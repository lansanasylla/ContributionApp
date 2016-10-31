//envoi du msg
<?php
    try{
        $smsPending = $bdd->prepare('SELECT * FROM MessaginQueens');
        $smsPending->execute();

        $config = array(
            'token' => '7Bfodsjoi4CKYcyzoALSBUgMGgSP'
        );

        $orangeAPI2 = new orangeAPI($config);

         while($tmp = $smsPending ->fetch()){
            $msg ="Bonjour " . $tmp['first_name'] .
            ", votre contribution de ". $tmp['amount'] ." a bien été reçu pour le compte de ".$tmp['location'].
            ", Merci pour votre appui.";

            $responses = $orangeAPI2->sendSms('tel:'.$tmp['first_name'] ,'tel:+'.$tmp['numbers'],$msg,'eHAG');

             if (empty($responses['error'])) {
                  $smsqueensdel = $bdd->prepare('DELETE FROM MessaginQueens WHERE id=:id');
                  $smsqueensdel->execute(array(
                        'id' => $tmpa['id']	   
                    ));
                    echo 'Contribution enregistree avec succes, 
                    le contributeur recevra un message ';
                    
                }else {
                        echo'Contribution enregistree avec succes,mais le message n\'a pas ete re-envoye :';
                }
            }
        
        ;

    }catch(Exception $e){ 
        die('Erreur : '.$e->getMessage());
    }
?>