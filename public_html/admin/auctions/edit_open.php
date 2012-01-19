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
# $srp: godealertodealer.com/htdocs/admin/auctions/edit.php,v 1.2 2002/09/03 00:36:07 steve Exp $
#

include('../../../include/db.php');
db_connect();
extract(defineVars("id","title","description","condition","add_description","add_condition","reserve_price","buy_now_price","PHP_SELF",
				   "vid","id","in","cid","subcid1","subcid2",
				   "title","description","condition","minimum_bid","bid_increment","starts_month","starts_day","starts_year","starts_hour",
				   "ends_month","ends_day","ends_year","ends_hour","reserve_price","reserve_price_orig","buy_now_price","buy_now_price_orig",
				   "pays_transport","submit")); //JJM added 4/16/2010


$page_title = 'Update Open Auction';

if (empty($id) || $id <= 0) {
	header('Location: index.php?s=pending');
	exit;
}
$aid=$id;

$result = db_do("SELECT auctions.id, vehicles.id FROM auctions, vehicles
				WHERE auctions.id='$id'
				AND vehicles.id=auctions.vehicle_id AND auctions.status='open'");

if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}
list($aid, $vid) = db_row($result);
db_free($result);

$title				= trim($title);
$description		= trim($description);
$condition			= trim($condition);
$add_description	= trim($add_description);
$add_condition		= trim($add_condition);
$reserve_price		= fix_price($reserve_price);
$buy_now_price		= fix_price($buy_now_price);
$errors				= '';

