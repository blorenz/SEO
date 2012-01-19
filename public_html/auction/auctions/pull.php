<?php

// $Id: pull.php 373 2006-07-17 21:39:12Z dsmalley $


$page_title = 'Pull Auction';
$help_page = "chp6_activate.php";

include('../../../include/session.php');
extract(defineVars("id","privs","submit","confirm"));

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

$result = db_do("SELECT auctions.title, DATE_FORMAT(auctions.starts, '%a, %e %M %Y %H:%i'), DATE_FORMAT(auctions.ends, '%a, %e %M %Y %H:%i'),
			DATE_FORMAT(NOW(), '%a, %e %M %Y %H:%i'), auctions.status, auctions.minimum_bid, auctions.current_bid, auctions.reserve_price, auctions.vehicle_id,
			categories.name, vehicles.vin, vehicles.hin, vehicles.stock_num
			FROM auctions, categories, vehicles
			WHERE auctions.id='$id' AND auctions.dealer_id='$dealer_id' AND auctions.category_id=categories.id AND vehicles.id=auctions.vehicle_id ");

if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}

list($title, $starts, $ends, $now, $status, $minimum_bid, $current_bid, $reserve_price, $vid,
    $category, $vin, $hin, $stock_num) = db_row($result);
db_free($result);

if ($hin > 0)
	$in = "HIN:            $hin";
else
	$in = "VIN:            $vin";

$timezone = date('T');

$starts .= " $timezone";
$ends   .= " $timezone";
$now   .= " $timezone";

$pull_fee = '0.00';

if ($status != 'pending' && $status != 'open') {
	header('Location: index.php');
	exit;
} elseif ($status == 'open') {
	if ($current_bid > 0 && $current_bid >= $reserve_price) {
		header("Location: pull_error.php?id=$id");
		exit;
	}

	if ($minimum_bid > $reserve_price)
		$reserve_price = $minimum_bid;

	if ($reserve_price > 0) {
		$result = db_do("SELECT dollars FROM pull_fees WHERE " .
		    "low<='$reserve_price' AND high>='$reserve_price'");

		if (db_num_rows($result) != 0)
			list($dollars) = db_row($result);
		else
			$dollars = 100.00;

		db_free($result);
		$pull_fee = number_format($dollars, 2);
	} else
		$pull_fee = '0.00';


      /**
      * Pull Fee?  DELETED!
      */
      $pull_fee = 0;


}

if (isset($submit)) {
	if ($confirm == 'yes') {

		#
		# Send pull confirmation.
		#

		$result = db_do("SELECT CONCAT(first_name, ' ', last_name), " .
		    "email FROM users where id='$userid'");
		list($full_name, $email) = db_row($result);
		db_free($result);

		$result = db_do("SELECT COUNT(*) FROM bids WHERE auction_id='$id'");
		list($count_bids) = db_row($result);
		db_free($result);

	if ($status == 'pending') {
			db_do("DELETE FROM auctions WHERE id='$id'");

			db_disconnect();

			header('Location: pending.php');
			exit;
	} elseif ($status == 'open') {
			db_do("UPDATE auctions SET status='pulled', modified=NOW() WHERE id='$id'");

				db_do("INSERT INTO charges
				SET auction_id='$id', dealer_id='$dealer_id', user_id='$userid', vehicle_id='$vid',
				fee='$pull_fee', fee_type='pull', modified=NOW(), created=modified, status='open'");

				$result_info = db_do("SELECT aes.user_id, aes.commission_percentage, dms.user_id, dms.override_percentage
					FROM aes, dms, dealers
					WHERE dealers.id='$dealer_id' AND dealers.ae_id=aes.id AND aes.dm_id=dms.id");
				list($ae_user_id, $ae_com, $dm_user_id, $dm_ovr) = db_row($result_info);

				$commission = $override = 0;
				$commission = $pull_fee * $ae_com * 2;	#Multiply by 2 because the commision was intended to split buy fees between the AEs
														#in this case, there is only AE, so he gets it all
				if ($dm_user_id != $ae_user_id)
					$override = $dm_ovr * $commission;

				db_do("INSERT INTO commission
				SET type_id='$id', ae_user_id='$ae_user_id', commission='$commission', dm_user_id='$dm_user_id', override='$override',
				fee_type='pull', dealer_type='seller', modified=NOW(), created=NOW()");



		$result = db_do("SELECT DATE_FORMAT(created, " .
    	"'%Y%m%d'), id FROM charges WHERE auction_id='$id' AND " .
		"dealer_id='$dealer_id' AND user_id='$userid' AND vehicle_id='$vid'");
		list($pull_time, $cid) = db_row($result);
		db_free($result);

		$pull_ref_no = "$pull_time-$cid";

		$title = stripslashes($title);
		$msg = "UserID: $username
Full Name: $full_name

You have pulled an auction from an Open Auction status.  Below are the details of the Pulled Auction:

Auction #:      $id
Auction Title:  $title
Stock Number:   $stock_num
$in
Start Time:     $starts\n" .
"Pull Time:      $now\n" .
"High Bid:       ".number_format($current_bid, 2)."
Number of Bids: ".number_format($count_bids). "

";  //make sure we have a new line.


if ($pull_fee > 0 ) {
   $msg .= "Your Pull Fee due to Go DEALER to DEALER is: US \$".number_format($pull_fee, 2);
	$msg.= " reference#: $pull_ref_no";
   $msg.= "This fee will be added to your account and automatically processed monthly.";
} else {
   $msg .= "All Pull Fees have been waived for the month of May!";
}



$msg.= "

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";
		mail($email, "Pulled Auction #" .$id, $msg, $EMAIL_FROM);

$result = db_do("SELECT CONCAT(users.first_name, ' ', users.last_name), users.username, users.email
				FROM auctions, bids, users WHERE auctions.id='$id' AND bids.auction_id=auctions.id AND bids.user_id=users.id
				GROUP by users.id ");

if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}

while (list($bidder_name, $bidder_username, $bidder_email) = db_row($result)) {

$bidder_msg = "UserID: $bidder_username
Full Name: $bidder_name

This auction has been pulled by the seller or is no longer available:

Auction #:      $id
Auction Title:  $title
Start Time:     $starts
Pull Time:      $now
High Bid:       ".number_format($current_bid, 2)."
Number of Bids: ".number_format($count_bids)."

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";
		mail($bidder_email, "Auction #" .$id." is No Longer Available", $bidder_msg, $EMAIL_FROM);
			}

	db_do("UPDATE watch_list SET email='sent' WHERE auction_id='$id'");

			db_disconnect();

			header('Location: index.php');
			exit;
		}
	}

	header('Location: index.php');
	exit;
}

include('../header.php');
db_disconnect();
?>

  <br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include('_links.php'); ?>

  <center>
   <div class="big">Are you sure you want to pull this auction?</div>
   <form action="<?= $PHP_SELF; ?>" method="POST">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <input type="radio" name="confirm" value="yes">Yes <input type="radio" name="confirm" value="no" checked>No<br><p><input type="submit" name="submit" value=" Pull Auction "></p>
   </form>
  </center>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
    <td align="right" class="header">Category:</td>
    <td class="normal"><?php tshow($category); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction Title:</td>
    <td class="normal"><?php tshow($title); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction starts:</td>
    <td class="normal"><?php tshow($starts); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction ends:</td>
    <td class="normal"><?php tshow($ends); ?></td>
   </tr>
<?php if ($status == 'open') { ?>

<?php } ?>
  </table>

<?php
include('../footer.php');
?>
