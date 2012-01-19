<?php

include('../../include/session.php');
//include('../../include/defs.php');  JJM commented out 1/31/10 already used in session or db
include('../../include/db.php');
db_connect();

extract(defineVars("id","dealer_id","submit_buy")); //JJM 1/31/10

//JJM 1/31/10 Also had to move this if statement below the id check
if (empty($id) || $id <= 0) {
	header('Location: index.php');
	exit;
}

$page_title = "Buy Now - Auction #$id";
$help_page = "chp5_place.php";


$result = db_do("SELECT can_buy FROM dealers WHERE id='$dealer_id'");
list($can_buy) = db_row($result);
db_free($result);

if (!$can_buy) {
	header("Location: auction.php?id=$id");
	exit;
}

$result = db_do("SELECT categories.name, auctions.dealer_id, auctions.title, " .
    "auctions.description, auctions.minimum_bid, auctions.reserve_price, " .
    "auctions.buy_now_price, auctions.buy_now_end, auctions.current_bid, auctions.dealer_id, " .
    "DATE_FORMAT(auctions.starts, '%a, %e %M %Y %H:%i'), " .
    "DATE_FORMAT(auctions.ends, '%a, %e %M %Y %H:%i'), " .
    "auctions.status, auctions.vehicle_id, vehicles.year, vehicles.vin, vehicles.hin, " .
    "vehicles.make, vehicles.model, vehicles.city, vehicles.state, vehicles.stock_num, " .
    "vehicles.zip, vehicles.photo_id, vehicles.condition_report, auctions.disable_bid " .
    "FROM auctions " .
    "LEFT JOIN categories ON auctions.category_id = categories.id " .
    "LEFT JOIN vehicles ON auctions.vehicle_id = vehicles.id " .
    "WHERE auctions.id = '$id'"); //JJM 1/31/10 Altered to use left join instead of the old style join

if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}

list($category, $seller, $title, $description, $minimum_bid, $reserve_price,
    $buy_now_price, $buy_now_end, $current_bid, $did, $starts, $ends, $status, $vid, $year,
    $vin, $hin, $make, $model, $city, $state, $stock_num, $zip, $photo, $condition, $disable_bid)
    = db_row($result);

	if ($hin > 0)
		$in = "HIN:               $hin";
	else
		$in = "VIN:               $vin";

db_free($result);

#
# A dealer can't bid on her own vehicles.
#
if ($did == $dealer_id) {
	header('Location: index.php');
	exit;
}

if (($status != 'open') || ($current_bid >= $buy_now_end && $disable_bid == 'no') ) {
	header("Location: auction.php?id=$id");
	exit;
}

