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
# $srp: godealertodealer.com/htdocs/auction/auctions/pull_error.php,v 1.4 2002/09/03 00:40:30 steve Exp $
#

$page_title = 'Pull Auction';
$help_page = "chp6_activate.php";

include('../../../include/session.php');

if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (empty($id) || $id <= 0) {
	header('Location: index.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$result = db_do("SELECT auctions.title, DATE_FORMAT(auctions.starts, " .
    "'%a, %e %M %Y %H:%i'), DATE_FORMAT(auctions.ends, " .
    "'%a, %e %M %Y %H:%i'), auctions.status, auctions.current_bid, " .
    "auctions.reserve_price, auctions.vehicle_id, categories.name FROM " .
    "auctions, categories WHERE auctions.id='$id' AND dealer_id='$dealer_id' " .
    "AND auctions.category_id=categories.id");

if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}

list($title, $starts, $ends, $status, $current_bid, $reserve_price, $vid,
    $category) = db_row($result);
db_free($result);

$current_bid = number_format($current_bid, 2);
$reserve_price = number_format($reserve_price, 2);

$timezone = date('T');

$starts .= " $timezone";
$ends   .= " $timezone";

if ($status != 'open' || $current_bid < $reserve_price) {
	header('Location: index.php');
	exit;
}

include('../header.php');
db_disconnect();
?>

  <br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include('_links.php'); ?>

  <p align="center" class="big"><b>You cannot pull this auction because the current<br />bid meets or exceeds the reserve price.</b></p>
  </center>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
    <td align="right" class="header">Category:</td>
    <td class="normal"><?php tshow($category); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction Title:</td>
    <td class="normal"><a href="../auction.php?id=<?php echo $id; ?>"><?php tshow($title); ?></a></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction starts:</td>
    <td class="normal"><?php tshow($starts); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction ends:</td>
    <td class="normal"><?php tshow($ends); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Current Bid:</td>
    <td class="normal">$<?php tshow($current_bid); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Reserve Price:</td>
    <td class="normal">$<?php tshow($reserve_price); ?></td>
   </tr>
  </table>

<?php
include('../footer.php');
?>
