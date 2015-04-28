<?php
	
	$response = array();
	$tipsList = array();
	
	if (isset($_POST['arrhythmia'])){
		$arrhythmia = $_POST['arrhythmia'];
		
		
		
		$searchQuery = "SELECT * FROM tips  WHERE arrhythmia = '$arrhythmia'";
  
		//Check if User exist as caretaker
		$result=mysql_query($searchQuery);
        if(mysql_num_rows($result) > 0) {
 
            $row = mysql_fetch_array($result);
 
            $response["arrhythmia"]=$row["arrhythmia"];
			
			$response["tips"]=$row["tips"];
            // success
            $response["success"] = 1;
			$response["message"] = "These are the tips";
            // user node
            
 
            // echoing JSON response
            echo json_encode($response);
        } else {
		// required field is missing
		$response["arrhythmia"] = $arrhythmia;
		$response["success"] = 0;
		$response["message"] = "Our application can\'t detect this kind of arrhythmia";
	 
		// echoing JSON response
		echo json_encode($response);
		}
			
	}
	
	
?>