if (isset($submit)) {
	if (empty($title))
		$errors .= '<li>You must specify a title.</li>';

	if (empty($description))
		$errors .= '<li>You must describe this auction.</li>';

	if (empty($condition))
		$errors .= '<li>You must specify a condition for this auction.</li>';

	if (!empty($reserve_price) && $reserve_price != 0 && $reserve_price < $minimum_bid)
		$errors .= '<li>Your reserve price must be higher or equal to the minimum bid.</li>';

	if (!empty($buy_now_price) && $buy_now_price != 0 && $buy_now_price < $minimum_bid)
		$errors .= '<li>Your buy now price must be higher of equal to the minimum bid.</li>';

	if (($reserve_price > $buy_now_price) && ($buy_now_price>1))
		$errors .= '<li>Your reserve price can not be higher than your buy now price.</li>';

	if ($starts_year > $ends_year)
		$errors .= '<li>The ending year must be later than the starting year.</li>';

if (empty($errors)) {
	if (empty($reserve_price))
			$reserve_price = 0;

	if (!empty($reserve_price) && $reserve_price < $reserve_price_orig) {
		 $reserve_lowered = 'yes';
	} else {
		 $reserve_lowered = 'no';
	}

	$s=$starts_year.$starts_month.$starts_day.$starts_hour.'0000';
	$e=$ends_year.$ends_month.$ends_day.$ends_hour.'0000';

		db_do("UPDATE auctions SET title='$title', description='$description', condition_report='$condition'," .  //JJM 5/16/2010 changed condition to condition_report
			"desc_mod=NOW(), cond_mod=NOW(), minimum_bid='$minimum_bid', " .
		    "reserve_price='$reserve_price', reserve_lowered='$reserve_lowered', " .
			"starts='$s', ends='$e', " .
		    "buy_now_price='$buy_now_price', bid_increment='$bid_increment', " .
		    "pays_transport='$pays_transport' WHERE id='$id'");

		$auction_id = $id;
		#$id = db_insert_id();

		$results = db_do("SELECT email, CONCAT(first_name, ' ', last_name) FROM users WHERE username='$username'");
		list($email, $full_name) = db_row($results);
	#
	# Notify folks who have placed bids.
	#
$msg = "UserID $username
Full Name: $full_name

This email is to notify you that you lowered the reserve price of this auction.

Auction #:     $auction_id
Auction Title: $title
$in
End Time:      $end_time
Reserve Price: \$".number_format($reserve_price, 2)."

Review your auction at:
http://$HTTP_HOST/auction/auction.php?id=$auction_id

Do not reply to this automated message.  This is not a monitored e-mail account.

Thank You,

Go DEALER to DEALER
";
		mail($email, "Reserve Lowered for Auction #$auction_id", $msg, $EMAIL_FROM);


		if($reserve_lowered == 'yes') {
			$results = db_do("SELECT users.email, users.first_name, users.last_name, users.username
								FROM  bids, users WHERE bids.auction_id='$auction_id' AND users.id=bids.user_id GROUP by users.id");
		while(list($email, $first_name, $last_name, $user_name) = db_row($results)) {
		#
		# Notify folks who have placed bids.
		#
$msg = "UserID $user_name
Full Name: $first_name $last_name

This email is to notify you that the reserve price of an auction that you have placed a bid on has been lowered.

Auction #:     $auction_id
Auction Title: $title
$in
End Time:      $end_time
Reserve Price: \$".number_format($reserve_price, 2)."

Place your new bid at:
http://$HTTP_HOST/auction/auction.php?id=$auction_id

Do not reply to this automated message.  This is not a monitored e-mail account.

Thank You,

Go DEALER to DEALER
";
			mail($email, "Auction #$auction_id Reserve Lowered", $msg, $EMAIL_FROM);
			}
			db_free($results);
		}
		db_disconnect();

		header("Location: index.php");
		exit;
	}
} else {
  $bid_result = db_do("SELECT count(*) from bids WHERE auction_id='$id'");
  list($bid_count) = db_row($bid_result);
	db_free($bid_result);

	$result = db_do("SELECT auctions.id, auctions.category_id, auctions.subcategory_id1, auctions.subcategory_id2,
				auctions.title, auctions.description, auctions.condition_report, auctions.add_description, auctions.add_condition,
				DATE_FORMAT(auctions.desc_mod, '%a, %e %M %Y %H:%i'), DATE_FORMAT(auctions.cond_mod, '%a, %e %M %Y %H:%i'),
				auctions.reserve_price, auctions.reserve_lowered, auctions.buy_now_price, auctions.minimum_bid, auctions.bid_increment,
				DATE_FORMAT(auctions.starts, '%a, %e %M %Y %H:%i'), DATE_FORMAT(auctions.ends, '%a, %e %M %Y %H:%i'), DATE_FORMAT(auctions.starts, '%m'), DATE_FORMAT(auctions.ends, '%m'), DATE_FORMAT(auctions.starts, '%e'), DATE_FORMAT(auctions.ends, '%e'), DATE_FORMAT(auctions.starts, '%Y'), DATE_FORMAT(auctions.ends, '%Y'), DATE_FORMAT(auctions.starts, '%H'), DATE_FORMAT(auctions.ends, '%H'),
				vehicles.id, vehicles.vin, vehicles.hin, auctions.pays_transport FROM auctions, vehicles
				WHERE auctions.id='$id'
				AND vehicles.id=auctions.vehicle_id AND auctions.status='open'");
	list($id, $cid, $subcid1, $subcid2, $title, $description, $condition, $add_description, $add_condition, $desc_mod, $cond_mod,
		$reserve_price, $reserve_lowered, $buy_now_price, $minimum_bid, $bid_increment, $starts, $ends, $starts_month, $ends_month, $starts_day, $ends_day, $starts_year, $ends_year, $starts_hour, $ends_hour, $vid, $vin, $hin, $pays_transport)
	    = db_row($result);
	db_free($result);

	if ($hin > 0)
		$in = "HIN:           $hin";
	else
		$in = "VIN:           $vin";

	$title         = stripslashes($title);
	$description   = stripslashes($description);
	$condition		= stripslashes($condition);
	$add_description   = stripslashes($add_description);
	$add_condition	= stripslashes($add_condition);
	$reserve_price = stripslashes($reserve_price);
	$reserve_lowered = stripslashes($reserve_lowered);
	$buy_now_price = stripslashes($buy_now_price);

	$buy_now_price_orig = $buy_now_price;
	$reserve_price_orig = $reserve_price;
}

?>
<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
<?php
include('_links.php');
include('_links_edit.php');
echo "<br>";
include('_form.php');
db_disconnect();
?>
