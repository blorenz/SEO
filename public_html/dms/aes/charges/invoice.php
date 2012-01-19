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
# $srp: godealertodealer.com/htdocs/admin/charges/index.php,v 1.32 2003/07/30 15:27:53 steve Exp $
#
include('../../../../include/session.php'); 
include('../../../../include/db.php'); 
db_connect();  

if (empty($did) || $did <= 0) { 
	header('Location: ../dealers/index.php'); 
	exit; 
} 

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

$page_title = 'Charges for Dealership / Financial Company'; 

$result = db_do("SELECT name FROM dealers WHERE id='$did'"); 
list($dealer) = db_row($result); 
db_free($result); 
?> 
<html> 
 <head> 
  <title>District Manager: <?= $page_title ?></title> 
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" /> 
 </head> 
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../../header.php'); ?><?php include('_links.php'); ?>
<p align="center" class="big"><b>Charges for <?php echo $dealer; ?></b></p><br>
<?php
if (!isset($invoice))
	$invoice = date("Y").str_pad(number_format(date("m"), 0), 2, "0", STR_PAD_LEFT);
	
	include('_links_months.php');
	$invoice = trim($invoice);
?>
<table align="center" border="0" cellspacing="0" cellpadding="5">

<?php

$result = db_do("SELECT charges.auction_id, charges.user_id, charges.vehicle_id, charges.fee, charges.fee_type, charges.status, 
					auctions.title, DATE_FORMAT(charges.created, '%Y%m%d'), charges.id, DATE_FORMAT(charges.created, '%a, %e %M %Y %H:%i')
					FROM auctions, charges WHERE '$invoice'=substring(charges.created,1,6) AND auctions.id=charges.auction_id AND charges.dealer_id='$did' 
					AND charges.status='open' ORDER BY charges.created");
				
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No charges/fees found.</td>
   </tr>
<?php
} else {
?>  <tr class="header" align="center" bgcolor="<?php echo $bgcolor; ?>">
	<td><b>Date</b></td>
	<td><b>Reference</b></td>
    <td align="left"><b>Aution Title</b></td>
    <td><b>Item</b></td>
    <td><b>Fee Type</b></td>
	<td><b>Status</b></td>
    <td><b>Amount</b></td>
  </tr>
<?php 
while (list($auction_id, $user_id, $vehicle_id, $fee, $fee_type, $status, 
			$title, $invoice_num, $charges_id, $date) = db_row($result))
{
$invoice_num .= "-$charges_id";
if ($status == 'open') $status = "Unpaid";
if ($status == 'closed') $status = "Paid";
$total_fee += $fee;
$bgcolor = ($bgcolor == '#E6E6E6') ? '#FFFFFF' : '#E6E6E6';

?>
  <tr class="normal" align="center" bgcolor="<?php echo $bgcolor; ?>">
  	<td><?php echo $date; ?></td>
	<td><?php tshow($invoice_num); ?></td>
    <td align="left"><a href="../auctions/auction.php?aid=<?php echo $auction_id; ?>"><?php tshow($title); ?></a></td>
    <td><?php echo $auction_id; ?></td>
    <td><?php echo ucwords($fee_type); ?></td>
    <td><?php echo ucwords($status); ?></td>
    <td>US $<?php tshow($fee); ?></td>
  </tr>
<?php } ?>
  <tr class="normal" align="center">
    <td colspan="5"></td>
	<td><b>Total:</b></td>
    <td align="right"><b>US $<?php echo number_format($total_fee, 2); ?></b></td>
  </tr>
</table>
<?php
} 
db_free($result);
db_disconnect();
include('../../footer.php');
?>
