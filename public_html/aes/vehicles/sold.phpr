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
# $srp: godealertodealer.com/htdocs/auction/vehicles/sold.php,v 1.2 2003/02/11 04:36:18 steve Exp $
#

$page_title = 'Your Sold Vehicles / Items';

include('../../../include/session.php');

if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$sql = "SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id' AND " .
    "status='closed' AND winning_bid!=0 AND current_bid>=reserve_price";

include('../../../include/list.php');
include('../header.php');

$result = db_do("SELECT vehicles.id, auctions.current_bid, DATE_FORMAT(auctions.modified, " .
    "'%b %e, %Y %r'), categories.name, vehicles.short_desc, " .
    "vehicles.year, vehicles.make, vehicles.model, vehicles.vin, vehicles.stock_num FROM " .
    "auctions, categories, vehicles, users WHERE " .
    "auctions.dealer_id='$dealer_id' AND auctions.status='closed' AND vehicles.status='sold' AND " .
    "auctions.category_id=categories.id AND auctions.winning_bid!=0 AND " .
    "auctions.current_bid>=auctions.reserve_price AND " .
    "auctions.vehicle_id=vehicles.id AND auctions.user_id=users.id ORDER BY " .
    "auctions.ends DESC, auctions.id LIMIT $_start, $limit");
?>
  <br />
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include('_links.php'); ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No auctions found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="7"><?php echo $nav_links; ?></td></tr>
   <tr>
	  <td class="header">Your Options</td>
    <td class="header">Category</td>
		<td class="header">Stock Number</td>
    <td class="header">Vehicle/Item Name</td>
    <td class="header">Year</td>
    <td class="header">Make</td>
    <td class="header">Model</td>
    <td class="header">VIN</td>
    <td class="header">Date of Sale</td>
    <td class="header">Sale Amount</td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $high_bid, $sale_date, $category, $short_desc, $year, $make,
	    $model, $vin, $stock_num) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
	  <td class="normal">
     <a href="edit.php?id=<?php echo $id; ?>">edit</a>
		 | <a href="remove.php?id=<?php echo $id; ?>">remove</a>
    </td>
    <td class="normal"><?php tshow($category); ?></td>
		<td class="normal"><?php tshow($stock_num); ?></td>
    <td class="normal"><?php tshow($short_desc); ?></td>
    <td class="normal"><?php tshow($year); ?></td>
    <td class="normal"><?php tshow($make); ?></td>
    <td class="normal"><?php tshow($model); ?></td>
    <td class="normal"><?php tshow($vin); ?></td>
    <td class="normal"><?php tshow($sale_date); ?></td>
    <td align="right" class="normal">$<?php tshow($high_bid); ?></td>
   </tr>
<?php
	}
}

db_free($result);
db_disconnect();
?>
  </table>
