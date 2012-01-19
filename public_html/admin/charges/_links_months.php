<p align="center" class="normal">
<?php
$months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
$month = number_format(date("m"), 0);
$current = TRUE;
echo " [ ";

if (empty($stats)) {  //JJM 8/27/2010 altered from !isset to empty to account for our new variable setup
	echo "<b>Last 30 Days</b> | ";
	$current = FALSE;
}
else
	echo "<a href=\"?\">Last 30 Days</a> | ";

do{

	if ($month >= number_format(date("m"), 0)) $year = date("Y")-1;
	else $year = date("Y");

	$timeperiod = $year.'-'.str_pad($month+1, 2, "0", STR_PAD_LEFT);

	if ($stats == $timeperiod) {
		echo "<b>".$months[$month]." ".substr($year, -2, 2)."</b> | ";
		$current = FALSE;
	}
	else
		echo "<a href=\"?stats=$timeperiod&s=$status\">".$months[$month]." ".substr($year, -2, 2)."</a> | ";


	if ($month < 11)
		$month++;
	else
		$month = 0;

}while($month != date("m")-1);
if ($current == TRUE)
	echo "<b>Current Month</b> ]";
else {
	$timeperiod = date("Y").'-'.str_pad(number_format(date("m"), 0), 2, "0", STR_PAD_LEFT); //JJM 08/27/2010 had to add a missing dash in the date format
	echo "<a href=\"?stats=$timeperiod&s=$status\">Current Month</a> ]";
}
?>
</p><br>
