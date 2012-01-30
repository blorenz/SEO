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
# $srp: godealertodealer.com/htdocs/auction/fees/index.php,v 1.6 2002/09/03 00:40:32 steve Exp $
#

include('../../../include/session.php');

if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

$page_title = 'Unsettled Fees';
$help_page = "chp7.htm#Chp7_Unsettledfees";

include('../../../include/db.php');
db_connect();

include('../header.php');
include('_links.php'); 

$result = db_do("SELECT auctions.title, DATE_FORMAT(charges.created, " .
    "'%Y%m%d'), charges.id, charges.auction_id, charges.fee, " .
    "charges.fee_type, charges.status, DATE_FORMAT(charges.created, " .
    "'%a, %e %M %Y %H:%i') FROM auctions, charges WHERE " .
    "auctions.id=charges.auction_id AND charges.dealer_id='$dealer_id' AND " .
    "charges.status='open' ORDER BY charges.created");

?>

  <br>
  <p align="center" class="big"><b>Unsettled Fees</b></p>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No charges/fees found.</td>
   </tr>
<?php
} else {
?>
   <tr>
    <td class="header"><b>Reference</b></td>
    <td class="header"><b>Auction Title</b></td>
    <td class="header"><b>Fee</b></td>
    <td class="header"><b>Fee Type</b></td>
    <td class="header"><b>Status</b></td>
    <td class="header"><b>Created</b></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($title, $invoice_num, $cid, $auction_id, $fee, $fee_type,
	    $status, $created) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		$invoice_num .= "-$cid";
		$fee = number_format($fee, 2);
		if ($status == 'open') $status = "Unpaid";
		if ($status == 'closed') $status = "Paid";
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><?php tshow($invoice_num); ?></td>
    <td class="normal"><a href="../auction.php?id=<?php echo $auction_id; ?>"><?php tshow($title); ?></a></td>
    <td class="normal">US $<?php tshow($fee); ?></td>
    <td class="normal"><?php echo ucwords($fee_type); ?></td>
    <td class="normal"><?php echo ucwords($status); ?></td>
    <td class="normal"><?php tshow($created); ?></td>
   </tr>
<?php
	}
}

db_free($result);
?>
  </table>

<?php
db_disconnect();
include('../footer.php');
?>
