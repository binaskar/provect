<?php
	/*
     * Following code will Respond a tips rows
     * All tips details are read from HTTP Post Request
     *
     */
     
     
    //Intilize Response
	$response = array();
	
	// check for required fields
	if (isset($_POST['arrhythmia'])){
		$arrythmia = $_POST['arrhythmia'];
		
		$tipsList = array();
		
		// include db connect class
		require_once __DIR__ . '/db_connect.php';
		
		//Connecting to DB
		$db = new DB_CONNECT();
		
		$condition = 0;
		$query = "SELECT * FROM tips WHERE arrhythmia = '$arrhythmia'";
			if(!mysql_query($query)){
				$response["arrhythmia"] = "$arrhythmia";
				$response["status"] = "";
				$response["status"] = "Uknown";
	
			
				
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