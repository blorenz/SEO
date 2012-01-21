<?php

/**
 * $Id$
 */

$_pagetitle = "DM Stats";
include "$_SERVER[DOCUMENT_ROOT]/rms/libs/header.php";

$dms = $rm->getDMs();

?>

<h2>DM Stats</h2>

<center>
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

$past_12 = prev_months();


if (!isset($_GET['year']) || !isset($_GET['month'])) {
   $year = date('Y');
   $month = date('m');
} else {
   $year = $_GET['year'];
   $month = $_GET['month'];
}


$i = 0;

foreach ($past_12 as $months) {
   $i++;
   if ($months['m'] == $month && $months['y'] == $year) {
      echo "$months[M] $months[y]";
   } else {
      echo "<a href=\"$_SERVER[PHP_SELF]?month=$months[m]&year=$months[y]\">$months[M] $months[y]</a>";
   }
   
   if ($i < (count($past_12))) { echo ' | '; }
}

$when = "$year-$month";
?>

<table class="dm_info">
	<tr>
		<th>Name</th>
		<th>Bids Made</th>
		<th>Auctions Created</th>
		<th>Auctions Pulled</th>
		<th>Auctions Sold</th>
		<th>Auctions Bought</th>
		<th>Charges</th>
	</tr>
	<?php
	
	setlocale(LC_MONETARY, 'en_US');
	
	foreach($dms as $dm) {
	   $dm_stats = new gdtd_DM($dm['id']);
	   ?>
	   <tr>
	   	<td><?php echo $dm['name'] ?></td>
	   	<td><?php echo $dm_stats->getBidsByMonth($when); ?></td>
	   	<td><?php echo $dm_stats->getAuctionsByMonth($when); ?></td>
	   	<td><?php echo $dm_stats->getAuctionsByMonth($when, 'pulled'); ?></td>
	   	<td><?php echo $dm_stats->getAuctionsByMonth($when, $status='closed', true); ?></td>
	   	<td><?php echo $dm_stats->getBoughtByMonth($when); ?></td>
	   	<td><?php echo money_format('%.2n', $dm_stats->getChargesByMonth($when)); ?></td>
	   </tr>
	   <?php
	}
?>
</table>

</center>
<br />
<?php
include 'footer.php';
?>