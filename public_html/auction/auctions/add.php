<?php

$page_title = 'Create a Wholesale Auction';
$help_page = "chp6_activate.php";

include('../../../include/session.php');
//include('../../../include/defs.php');
include('_requests.php');
extract(defineVars("z", "q", "no_menu", "id", "in",
"title", "description", "condition", "current_bid", "minimum_bid",
"minimum_bid_orig", "reserve_price", "reserve_price_orig", "buy_now_price",
"buy_now_price_orig", "buy_now_end", "invoice", "pays_transport", "submit",
"starts_hour", "starts_month", "starts_day", "starts_year", "ends_hour",
"ends_month", "ends_day", "ends_year", "bid_increment", "no_reserve",
"vid", "cid", "subcid1", "subcid2"));    // Added by RJM 1/4/10


if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (empty($vid) || $vid <= 0) {
	header('Location: ../vehicles/index.php');
	exit;
}

include_once('../../../include/db.php');
db_connect();

$result = db_do("SELECT id FROM vehicles WHERE id='$vid' AND dealer_id='$dealer_id'");
if (db_num_rows($result) <= 0) {
	 db_free($result);
	header('Location: ../vehicles/index.php');
	exit;
}

db_free($result);

$result = db_do("SELECT id FROM auctions WHERE vehicle_id='$vid'" .
    " AND (status='pending' OR status='active')");
if (db_num_rows($result) > 0) {
	header("Location: http://$_SERVER[SERVER_NAME]/auction/vehicles/");
	exit;
}


$minimum_bid   = fix_price($minimum_bid);
$reserve_price = fix_price($reserve_price);
$buy_now_price = fix_price($buy_now_price);
$buy_now_end   = fix_price($buy_now_end);
$errors        = '';

