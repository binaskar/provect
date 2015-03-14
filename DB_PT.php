<?php
	require_once __DIR__ .'/Real/db_connect.php';
	require __DIR__  .'/panTomken.php';

	$alg = new panTomken();
	$db =  new DB_CONNECT();
	
	$startID=300.000;
	$endID=600.000;
	$response = array();
	$query = "SELECT v11 FROM HPv2 WHERE Time > '$startID' AND Time < '$endID' ";
	
	
	$result = mysql_query($query);
		//echo "working";
		if($result){
		//echo(" Result");
			
			//$dataArray = array();
			
			while($row = mysql_fetch_row($result))
			
			$response[] = $row[0]; 
			echo("getting Response");
		}
	
	if($ecgData = fopen("ecgDataTPRF.text", "w")){
		
		for($i = 0; $i<count($response); $i++){
			$timeAverage=0;
			$bandPassed=0;
			$differentiated=0;
			$signal = $response[$i];
			
			//$differentiated = call_user_method("derivation",$alg,$signal); 
			$bandPassed = call_user_method("twoPoleRecursive",$alg,$signal);
			//$bandPassed = call_user_method("highPassFilter",$alg,$bandPassed);
			//$bandPassed = call_user_method("derivation",$alg,$bandPassed);
			//$bandPassed = call_user_method("movingWindowIntegral",$alg,$bandPassed); 
			//$timeAverage = call_user_method("derivation",$alg,$bandPassed);
			//$timeAverage = call_user_method("power2",$alg,$timeAverage);
			//$timeAverage = call_user_method("movingWindowIntegral",$alg,$timeAverage);
			$text = "$differentiated\t$bandPassed\t$timeAverage \n";
			echo("Writing $text\n");
			fwrite($ecgData, $text);
			
		}	
	}
	else{
		
		echo("Couldn't Open File");
	}
	
?>