<?php 
 
if( isset($_POST["json"]) ) {
	$data = json_decode($_POST["json"]);
	
	$name=$data->PatientName;
	/*$file=fopen($name.".txt","w");
	
	$fileName=$name."_data.txt"; 
	
	$data=$fileName."\t".$qrsName."\t".$fileResult;
	fwrite($file, $data);
	fclose($file);	
	*/
	
	$qrsName =$name."_qrs.txt";
	$fileResult=$name."_Result.txt";
	
	$fileName=$name."_data.txt"; 
	$fileN=fopen($fileName,"a");//for start writing form end of file
	
	foreach( $data->lineData as $lineD  ){
		$endl="\r\n";		
		$realData2=$lineD;
		fwrite($fileN,$realData2);
		fwrite($fileN,$endl);
	}
	 
	fclose($fileN);
	//exec("myrestexe.exe {$fileName}",$output);
	//exec("mainv15.exe {$data->PatientName}",$output);
	//exec("myrestexe.exe $fileName $qrsName $fileResult",$output);
	exec("mainv15.exe $name $fileName $qrsName $fileResult",$output);
	if($output!="Done!"){
		$data->PatientName=$output;
		echo json_encode($data);
	}else{
		$data->PatientName="error";
		echo json_encode($data);
	}
	
 
}