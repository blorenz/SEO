<?php

/**
 * $Id: index.php 388 2006-07-30 23:08:21Z kaneda $
 */

$_pagetitle = "Home";
include "$_SERVER[DOCUMENT_ROOT]/rms/libs/header.php";
?>

<div class="ie_center">
<div class="msgbox">
	<p class="title">Welcome, <?php echo $rm->getRealName(); ?></p>
	<p class="subtitle">An overview of your DM activity follows.</p>
</div>
</div>

<div id="l3_summary">

<table summary="Your Regional Manager Alerts">
	<tr>
		<th colspan="2">Alerts</th>
	</tr>
	<tr>
		<td><a href="alerts.php">Alerts:</a></td>
		<td class="numeric"><?php echo $rm->getNumAlerts(); ?></td>
	</tr>
	<!-- 
	<tr class="altrow">
		<td>New Dealer Signups:</td>
		<td class="numeric">0</td>
	</tr>
	-->
</table>

<table summary="Your Auction Statistics">
	<tr>
		<th colspan="2">Auctions</th>
	</tr>
	<tr>
		<td>Your DMs Active Auctions:</td>
		<td class="numeric"><?php echo $rm->getActiveAuctions(); ?></td>
	</tr>
	<tr class="altrow">
		<td>...that have met reserve:</td>
		<td class="numeric"><?php echo $rm->getActiveAuctions(true); ?></td>
	</tr>
	<tr>
		<td>...ending in the next 24 hours (met reserve/total):</td>
		<td class="numeric"><?php echo $rm->getActiveAuctions(true, true) . '/' . 
			$rm->getActiveAuctions(null, true); ?></td>
	</tr>
</table>

<table summary="Your auction requests and offers made">
	<tr>
		<th colspan="2">Things That Need Attention</th>
	</tr>
	<tr>
		<td>Auction Requests (older than 24 hours):</td>
		<td class="numeric"><?php echo $rm->getAuctionRequests(); ?></td>
	</tr>
	<tr class="altrow">
		<td>Offers (sitting in Pending status for 24 hours):</td>
		<td class="numeric"><?php echo $rm->getMakeOffers(true); ?></td>
	</tr>
</table>
	
</div>

<?php 
include 'footer.php';
?>
