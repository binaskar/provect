<?php
    
   
    // array for JSON response
    $response = array();
    
    // check for required fields
    if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['type'])) {
        
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $type = $_POST['type'];

        // include db connect class
        require_once __DIR__ . '/db_connect.php';
        // connecting to db
        $db = new DB_CONNECT();
        //MySQL Quieries
        
        
        //Insert
        $quieryInsertCT = "INSERT INTO caretakertable (cUserName, password, email) VALUES('$name', '$password', '$email')";
        //A Checker for Records Duplication
		$searchCTQuery = "SELECT * FROM caretakertable  WHERE cUserName = '$name'";
  
		//Check if User exist as caretaker
		$result=mysql_query($searchCTQuery);
        if(mysql_num_rows($result) > 0){
            $response["success"] = 0;
            $response["message"] = "User name is already exist";
            echo json_encode($response);
            
        }	else{//User Doesn't Exist
            
            
            $result = mysql_query($quieryInsertCT);
            
            // check if row inserted or not
            if ($result) {
                // successfully inserted into database
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