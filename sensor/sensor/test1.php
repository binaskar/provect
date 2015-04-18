<?php 
 
if( isset($_POST["json"]) ) {
     $data = json_decode($_POST["json"]);
     //Files Required
     //arrhthmyia Detector
     //file Handling
     //
  
     //$data->PatientName =;
     $patientName = $data->PatientName;
	 $data2 = array();
	 foreach($data->sTime as $sTime && $data->id as $id 
	 && $data->high2 as $high && $data->low2 as $low){
	 	
	 	
		insertSatanard($sTime,$id,$high,$low);	
		insertDB($sTime,$id,$high,$low);
	 }
	 $data->PatientName = "100";
	 echo json_encode($data);
 
}