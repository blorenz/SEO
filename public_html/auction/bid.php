<?php

//moved these two includes abocve the $page title so we can get the id value in the title
include('../../include/session.php');
include('../../include/defs.php');

extract(defineVars("id","amount","submit_bid","maximum_bid","dealer_id","submit2"));

$page_title = "Bid on Auction #$id";
$help_page = "chp5_place.php";

if (empty($id) || $id <= 0 || !has_priv('buy', $privs)) {
	header('Location: index.php');
	exit;
}

include('../../include/db.php');
db_connect();

$result = db_do("SELECT can_buy FROM dealers WHERE id='$dealer_id'");
list($can_buy) = db_row($result);
db_free($result);

if (!$can_buy) {
	header("Location: auction.php?id=$id");
	exit;
}

$result = db_do("SELECT categories.name, auctions.title, auctions.status, " .
    "auctions.description, auctions.minimum_bid, auctions.reserve_price, " .
    "auctions.current_bid, auctions.bid_increment, auctions.dealer_id, auctions.user_id, " .
    "DATE_FORMAT(auctions.starts, '%a, %e %M %Y %H:%i'), " .
    "DATE_FORMAT(auctions.ends, '%a, %e %M %Y %H:%i'), auctions.ends, " .
    "auctions.vehicle_id, vehicles.year, vehicles.make, " .
    "vehicles.model, vehicles.city, vehicles.state, vehicles.zip, " .
    "vehicles.photo_id, vehicles.vin, vehicles.hin, vehicles.stock_num, vehicles.condition_report FROM auctions, categories, " .
    "vehicles WHERE auctions.id='$id' AND auctions.category_id=categories.id " .
    "AND auctions.vehicle_id=vehicles.id");

if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}

list($category, $title, $status, $description, $minimum_bid, $reserve_price,
    $current_bid, $bid_increment, $did, $uid, $starts, $ends, $end_time, $vid, $year, $make,
    $model, $city, $state, $zip, $photo, $vin, $hin, $stock_num, $condition) = db_row($result);
db_free($result);

#
# A dealer can't bid on her own vehicles.
#
if ($did == $dealer_id) {
	header('Location: index.php');
	exit;
}

$amount = fix_price($amount);

$errors = '';

