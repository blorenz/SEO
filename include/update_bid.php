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
# $srp: godealertodealer.com/include/update_bid.php,v 1.13 2003/02/25 18:18:32 Exp $
#

#
# List of folks to notify that they've been outbid.
#
include('defs.php');
$lusers = array();

#
# Lock tables we'll be modifying or don't want changing out from underneath us.
#

db_do("LOCK TABLE auctions WRITE, bids WRITE");

#
# Get the user_id for the current winning_bid.
#

$old_user_id = '';
$result = db_do("SELECT bids.user_id FROM auctions, bids WHERE " .
    "auctions.id='$auction_id' AND bids.id=auctions.winning_bid");
list($old_user_id) = db_row($result);
$lusers[$old_user_id]++;
db_free($result);

#
# Get the maximum current_bid for this auction.
#

$result = db_do("SELECT auctions.title, auctions.bid_increment, bids.id, " .
    "bids.current_bid, bids.user_id FROM auctions, bids WHERE " .
    "auctions.id='$auction_id' AND bids.auction_id='$auction_id' ORDER BY " .
    "bids.current_bid DESC LIMIT 1");
list($auction_title, $increment, $bid, $max, $new_user_id) = db_row($result);
db_free($result);

#
# Set current_bid and winning_bid for this auction.
#

db_do("UPDATE auctions SET current_bid='$max', winning_bid='$bid' " .
    "WHERE id='$auction_id'");

#
# Check for proxy bids that need to be updated.
#

$result = db_do("SELECT id, auction_id, current_bid, maximum_bid, user_id " .
    "FROM bids WHERE auction_id='$auction_id' AND maximum_bid >= $max " .
    "ORDER BY maximum_bid, id DESC");

if (db_num_rows($result) > 2 ) {
	#xxx This shouldn't happen but if it does fire off an email so I can
	#xxx figure out why my assumption is wrong.
	
	$msg = "Assumption failed for auction $auction_id.";
	
	while (list($bid, $aid, $current_bid, $maximum_bid, $uid) = db_row($result)) {;
	$dbnr =	db_num_rows($result);
	
	$msg .= "
		
Bids ID: $bid
Auction ID: $aid
Current Bid: $current_bid
Maximum Bid: $maximum_bid
User ID: $uid
[Currently: $max increase by $increment]";

}

	mail('pfaciana@godealertodealer.com', 'Failed assumption in update_bid.php',
	    $msg, "From: webmaster@goDEALERtoDEALER.com");
} elseif (db_num_rows($result) == 2) {
	#
	# We have competing bids.  The first one will be the losing bid so
	# max it out and add him to the lusers list.
	#

	list($bid, $aid, $current_bid, $maximum_bid, $uid) = db_row($result);
	db_do("UPDATE bids SET current_bid=maximum_bid WHERE id='$bid'");
	$lusers[$uid]++;
	$max = $maximum_bid;

	#
	# This one is our winning bid.
	#

	list($bid, $aid, $current_bid, $maximum_bid, $uid) = db_row($result);

	$new_bid = $max + $increment;
	if ($new_bid > $maximum_bid)
		$new_bid = $maximum_bid;

	db_do("UPDATE bids SET current_bid='$new_bid' WHERE id='$bid'");
	db_do("UPDATE auctions SET current_bid='$new_bid', " .
	    "winning_bid='$bid' WHERE id='$auction_id'");

	$new_user_id = $uid;
} elseif (db_num_rows($result) == 1) {
	#
	# We have a potential proxy bid.  Make sure it isn't the user
	# with the current winning_bid.
	#

	list ($bid, $aid, $current_bid, $maximum_bid, $uid) = db_row($result);
	if ($uid != $new_user_id) {
		$new_bid = $max + $increment;
		if ($new_bid > $maximum_bid)
			$new_bid = $maximum_bid;

		db_do("UPDATE bids SET current_bid='$new_bid' WHERE id='$bid'");
		db_do("UPDATE auctions SET current_bid='$new_bid', " .
		    "winning_bid='$bid' WHERE id='$auction_id'");

		$lusers[$new_user_id]++;
		$new_user_id = $uid;
	}
}

db_free($result);

#
# Unlock tables.
#

db_do("UNLOCK TABLES");


#
# Notify folks who have been outbid.
#

$msg = "You have been outbid on the following auction.

Auction #:    $auction_id
Auction Name: $auction_title

Place your new bid at:
https://$HTTP_HOST/auction/auction.php?id=$auction_id

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER TO DEALER©.
";

while (list($old_user_id) = each($lusers)) {
	if (!empty($old_user_id) && $old_user_id != $new_user_id) {
		$result = db_do("SELECT email FROM users where " .
		    "id='$old_user_id'");
		list($email) = db_row($result);
		db_free($result);

		if (!empty($email)) {
			mail($email, "Outbid notice for auction #$auction_id", $msg, $EMAIL_FROM);
		}
	}
}
?>