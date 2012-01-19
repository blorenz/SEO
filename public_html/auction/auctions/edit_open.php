<?php

#
# List of folks to notify if the reserve is lowered.
#

include('../../../include/session.php');
//include('../../../include/defs.php');  //JJM 1/31/10 commented out, don't need, included somewhere else
include('../../../include/db.php');
db_connect();

extract(defineVars("id","dealer_id", "vid",  "submit", "confirm", //JJM 1/31/10 added, need variables
				"title", "description", "condition", "add_description",
				"add_condition", "reserve_price", "buy_now_price", "buy_now_end",
				"current_bid", "minimum_bid", "reserve_price_orig",
				"minimum_bid_orig", "buy_now_price_orig",
				"in","cid","subcid1","subcid2","bid_count", //JJM 8/27/10 added more variables were missing from edit_open.php
				"starts","ends","bid_increment","no_reserve","invoice"));


$page_title = 'Update Open Auction';
$help_page = "chp6_activate.php";

if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (empty($id) || $id <= 0) {
	header('Location: index.php');
	exit;
}


$result = db_do("SELECT auctions.id FROM auctions, vehicles
				WHERE auctions.id='$id' AND auctions.dealer_id='$dealer_id'
				AND vehicles.id=auctions.vehicle_id AND auctions.status='open'");

if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}

db_free($result);

$title				= trim($title);
$description		= trim($description);
$condition			= trim($condition);
$add_description	= trim($add_description);
$add_condition		= trim($add_condition);
$reserve_price		= fix_price($reserve_price);
$buy_now_price		= fix_price($buy_now_price);
$buy_now_end		= fix_price($buy_now_end);
$errors				= '';
$lowerReserveFlag	= '';


if (isset($submit)) {
	if (empty($title))
		$errors .= '<li>You must specify a title.</li>';

	if (empty($description))
		$errors .= '<li>You must describe this auction.</li>';

	if (empty($condition))
		$errors .= '<li>You must specify a condition for this auction.</li>';

	if (!empty($reserve_price) && $reserve_price != 0 && $reserve_price <= $current_bid)
		$errors .= "<li>Your reserve price must be higher than the current bid of $current_bid.</li>";

	if (!empty($reserve_price) && $reserve_price < $minimum_bid && $reserve_price_orig != $reserve_price)
		$errors .= "<li>Your reserve price must be higher or equal to the minimum bid.</li>";

	if (!empty($buy_now_price) && $buy_now_price != 0 && $buy_now_price < $minimum_bid)
		$errors .= '<li>Your buy now price must be higher or equal to the minimum bid.</li>';

	if ($reserve_price_orig < $reserve_price)
		$errors .= '<li>Your reserve price can not be increased.</li>';

	if ($minimum_bid_orig < $minimum_bid)
		$errors .= '<li>Your starting price can not be increased.</li>';

	if ($buy_now_price_orig < $buy_now_price)
		$errors .= '<li>Your buy now price can not be increased.</li>';

	if ($reserve_price > $buy_now_price && $buy_now_price > 0)
		$errors .= '<li>Your reserve price can not be higher than your buy now price.</li>';

	if (empty($errors)) {
		if (($no_reserve != 'yes' && $reserve_price == 0) || ($no_reserve == 'yes' && $reserve_price > 0))
			$errors .= '<li>Please check your Reserve Price.</li>
						<br>If you do not want your auction to have a Reserve, Please check the \'<span class="header">Verify NO RESERVE</span>\' box.
						<br>Otherwise enter a Reserve Price greater than $0.00, and leave the checkbox empty.<br>&nbsp;';
	}

if (empty($errors)) {
	if ($reserve_price_orig > $reserve_price && $confirm != 'yes')
		$errors .= "<div align='center'>Please confirm that you are lowering your Reserve to $".number_format($reserve_price, 2)."<br>
			By selecting 'Yes' and then clicking the 'Update Open Auction' button.</div>";
		$lowerReserveFlag = 'Y'; //JJM added 7/6/2010, the reserve Y/N selection box was showing when it shouldn't
}

if (empty($errors)) {
	if (empty($reserve_price))
			$reserve_price = 0;

	if (!empty($reserve_price) && $reserve_price < $reserve_price_orig) {
		 $reserve_lowered = 'yes';
	} else {
		 $reserve_lowered = 'no';
	}

   // if the "disable bid" box wasn't checked, set it to no.
   if (empty($_GET['invoice'])) $_GET['invoice'] = 'no';

		db_do("UPDATE auctions SET title='$title', add_description='$add_description', add_condition='$add_condition', minimum_bid='$minimum_bid',
				desc_mod=NOW(), cond_mod=NOW(), reserve_price='$reserve_price', reserve_lowered='$reserve_lowered',
				buy_now_price='$buy_now_price', bid_increment='$bid_increment', pays_transport='$pays_transport', buy_now_end='$buy_now_end', disable_bid='$_GET[invoice]'
				WHERE id='$id'");

		if (isset($condition) && isset($description)) {
			db_do("UPDATE auctions SET description='$description', condition_report='$condition' WHERE id='$id'");
		}

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
End Time:      $ends
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
End Time:      $ends
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
				DATE_FORMAT(auctions.desc_mod, '%a, %e %M %Y %H:%i'), DATE_FORMAT(auctions.cond_mod, '%a, %e %M %Y %H:%i'), auctions.current_bid,
				auctions.reserve_price, auctions.reserve_lowered, auctions.buy_now_price, auctions.minimum_bid, auctions.bid_increment,
				DATE_FORMAT(auctions.starts, '%a, %e %M %Y %H:%i'), DATE_FORMAT(auctions.ends, '%a, %e %M %Y %H:%i'),
				vehicles.vin, vehicles.hin, auctions.pays_transport, auctions.buy_now_end,
            auctions.disable_bid
				FROM auctions, vehicles
				WHERE auctions.id='$id' AND auctions.dealer_id='$dealer_id'
				AND vehicles.id=auctions.vehicle_id AND auctions.status='open'");
	list($id, $cid, $subcid1, $subcid2, $title, $description, $condition, $add_description, $add_condition, $desc_mod, $cond_mod, $current_bid,
		$reserve_price, $reserve_lowered, $buy_now_price, $minimum_bid, $bid_increment, $starts, $ends, $vin, $hin, $pays_transport, $buy_now_end, $invoice)
	    = db_row($result);
	db_free($result);

	if ($hin > 0)
		$in = "HIN:           $hin";
	else
		$in = "VIN:           $vin";

	$title         	= stripslashes($title);
	$description   	= stripslashes($description);
	$condition		= stripslashes($condition);
	$add_description = stripslashes($add_description);
	$add_condition	= stripslashes($add_condition);
	$current_bid 	= stripslashes($current_bid);
	$reserve_price 	= stripslashes($reserve_price);
	$reserve_lowered = stripslashes($reserve_lowered);
	$buy_now_price 	= stripslashes($buy_now_price);
	$minimum_bid 	= stripslashes($minimum_bid);

	$buy_now_price_orig = $buy_now_price;
	$reserve_price_orig = $reserve_price;
	$minimum_bid_orig = $minimum_bid;
}

include('../header.php');
?>

  <br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include('_links.php'); ?>
<?php
include('_form.php');
include('../footer.php');
db_disconnect();
?>
