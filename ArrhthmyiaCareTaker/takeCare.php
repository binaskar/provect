<?php

	/*
     * Following code will Update an Existed  rows
     * All Patient Update details are from HTTP Post Request
     */
	
	
	//Intilize the Response
	$response = array();
	
	
	
	if (isset($_POST['requestFollw']) && isset($_Post['userName']) && isset($_POST['patientUserName'])){
		$userName = $_POST['userName'];
		$patient = $_POST['patientUserName'];
		
		//Require DataBase Handler File	
		require_once __DIR__ .  '/db_connect.php';
		
		//Connect to DataBase
		$db = new DB_CONNECT();
		
		
		//MySql Queries
		$updateQuery = "UPDATE Patient SET cUserName= $userName WHERE pUserName = '$patient'";
		$selectQuery = "SELECT 	currentStatus FROM patient WHERE pUserName = '$patient'";
		$checkPExistQuery = "SELECT 	* FROM patient WHERE pUserName = '$patient'";
			
			
			//Response Builder
		if(mysql_query($updateQuery)){
			//Build Successed 
				
				//Get Status from DataBase
				$result = mysql_query($selectQuery);
				$response["patientFound"] = "YES";
				$response["takeCare"] = "YES";
				$response["currentStatus"] = $result;
				
				
		}	//Check if The patient exist or not
			else if($checkPExistQuery){
				$response["patientFound"] = "Yes";
				$response["takeCare"] = "NO";
				$response["currentStatus"] = "Unknown";
		}	//The patient does not exist
			else{
				$response["patientFound"] = "NO";
				$response["takeCare"] = "NO";
				$response["currentStatus"] = "Unknown";
		}
		
	}	
?>