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

if (isset($s))
	$result = db_do("SELECT id, category_id, short_desc, year, vin, make, model, sell_price, stock_num 
		FROM vehicles WHERE dealer_id='$did' AND status='closed'");
else
	$result = db_do("SELECT id, category_id, short_desc, year, vin, make, model, sell_price, stock_num FROM vehicles WHERE dealer_id='$did' AND status='active'");
	
$result_dealer_name = db_do("SELECT dba FROM dealers WHERE id='$did'");
list($dealer_name) = db_row($result_dealer_name);

$page_title = "Items for $dealer_name";
$page_link = '../docs/chp5.php#Chp5_DealersActive';
?>
<html>
 <head>
  <title>Account Executive: <?=$page_title?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?><?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p><br>

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
	while (list($vid, $cid, $short_desc, $year, $vin, $make, $model,
	    $sell_price, $stock_num) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		
		$r = db_do("SELECT status FROM auctions WHERE vehicle_id='$vid' ");
		list($auction_status) = db_row($r);
		db_free($r);
		
		$r = db_do("SELECT name FROM categories WHERE id='$cid'");
		list($categories_id) = db_row($r);
		db_free($r);
?>
	<tr bgcolor="<?php echo $bgcolor; ?>">
		<td class="normal"><a href="view.php?vid=<?=$vid?>&did=<?=$did?>">view</a></td>
		<td class="normal"><?php tshow($auction_status); ?></td>
		<td class="normal"><?php tshow($categories_id); ?></td>
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
</table>
<?php
	include('../footer.php');
?>
