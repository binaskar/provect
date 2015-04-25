<?php
$response = array();
if(isset(_POST("serialId"))){//or "PuserName"
	//store data form sensor in queue for 8 second
	//count number of p-wave for 8 second
	//
	$pwave;
	$heartbeat;
	if($pwave > $heartbeat or $pwave<$heartbeat){
		$state="danger";
		$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
		mysql_query($updateQuery);
	}
		
	
	
	
	//store data form sensor in queue for 60 second
	//count number of p-wave and heartbeat for 60 second
	
	if($heartbeat>70&&$heartbeat<100){
		//normal
		$state="safe";
		$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
		mysql_query($updateQuery);
	}else{
		if($pwave==$heartbeat){
			if($heartbeat<70){
				//sleep
				$state="safe";
				$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
				mysql_query($updateQuery);
			}elseif($heartbeat>100){
				//activity
				$state="safe";
				$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
				mysql_query($updateQuery);
			}
		}else{
			//arrhythmia
			$state="danger";
			$updateQuery = "UPDATE patient SET currentStatus= '$state' WHERE serialID = '$serialId'";
			mysql_query($updateQuery);
		}
		
	}
	
	
}

?>