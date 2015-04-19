<?php
	
	class ArrhthmyiaDetector {
		private $Signals = new fileHndling("Signals","r");
		private $Report =  new fileHandling("Report","r");
		function Detect{
		exec("g++ main.cpp QRSDET.CPP QRSFILT.CPP fileHandling.cpp ArrhythmiaClassification.cpp");
		exec("./a.out");
		}
	}
?>