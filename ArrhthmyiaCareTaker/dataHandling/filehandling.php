<?php
	$temp = array();
	$main = array();
	$id = array();
	$num1 = array();
	$num2 = array();	
	$addcounter = false;
	require_once __DIR__ . '/Real/db_connect.php';
	$db = new DB_CONNECT();
	
	$counterTemp = 0;
	$handle = fopen("t.txt","r");
	$counter = 0;
	$tempValue = "";
	$string = "";
	$firstline = true;
	$addcounter = false;
	$insertCounter = 0;
	$counter2 = 0;
	$counter3 = 0;
	if ($handle) {
    	while (($buffer = fgets($handle)) !== false) {
    		//$le = strlen($buffer);
    		if($firstline==false){	
      		$temp = str_split($buffer);
      		//for($i=0;$i<count($temp);$i++)echo("TEMP[$i] = $temp[$i]");
	      	for($i=0;$i<count($temp);$i++){
	      	
	      			
		      		
		      		if($temp[$i]!==" " && $addcounter==false){
		      			$string =$temp[$i];
			  		$addcounter = true;
			  		}
			  	else if ($temp[$i]!==" " && $addcounter==true){
				  		$string.=$temp[$i];	
			  		}
			  	else if($temp[$i]==" "&&$addcounter==true){
				  		$main[$counterTemp] = $string;
				  		$counterTemp++;
				  		$addcounter = false;
				  		
				  		//echo("string = $string");
				  		
				  		$string = "";
				  		
				  		//echo(" **empty**$counterTemp ");
			  	}else if($temp[$i]==" " && $addcounter==false){
				  	echo(" ");
			  	}
			  	
			  				  	
	
	      	}$insertCounter++;$counter2++;
	      	}$firstline =false;
	      	
	      	
	      	if ($insertCounter==3){
	      	
	      				//echo($counter2-2);
				  	$time = $main[$counter2-3];
				  	//echo($counter2-1);
				  	$v11 = $main[$counter2-2];
				  	//echo($counter2);
				  	//if($counter2)
				  	$v5 = $main[$counter2-1];
				  	
				  	//echo("TIME = $time , V11 = $v11 , V5 = $v5 , \n");
				  	insert ($time, $v11, $v5);
				  	$insertCounter=0;
			  	}

      	
      	}
        if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
		}
		fclose($handle);
	}else{echo("Not Handle");}
	
	$counter = 0;
	//echo("main0 = $main[0]");
	for($i=0;($i+3)<count($main);$i+=3){
		
		//echo("$main[$i]\n");
		//echo("Displayed**********    ");
		$id[$counter] 	= $main[$i];
		$num1[$counter] = $main[$i+1];
		$num2[$counter] = $main[$i+2];
		$counter++;	
	}
	
	for($i=0;$i<count($id);$i++){
		echo("Not Working");
		//insert ($id[$i], $num1[$i], $num2[$i]);
	
	}
	
	
	
	
	
	function insert ($time, $v11, $v5){
		echo("TIME = $time , V11 = $v11 , V5 = $v5 , \n");
		$result =  mysql_query("INSERT INTO HPv2 (Time, v5, v11) VALUES('$time','$v11','$v5')");
		if($result){echo("Succ");}
		//else{echo mysql_errno($result) . ": " . mysql_error($result) . "\n";}
		//return false;
		//echo("id = $id ******* num1 = $num1 ****** num2 = $num2");
	}
?>