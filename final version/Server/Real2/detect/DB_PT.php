<?php
	require_once __DIR__ . '/db_connect.php';
	require_once __DIR__  .'/panTomken.php';

	$alg = new panTomken();
	$db =  new DB_CONNECT();
	
	$startID=300.000;
	$endID=600.000;
	$response = array();
	$query = "SELECT v11 FROM hpv2 WHERE Time > '$startID' AND Time < '$endID' ";
	
	
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
			$two=call_user_method("twoPoleRecursive",$alg,$signal);
			$dX = call_user_method("derivation",$alg,$two); 
			$low = call_user_method("lowPassFilter",$alg,$two);
			$dY = call_user_method("highPassFilter",$alg,$low);
			$squre=$dY*$dY;
			$timeAverage = call_user_method("movingWindowIntegral",$alg,$squre);
			 
			
			
			//$bandPassed = call_user_method("twoPoleRecursive",$alg,$signal);
			//$bandPassed = call_user_method("highPassFilter",$alg,$bandPassed);
			//$bandPassed = call_user_method("derivation",$alg,$bandPassed);
			//$bandPassed = call_user_method("movingWindowIntegral",$alg,$bandPassed); 
			//$timeAverage = call_user_method("derivation",$alg,$bandPassed);
			//$timeAverage = call_user_method("power2",$alg,$timeAverage);
			//$timeAverage = call_user_method("movingWindowIntegral",$alg,$timeAverage);
			$text = "$signal\t$two\t$dX\t$low\t$dY\t$squre\t$timeAverage \n";
			echo("Writing $text\n");
			fwrite($ecgData, $text);
			
		}	
	}
	else{
		
		echo("Couldn't Open File");
	}
	
?>