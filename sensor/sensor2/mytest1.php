<?php 
 
if( isset($_POST["json"]) ) {
     $data = json_decode($_POST["json"]);
     
	 //$data->sTime[1]=55;
	
	 $fileName=$data->PatientName."_data.txt";
	 $file=fopen($fileName,"w");
	 
	 foreach( $data->lineData as $lineD  ){
		$endl="\r\n";		
	 $realData2=$lineD;
	fwrite($file,$realData2);
	fwrite($file,$endl);
	 }
	 
	 
	// $size=count($data->sTime);*/
	 $data->PatientName="111";
      echo json_encode($data);
 
}