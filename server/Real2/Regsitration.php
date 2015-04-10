<?php
    
    /*
     * Following code will create a new product row
     * All product details are read from HTTP Post Request
     */
    
    // array for JSON response
    $response = array();
    
    // check for required fields
    if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['type'])) {
        
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $type = $_POST['type'];
        
        $result;
        
        // include db connect class
        require_once __DIR__ . '/db_connect.php';
        
        // connecting to db
        $db = new DB_CONNECT();
        //$resultName = mysql_query("SELECT *FROM caretakers WHERE name = $name");
        
        //MySQL Quieries
        
        //Check
        $quiryCheckP    = "SELECT * FROM patient WHERE pUserName = '$name'";
        $quieyCheckCT   = "SELECT * FROM caretaker WHERE cUserName = '$name'";
        
        //Insert
        $quieryInsertCT = "INSERT INTO caretaker (cUserName, password, email) VALUES('$name', '$password', '$email')";
        $quieryInsertP  = "INSERT INTO patient   (pUserName, password, email) VALUES('$name', '$password', '$email')";
        
        
        
        //A Checker for Records Duplication
        if(!mysql_query($quieyCheckCT)){
            $response["success"] = 0;
            $response["message"] = "User name is already exist";
            echo json_encode($response);
            
        }	else{//User Doesn't Exist
            
            // Registration for Caretaker
            if($type=="careTaker"){
            
                // mysql inserting a new Caretaker
                $result = mysql_query($quieryInsertCT);
				
			}
            
            // Registration for Patient
            	else{
            	
            	// mysql inserting a new Patient
	            $result =  mysql_query($quieryInsertP);
            }
            
            
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