if (isset($submit_buy)) {
	$bid = $buy_now_price;
	$buy_now_price = number_format($buy_now_price, 2);

	db_do("LOCK TABLE auctions WRITE, bids WRITE");

	db_do("INSERT INTO bids SET auction_id='$id', " .
	    "dealer_id='$dealer_id', user_id='$userid', opening_bid='$bid', " .
	    "current_bid='$bid', maximum_bid='0', modified=NOW(), " .
	    "created=modified");
	$b = db_insert_id();

	db_do("UPDATE auctions SET current_bid='$bid', winning_bid='$b', " .
	    "status='closed', ends=NOW(), chaching=1 WHERE id='$id'");

	db_do("UNLOCK TABLES");

	db_do("UPDATE vehicles SET status='inactive', sell_price='$bid' " .
	    "WHERE id='$vid'");

	$result = db_do("SELECT percentage FROM fees WHERE low<='$bid' AND " .
	    "high>='$bid'");

	if (db_num_rows($result) != 0)
		list($percentage) = db_row($result);
	else
		$percentage = 1;

	db_free($result);

	#
	# Calculate the fee but make sure to not put any commas in the result.
	#

	$fee = number_format(($bid * $percentage) / 100, 2, '.', '');

	#
	# Charge the buyer a fee for purchasing this vehicle.
	#

	db_do("INSERT INTO charges SET auction_id='$id', " .
	    "dealer_id='$dealer_id', user_id='$userid', vehicle_id='$vid', " .
	    "fee='$fee', fee_type='buy', modified=NOW(), created=modified, " .
	    "status='open'");

	$result_info = db_do("SELECT aes.user_id, aes.commission_percentage, dms.user_id, dms.override_percentage
				FROM aes, dms, dealers
				WHERE dealers.id='$dealer_id' AND dealers.ae_id=aes.id AND aes.dm_id=dms.id");
	list($ae_user_id, $ae_com, $dm_user_id, $dm_ovr) = db_row($result_info);

	$commission = $override = 0;
	$commission = $fee * $ae_com;
	if ($dm_user_id != $ae_user_id)
		$override = $dm_ovr * $commission;

	db_do("INSERT INTO commission
	SET type_id='$id', ae_user_id='$ae_user_id', commission='$commission', dm_user_id='$dm_user_id', override='$override',
	fee_type='buy', dealer_type='buyer', modified=NOW(), created=NOW()");

	$buy_ref_no = date('Ymd') . "-" . db_insert_id();

	#
	# Get seller information.
	#

	$result = db_do("SELECT users.id, users.username, users.first_name, users.last_name, " .
	    "users.email, users.phone, users.address1, users.address2, users.city, users.state, ".
		"users.zip, dealers.has_sell_fee FROM auctions, " .
	    "users, dealers WHERE auctions.id='$id' AND " .
	    "auctions.user_id=users.id AND dealers.id=users.dealer_id");
	list($seller_id, $seller_user_name, $first_name, $last_name, $seller_email, $seller_phone, $seller_address1, $seller_address2, $seller_city, $seller_state, $seller_zip, $has_sell_fee) = db_row($result);
	db_free($result);

	$seller_name = "$first_name $last_name";

	#
	# If the seller pays a fee then add that to charges now.
	#

	if ($has_sell_fee) {
		db_do("INSERT INTO charges SET auction_id='$id', " .
		    "dealer_id='$seller', user_id='$seller_id', " .
		    "vehicle_id='$vid', fee='$fee', fee_type='sell', " .
		    "modified=NOW(), created=modified, status='open'");

		$result_info = db_do("SELECT aes.user_id, aes.commission_percentage, dms.user_id, dms.override_percentage
				FROM aes, dms, dealers
				WHERE dealers.id='$seller' AND dealers.ae_id=aes.id AND aes.dm_id=dms.id");
		list($ae_user_id, $ae_com, $dm_user_id, $dm_ovr) = db_row($result_info);

		$commission = $override = 0;
		$commission = $fee * $ae_com;
		if ($dm_user_id != $ae_user_id)
			$override = $dm_ovr * $commission;

		db_do("INSERT INTO commission
		SET type_id='$id', ae_user_id='$ae_user_id', commission='$commission', dm_user_id='$dm_user_id', override='$override',
		fee_type='sell', dealer_type='seller', modified=NOW(), created=NOW()");

		$sell_ref_no = date('Ymd') . "-" . db_insert_id();
	} else {
		$result_info = db_do("SELECT aes.user_id, aes.commission_percentage, dms.user_id, dms.override_percentage
				FROM aes, dms, dealers
				WHERE dealers.id='$seller' AND dealers.ae_id=aes.id AND aes.dm_id=dms.id");
		list($ae_user_id, $ae_com, $dm_user_id, $dm_ovr) = db_row($result_info);

		$commission = $override = 0;
		$commission = $fee * $ae_com;
		if ($dm_user_id != $ae_user_id)
			$override = $dm_ovr * $commission;

		db_do("INSERT INTO commission
		SET type_id='$id', ae_user_id='$ae_user_id', commission='$commission', dm_user_id='$dm_user_id', override='$override',
		fee_type='buy', dealer_type='seller', modified=NOW(), created=NOW()");
	}

	#
	# Get buyer information.
	#

	$result = db_do("SELECT first_name, last_name, email, phone, address1, address2, city, " .
	"state, zip FROM users WHERE id='$userid'");
	list($first_name, $last_name, $buyer_email, $buyer_phone, $buyer_address1, $buyer_address2, $buyer_city, $buyer_state, $buyer_zip) = db_row($result);
	db_free($result);

	$buyer_name = "$first_name $last_name";

	#
	# Put the fee in human readable format including commas where needed.
	#

	$fee = number_format($fee, 2);

	#
	# Send notification to the buyer.
	#

	$msg = "UserID: $username
Full Name: $buyer_name

Congratulations on your Buy Now decision for the following auction:

Auction #:     $id
Auction Title: $title
$in
Buy Now Price: \$$buy_now_price


Please contact the seller within the next 24 hours to coordinate payment for
and transfer of the item.

Name:    $seller_name
Phone:   $seller_phone
E-mail:  $seller_email
Address: $seller_address1";
if ($seller_address2!=NULL) {
	$msg .= "$\n         $seller_address2";
	}
$msg .= "\nCity:    $seller_city
State:   $seller_state
Zip:     $seller_zip

Your Buy Now fee due to Go DEALER to DEALER. is:

US \$$fee	reference#: $buy_ref_no

This fee will be added to your account and automatically processed monthly.

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";

	mail($buyer_email, 'Buy Now confirmation for auction #' . $id, $msg,
	    $EMAIL_FROM);

	#
	# Send notification to the seller.
	#

	$msg = "UserID: $seller_user_name
Full Name: $seller_name

Congratulations, your Buy Now option has been accepted for the following auction:

Auction #:         $id
Auction Title:     $title
Stock Number:      $stock_num
$in
Buy Now Price: \$$buy_now_price

Please contact the buyer within the next 24 hours to coordinate payment for
and transfer of the item.

Name:    $buyer_name
Phone:   $buyer_phone
E-mail:  $buyer_email
Address: $buyer_address1";
if ($buyer_address2!=NULL) {
	$msg .= "$\n         $buyer_address2";
	}
$msg .= "\nCity:    $buyer_city
State:   $buyer_state
Zip:     $buyer_zip
";

	if ($has_sell_fee) {
		$msg .= "
Your Sell fee due to Go DEALER to DEALER is:

US \$$fee	reference#: $sell_ref_no

This fee will be added to your account and automatically processed monthly.
";
	}

	$msg .= "
Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank you,

Go DEALER to DEALER";

	mail($seller_email, 'Buy Now option accepted for auction #' . $id, $msg,
	    $EMAIL_FROM);

	#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
	#xxx
	#xxx Do we need to send an "outbid notice" is there's a current
	#xxx winning bid?
	#xxx
	#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

	header('Location: bids/won.php');
	exit;
}

$timezone = date('T');

$starts .= " $timezone";
$ends   .= " $timezone";

$result = db_do("SELECT COUNT(*) FROM bids WHERE auction_id='$id'");
list($count_bids) = db_row($result);
db_free($result);

if (empty($count_bids))
	$count_bids = 0;

if (!empty($photo) && file_exists("uploaded/$photo.jpg")) {
	$image = "<img src=\"uploaded/$photo.jpg\">";

	$result = db_do("SELECT caption FROM photos WHERE id='$photo'");
	list($caption) = db_row($result);
	db_free($result);
} else
	$image = '&nbsp;';

include('header.php');
?>

  <br>
  <p align="center" class="big">Confirm your <b>Buy Now</b> price of <b>US $<?php echo number_format($buy_now_price, 2); ?></b> for auction <b>#<?php echo $id; ?></b>.</p>
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <input type="hidden" name="id" value="<?php echo $id; ?>" />
   <table align="center" border="0" cellpadding="4" cellspacing="0">
    <tr>
     <td align="right" class="header">Auction Title:</td>
     <td class="normal"><a href="auction.php?id=<?php echo $id; ?>"><?php echo $title; ?></a></td>
    </tr>
    <tr>
     <td align="right" class="header">Item:</td>
     <td class="normal"><?php echo "$year $make $model"; ?></td>
    </tr>
    <tr>
     <td align="right" class="header">Starts:</td>
     <td class="normal"><?php echo $starts; ?></td>
    </tr>
    <tr>
     <td align="right" class="header">Ends:</td>
     <td class="normal"><?php echo $ends; ?></td>
    </tr>
    <tr>
     <td align="right" class="header">Location:</td>
     <td class="normal"><?php echo "$city, $state $zip"; ?></td>
    </tr>
    <tr><td class="small" colspan="2">&nbsp;</td></tr>
    <tr>
     <td align="center" class="normal" colspan="2"><input type="submit" name="submit_buy" value=" Confirm Bid " /></td>
    </tr>
   </table>
  </form>

<?php
db_disconnect();
include('footer.php');
?>
