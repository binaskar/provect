<?php
//Instant Detection


$signal = new fileHandle("signal","c");
exec("g++ main.cpp QRSDET.CPP QRSFILT.CPP fileHandling.cpp ArrhythmiaClassification.cpp");
exec("./a.out");
$detailedReport = new fileHandle("dReport","r");
$generalReport = new fileHandle("gReport","r");
sendReport($report);



function sendReport($report){
		
}

function insertSignal(){
	
}
/*$counterTemp = 0;
$addcounter = false;
$main = array();
$val = " hello 0   0 0 010   0  0  0";
$temp = array();
$temp = str_split($val);
$string = " ";
for($i=0;$i<count($temp);$i++){
			//echo(" **temp[$i] = $temp[$i]** ");
	      	if ($temp[$i] !== " "){
	      		//$main[$counterTemp] = "$temp[$i]";
	      		
		  		$string .=$temp[$i];
		  		$addcounter = true;
		  		echo(" **string = $string** ");
		  		
		  		//echo(" **not empty** ");
		  		}
		  		else if($addcounter==true && $temp[$i]==" "){
			  		$main[$counterTemp] = $string;
			  		$counterTemp++;
			  		$addcounter = false;
			  		$string = " ";
			  		//echo(" **empty**$counterTemp ");
		  		}
		  		
		  		
		  	}
for($i=0;$i<count($main);$i++){
	echo(" **main[$i] = $main[$i]** ");
	
	
}*/
?>
