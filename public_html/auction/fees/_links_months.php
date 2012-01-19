<?php

function prev_months() 
{
   $months = array();
   $months[0]['m'] = date('m');
   $months[0]['M'] = date('M');
   $months[0]['y'] = date('Y');
   
   for($i=1; $i<12; $i++) {
      $months[$i]['m'] = date('m', strtotime("-$i Months"));
      $months[$i]['M'] = date('M', strtotime("-$i Months"));
      $months[$i]['y'] = date('Y', strtotime("-$i Months"));
   }
   
   return array_reverse($months);
}
     
/*
$months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
$month = number_format(date("m"), 0);
$current = TRUE;
$count = 0;
echo " [ ";
do{
	
	if ($month >= number_format(date("m"), 0)) $year = date("Y")-1;
	else $year = date("Y");
	
	$timeperiod = $year.str_pad($month+1, 2, "0", STR_PAD_LEFT);	
	
	if ($invoice == $timeperiod) {
		echo "<b>".$months[$month]." ".substr($year, -2, 2)."</b> | ";
		$current = FALSE;
	}
	else {
		if ($month < 12)
			echo "<a href=\"?invoice=$timeperiod\">".$months[$month]." ".substr($year, -2, 2)."</a> | ";
	}
	
	if ($month < 11)
		$month++;
	else
		$month = 0;
	$count++;
	
	
}while($count < 12);
if ($current == TRUE)
	echo "<b>Current</b> ]";
else {
	$timeperiod = date("Y").str_pad(number_format(date("m"), 0), 2, "0", STR_PAD_LEFT);
	echo "<a href=\"?invoice=$timeperiod"."c"."\">Current</a> ]";
}
*/
?>
   


