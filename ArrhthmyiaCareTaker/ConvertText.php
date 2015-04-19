<?php
	//one Time prgram to fetch and save heart signals into the database
	//$response = new array();
	//if (isset($_POST['ECG'])){
		
	$temp = array();
	$linearr = array();
	$counterLine = 0;
	require_once __DIR__ . '/db_connect.php';
	$db = new DB_CONNECT();
	
	
	$handle = fopen("100.text", "r");
	
	

	if ($handle) {
	
    	while (($line = fgets($handle)) !== false) {
        	$temp = explode(" ",$line);
			echo($line);
			//echo(" New Line ");
			for($i=0;$i<count($temp);$i++){
	      	$main[$counterLine] = $temp[$i];
	      	$counterLine++;
		  	}
		}
		fclose($handle);
		for($i=0;$i<count($main);$i++){
	      	
	      	echo($main[$i]);
		  	}
	} 
	
?>