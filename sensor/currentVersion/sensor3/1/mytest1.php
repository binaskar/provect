<?php 
 
if( isset($_POST["json"]) ) {
	$data = json_decode($_POST["json"]);
	
	$fileName=$data->PatientName."_data.txt"; 
	$file=fopen($fileName,"a");//for start writing form end of file
	 
	foreach( $data->lineData as $lineD  ){
		$endl="\r\n";		
		$realData2=$lineD;
		fwrite($file,$realData2);
		fwrite($file,$endl);
	}
	 
	
	
	$fileResult=$data->PatientName."_Result.txt";
	//exec("ARR.exe {$fileName,$fileResult}");
	
	$fileR=fopen($fileResult,"a");//reading file result
	$readl=fgets($fileR);
	$result = explode("\t", $readl);
	//$result[0] id $result[1] , first iteration in hierarchical Bpm ,
	//$result[2] type of result current TA,BN,NA , $result[3] second iteration in hierarchical p-wave
	//fclose($myfile);
	$clearOldData=fopen($fileName,"w");//for clear old data to start calculate next 1 min
	fwrite($clearOldData,$data->lineData[count($data->lineData)-1]."\r\n");//write last data in file  
	
	
	 
	
	
	//hierarchical algorithm
	//first iteration 
	//need bpm 
	
	/*
	if($result[1]>100){//tread or activity 
		if($result[1]==$result[3]){//activity
			//update database activity to activity
			
		}
	}else if($result[1]<70){//bard or sleep
		if($result[1]==$result[3]){//sleep
			//update database
		}
		
	}else{//normal heartbeat
		
	}*/
	
	$data->PatientName="im done";
    echo json_encode($data);
 
}