<?php

$page_title = 'Update Pending Auction';

if (empty($id) || $id <= 0) {
	header('Location: index.php?s=pending');
	exit;
}

include('../../../include/db.php');
db_connect();

$result = db_do("SELECT id FROM auctions WHERE id='$id'");
if (db_num_rows($result) <= 0) {
	header('Location: index.php?s=pending');
	exit;
}

db_free($result);

$result = db_do("SELECT id FROM auctions WHERE id='$id' AND " .
    "status='pending'");

db_free($result);

$title         = trim($title);
$description   = trim($description);
$condition	   = trim($condition);
$minimum_bid   = fix_price($minimum_bid);
$reserve_price = fix_price($reserve_price);
$buy_now_price = fix_price($buy_now_price);
$errors        = '';

if (isset($submit)) {
	if (empty($title))
		$errors .= '<li>You must specify a title.</li>';

	if (empty($description))
		$errors .= '<li>You must describe this auction.</li>';
		
	if (empty($condition))
		$errors .= '<li>You must specify a condition for this auction.</li>';

	if ($minimum_bid <= 0)
		$errors .= '<li>You must specify the starting price for bidding.</li>';

	if (!empty($reserve_price) && $reserve_price != 0 && $reserve_price < $minimum_bid)
		$errors .= '<li>Your reserve price must be higher or equal to the minimum bid.</li>';

	if (!empty($buy_now_price) && $buy_now_price != 0 && $buy_now_price < $minimum_bid)
		$errors .= '<li>Your buy now price must be higher of equal to the minimum bid.</li>';

	#$now  = time();
	#$then = mktime($starts_hour, 0, 0, $starts_month, $starts_day,
	#    $starts_year);

	#if ($now > $ends)
	#	$errors .= '<li>You must choose a future start date.</li>';

	if (empty($errors)) {
	#	$starts = "$starts_year-$starts_month-$starts_day " .
	#	    "$starts_hour:00";
	#	$ends   = date('Y-m-d H:i', strtotime("+$duration days",
	#	    $then));

		if (empty($reserve_price))
			$reserve_price = 0;

		db_do("UPDATE auctions SET title='$title', description='$description', condition_report='$condition', " .
		    "minimum_bid='$minimum_bid', " .
		    "reserve_price='$reserve_price', " .
		    "buy_now_price='$buy_now_price', " .
		    "bid_increment='$bid_increment', " .
		    "pays_transport='$pays_transport' WHERE id='$id'");

		db_disconnect();

		header("Location: preview.php?id=$id");
		exit;
	}
} else {
	$result = db_do("SELECT category_id, subcategory_id1, subcategory_id2, title, description, condition_report, " .
	    "minimum_bid, reserve_price, buy_now_price, bid_increment, " .
	    "DATE_FORMAT(starts, '%a, %e %M %Y %H:%i'), DATE_FORMAT(ends, '%a, %e %M %Y %H:%i'), duration, pays_transport FROM auctions WHERE id='$id'");
	list($cid, $subcid1, $subcid2, $title, $description, $condition, $minimum_bid, $reserve_price,
	    $buy_now_price, $bid_increment, $starts, 
			$ends, $duration, $pays_transport)
	    = db_row($result);
		
	$buy_now_price_orig = $buy_now_price;
	$reserve_price_orig = $reserve_price;
	
	db_free($result);

	$starts_year  = substr($starts, 0, 4);
	$starts_month = substr($starts, 4, 2);
	$starts_day   = substr($starts, 6, 2);
	$starts_hour  = substr($starts, 8, 2);
}

$title         = stripslashes($title);
$description   = stripslashes($description);
$condition	   = stripslashes($condition);
$minimum_bid   = stripslashes($minimum_bid);
$reserve_price = RemoveNonNumericChar($reserve_price);
$buy_now_price = RemoveNonNumericChar($buy_now_price);

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
include('_form.php');
db_disconnect();
?>
