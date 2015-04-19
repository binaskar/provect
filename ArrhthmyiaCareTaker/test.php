<?php
$counterTemp = 0;
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
}
?>