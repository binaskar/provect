<?php

	//File For instant Detection

	$response = array();
	
	if(isset($_POST['PatientName']) && isset($_POST['time']) && isset($_POST['id']) 
	&& isset($_POST['low1']) && isset($_POST['high1']) && isset($_POST['low2'])
	&& isset($_POST['high2']))
	{
		$signal = new fileHandle("/ArrhythmiaDetection/ArrhythmiaDetection/sandData.txt","c");
		$patientName = $_POST['patient'];
		$heartbeat = array();
		$time = array($_POST['time']);
		$high = array($_POST['high2']);
		$low = array($_POST['low2']);
		$ids = array($_POST['id']);
		require_once __DIR__ . '/Real/db_connect.php';
		$db = new DB_CONNECT();
		require_once __DIR__ . 'fileHandling.php';
		$signals = new fileHandling("signals","w");
		$i = 0;
		for($i=0; $i<count($time); $i++){
			$signal->insertStandard($ids[$i],$time[$i],$high[$i],$low[$i]);
		}
		
		
		/*foreach($_POST['time'] as $timeRow && $_POST['id'] as $idRow 
		  && $_POST['high2'] as $highSRow && $_POST['low2'] as $lowSRow){
			$data["ID"] = $timeRow[$i];
			$data["time"] = $idRow[$i];
			$data["high"] = $highSRow[$i];
			$data["low"] = $lowSRow[$i];
			insertStandard($data["ID"], $data["time"], $data["high"], $data["low"]);
			insertDB($patientName,$data["ID"], $data["time"], $data["high"], $data["low"]);
			$i++;
		}*/
		
		
		exec("g++ main.cpp QRSDET.CPP QRSFILT.CPP fileHandling.cpp ArrhythmiaClassification.cpp");
		exec("./a.out");
		$detailedReport = new fileHandle("dReport","r");
		$generalReport = new fileHandle("gReport","r");
		sendReport($report);
	
			
	}
	
	
	
	
	function encodeDReport($report){
		
	}

	function encodeSignal(){
	
	}

	
	
?>