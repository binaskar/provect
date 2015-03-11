<?php
	
	$response = array();
	$tipsList = array();
	
	if (isset($_POST['arrhythmia'])){
		$arrythmia = $_POST['arrhythmia'];
		
		
		
		require_once __DIR__ . '/db_connect.php';
		
		$db = new DB_CONNECT();
		$condition = 0;
		$query = "SELECT tip FROM tips WHERE arrhythmia = $arrhythmia";
			if(!mysql_query($query)){
				$response["arrhythmia"] = "$arrhythmia";
				$response["condition"] = 4;
				$response["status"] = "Uknown";
	
			
				json_encode($response);
			}	else{
				$response["arrhythmia"] = "$arrhythmia";
				$response["condition"] = $condition;
				$response["status"] = "Known";
				$tipList = getTips($arrhythmia);
				$response["tips"] = array("tip1" => "tip1",
										  "tip2" => "tip2");
				
				
			}
			
			function getTips($arrhythmia){
				$result = $conn->query($queryCheck);
				$result = mysql_query($query);
				$row = mysql_fetch_array($result);
				return $row;
			}
			echo json_encode($response);
	}
	
	
?>