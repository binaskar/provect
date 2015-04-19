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
	
	$addcounter = false;
	if ($handle) {/*
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
		
	*/
		while(($buffer = fgets($handle))!== false){
			$temp = 
		}
	}else{echo("Not Handle");}}
	
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
	
		insert ($id[$i], $num1[$i], $num2[$i]);
	
	}
	
	
	
	
	
	function insert ($id, $num1, $num2){
		$result =  mysql_query("INSERT INTO HP1 (ID, num1, num2) VALUES('$id','$num1','$num2')");
		if($result){echo("Succ");}
		else{echo mysql_errno($result) . ": " . mysql_error($result) . "\n";}
		//return false;
		//echo("id = $id ******* num1 = $num1 ****** num2 = $num2");
	}

	
	
	
?>