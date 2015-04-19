<?php
	$response  = array();
	
	if(isset($_POST['startID']) && isset($_POST['endID'])){
		
		$start 	= $_POST['startID'];
		$end	= $_POST['endID'];
		
		require_once __DIR__ . '/Real/db_connect.php';
		$db = new DB_CONNECT();
		$query = "SELECT * FROM HP1 WHERE ID >= '$start' AND ID <= '$end' ";
		
	}	
?>