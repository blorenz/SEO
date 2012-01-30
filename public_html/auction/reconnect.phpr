<?php
#
# Copyright (c) 2006 Go DEALER to DEALER
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
# $srp: godealertodealer.com/htdocs/auction/bids/index.php,v 1.14 2003/05/15 16:40:12 Exp $
#

include('../../../include/session.php');
extract(defineVars( "q", "page_title", "no_menu"));    // Added by RJM 1/4/10

if (!has_priv('buy', $privs)) {
	header('Location: ../menu.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$sql = "SELECT COUNT(DISTINCT(auction_id)) FROM auctions, bids WHERE " .
    "bids.dealer_id='$dealer_id' AND bids.auction_id=auctions.id AND " .
    "auctions.status='open'";

$help_page = "chp5_check.php";

include('../../../include/list.php');
include('../header.php');

$result = db_do("SELECT bids.auction_id, auctions.title, auctions.winning_bid, auctions.reserve_price, auctions.vehicle_id
				FROM auctions, bids
				WHERE auctions.id=bids.auction_id AND auctions.status='open' AND bids.dealer_id='$dealer_id'
				GROUP BY bids.auction_id
				ORDER BY auctions.id DESC LIMIT $_start, $limit");
?>
  <br>
  
<p align="center" class="big"><b> <font size="5" color="#FF0000"><u><i>You have 
  been logged out due to inactivity!!!!</i></u></font></b></p>
<p align="center" class="big"><b>Click here to log back in:</b><br>
  <a href="index.php">Reconnect</a></p>
<p align="center" class="big">&nbsp;</p>
<p align="center" class="big">Thank you for using, &quot;Dealer to Dealer.&quot;.</p>
