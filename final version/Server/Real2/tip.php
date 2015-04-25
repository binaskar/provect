<?php
	
	$response = array();
	$tipsList = array();
	
	if (isset($_POST['arrhythmia'])){
		$arrythmia = $_POST['arrhythmia'];
		
		
		
		require_once __DIR__ . '/db_connect.php';
		
		$db = new DB_CONNECT();
		
		$query = "SELECT Tip FROM tips WHERE Arrhythmia = '$arrhythmia'";
		$result = mysql_query($query);
			if($result){
				$response["success"] = 1;
				if($arrythmia=="Bradycardia"){
					$Tip="Use pacemaker";
				}else{
				$Tip="1-Carotid sinus massage: gentle pressure on the neck, where the carotid artery splits into two branches. Must be performed by a healthcare professional to minimize risk of stroke, heart or lung injury from blood clots.
							\n2-Pressing gently on the eyeballs with eyes closed.
							\n3-Valsalva maneuver: holding your nostrils closed while blowing air through your nose.
							\n4-Dive reflex: the body's response to sudden immersion in water, especially cold water.
							\n5-Sedation.";
				}
				$response["tips"] = $Tip;
				 echo json_encode($response);
			}else{
				$response["success"] = 0;
				 echo json_encode($response);
			}
			
	}
	
	
?>