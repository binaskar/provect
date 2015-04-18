<?php 
 
if( isset($_POST["json"]) ) {
     $data = json_decode($_POST["json"]);
     $data->PatientName="111";
	 $data->sTime[1]=55;
     echo json_encode($data);
 
}