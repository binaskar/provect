<?php
	require_once __DIR__ .'/Real/db_connect.php';
	require __DIR__  .'/panTomken.php';

	$alg = new panTomken();
	$db =  new DB_CONNECT();
	
	$startID=1000;
	$endID=1500;
	$response = array();
	$query = "SELECT MLII FROM HPv2 WHERE Time > '$startID' AND Time < '$endID' ";
	
	
	$result = mysql_query($query);
		//echo "working";
		if($result){
		//echo(" Result");
			
			//$dataArray = array();
			
			while($row = mysql_fetch_row($result))
			
			$response[] = $row[0]; 
			//echo("getting Response");
		}
	
	if($ecgData = fopen("ecgDatav2.text", "w")){
		
		for($i = 0; $i<count($response); $i++){
			$timeAverage=0;
			$bandPassed=0;
			$bandPassed2 = 0;
			$differentiated=0;
			$tpl = 0; 
			$signal = $response[$i];
			//echo("signal  = $signal");
			//$differentiated = call_user_method("derivation",$alg,$signal); 
			//$tpl = call_user_method("twoPoleRecursive",$alg,$signal);
			$bandPassed = call_user_method("lowPassFilter",$alg,$signal);
			//echo("bandPassed  = $bandPassed");
			//$bandPassed = call_user_method("highPassFilter",$alg,$bandPassed);
			//$bandPassed = call_user_method("derivation",$alg,$bandPassed);
			//$bandPassed = call_user_method("movingWindowIntegral",$alg,$bandPassed); 
			//$timeAverage = call_user_method("derivation",$alg,$bandPassed);
			//$timeAverage = call_user_method("power2",$alg,$timeAverage);
			//$timeAverage = call_user_method("movingWindowIntegral",$alg,$timeAverage);
			$text = "$signal\t$differentiated\t$bandPassed\t$timeAverage\t$tpl\t$bandPassed2\n";
			//echo("Writing $text\n");
			fwrite($ecgData, $text);
			
		}	
	}
	else{
		
		echo("Couldn't Open File");
	}
	
?>