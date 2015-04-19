<?php
	
	
	$response  = array();
	
	
	 
	if(isset($_POST['startID']) && isset($_POST['endID']))
	{	echo("Inside if");
		
		$start 	= $_POST['startID'];
		$end	= $_POST['endID'];
		
		require_once __DIR__ . '/Real/db_connect.php';
		$db = new DB_CONNECT();
		$query = "SELECT * FROM HP1 WHERE ID >= '$start' AND ID <= '$end' ";
		
		$result = mysql_query($query);
		//echo "working";
		if($result){
		echo(" Result");
			$max = mysql_num_rows($query);
			$response["found"] = "true";
			//$dataArray = array();
			$response["data"]  = array();
			while($row = mysql_fetch_array($result)){
				$data["ID"]   = $row["ID"];
				$data["num1"] = $row["NUM1"];
				$data["num2"] = $row["NUM2"];
				array_push($response["data"],$data );
			}
			
		}
		 else{
		 echo("Not Result");
			 echo mysql_errno(mysql_query($query)) . ": " . mysql_error(mysql_query($query)) . "\n";
			 $response["found"] = "false";
		 }
		
	echo json_encode($response);
	}
	else{
		echo("Error");
	}
	
	
	
?>