<?php
	
	
	
	class fileHandling {
		private $file;
		
		function __construct($fileName,$mode) {
			// Opening new File
			$file = fopen($fileName, $mode);
			
			}
			
		function insertStandard ($ID, $time, $high, $low){
			//Used for standard data
			$statemnt = "$ID\t$time\t$high\t$low\n";
			fwrite($file, $statemnt);
			}
		
		function insertCSV ($ID, $time, $high, $low){
			//Used for CSV format Data
			$statemnt = "$ID\t$time\t$high\t$low\n";
			fwrite($file, $statemnt);
			}
			
		function insertDB ($patient,$ID, $time, $high, $low){
			require_once __DIR__ . '/Real/db_connect.php';
			$db = new DB_CONNECT();
			$result =  mysql_query("INSERT INTO HB (ID, Time, high, low) VALUES('$ID','$time','$high','$low')");
			if($result){return "success";}else return "Failed";
			
		}
		
		function readFileLines(){
			$line =  fgetcsv ($file, 100,  "\t");
				
		}
		
		
		function __destruct() {
			// closing file opend
			$file->close();
			}
			
		
	}
	
?>