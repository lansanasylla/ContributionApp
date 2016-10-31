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
<body ng-app="donatorApp">  
      <!--header-->
	<?php
      require_once('inc/header.inc.php');
    ?>
	
	<?php  
	// on teste s'il est connecte
	if(isset($_SESSION['isConnected']) && $_SESSION['isConnected'] ==true){
	require_once("api/db_access/connection_bd.php");
	require_once("api/contribute/orangeapi.php");
	require_once("api/fonctions.inc.php");
    //require_once("inc/smsqueens.inc.php");
	?>

    <div class="container">
        <ul id="navTab" class="nav nav-tabs">
            <li class="nav active"><a href="#Contribution" data-toggle="tab">Contribution</a></li>
            <li class="nav"><a href="#Contributors-List" data-toggle="tab">Contributors List</a></li>
        </ul>
         <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="Contribution">
                <?php
					require_once('inc/submitForm.inc.php');
                    require_once("inc/retrieveForm.inc.php");
				?>
            </div>

            <div class="tab-pane fade" id="Contributors-List">
                <?php
					require_once('inc/listForm.inc.php');
				?>
            </div>
        </div>
    </div>
	<?php
	} else {
	   echo"Vous devez etre connecte pour acceder a cette page<br/>";	
	   header('location:index.php');
	}
     ?>

     <!--footer-->
	 <?php
     require_once('inc/footer.inc.php');
     ?>
    <script src="js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/angular.min.js"></script>
	<script src="js/App.js"></script>
</body>
</html>