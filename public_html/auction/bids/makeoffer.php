<?php

include('../../../include/session.php');

extract(defineVars("id","vid","uid","aid","cid","subcid1","subcid2",
				"final_bid","reserve_price","title","photo","to_user",
				"from_user","offer_value","submit","cancel",
				"accept","decline","retract")); //JJM added 7/9/2010

if (!has_priv('buy', $privs) && !has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

include('../../../include/db.php');
db_connect();

	$result_offer = db_do("SELECT id, final_bid, reserve_price, offer_value, to_user, from_user
							FROM alerts
							WHERE auction_id='$id' AND (to_user='$userid' OR from_user='$userid') AND alerts.status='pending'");
		if (db_num_rows($result_offer) <= 0){
			header('Location: ../index.php');
			exit;
		}
		else
			list($alert_id, $final_bid, $reserve_price, $offer_value_orig, $to_user_orig, $from_user_orig) = db_row($result_offer);

if (isset($submit)) {

	$offer_value = RemoveNonNumericChar($offer_value);
	if ($offer_value > 0) {
		if ($offer_value > 1000000) {
			SendEmailQC($offer_value, $id, $to_user, $from_user);
		}
		db_do("DELETE FROM alerts WHERE vehicle_id='$vid'");
		db_do("INSERT INTO alerts SET to_user='$from_user', from_user='$to_user', auction_id='$id',
				vehicle_id='$vid', offer_value='$offer_value', final_bid='$final_bid', reserve_price='$reserve_price', modified=NOW()");
      $makeoffer_id = db_insert_id();

		$result_offer = db_do("SELECT a.id, v.make, v.model, v.year FROM alerts a, vehicles v WHERE vehicle_id='$vid' and a.status='pending'");
		if (db_num_rows($result_offer) > 0) {

			$result_alert = db_do("SELECT auction_id, to_user, from_user FROM alerts WHERE vehicle_id='$vid'");
			while(list($alert_auction_id, $to_user, $from_user) = db_row($result_alert)) {

				$msg = "Auction #$alert_auction_id has a new Make Offer Alert.

    Vehicle:   $year $make $model
    Offer:     $offer_value
    Final Bid: $final_bid
    Reserve:   $reserve_price

To view the offer, click on the following link, or copy-and-paste the URL
into your browser:
http://$_SERVER[SERVER_NAME]/auction/bids/makeoffer.php?id=$makeoffer_id

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";

				if ($from_user > 0) {
					$result_email = db_do("SELECT email FROM users WHERE id='$from_user'");
					list($from_user_email) = db_row($result_email);
					mail($from_user_email, 'Make Offer alert for auction #' . $alert_auction_id, $msg, $EMAIL_FROM);
					db_free($result_email);
				}
				if ($to_user > 0) {
					$result_email = db_do("SELECT email FROM users WHERE id='$to_user'");
					list($to_user_email) = db_row($result_email);
					mail($to_user_email, 'Make Offer alert for auction #' . $alert_auction_id, $msg, $EMAIL_FROM);
					db_free($result_email);
				}
			}
		}

		header('Location: ..');
		exit;
	} else
		$errors = "<p align='center'><font color='#FF0000'><b>
					*In order to submit a counter offer, you must specify a price.</b></font></p>";
}
elseif (isset($accept)) {

	$offer_value_orig = RemoveNonNumericChar($offer_value_orig);
	$result = db_do("SELECT categories.name, auctions.dealer_id, auctions.user_id, auctions.title, " .
		"auctions.description, auctions.minimum_bid, auctions.reserve_price, " .
		"auctions.buy_now_price, auctions.current_bid, auctions.dealer_id, " .
		"DATE_FORMAT(auctions.starts, '%a, %e %M %Y %H:%i'), " .
		"DATE_FORMAT(auctions.ends, '%a, %e %M %Y %H:%i'), " .
		"auctions.status, auctions.vehicle_id, vehicles.year, vehicles.vin, vehicles.hin, " .
		"vehicles.make, vehicles.model, vehicles.city, vehicles.state, vehicles.stock_num, " .
		"vehicles.zip, vehicles.photo_id, vehicles.condition_report FROM auctions, " .
		"categories, vehicles WHERE auctions.id='$aid' AND " .
		"categories.id=auctions.category_id AND vehicles.id=auctions.vehicle_id");

	if (db_num_rows($result) <= 0) {
		header('Location: index.php');
		exit;
	}

	list($category, $seller, $seller_id, $title, $description, $minimum_bid, $reserve_price,
		$buy_now_price, $current_bid, $did, $starts, $ends, $status, $vid, $year,
		$vin, $hin, $make, $model, $city, $state, $stock_num, $zip, $photo, $condition)
		= db_row($result);

		if ($hin > 0)
			$in = "HIN:           $hin";
		else
			$in = "VIN:           $vin";

	if ($seller_id != $userid) {
		list($buyer_dealer) = db_row(db_do("SELECT dealer_id from users WHERE users.id='$to_user'"));
		$buyer = $to_user;
	} else  {
		list($buyer_dealer) = db_row(db_do("SELECT dealer_id from users WHERE users.id='$from_user'"));
		$buyer = $from_user;
	}

	db_do("INSERT INTO bids SET auction_id='$id', " .
	    "dealer_id='$buyer_dealer', user_id='$buyer', opening_bid='$offer_value_orig', " .
	    "current_bid='$offer_value_orig', maximum_bid='0', modified=NOW(), " .
	    "created=modified");
	$b = db_insert_id();

	db_do("UPDATE auctions SET current_bid='$offer_value_orig', winning_bid='$b', " .
	    "status='closed', chaching=1 WHERE id='$id'");

	db_do("UNLOCK TABLES");

	db_do("UPDATE vehicles SET status='inactive', sell_price='$offer_value_orig' " .
	    "WHERE id='$vid'");

	$result = db_do("SELECT percentage FROM fees WHERE low<='$offer_value_orig' AND " .
	    "high>='$offer_value_orig'");

	if (db_num_rows($result) != 0)
		list($percentage) = db_row($result);
	else
		$percentage = 1;

	db_free($result);

	#
	# Calculate the fee but make sure to not put any commas in the result.
	#

	$fee = number_format(($offer_value_orig * $percentage) / 100, 2, '.', '');

	#
	# Charge the buyer a fee for purchasing this vehicle.
	#

	db_do("INSERT INTO charges SET auction_id='$id', " .
	    "dealer_id='$buyer_dealer', user_id='$buyer', vehicle_id='$vid', " .
	    "fee='$fee', fee_type='buy', modified=NOW(), created=modified, " .
	    "status='open'");

		$result_info = db_do("SELECT aes.user_id, aes.signup_percentage, dms.user_id, dms.override_signup
					FROM aes, dms, dealers
					WHERE dealers.id='$buyer_dealer' AND dealers.ae_id=aes.id AND aes.dm_id=dms.id");
		list($ae_user_id, $ae_com, $dm_user_id, $dm_ovr, $rm_user_id, $rm_ovr) = db_row($result_info);

		$commission = $override = 0;
		$commission = $fee * $ae_com;
		if ($dm_user_id != $ae_user_id)
			$override = $dm_ovr * $commission;
		if ($rm_user_id != $ae_user_id)
			$rm_override = $rm_ovr * $commission;

		db_do("INSERT INTO commission
				SET type_id='$id', ae_user_id='$ae_user_id', commission='$commission',
								   dm_user_id='$dm_user_id', override='$override',
				fee_type='buy', dealer_type='buyer', modified=NOW(), created=NOW()");


	$offer_ref_no = date('Ymd') . "-" . db_insert_id();

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

	$result_info = db_do("SELECT aes.user_id, aes.signup_percentage, dms.user_id, dms.override_signup
				FROM aes, dms, dealers
				WHERE dealers.id='$seller' AND dealers.ae_id=aes.id AND aes.dm_id=dms.id");
	list($ae_user_id, $ae_com, $dm_user_id, $dm_ovr, $rm_user_id, $rm_ovr) = db_row($result_info);

	$commission = $override = 0;
	$commission = $fee * $ae_com;
	if ($dm_user_id != $ae_user_id)
		$override = $dm_ovr * $commission;
	if ($rm_user_id != $ae_user_id)
		$rm_override = $rm_ovr * $commission;

	db_do("INSERT INTO commission
			SET type_id='$id', ae_user_id='$ae_user_id', commission='$commission',
							   dm_user_id='$dm_user_id', override='$override',
			fee_type='sell', dealer_type='seller', modified=NOW(), created=NOW()");

		$sell_ref_no = date('Ymd') . "-" . db_insert_id();
	} else {
		$result_info = db_do("SELECT aes.user_id, aes.signup_percentage, dms.user_id, dms.override_signup
					FROM aes, dms, dealers
					WHERE dealers.id='$seller' AND dealers.ae_id=aes.id AND aes.dm_id=dms.id");
		list($ae_user_id, $ae_com, $dm_user_id, $dm_ovr, $rm_user_id, $rm_ovr) = db_row($result_info);

		$commission = $override = 0;
		$commission = $fee * $ae_com;
		if ($dm_user_id != $ae_user_id)
			$override = $dm_ovr * $commission;
		if ($rm_user_id != $ae_user_id)
			$rm_override = $rm_ovr * $commission;

		db_do("INSERT INTO commission
				SET type_id='$id', ae_user_id='$ae_user_id', commission='$commission',
								   dm_user_id='$dm_user_id', override='$override',
				fee_type='buy', dealer_type='seller', modified=NOW(), created=NOW()");

	}

	#
	# Get buyer information.
	#

	$result = db_do("SELECT username, first_name, last_name, email, phone, address1, address2, city, state, zip FROM users WHERE id='$buyer'");
	list($buyer_username, $first_name, $last_name, $buyer_email, $buyer_phone, $buyer_address1, $buyer_address2, $buyer_city, $buyer_state, $buyer_zip) = db_row($result);
	db_free($result);

	$buyer_name = "$first_name $last_name";

	#
	# Put the fee in human readable format including commas where needed.
	#

	$fee = number_format($fee, 2);

	#
	# Send notification to the buyer.
	#

	$msg = "UserID: $buyer_username
Full Name: $buyer_name

Congratulations!! Your offer has been accepted for the following auction:

Auction #:     $id
Auction Title: $title
$in
Offer Price:   \$".number_format($offer_value_orig, 2)."


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

Your Buy fee due to Go DEALER to DEALER. is:

US \$$fee	reference#: $offer_ref_no

This fee will be added to your account and automatically processed monthly.

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";

	mail($buyer_email, 'Make Offer ACCEPTED for auction #' . $id, $msg,
	    $EMAIL_FROM);

	#
	# Send notification to the seller.
	#

	$msg = "UserID: $seller_user_name
Full Name: $seller_name

Congratulations!! Your offer has been accepted for the following auction:

Auction #:         $id
Auction Title:     $title
Stock Number:      $stock_num
$in
Offer Price:       \$".number_format($offer_value_orig, 2)."

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

	mail($seller_email, 'Make Offer ACCEPTED for auction #' . $id, $msg,
	    $EMAIL_FROM);

	#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
	#xxx
	#xxx Do we need to send an "outbid notice" is there's a current
	#xxx winning bid?
	#xxx
	#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

	db_do("DELETE FROM alerts WHERE vehicle_id='$vid'");
	header('Location: ..');
	exit;
}
elseif (isset($decline) || isset($cancel) || isset($retract)) {

	if (isset($decline))
		db_do("UPDATE alerts SET status='decline' WHERE vehicle_id='$vid'");
	elseif(isset($cancel))
		db_do("UPDATE alerts SET status='cancel' WHERE vehicle_id='$vid'");
	elseif(isset($retract))
		db_do("UPDATE alerts SET status='retract' WHERE vehicle_id='$vid'");

	$result = db_do("SELECT categories.name, auctions.dealer_id, auctions.user_id, auctions.title, " .
		"auctions.description, auctions.vehicle_id, vehicles.year, vehicles.vin, vehicles.hin, " .
		"vehicles.make, vehicles.model, vehicles.condition_report FROM auctions, " .
		"categories, vehicles WHERE auctions.id='$aid' AND " .
		"categories.id=auctions.category_id AND vehicles.id=auctions.vehicle_id");

	list($category, $seller, $seller_id, $title, $description, $vid, $year,
		$vin, $hin, $make, $model, $condition)
		= db_row($result);

		if ($hin > 0)
			$in = "HIN:           $hin";
		else
			$in = "VIN:           $vin";

	if ($seller_id != $userid) {
		list($buyer_dealer) = db_row(db_do("SELECT dealer_id from users WHERE users.id='$to_user'"));
		$buyer = $to_user;
	} else  {
		list($buyer_dealer) = db_row(db_do("SELECT dealer_id from users WHERE users.id='$from_user'"));
		$buyer = $from_user;
	}

	#
	# Get seller information.
	#

	$result = db_do("SELECT users.id, users.username, users.first_name, users.last_name, " .
	    "users.email FROM auctions, users WHERE auctions.id='$id' AND auctions.user_id=users.id");
	list($seller_id, $seller_user_name, $first_name, $last_name, $seller_email) = db_row($result);
	db_free($result);

	$seller_name = "$first_name $last_name";

	#
	# Get bidder information.
	#

	$result = db_do("SELECT username, first_name, last_name, email FROM users WHERE id='$buyer'");
	list($buyer_username, $first_name, $last_name, $buyer_email) = db_row($result);
	db_free($result);

	$buyer_name = "$first_name $last_name";

	#
	# Send notification to the buyer.
	#

	$msg = "UserID: $buyer_username
Full Name: $buyer_name

Make offer was DECLINED and has ended without a sale for the following auction:

Auction #:     $id
Auction Title: $title
$in

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";

	mail($buyer_email, 'Make Offer DECLINED for auction #' . $id, $msg,
	    $EMAIL_FROM);

	#
	# Send notification to the seller.
	#

	$msg = "UserID: $seller_user_name
Full Name: $seller_name

Make offer was DECLINED and has ended without a sale for the following auction:

Auction #:     $id
Auction Title: $title
$in

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank you,

Go DEALER to DEALER";

	mail($seller_email, 'Make Offer DECLINED for auction #' . $id, $msg,
	    $EMAIL_FROM);


	header('Location: ..');
	exit;

}
else {

	$result = db_do("SELECT auctions.id, auctions.vehicle_id, auctions.user_id, auctions.category_id, auctions.subcategory_id1, auctions.subcategory_id2, auctions.title, auctions.description, bids.user_id, CONCAT(vehicles.city, ' ', vehicles.state) AS location FROM auctions, bids, vehicles WHERE auctions.id='$id' AND auctions.winning_bid=bids.id AND auctions.vehicle_id = vehicles.id");
		if (db_num_rows($result) <= 0) {
			header('Location: ..');
			exit;
		}
		else {
		   list($aid, $vid, $uid, $cid, $subcid1, $subcid2, $title, $description, $buid, $v_loc) = db_row($result);

			$result = db_do("SELECT id FROM photos WHERE vehicle_id='$vid' ORDER BY id LIMIT 1");
			list($photo) = db_row($result);
		}

		db_free($result);

		$from_user = $from_user_orig;
		$to_user = $to_user_orig;

		//user id - 51 == seller id -- uid
		//buyer id - bid user id - buid

		if ($from_user_orig == 0) {
			//buyer responds - seller is from user
			if ($to_user==$buid)
				$from_user = $uid;
			//seller responds - buyer is from user
			else
				$from_user = $buid;
			}

		$offer_value = '';
}

$help_page = "chp5_check.php";

include('../header.php'); ?>

<br>
<p align="center" class="huge"><u><b><font color="#FF0000">Make Wholesale Offer</font></b></u></p><br>
<? if (isset($errors))
	echo $errors; ?>
<form action="<?php echo $PHP_SELF; ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="hidden" name="vid" value="<?php echo $vid; ?>" />
	<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
	<input type="hidden" name="aid" value="<?php echo $aid; ?>" />
	<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
	<input type="hidden" name="subcid1" value="<?php echo $subcid1; ?>" />
	<input type="hidden" name="subcid2" value="<?php echo $subcid2; ?>" />
	<input type="hidden" name="final_bid" value="<?php echo $final_bid; ?>" />
	<input type="hidden" name="reserve_price" value="<?php echo $reserve_price; ?>" />
	<input type="hidden" name="title" value="<?php echo $title; ?>" />
	<input type="hidden" name="photo" value="<?php echo $photo; ?>" />
	<input type="hidden" name="to_user" value="<?php echo $to_user; ?>" />
	<input type="hidden" name="from_user" value="<?php echo $from_user; ?>" />
<?php if(isset($cid)) {
		$result = db_do("SELECT name FROM categories WHERE id=$cid");
		list($z) = db_row($result); }
	if(isset($subcid1)) {
		$result = db_do("SELECT name FROM categories WHERE id=$subcid1");
		list($y) = db_row($result); }
	if(isset($subcid2)) {
		$result = db_do("SELECT name FROM categories WHERE id=$subcid2");
		list($x) = db_row($result); } ?>
   <table align="center" border="0" cellspacing="0" cellpadding="2">
    <tr class="big">
     <td align="right" class="header">Auction:</td>
     <td><b><a href="../auction.php?id=<?php echo $aid; ?>"><?php echo "#$aid - $title"; ?></a></b></td>
    </tr>
	<tr>
		<td align="right" class="header">Category:</td><td class="normal">
     	<?php
     		echo "$z";
		if (isset($y) AND $subcid1 > 1)
		{
			echo " : $y ";
			if (isset ($x) AND $subcid2 > 1)
			echo " : $x";
		}
		?>
		</td>
    </tr>
<?php if (!empty($photo) && file_exists("../uploaded/$photo.jpg")) {
	$image = "<img src=\"../uploaded/$photo.jpg\">";

	$result = db_do("SELECT caption FROM photos WHERE id='$photo'");
	list($caption) = db_row($result);
	db_free($result);
} else
	$image = '&nbsp;';

	$final_bid_fn = number_format($final_bid, 2);
	$reserve_price_fn = number_format($reserve_price, 2);
	$offer_value_orig = number_format($offer_value_orig, 2);
?>
	<tr>
		<td align="center" class="normal" colspan="2">
		<?php echo $image; ?><br /><?php echo $caption; ?></td>
	</tr>
   <tr>
      <td align="right" class="header">Vehcile Location:</td>
      <td class="normal"><?php echo $v_loc ?></td>
   </tr>
	<tr>
		<td align="right" class="header">The Final Bid was:</td>
		<td class="normal">US $<?php tshow($final_bid_fn); ?></td>
    </tr>
	<tr>
		<td align="right" class="header">The Reserve Wholesale Price was:</td>
		<td class="normal">US $<?php tshow($reserve_price_fn); ?></td>
    </tr>
	<tr><td colspan="2">&nbsp;</td></tr>
<?php if($offer_value_orig != 0) { ?>
	<tr>
		<td align="right" class="header">The Current Wholesale Offer is:</td>
		<td class="normal">US $<?php tshow($offer_value_orig); ?></td>
    </tr>
<? } ?>
<?php if ($to_user == $userid) { ?>
			<tr>
				<td align="right" class="header">Make Wholesale Offer of:</td>
				<td class="normal" nowrap>US $<input type="text" name="offer_value" value="<?php echo $offer_value; ?>" size="9">
				<i>*Not required for Accept/Decline.</i></td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
		<?php if($offer_value_orig == 0) { ?>
			<tr>
			 <td align="center" colspan="2" class="normal"><input type="submit" name="submit" value=" Submit "></td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
			 <td align="center" colspan="2" class="normal"><input type="submit" name="cancel" value=" Cancel Make Offer for this Auction "></td>
			</tr>
		<?php }
		else { ?>
			<tr>
			 <td align="center" colspan="2" class="normal">
				<input type="submit" name="submit" value=" Counter ">
		<?php if ($uid == $userid) { ?>
				<input type="submit" name="accept" value=" Accept (SELL) ">
		<?php } else { ?>
				<input type="submit" name="accept" value=" Accept (BUY) ">
		<?php } ?>
				<input type="submit" name="decline" value=" Decline "></td>
			</tr>
		<?php }
} else { ?>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr><td colspan="2" class="error" align="center">This shows the Wholesale Offer you have made.<br>
					While you are waiting for the other dealer's response, you can...</td></tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
			 <td align="center" colspan="2" class="normal"><strong><a href="../alerts.php">Go Back</a></strong> and Wait for a Counter Offer</td>
			</tr>
			<tr>
			 <td align="center" colspan="2" class="normal"><br> - or - <input type="submit" name="retract" value=" Retract your Current Offer "></td>
			</tr>
<? } ?>
   </table>
  </form>

<?php include('../footer.php');
db_disconnect();
?>