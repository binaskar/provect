<?php 
 
if( isset($_POST["json"]) ) {
     $data = json_decode($_POST["json"]);
     $data->PatientName="111";
	
     echo json_encode($data);
 
}