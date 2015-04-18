<?php
	$response = array();
	
	if(isset($_POST['PatientName']) && is_array($_POST['time']) && is_array($_POST['id']) 
	&& is_array($_POST['low1']) && is_array($_POST['high1']) && is_array($_POST['low2'])
	&& is_array($_POST['high2']))
	{
		$patientName = $_POST['patient'];
		$heartbeat = array();
		$time = array();
		$high2 = array();
		$low = array()
		require_once __DIR__ . '/Real/db_connect.php';
		$db = new DB_CONNECT();
		require_once __DIR__ . 'fileHandling.php';
		$signals = new fileHandling("signals","w");
		$i = 0;
		foreach($_POST['time'] as $timeRow && $_POST['id'] as $idRow 
		  && $_POST['high2'] as $highSRow && $_POST['low2'] as $lowSRow){
			$data["ID"] = $timeRow[$i];
			$data["time"] = $idRow[$i];
			$data["high"] = $highSRow[$i];
			$data["low"] = $lowSRow[$i];
			insertStandard($data["ID"], $data["time"], $data["high"], $data["low"]);
			insertDB($patientName,$data["ID"], $data["time"], $data["high"], $data["low"]);
			$i++;
		}
		
	
		
	}
	
?>