if (isset($submit_bid)) {

if ($hin > 0)
	$in = "HIN:           $hin";
else
	$in = "VIN:           $vin";

	if ($status != 'open') {

		$result = db_do("SELECT CONCAT(first_name, ' ', last_name), email FROM users where id='$userid'");
		list($full_name, $email) = db_row($result);
		db_free($result);

			$msg = "UserID: $username
Full Name: $full_name

Your bid of US \$" . number_format($amount, 2) . " has been rejected for the following auction:

Auction #:     $id
Auction Title: $title
$in
End Time:      $ends

Possible reasons for rejection could be due to a cancelled auction or this auction was pulled while you were viewing it.

You can view the item at the following URL:

http://$HTTP_HOST/auction/auction.php?id=$id

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";
		mail($email, "Bid rejected for auction #".$id, $msg, $EMAIL_FROM);

		header("Location: auction.php?id=$id");
		exit;
	}

	$maximum_bid = fix_price($maximum_bid);
	if ($maximum_bid > 0 && $maximum_bid <= $amount)
		$errors = "Your maximum bid must exceed the current bid " .
		    "amount.";

	if (empty($errors)) {
		db_do("LOCK TABLES auctions READ, alerts WRITE, bids WRITE");

		if ($amount <= $current_bid) {
			db_do("UNLOCK TABLES");
			header("Location: auction.php?id=$id");
			exit;
		}

		$true_amount = $amount;

		if ($reserve_price > 0 && $maximum_bid > 0) {
			if ($maximum_bid > $reserve_price && $amount < $reserve_price )
				$amount = $reserve_price;
			elseif ($reserve_price >= $maximum_bid)
				$amount = $maximum_bid;
		}

		$result_offer = db_do("SELECT id FROM alerts WHERE vehicle_id='$vid' and status='pending'");
		if (db_num_rows($result_offer) > 0) {

			$result_alert = db_do("SELECT auction_id, to_user, from_user FROM alerts WHERE vehicle_id='$vid'");
			while(list($alert_auction_id, $to_user, $from_user) = db_row($result_alert)) {

				$msg = "Auction # $alert_auction_id is no longer available for make offer.

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";

				db_do("UNLOCK TABLES");
				if ($from_user > 0) {
					$result_email = db_do("SELECT email FROM users WHERE id='$from_user'");
					list($from_user_email) = db_row($result_email);
					mail($from_user_email, 'Make Offer ended for auction #' . $alert_auction_id, $msg, $EMAIL_FROM);
					db_free($result_email);
				}
				if ($to_user > 0) {
					$result_email = db_do("SELECT email FROM users WHERE id='$to_user'");
					list($to_user_email) = db_row($result_email);
					mail($to_user_email, 'Make Offer ended for auction #' . $alert_auction_id, $msg, $EMAIL_FROM);
					db_free($result_email);
				}
			}
			db_do("DELETE FROM alerts WHERE vehicle_id='$vid'");
			db_do("LOCK TABLES auctions READ, alerts WRITE, bids WRITE");
		}


		db_do("INSERT INTO bids SET auction_id='$id', " .
		    "dealer_id='$dealer_id', user_id='$userid', " .
		    "opening_bid='$true_amount', current_bid='$amount', " .
		    "maximum_bid='$maximum_bid', modified=NOW(), " .
		    "created=modified");

		#db_do("INSERT INTO alerts
				#SET from_user='0', to_user='$userid', auction_id='$id', vehicle_id='$vid',
					#offer_value='0', final_bid='$amount', reserve_price='$reserve_price'");

		#
		# If the end of the auction is within the next 5 minutes, extend the auction
		# by 5 more minutes
		#

		if (timeLeftLessThan5Min($end_time) ) {
			 		$end_time = add5MinToNow($end_time);

					db_do("UPDATE auctions SET ends=FROM_UNIXTIME($end_time)+0 WHERE id=$id");
		}

		db_do("UNLOCK TABLES");

		#
		# Send out bid confirmation.
		#

		$result = db_do("SELECT CONCAT(first_name, ' ', last_name), " .
		    "email FROM users where id='$userid'");
		list($full_name, $email) = db_row($result);
		db_free($result);

		$title = stripslashes($title);
		$msg = "UserID: $username
Full Name: $full_name

Your bid of US \$" . number_format($amount, 2) . " has been accepted for the following auction:

Auction #:     $id
Auction Title: $title
$in
End Time:      $ends
";

		if ($amount >= $reserve_price) {
			$msg .= "\nThe reserve price for this auction HAS " .
			    "been met.\n";
			$buyer_subject = "Bid accepted for auction #" . $id . " (Reserve Met)";
			}
		elseif ($reserve_price > 0) {
			$msg .= "\nThe reserve price for this auction has " .
			    "NOT been met.\n";
			$buyer_subject = "Bid accepted for auction #" . $id . " (Reserve Not Met)";
			}

		$msg .= "\nYou can review the item at the following URL:

http://$HTTP_HOST/auction/auction.php?id=$id

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";
		mail($email, $buyer_subject, $msg,
		    $EMAIL_FROM);

		if ($reserve_price > 0 && $amount >= $reserve_price && $current_bid<$reserve_price) {
			$result = db_do("SELECT email, first_name, last_name, username FROM auctions, users " .
			    "WHERE auctions.id='$id' AND " .
			    "auctions.user_id=users.id");
			list($email, $seller_first_name, $seller_last_name, $seller_user_name) = db_row($result);
			db_free($result);

			$msg = "UserID: $seller_user_name
Name: $seller_first_name $seller_last_name

Your reserve price has been met for auction:

Auction #:     $id
Auction Title: $title

Reserve Price: \$" . number_format($amount, 2) . "\n
Stock Number:  $stock_num
$in
Start Time:    $starts
End Time:      $ends " .

			    "\n\nYou can review the item at the following " .
			    "URL:\nhttp://$HTTP_HOST/auction/auction.php?id=$id\n\n " .

				"This item is now considered a \"guaranteed sale.\"  You will need to " .
				"remove this item from all retail venues and prepare it for sale and " .
				"transport.  Bidding may continue until your designated end of auction " .
				"time.  You will be given the final bidder's contact information once the auction closes.\n\n" .

				"Do not reply to this automated message.  " .
			    "This is not a monitored e-mail account.\n\nThank You,\n" .
			    "\nGo DEALER to DEALER";

			mail($email, "Reserve Met for auction #" . $id, $msg,
			    $EMAIL_FROM);
		}

		$auction_id = $id;
		include('../../include/update_bid.php');

		header("Location: auction.php?id=$id");
		exit;
	}
}

if ($status != 'open' || $amount <= $current_bid) {
	header("Location: auction.php?id=$id");
	exit;
}

$timezone = date('T');

$starts .= " $timezone";
$ends   .= " $timezone";

include('header.php');
?>

  <br>
  <p align="center" class="big">Confirm your bid of <b>US $<?php echo number_format($amount, 2); ?></b> for auction <b>#<?php echo $id; ?></b>.</p>
<?php if (!empty($errors)) { ?>
  <p align="center" class="error"><?php echo $errors; ?></p>
<?php } ?>
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <input type="hidden" name="id" value="<?php echo $id; ?>" />
   <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
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
    <tr>
     <td align="right" class="header">Bid Increment:</td>
     <td class="normal">US $<?php echo $bid_increment; ?></td>
    </tr>
    <tr>
     <td align="right" class="header">Maximum bid:</td>
     <td class="normal"><input type="text" name="maximum_bid" value="<?php echo $maximum_bid; ?>" size="20"></td>
    </tr>
    <tr>
     <td>&nbsp;</td>
     <td class="notice">Providing a maximum bid value allows for proxy bidding<br />up to that amount.</td>
    </tr>
    <tr><td class="small" colspan="2">&nbsp;</td></tr>
    <tr>
     <td align="center" class="normal" colspan="2"><input type="submit" name="submit_bid" value=" Confirm Bid " /></td>
    </tr>
   </table>
  </form>

<?php
db_disconnect();
include('footer.php');
?>

