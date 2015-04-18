<?php 
 
if( isset($_POST["json"]) ) {
     $data = json_decode($_POST["json"]);
     
	
     echo json_encode($data);
 
}