<?php
 

 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// check for post data
if (isset($_POST["name"])) {
    $name = $_POST['name'];
 
    
    $result = mysql_query("SELECT *FROM patienttable WHERE pUserName = '$name'");
 
    
        // check for empty result
        if (mysql_num_rows($result) > 0) {
 
            $row = mysql_fetch_array($result);
 
            $response["state"]=$row["state"];
			$response["arrhythmia"]=$row["arrhythmia"];
			$response["activity"]=$row["activity"];
            // success
            $response["success"] = 1;
			$response["message"] = "Successfully updated";
            // user node
            
 
            // echoing JSON response
            echo json_encode($response);
        } else {
		// required field is missing
		$response["success"] = 0;
		$response["message"] = "Database does not update yet";
	 
		// echoing JSON response
		echo json_encode($response);
		}
     
} 
?>