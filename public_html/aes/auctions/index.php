<?php

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$dealers_array = findDEALERforAE($ae_id);
if (!in_array($did, $dealers_array)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

if (empty($s))
	$status = 'open';
else
	$status = $s;

if ($status == 'all')
	$sql = "SELECT COUNT(*) FROM auctions, vehicles 
		WHERE vehicles.dealer_id='$did' AND auctions.vehicle_id=vehicles.id 
		ORDER BY auctions.category_id, vehicles.year";
else
	$sql = "SELECT COUNT(*) FROM auctions, vehicles 
		WHERE vehicles.dealer_id='$did' AND auctions.vehicle_id=vehicles.id AND auctions.status='$status'
		ORDER BY auctions.category_id, vehicles.year";	
include('../../../include/list.php');

if ($status == 'all' && $status != 'sold')
	$result = db_do("SELECT auctions.id, auctions.category_id, auctions.title, vehicles.year, 
			vehicles.vin, vehicles.make, vehicles.model, vehicles.sell_price, vehicles.stock_num, auctions.status
		FROM auctions, vehicles 
		WHERE vehicles.dealer_id='$did' AND auctions.vehicle_id=vehicles.id 
		ORDER BY auctions.category_id, vehicles.year 
		LIMIT $_start, $limit");
elseif ($status == 'sold') 
		$result = db_do("SELECT auctions.id, auctions.category_id, auctions.title, vehicles.year, 
			vehicles.vin, vehicles.make, vehicles.model, vehicles.sell_price, vehicles.stock_num, auctions.status
		FROM auctions, vehicles 
		WHERE vehicles.dealer_id='$did' AND auctions.vehicle_id=vehicles.id AND auctions.chaching='1' 
		ORDER BY auctions.category_id, vehicles.year 
		LIMIT $_start, $limit");
else
	$result = db_do("SELECT auctions.id, auctions.category_id, auctions.title, vehicles.year, 
			vehicles.vin, vehicles.make, vehicles.model, vehicles.sell_price, vehicles.stock_num, auctions.status
		FROM auctions, vehicles 
		WHERE vehicles.dealer_id='$did' AND auctions.vehicle_id=vehicles.id AND auctions.status='$status'
		ORDER BY auctions.category_id, vehicles.year 
		LIMIT $_start, $limit");		
		
$result_dealer_name = db_do("SELECT name FROM dealers WHERE id='$did'");
list($dealer_name) = db_row($result_dealer_name);

$page_title = "Auctions for $dealer_name";
$page_link = '../docs/chp5.php#Chp5_DealersActive';
?>
<html>
 <head>
  <title>Account Executive: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p>
<p align="center" class="normal"><br>[ <a href="?did=<?=$did?>&s=all">All Auctions</a> | 
	<a href="?did=<?=$did?>&s=pending">Pending Auctions</a> | 
	<a href="?did=<?=$did?>&s=open">Open Auctions</a> | 
	<a href="?did=<?=$did?>&s=closed">Closed Auctions</a> | 
	<a href="?did=<?=$did?>&s=pulled">Pulled Auctions</a> | 
	<a href="?did=<?=$did?>&s=sold">Sold Auctions</a> ]</p>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No items found.</td>
   </tr>
<?php
} else {
?>
	<tr><td colspan="5"><?php echo $nav_links; ?></td></tr>
	<tr> 
		<td class="header"><b>Your Options</b></td>
		<td class="header"><b>Auction Status</b></td>
		<td class="header"><b>Category</b></td>
		<td class="header"><b>Stock Number</b></td>
		<td class="header" nowrap><b>Item Title</b></td>
		<td class="header"><b>Year</b></td>
		<td class="header"><b>Make</b></td>
		<td class="header"><b>Model</b></td>
		<td class="header"><b>VIN</b></td>
		<td class="header"><b><?php if ($status == 'sold') echo 'Sale Amount'; ?></b></td>
	</tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($aid, $cid, $short_desc, $year, $vin, $make, $model,
	    $sell_price, $stock_num, $auction_status) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		
	$result_cid = db_do("SELECT name
		FROM categories
		WHERE id=$cid");
	list($category)=db_row($result_cid);
?>
	<tr bgcolor="<?php echo $bgcolor; ?>">
		<td class="normal"><a href="auction.php?did=<?=$did?>&aid=<?=$aid?>">view</a></td>
		<td class="normal"><?php tshow($auction_status); ?></td>
		<td class="normal"><?php tshow($category); ?></td>
		<td class="normal"><?php tshow($stock_num); ?></td>
		<td class="normal"><?php tshow($short_desc); ?></td>
		<td class="normal"><?php tshow($year); ?></td>
		<td class="normal"><?php tshow($make); ?></td>
		<td class="normal"><?php tshow($model); ?></td>
		<td class="normal"><?php tshow($vin); ?></td>
		<td align="right" class="normal"><?php if ($status == 'sold') echo '$' . number_format($sell_price, 2); ?></td>
	</tr>
<?php
	}
}
db_free($result);

db_disconnect();
?>
	<tr><td colspan="5"><?php echo $nav_links; ?></td></tr>
</table>
<?php
	include('../footer.php');
?>
