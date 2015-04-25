<?php
$response = array();

if(isset(_PSOT("serialId"))){//or "PuserName"
	$numberOfBeats;
	if($numberOfBeats>100){
		$numberOfPWave;
		if($numberOfPWave==0){
			//
			$state="danger";
			$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
			mysql_query($updateQuery);
		}else{
			if($numberOfBeats>$numberOfPWave){
				//
				$state="danger";
				$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
				mysql_query($updateQuery);
			}elseif($numberOfBeats<$numberOfPWave){
				//
				$state="danger";
				$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
				mysql_query($updateQuery);
			}else{
				//activity
				$state="healthy";
				$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
				mysql_query($updateQuery);
				
			}
		}
	}elseif($numberOfBeats<70){
		$numberOfPWave;
		if($numberOfBeats>$numberOfPWave){
			//
			$state="danger";
			$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
			mysql_query($updateQuery);
		}elseif($numberOfBeats<$numberOfPWave){
			//
			$state="danger";
			$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
			mysql_query($updateQuery);
		}else{
			//sleep
			$state="healthy";
			$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
			mysql_query($updateQuery);
		}
	}else{
		//normal
		$state="healthy";
			$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
			mysql_query($updateQuery);
	}
	
}


?>