<?php
$page_title = 'Update Open Auction';
$help_page = "chp6_activate.php";

include('../../../include/session.php');
include('../../../include/defs.php');

if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (empty($aid) || $aid <= 0) {
	header('Location: index.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$result = db_do("SELECT auctions.id FROM auctions, vehicles
				WHERE auctions.id='$aid' AND auctions.dealer_id='$dealer_id'
				AND vehicles.id=auctions.vehicle_id AND auctions.status='open'");

if (db_num_rows($result) <= 0) {
	header('Location: index.php2');
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
$errors				= '';

if (isset($submit)) {

	if($confirm == 'yes') {

		$reserve_lowered = 'yes';

		$reserve_price = $current_bid+1;

		db_do("UPDATE auctions SET reserve_price='$reserve_price', reserve_lowered='$reserve_lowered' WHERE id='$aid'");

			$results = db_do("SELECT email, CONCAT(first_name, ' ', last_name) FROM users WHERE username='$username'");
			list($email, $full_name) = db_row($results);

$msg = "UserID $username
Full Name: $full_name

This email is to notify you that you lowered the reserve price of this auction.

Auction #:     $aid
Auction Title: $title
$in
End Time:      $ends
Reserve Price: \$".number_format($reserve_price, 2)."

Review your auction at:
http://$HTTP_HOST/auction/auction.php?id=$aid

Do not reply to this automated message.  This is not a monitored e-mail account.

Thank You,

Go DEALER to DEALER
";
		mail($email, "Reserve Lowered for Auction #$aid", $msg, $EMAIL_FROM);

		header("Location: index.php");
		exit;
	}
	else {

		header("Location: index.php");
		exit;
	}

} else {
  $bid_result = db_do("SELECT count(*) from bids WHERE auction_id='$aid'");
  list($bid_count) = db_row($bid_result);
	db_free($bid_result);

	$result = db_do("SELECT auctions.category_id, auctions.subcategory_id1, auctions.subcategory_id2,
				auctions.title, auctions.current_bid, auctions.reserve_price, auctions.reserve_lowered,
				DATE_FORMAT(auctions.starts, '%a, %e %M %Y %H:%i'), DATE_FORMAT(auctions.ends, '%a, %e %M %Y %H:%i'),
				vehicles.vin, vehicles.hin FROM auctions, vehicles
				WHERE auctions.id='$aid' AND auctions.dealer_id='$dealer_id'
				AND vehicles.id=auctions.vehicle_id AND auctions.status='open'");
	list($cid, $subcid1, $subcid2, $title, $current_bid, $reserve_price, $reserve_lowered, $starts, $ends, $vin, $hin) = db_row($result);
	db_free($result);

	if ($hin > 0)
		$in = "HIN:           $hin";
	else
		$in = "VIN:           $vin";

	$title				= stripslashes($title);
	$current_bid 		= stripslashes($current_bid);
	$reserve_price 		= stripslashes($reserve_price);
	$reserve_lowered 	= stripslashes($reserve_lowered);

	$reserve_price_orig = $reserve_price;
}
include('../header.php');
?>

  <br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include('_links.php'); ?>

  <center><br><br>
   <div class="error">Are you sure you want to drop the Reserve Price so that next bid will meet Reserve?</div>
   <form action="<?= $PHP_SELF; ?>" method="POST">
    <input type="hidden" name="aid" value="<?= $aid; ?>">
	<input type="hidden" name="current_bid" value="<?= $current_bid; ?>">
    <input type="hidden" name="title" value="<?= $title; ?>">
	<input type="hidden" name="in" value="<?= $in; ?>">
	<input type="hidden" name="ends" value="<?= $ends; ?>">
    <input type="radio" name="confirm" value="yes">Yes <input type="radio" name="confirm" value="no" checked>No<br>
	<p><input type="submit" name="submit" value=" Submit "></p>
   </form>
  </center><br>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
    <td align="right" class="header">Auction #:</td>
    <td class="normal"><?php tshow($aid); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction Title:</td>
    <td class="normal"><?php tshow($title); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Current Bid $:</td>
    <td class="normal"><?php echo number_format($current_bid, 2); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Current Reserve $:</td>
    <td class="normal"><?php echo number_format($reserve_price, 2); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction starts:</td>
    <td class="normal"><?php tshow($starts); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction ends:</td>
    <td class="normal"><?php tshow($ends); ?></td>
   </tr>
  </table>

<?php
include('../footer.php');
?>