if (!empty($submit)) {

	if (empty($title))
		$errors .= '<li>You must specify a title.</li>';

	if (empty($description))
   $errors .= '<li>You must describe this auction.</gdtd/req_auc.sql/li>';

	if (empty($condition))
		$errors .= '<li>You must specify a condition for this auction.</li>';

	if (($minimum_bid <= 0) && (!$invoice))
                        $errors .= '<li>Y/gdtd/req_auc.sqlou must specify the starting price for ' .
		    'bidding.</li>';

	if (!empty($reserve_price) && $reserve_price != 0 &&
	    $reserve_price < $minimum_bid)
		$errors .= '<li>Your reserve price must be higher or equal ' .
		    'to the minimum bid.</li>';

	if (!empty($buy_now_price) && $buy_now_price != 0 &&
	    $buy_now_price < $minimum_bid)
		$errors .= '<li>Your buy now price must be higher of equal ' .
		    'to the minimum bid.</li>';

	if ((empty($buy_now_price) || ($buy_now_price <= 1)) && $invoice)
		$errors .= '<li>You must specify a buy now price to disable bidding.</li>';

	$now  = time();
	$then = mktime($starts_hour, 0, 0, $starts_month, $starts_day, $starts_year);
	$later = mktime($ends_hour, 0, 0, $ends_month, $ends_day, $ends_year);

	if ($now > $then)
		$errors .= '<li>You must choose a future start date.</li>';

	if ($now > $later)
		$errors .= '<li>You must choose a future end date.</li>';

	if ($then > $later)
		$errors .= '<li>You cannot end an auction before it starts.</li>';

	if (($then + 2592000) < $later)
		$errors .= '<li>Your auction can not last longer than 30 days.</li>';

	if (($now + 86400) > $later)
		$errors .= '<li>Your auction must last at least 1 day.</li>';

	if (empty($errors)) {
		if (($no_reserve != 'yes' && $reserve_price == 0) || ($no_reserve == 'yes' && $reserve_price > 0))
			$errors .= '<li>Please check your Reserve Price.</li>
						<br>If you do not want your auction to have a Reserve, Please check the \'<span class="header">Verify NO RESERVE</span>\' box.
						<br>Otherwise enter a Reserve Price greater than $0.00, and leave the checkbox empty.<br>&nbsp;';
	}

	if (empty($errors)) {
		$starts = "$starts_year-$starts_month-$starts_day " .
		    "$starts_hour:00";
		$ends   = "$ends_year-$ends_month-$ends_day " .
		    "$ends_hour:00";

		$buy_now_end = $buy_now_price - $bid_increment;
		if ($buy_now_end < 0)
			$buy_now_end = 0;

		if (empty($reserve_price))
			$reserve_price = 0;

		if ($invoice)
			$invoice = 'yes';
		else
			$invoice = 'no';

		db_do("LOCK TABLES auctions WRITE, vehicles WRITE, bids WRITE");

		$id = $aid;

		$result = db_do("SELECT status FROM auctions WHERE vehicle_id='$vid'");
		list($status_old) = db_row($result);
		db_free($result);

		if ($status_old == 'pulled')
			db_do("UPDATE auctions SET status='pulled', current='no' WHERE vehicle_id='$vid'");
		else
			db_do("UPDATE auctions SET status='closed', current='no' WHERE vehicle_id='$vid'");

		db_do("UPDATE vehicles SET minimum_bid='$minimum_bid', reserve_price='$reserve_price',
				buy_now_price='$buy_now_price', buy_now_end='$buy_now_end', status='active', bid_increment='$bid_increment' WHERE id='$vid'");

		db_do("INSERT INTO auctions SET dealer_id='$dealer_id', user_id='$userid', disable_bid='$invoice',
				category_id='$cid', subcategory_id1='$subcid1', subcategory_id2='$subcid2',
				vehicle_id='$vid', title='$title', description='$description', condition_report='$condition',
				minimum_bid='$minimum_bid', reserve_price='$reserve_price', buy_now_price='$buy_now_price', buy_now_end='$buy_now_end',
				bid_increment='$bid_increment', auction_type='1', modified=NOW(), created=modified, active='yes',
				starts='$starts', ends='$ends', status='pending', current='yes', winning_bid='0', pays_transport='$pays_transport'");

		$id = db_insert_id();

		db_do("UNLOCK TABLES");

		#
		# Send out a confirmation that the auction has been
		# successfully created.
		#

		$result = db_do("SELECT CONCAT(first_name, ' ', last_name), email FROM users WHERE id='$userid'");
		list($full_name, $email) = db_row($result);
		db_free($result);

		$result = db_do("SELECT vehicles.miles, vehicles.vin, vehicles.hin, vehicles.condition_report, vehicles.comments, vehicles.stock_num,
						DATE_FORMAT(auctions.ends, '%a, %e %M %Y %H:%i'), DATE_FORMAT(auctions.starts, '%a, %e %M %Y %H:%i')
						FROM vehicles, auctions
						WHERE auctions.vehicle_id=vehicles.id AND auctions.id='$id'");
		list($miles, $vin, $hin, $condition, $comments, $stock_num, $endtime, $starttime) = db_row($result);
		db_free($result);

		if ($hin > 0)
			$in = "HIN:           $hin";
		else
			$in = "VIN:           $vin";

		$timezone = date('T');
		$minimum_bid = number_format($minimum_bid, 2);
		$reserve_price = number_format($reserve_price, 2);
		$buy_now_price = number_format($buy_now_price, 2);

		$title = stripslashes($title);
		$description = stripslashes($description);
		$condition	 = stripslashes($condition);

		$msg = "UserID: $username
Full Name: $full_name

You have successfully created the following auction:

Auction #:     $id
Auction Title: $title
Start Time:    $starttime $timezone
End Time:      $endtime $timezone
Bids Start at: US \$$minimum_bid
Reserve Price: US \$$reserve_price
Buy Now Price: US \$$buy_now_price
Stock Number:  $stock_num
$in
Comments:      $comments

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";
		mail($email, "Auction #$id Successfully Created", $msg, $EMAIL_FROM);

      notify_requesters($id, $title, $vid, $starttime);

		header("Location: preview.php?id=$id");
		exit;
  }
} else {
	$result = db_do("SELECT id, category_id, subcategory_id1, subcategory_id2, short_desc, long_desc, " .
	    "condition_report, minimum_bid, reserve_price, buy_now_price, buy_now_end, bid_increment FROM " .
	    "vehicles WHERE id='$vid'");
	list($vid, $cid, $subcid1, $subcid2, $title, $description, $condition, $minimum_bid, $reserve_price,
	    $buy_now_price, $buy_now_end, $bid_increment) = db_row($result);
	db_free($result);

	if (empty($condition)){
		header("Location: ../vehicles/condition.php?vid=$vid&e=e");
		exit;
	}

	$date = strtotime("+1 hours");
	$starts_year = date('Y', $date);
	$starts_month = date('m', $date);
	$starts_day = date('d', $date);
	$starts_hour = date('H', $date);

	$date_in_ten = $date + 864000;
	$date_in_seven = $date + 604800;


	$ends_year = date('Y', $date_in_seven);
	$ends_month = date('m', $date_in_seven);
	$ends_day = date('d', $date_in_seven);
	$ends_hour = date('H', $date_in_seven);
}

$title         = stripslashes($title);
$description   = stripslashes($description);
$condition	   = stripslashes($condition);
$minimum_bid   = stripslashes($minimum_bid);
$reserve_price = stripslashes($reserve_price);
$buy_now_price = stripslashes($buy_now_price);
$buy_now_end   = stripslashes($buy_now_end);

if ($minimum_bid <= 0)
	$minimum_bid = 1;

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