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
# $srp: godealertodealer.com/htdocs/admin/charges/dealer.php,v 1.4 2002/09/03 00:36:09 steve Exp $
#

$page_title = 'Charges per Dealership / Financial Company';

include('../../../include/db.php');
db_connect();

extract(defineVars("id")); //JJM added 5/9/2010

if (empty($id) || $id <= 0) {
	header('Location: ../dealers/index.php');
	exit;
}

$result = db_do("SELECT name FROM dealers WHERE id='$id'");
list($dealer) = db_row($result);
db_free($result);
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
  <p align="center" class="big"><b>Charges for <a href="../dealers/edit.php?id=<?php echo $id; ?>"><?php echo $dealer; ?></b></a></p>
  <form action="update.php" method="get">
   <input type="hidden" name="id" value="<?php echo $id; ?>" />
   <table align="center" border="0" cellspacing="0" cellpadding="5">
    <tr>
     <td align="center" class="big" colspan="6"><b>Unpaid Buy Charges</b></td>
    </tr>
<?php
$result = db_do("SELECT auctions.title, charges.id, charges.auction_id, " .
    "charges.dealer_id, charges.fee, DATE_FORMAT(charges.created, '%Y%m%d'), " .
    "dealers.name FROM auctions, charges, dealers WHERE " .
    "charges.status='open' AND charges.fee_type='buy' AND " .
    "charges.auction_id=auctions.id AND charges.dealer_id='$id' AND " .
    "charges.dealer_id=dealers.id ORDER BY charges.created");

if (db_num_rows($result) <= 0) {
?>
    <tr>
     <td align="center" class="big" colspan="6">No charges found.</td>
    </tr>
<?php
} else {
?>
    <tr>
     <td class="header">Paid</td>
     <td class="header">Invoice Number</td>
     <td align="right" class="header"><b>Fee (US $)</b></td>
     <td class="header"><b>Auction Title</b></td>
     <td class="header"><b>Auction #</b></td>
     <td class="header"><b>Dealership</b></td>
    </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($title, $cid, $aid, $did, $fee, $created, $dealer)
	    = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$invoice_num = "$created-$cid";
?>
    <tr bgcolor="<?php echo $bgcolor; ?>">
     <td align="center" class="normal"><input type="checkbox" name="paid[]" value="<?php echo $cid; ?>" /></td>
     <td class="normal"><?php echo $invoice_num; ?></td>
     <td align="right" class="normal"><?php tshow($fee); ?></td>
     <td class="normal"><a href="../../auction/auction.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a></td>
     <td align="center" class="normal"><?php echo $aid; ?></td>
     <td class="normal"><a href="../dealers/edit.php?id=<?php echo $did; ?>"><?php tshow($dealer); ?></a></td>
    </tr>
<?php
	}
}

db_free($result);
?>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
     <td align="center" class="big" colspan="6"><b>Unpaid Pull Charges</b></td>
    </tr>
<?php
$result = db_do("SELECT auctions.title, charges.id, charges.auction_id, " .
    "charges.dealer_id, charges.fee, DATE_FORMAT(charges.created, '%Y%m%d'), " .
    "dealers.name FROM auctions, charges, dealers WHERE " .
    "charges.status='open' AND charges.fee_type='pull' AND " .
    "charges.auction_id=auctions.id AND charges.dealer_id='$id' AND " .
    "charges.dealer_id=dealers.id ORDER BY charges.created");

if (db_num_rows($result) <= 0) {
?>
    <tr>
     <td align="center" class="big" colspan="6">No charges found.</td>
    </tr>
<?php
} else {
?>
    <tr>
     <td class="header">Paid</td>
     <td class="header">Invoice Number</td>
     <td align="right" class="header"><b>Fee (US $)</b></td>
     <td class="header"><b>Auction Title</b></td>
     <td class="header"><b>Auction #</b></td>
     <td class="header"><b>Dealership</b></td>
    </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($title, $cid, $aid, $did, $fee, $created, $dealer)
	    = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$invoice_num = "$created-$cid";
?>
    <tr bgcolor="<?php echo $bgcolor; ?>">
     <td align="center" class="normal"><input type="checkbox" name="paid[]" value="<?php echo $cid; ?>" /></td>
     <td class="normal"><?php echo $invoice_num; ?></td>
     <td align="right" class="normal"><?php tshow($fee); ?></td>
     <td class="normal"><a href="../../auction/auction.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a></td>
     <td align="center" class="normal"><?php echo $aid; ?></td>
     <td class="normal"><a href="../dealers/edit.php?id=<?php echo $did; ?>"><?php tshow($dealer); ?></a></td>
    </tr>
<?php
	}
}

db_free($result);
?>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
     <td align="center" class="big" colspan="6"><b>Unpaid Sell Charges</b></td>
    </tr>
<?php
$result = db_do("SELECT auctions.title, charges.id, charges.auction_id, " .
    "charges.dealer_id, charges.fee, DATE_FORMAT(charges.created, '%Y%m%d'), " .
    "dealers.name FROM auctions, charges, dealers WHERE " .
    "charges.status='open' AND charges.fee_type='sell' AND " .
    "charges.auction_id=auctions.id AND charges.dealer_id='$id' AND " .
    "charges.dealer_id=dealers.id ORDER BY charges.created");

if (db_num_rows($result) <= 0) {
?>
    <tr>
     <td align="center" class="big" colspan="6">No charges found.</td>
    </tr>
<?php
} else {
?>
    <tr>
     <td class="header">Paid</td>
     <td class="header">Invoice Number</td>
     <td align="right" class="header"><b>Fee (US $)</b></td>
     <td class="header"><b>Auction Title</b></td>
     <td class="header"><b>Auction #</b></td>
     <td class="header"><b>Dealership</b></td>
    </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($title, $cid, $aid, $did, $fee, $created, $dealer)
	    = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$invoice_num = "$created-$cid";
?>
    <tr bgcolor="<?php echo $bgcolor; ?>">
     <td align="center" class="normal"><input type="checkbox" name="paid[]" value="<?php echo $cid; ?>" /></td>
     <td class="normal"><?php echo $invoice_num; ?></td>
     <td align="right" class="normal"><?php tshow($fee); ?></td>
     <td class="normal"><a href="../../auction/auction.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a></td>
     <td align="center" class="normal"><?php echo $aid; ?></td>
     <td class="normal"><a href="../dealers/edit.php?id=<?php echo $did; ?>"><?php tshow($dealer); ?></a></td>
    </tr>
<?php
	}
}

db_free($result);
?>
   </table>
   <div align="center"><p class="normal"><input type="submit" name="submit" value=" Update Charges " /></p></div>
  </form>
 </body>
</html>
<?php db_disconnect(); ?>
