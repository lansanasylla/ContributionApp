<?php

	include 'orangeapi.php';
	
	/**
	* @param $value
	* @return mixed
	*/
	function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
		$escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
		$replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
		$result = str_replace($escapers, $replacements, $value);
		return $result;
	}

	if (isset($_POST["btnSubmitSMS"])) {
		//$senderName = 'MyService';
		//$token = 
		//$callbackdata = date("Y-m-dTH:i:s"); //initialize callbackData with current datetime, in order to retrieve it in the SMS DR
		// send SMS with the message to the provided MSISDN
		//$returnedSMS = sendSMS($_POST["address"],$_POST["address"], $_POST["msg"], $_POST["senderName"]);
		
		// write the API response
		//echo '<br/><br/><span STYLE="color: white; font-size: 10pt">';
		//echo 'API Response is HTTP code </span><span STYLE="color: orange; font-size: 10pt"><b>' . $returnedSMS[0] . '</b></span>
		//<span STYLE="color: white; font-size: 10pt"> and Response body is:</span>
		//<span STYLE="color: orange; font-size: 10pt"><br/>'.$returnedSMS[1];
		//echo '</span><hr/>';
		
		//print_r ($returnedSMS);
	
	$config = array(
			'token' => '7Bfodsjoi4CKYcyzoALSBUgMGgSP'
		);

	$orangeAPI = new orangeAPI($config);


	$response = $orangeAPI->sendSms(
		// sender
		'tel:'. $_POST['senderName'] ,
		// receiver
		'tel:'. $_POST['address'],
		// message
		$_POST['msg'],
		'testeur'
	);

	if (empty($response['error'])) {
		echo 'Done!';
	} else {
		echo $response['error'];
	}
		
	}
	
?>


<html>
	<head>
		<title>ORANGE API</title>
		<link rel="stylesheet" type="text/css" media="all" href="index.css?v=0.1" />
	</head>
	<body>
		<br/>
		<table align="center" border="1" cellpadding="20">
		<tr>
		<td valign="top" align="center">
		<h2>sendSMS</h2><br/>
		<form method="POST" id="myform">
        
		<label> MSISDN : <br/>
		    <input type="text" name="address" id="address" maxlength="15" value="<?php if (isset($_POST["address"])){echo $_POST["address"];}else{ echo "+224620259513";}?>" style="text-align: center;" required> <br/>
		</label> <br/><br/>
		<label> SENDER NAME  : <br/>
			<input type="text" name="senderName" id="senderName" maxlength="11" value="<?php if (isset($_POST["senderName"])){echo $_POST["senderName"];}else{ echo "test";}?>" style="text-align: center;" required>
		</label>	
			<br/><br/>
		<label>
			Message:<br/>
			<input type="text" name="msg" id="msg" maxlength="160" value="<?php if (isset($_POST["msg"])){echo $_POST["msg"];}else echo 'message de test'; ?>" style="text-align: center; width: 100%; padding: 2px; margin: 0px;" required>
		</label>	
		<br/><br/>
		<input type="Submit" name="btnSubmitSMS" id="btnSubmitSMS" value="send SMS" >
		</form>
		</td>
		</tr>
		</table>
	</body>
</html>

