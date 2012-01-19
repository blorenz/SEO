<?php

include('../../../include/session.php');

extract(defineVars("id", "timeliness", "accuracy", "condition", "availability", "prompt_payment", "prompt_transport", "professionalism", "comments", "submit"));  //JJM  3/19/10

if (empty($id) || $id <= 0) {
	header('Location: ./');
	exit;
}

if (!has_priv('buy', $privs)) {
	header('Location: ../menu.php');
	exit;
}

include('../../../include/db.php');
db_connect();
$result = db_do("SELECT auctions.title FROM auctions, bids WHERE " .
	"auctions.id='$id' AND auctions.status='closed' AND auctions.chaching=1 " .
   	"AND auctions.winning_bid=bids.id AND bids.dealer_id='$dealer_id'");

if (db_num_rows($result) <= 0) {
	header('Location: ./');
	exit;
}
list($title) = db_row($result);

$result = db_do("SELECT COUNT(*) FROM ratings WHERE auction_id='$id' AND buyer_id='$dealer_id'");
list($count) = db_row($result);
db_free($result);

if ($count) {
	header('Location: ./');
	exit;
}

if (isset($submit)) {
	$num_answers = 7;
	$total = $timeliness + $accuracy + $availability + $prompt_payment + $prompt_transport + $condition + $professionalism;

	if (($total/$num_answers) < 3 && empty($comments))
		$errors = "NOTE: You Must Insert Comments when Rating a Seller below 3.0";

	if (empty($errors)) {

		$result = db_do("SELECT dealer_id FROM auctions WHERE id='$id'");
		list($seller_id) = db_row($result);
		db_free($result);

		if (($total/$num_answers) < 3)
			db_do("INSERT INTO ratings SET auction_id='$id', user_id='$userid', " .
				"buyer_id='$dealer_id', seller_id='$seller_id', status='active', " .
				"answered='$num_answers', total='$total', endtime=(NOW()+INTERVAL 60 DAY), " .
				"timeliness='$timeliness', accuracy='$accuracy', " .
				"availability='$availability', prompt_payment='$prompt_payment', " .
				"prompt_transport='$prompt_transport', vehicle_condition='$condition', " .
				"professionalism='$professionalism', comments='$comments'");
		else
			db_do("INSERT INTO ratings SET auction_id='$id', user_id='$userid', " .
				"buyer_id='$dealer_id', seller_id='$seller_id', " .
				"answered='$num_answers', total='$total', endtime=(NOW()+INTERVAL 60 DAY), " .
				"timeliness='$timeliness', accuracy='$accuracy', " .
				"availability='$availability', prompt_payment='$prompt_payment', " .
				"prompt_transport='$prompt_transport', vehicle_condition='$condition', " .
				"professionalism='$professionalism', comments='$comments'");

		$result = db_do("SELECT COUNT(*), SUM(total), SUM(answered) FROM " .
			"ratings WHERE seller_id='$seller_id'");
		list($count, $total, $answered) = db_row($result);

		if ($count >= 1) {
			$rating = $total / $answered;
			db_do("UPDATE dealers SET rating='$rating' WHERE id='$seller_id'");

			if ($rating < 3) {

				#db_do("UPDATE dealers SET status='suspended' WHERE id='$seller_id'");
				#db_do("UPDATE users SET status='suspended' WHERE dealer_id='$seller_id'");

				if ($old_rating>=3) {
#
### Email to Dealer POC and AE if Rating is below 3.0
#


					$result = db_do("SELECT dealers.name, dealers.poc_f_name, dealers.poc_l_name, dealers.poc_phone, dealers.poc_email, aes.user_id, aes.first_name, aes.last_name, aes.email, aes.phone FROM dealers, aes WHERE dealers.id='$seller_id' AND aes.id=dealers.ae_id");
					list($name, $poc_f_name, $poc_l_name, $poc_phone, $poc_email, $ae_id, $first_name, $last_name, $email, $phone) = db_row($result);
					db_free($result);

					$msg = "\nPoint of Contact: $poc_f_name $poc_l_name

Dealership: $name

Your Dealership Rating has dropped below 3.0.  Please contact your Account Executive
immediately to resolve this issue.

Your Account Executive: $first_name $last_name
Phone Number: $phone
Email address: $email

Do not reply to this automated message.  This is not a monitored e-mail account.

Thank you,

Go DEALER TO DEALER";
				mail("$email, $poc_email", "$name has a rating below 3", $msg, $EMAIL_FROM);

				$title = 'Rating Below 3.0';
				$description = "A Dealership has dropped below the 3.0 Rating.  The Dealership contact is ".$poc_f_name." ".$poc_l_name." at ".$poc_phone.".  Thank You.";
				$from_user = 'GDTD Rating Control';

				db_do("INSERT INTO alerts SET to_user='$ae_id', from_user='0',
				title='$title', description='$description', modified=NOW()");


#
### Email to QC if Rating is below 3.0
#

		$result = db_do("SELECT email FROM users WHERE id='$userid'");
			list($email) = db_row($result);
			db_free($result);

			$comments = stripslashes($comments);
			$msg = "
Auction Number : $id
Auction Name   : $title

http://$HTTP_HOST/auction/auction.php?id=$id

Timeliness of Initial Contact/Business Communication? $timeliness
Accuracy of Item Description?                         $accuracy
Accuracy of Item Condition?                           $condition
Availability of Title/Certificate?                    $availability
Prompt Payment Coordination?                          $prompt_payment
Prompt Transport Coordination?                        $prompt_transport
Overall Professionalism?                              $professionalism

Buyer's Comments:
$comments";

			mail('qc@godealertodealer.com', 'new seller rating', $msg,
			"From: $email");

			header('Location: ./');
			exit;
			}
		}

		} else
			db_do("UPDATE dealers SET rating='0.0' WHERE id='$seller_id'");

		header('Location: ./');
		exit;
	}
}

$page_title = "Rate Sellers";
$help_page = "chp7.php#Chp7_Ratesellers";

include('../header.php');
?>

<p align="center" class="big"><b>Rate Seller</b></p>
<p align="center" class="error">Please use the following<br />Go Dealer To Dealer© Member Rating System:</p>
<form action="<?php echo $PHP_SELF; ?>" method="post">
 <input type="hidden" name="id" value="<?php echo $id; ?>" />
 <table align="center" border="0" cellpadding="2" cellspacing="0">
   <tr>
     <td align="center" class="big" colspan="6">
       <table border="0" cellpadding="3" cellspacing="0">
         <tr>
           <td class="normal">Excellent</td>
           <td class="normal">5 points</td>
         </tr>
         <tr>
           <td class="normal">Good</td>
           <td class="normal">4 points</td>
         </tr>
         <tr>
           <td class="normal">Average</td>
           <td class="normal">3 points</td>
         </tr>
         <tr>
           <td class="normal">Fair</td>
           <td class="normal">2 points</td>
         </tr>
         <tr>
           <td class="normal">Poor</td>
           <td class="normal">1 point</td>
         </tr>
     </table></td>
   </tr>
   <tr>
     <td class="big"><b>Auction #<?php echo $id; ?> : <b><?php echo $title; ?></b></b></td>
     <td align="center">1</td>
     <td align="center">2</td>
     <td align="center">3</td>
     <td align="center">4</td>
     <td align="center">5</td>
   </tr>
   <tr>
     <td class="normal">Timeliness of Initial Contact &amp; Business Communication</td>
     <td align="center"><input type="radio" value=1 name="timeliness" <?php if ($timeliness == 1) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=2 name="timeliness" <?php if ($timeliness == 2) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=3 name="timeliness" <?php if ($timeliness == 3) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=4 name="timeliness" <?php if ($timeliness == 4) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=5 name="timeliness" <?php if ($timeliness == 5 || !isset($timeliness)) echo 'checked'; ?>></td>
   </tr>
   <tr>
     <td class="normal">Accuracy of Item Description</td>
     <td align="center"><input type="radio" value=1 name="accuracy" <?php if ($accuracy == 1) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=2 name="accuracy" <?php if ($accuracy == 2) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=3 name="accuracy" <?php if ($accuracy == 3) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=4 name="accuracy" <?php if ($accuracy == 4) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=5 name="accuracy" <?php if ($accuracy == 5 || !isset($accuracy)) echo 'checked'; ?>></td>
   </tr>
   <tr>
     <td class="normal">Accuracy of Item Condition</td>
     <td align="center"><input type="radio" value=1 name="condition" <?php if ($condition == 1) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=2 name="condition" <?php if ($condition == 2) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=3 name="condition" <?php if ($condition == 3) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=4 name="condition" <?php if ($condition == 4) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=5 name="condition" <?php if ($condition == 5 || !isset($condition)) echo 'checked'; ?>></td>
   </tr>
   <tr>
     <td class="normal">Availability of Title/Certificate</td>
     <td align="center"><input type="radio" value=1 name="availability" <?php if ($availability == 1) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=2 name="availability" <?php if ($availability == 2) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=3 name="availability" <?php if ($availability == 3) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=4 name="availability" <?php if ($availability == 4) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=5 name="availability" <?php if ($availability == 5 || !isset($availability)) echo 'checked'; ?>></td>
   </tr>
   <tr>
     <td class="normal">Prompt Payment Coordination</td>
     <td align="center"><input type="radio" value=1 name="prompt_payment" <?php if ($prompt_payment == 1) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=2 name="prompt_payment" <?php if ($prompt_payment == 2) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=3 name="prompt_payment" <?php if ($prompt_payment == 3) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=4 name="prompt_payment" <?php if ($prompt_payment == 4) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=5 name="prompt_payment" <?php if ($prompt_payment == 5 || !isset($prompt_payment)) echo 'checked'; ?>></td>
   </tr>
   <tr>
     <td class="normal">Prompt Transport Coordination</td>
     <td align="center"><input type="radio" value=1 name="prompt_transport" <?php if ($prompt_transport == 1) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=2 name="prompt_transport" <?php if ($prompt_transport == 2) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=3 name="prompt_transport" <?php if ($prompt_transport == 3) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=4 name="prompt_transport" <?php if ($prompt_transport == 4) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=5 name="prompt_transport" <?php if ($prompt_transport == 5 || !isset($prompt_transport)) echo 'checked'; ?>></td>
   </tr>
   <tr>
     <td class="normal">Overall Professionalism</td>
     <td align="center"><input type="radio" value=1 name="professionalism" <?php if ($professionalism == 1) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=2 name="professionalism" <?php if ($professionalism == 2) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=3 name="professionalism" <?php if ($professionalism == 3) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=4 name="professionalism" <?php if ($professionalism == 4) echo 'checked'; ?>></td>
     <td align="center"><input type="radio" value=5 name="professionalism" <?php if ($professionalism == 5 || !isset($professionalism)) echo 'checked'; ?>></td>
   </tr>
   <tr>
     <td colspan="6">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="6" class="normal">Note: your comments will be delivered to our <a href="mailto:qc@godealertodealer.com">Quality Control Dept. at GoDealerToDealer Headquarters</a>.</td>
   </tr>
   <tr>
     <td colspan="6">&nbsp;</td>
   </tr>
   <?php if (isset($errors)) { ?>
   <tr>
     <td colspan="6" class="error" align="center"><br><?=$errors?><br>&nbsp;</td>
   </tr>
   <?php } ?>
   <tr>
   	<td class="normal" colspan="6">Buyer's Comments<br />
          <textarea name="comments" rows="4" cols="90" wrap="virtual"></textarea></td>
  </tr>
 </table>
 <div align="center"><p><input type="submit" name="submit" value=" Rate Seller " /></p></div>
</form>
<?php include('../footer.php'); ?>
