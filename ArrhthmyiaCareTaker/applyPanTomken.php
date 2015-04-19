<?php
	//Apply Pan Tomken
	require __DIR__  .'/panTomken.php';
	$alg = new panTomken();
	
	require_once __DIR__  .'/Real/db_connect.php';
	$db = new DB_CONNECT();
	$signal = 0;
	$query  = "INSERT INTO PTresult (signal) VALUES('$signal')";
	
	
	$data1 = 0;
	$handle = fopen("t.txt","r");
	$data = array();
	$counter = 0;
	$counter2 = 0;
	$addcounter = false;
	$counterTemp = 0;
	$temp = array();
	$string = "";
	$main = array();
	for($i=0;$i<count($main);$i++)$main[$i] = 0;
	
	if ($handle) {
    		while (($buffer = fgets($handle)) !== false) {
    				
	    		$temp = str_split($buffer);
	    		for($i=0;$i<count($temp);$i++){
	      			if($temp[$i]!==" " && $addcounter==false && $i !== 0){
		      			$string =$temp[$i];
		      			$addcounter = true;
		  		}
		  		else if ($temp[$i]!==" "&&$addcounter==true){
			  		$string.=$temp[$i];	
		  		}
		  		else if($temp[$i]==" "&&$addcounter==true){
			  		
			  		
			  		
			  		$main[$counterTemp] = $string;
			  		
			  		
			  		$counterTemp++;
			  		$addcounter = false;
			  		$string = "";
			  		
			  		//echo(" **empty**$counterTemp ");
		  		}
		  		
		  		
		  	}
      	
		 }
		 if (!feof($handle)) {
			 echo "Error: unexpected fgets() fail\n";
		}
		
		fclose($handle);
		
	}else{echo("Not Handle");}
	$counter = 0;
	for($i = 0;count($main);$i++){
		//echo("In if");
		if($counter2==2)$counter2=0;
		$data1 = intval($main[$i]);
		if($counter2==1){$data[$counter] = $data1; $counter++;echo("Added Seccessfully");
		}
		$counter2++;
	}
	for($i = 0;count($data);$i++){
		$data[$i] = lowPassFilter($data[$i],$alg);
		$data[$i] = highPassFilter($data[$i],$alg);
		$date[$i] = Derivation($data[$i],$alg);
		$data[$i] = movingWindowIntegral($data[$i],$alg);
		$signal = $data[$i];
		if(mysql_query($query)){
			echo("$signal Seccussfully Added ");
		}else{
			echo("$signal Failed Add $signal");
		}
	}

?>