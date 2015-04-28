<?php
    
   
    
    // array for JSON response
    $response = array();
    
    // check for required fields
    if (isset($_POST['patient']) && isset($_POST['caretaker']) && isset($_POST['sensor'])) {
        
        $patientName = $_POST['patient'];
        $caretakerName = $_POST['caretaker'];
        $sensor = $_POST['sensor'];
        $state="healthy";
		$activity="none";
		$arrhythmia="none";
        // include db connect class
        require_once __DIR__ . '/db_connect.php';
        // connecting to db
        $db = new DB_CONNECT();
        //MySQL Quieries
        
        //Insert
        $quieryInsertP  = "INSERT INTO patienttable   (pUserName, who_will_caring_patient, sensorName,state,activity,arrhythmia) VALUES('$patientName', '$caretakerName', '$sensor','$state','$activity','$arrhythmia')";
        //A Checker for Records Duplication
		$searchCTQuery = "SELECT * FROM patienttable  WHERE pUserName = '$patientName'";
  
		//Check if User exist as patient
		$result=mysql_query($searchCTQuery);
        if(mysql_num_rows($result) > 0){
            $response["success"] = 0;
            $response["message"] = "User name is already exist";
            echo json_encode($response);
            
        }	else{//User Doesn't Exist
            
            
            $result = mysql_query($quieryInsertP);
            
            // check if row inserted or not
            if ($result) {
                // successfully inserted into database
				$file=fopen("C:/wamp/www/Real3/sensor/".$patientName."_data.txt","w");
                $response["success"] = 1;
                $response["message"] = "Accept.";
                
                // echoing JSON response
                echo json_encode($response);
            } 	else {
                // failed to insert row
                $response["success"] = 0;
                $response["message"] = "Oops! An error occurred.";
                
                // echoing JSON response
                echo json_encode($response);
            }
        } 
    }
?>