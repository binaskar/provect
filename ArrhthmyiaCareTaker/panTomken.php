<?php
	class panTomken{
	
		function lowPassFilter($data){
			$data = var_dump($data);
			//echo("data0 = $data ******");
			static $y1 = 0;
			static $y2 = 0;
			static $x  = array(26);
			static $n  = 12;
			$y0 = 0;
			//$y0 = var_dump(0);
			
			for($i=0;$i<26;$i++)$x[$i] = 0;
			
			$x[$n] = $x[$n+13] = $data;
			//echo("data1 = $y0 ******");
			$y0  = ($y1 << 1) - $y2 + $x[$n] - ($x[$n+6] << 1) + $x[$n+12];
			//echo("data2 = $y0 ******");
			$y2  = $y1;
			//echo("data3 = $y0 ******");
			$y1  = $y0;
			//echo("data4 = $y0 ******");
			//$y0 /= 32;
			//echo("data5 = $y0 ******");
			$y0 >>= 5;
			//echo("data6 = $y0 ******");
			if(--$n < 0){
				$n = 12;
				}
			return ($y0);	
		}
		
		function highPassFilter($data){
			$data = var_dump($data);
			static $y1 = 0;
			static $x  = array(66);
			static $n  = 32;
			
			$y0 = 0;
			for($i=0;$i<66;$i++)$x[$i] = 0;
			
			$x[$n] = $x[$n+33] = $data;
			$y0 = $y1 + $x[$n] - $x[$n+32];
			$y1 = $y0;
			
			if(--$n < 0){
				$n = 32;
			}
			return ($x[$n + 16]  - ($y0 >> 5));	
		}
		
		function derivation($data){
			$data = var_dump($data);
			$y = 0;
			$i = 0;
			
			static $xDerv  = array(4);
			
			for($i=0;$i<4;$i++)$xDerv[$i] = 0;
			
			$y = ($data << 1) + $xDerv[3] - $xDerv[1] - ($xDerv[0] << 1) ;
			
			
			$y >>= 3;
			for($i=0;$i<3;$i++)$xDerv[$i] = $xDerv[$i+1];
			$xDerv[3] = $data;
			
			return ($y);
			
		}
		function movingWindowIntegral($data){
			$data = var_dump($data);											
			static $ptr = 0;
			static $sum = 0;
			static $x  = array(32);
			
			for($i=0;$i<32;$i++)$x[$i] = 0;
			
			$ly = 0;
			$y  = 0;
			
			if(++$ptr == 3)	$ptr=0;
			$sum -= $x[$ptr];
			$sum += $data;
			$ly = $sum >> 5;
			
			if($ly > 32400)
				$y = 32400;
				else $y = $ly;
			
			return ($y);
				
		}
		function power2 ($data){
			$data = var_dump($data);
			return ($data*$data);
		}
		function summation ($data){
			$sm = 0;
			for($i=0;$i<32;$i++){
				$sm+=$data;
			}
			return ($data=$sm*(1/32));
		}
		function twoPoleRecursive($data)
		{
			$data = var_dump($data);
			static  $xnt, $xm1, $xm2, $ynt, $ym1, $ym2 = 0;
			$xnt = $data;
			$ynt = ($ym1 + $ym1 >> 1 + $ym1 >> 2 + $ym1 >> 3) +
			($ym2 >> 1 + $ym2 >> 2 + $ym2 >> 3 +
			$ym2 >> 5 + $ym2 >> 6) + $xnt - $xm2;
			$xm2 = $xm1;
			$xm1 = $xnt;
			$xm2 = $ym1;
			$ym2 = $ym1;
			$ym1 = $ynt;
			return($ynt);
		}
		
	}
	
?>