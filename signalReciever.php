<?php
	$response = array();
	
	if(isset($_POST['patient']) && is_array($_POST['heartbeat'])){
		$patientName = $_POST['patient'];
		$heartbeat = array();
		$data = array();
		require_once __DIR__ . '/Real/db_connect.php';
		$db = new DB_CONNECT();
		require_once __DIR__ . 'fileHandling.php';
		$signals = new fileHandling("signals","w");
		foreach($_POST['heartbeat'] as $row ){
			$data["ID"] = $row["ID"];
			$data["time"] = $row["time"];
			$data["high"] = $row["high"];
			$data["low"] = $row["low"];
			insertStandard($data["ID"], $data["time"], $data["high"], $data["low"]);
			insertDB($patientName,$data["ID"], $data["time"], $data["high"], $data["low"]);
		}
		
	
		
	}
	
?>