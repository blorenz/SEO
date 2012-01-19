<?php
#
# Copyright (c) 2002 Steve Price
# All rights reserved.
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions
# are met:
#
# 1. Redistributions of source code must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
# 2. Redistributions in binary form must reproduce the above copyright
#    notice, this list of conditions and the following disclaimer in the
#    documentation and/or other materials provided with the distribution.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
# ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
# FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
# DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
# OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
# HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
# LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
# OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
# SUCH DAMAGE.
#
# $srp: godealertodealer.com/htdocs/auction/vehicles/index.php,v 1.21 2003/02/03 03:22:08 steve Exp $
#

include('../../../../include/session.php');
include('../../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$ae_array = findAEforDM($dm_id);
if (!in_array($id, $ae_array)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$dealers_array = findDEALERforAE($id);
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
include('../../../../include/list.php');

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
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../../header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p>
<p align="center" class="normal"><br>[ <a href="?id=<?=$id?>&did=<?=$did?>&s=all">All Auctions</a> | 
	<a href="?id=<?=$id?>&did=<?=$did?>&s=pending">Pending Auctions</a> | 
	<a href="?id=<?=$id?>&did=<?=$did?>&s=open">Open Auctions</a> | 
	<a href="?id=<?=$id?>&did=<?=$did?>&s=closed">Closed Auctions</a> | 
	<a href="?id=<?=$id?>&did=<?=$did?>&s=pulled">Pulled Auctions</a> | 
	<a href="?id=<?=$id?>&did=<?=$did?>&s=sold">Sold Auctions</a> ]</p>
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
</table>
<?php
	include('../../footer.php');
?>
