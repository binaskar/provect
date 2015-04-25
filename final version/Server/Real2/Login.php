<?php
 
/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_POST['name']) && isset($_POST['password'])) {
 
    $name = $_POST['name'];
    $password = $_POST['password'];
    
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
	 //$resultName = mysql_query("SELECT *FROM caretakers WHERE name = $name");
 
    //MySql Queries
    $searchCTQuery = "SELECT * FROM caretaker  WHERE cUserName = '$name' AND password = '$password'";
   // $searchPQuery  = "SELECT * FROM patient 	WHERE PuserName = '$name' AND password = '$password'";
    
    //Check if User exist as patient or caretaker
	$result=mysql_query($searchCTQuery);
   if (mysql_num_rows($result) > 0){
	   $response["isMatched"] = 1;//1 stands for true
	   echo json_encode($response);
   } else {
		//User Doesn't Exist or password is not correct
   		$response  ["isMatched"] = 0;//0 stands for false
		echo json_encode($response);
		}
   
   
}
?>