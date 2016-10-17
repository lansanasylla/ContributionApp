<?php session_start();
$_SESSION['isConnected'] = false;
 ?>
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
<?php
     require_once('inc/header.inc.php');
 ?>
 
 <?php
     
	 require_once("api/db_access/connection_bd.php");
 
     if((isset($_POST['login']) && !empty($_POST['login'])) && 
		(isset($_POST['passwd']) && !empty($_POST['passwd']))){
    
		$response = "";
	
 
		$login = htmlspecialchars($_POST['login']);
		$pass = htmlspecialchars($_POST['passwd']);
	
  try{ 
  
	$requete = $bdd->prepare('SELECT * FROM login 
								WHERE login LIKE :login AND passwd LIKE :pass
								LIMIT 1');
	$requete->execute(array('login'=>$login,
							'pass'=>$pass,
					));
		
	if($requete->rowCount() > 0){
		//c'est bon 
		$_SESSION['isConnected'] = true;
		
		header('location:contribute.php');
		
		}else {
		//login ou mot de passe errone
		$_SESSION['isConnected'] = false;
		}
	
	
	 }catch(Exception $e){ 
	      die('Erreur : '.$e->getMessage());
		  echo json_encode ($response);
	  }
	
 }
 ?>

    <div class="container" style='padding-top:30px;'>
	<?php	
	// on teste s'il n'est pas connect avant d'afficher le formulaire
	if(!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] ==false){
		
	?>
        <form class="form-signin" action='index.php' method='POST'>
            <h2 class="form-signin-heading">Please sign in</h2>
            <input type="text" name='login' class="form-control" placeholder="Login" required autofocus>
            <input type="password" name='passwd' class="form-control" placeholder="Password" required>
            <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
            </div>
            <button class="btn btn-lg btn-success btn-block" type="submit">Sign In</button>
        </form>
	<?php }
        else {
			echo "vous etes deja connecter mon amie !";
			header('location:contribute.php');
		}
	?>
    </div>
	<?php
     require_once('inc/footer.inc.php');
     ?>
</body>
</html>