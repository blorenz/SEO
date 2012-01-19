<?php

if (!is_numeric($_POST['arb_auction'])) {
   echo "<p>ERROR 0x0F23F0AD: The auction ID is invalid.</p>";
   die();
}

$seller_sql = "SELECT d.name, d.dba, d.address1, d.address2, d.city, d.state, d.zip
FROM auctions a, dealers d WHERE a.id = '$_POST[arb_auction]' AND a.dealer_id = d.id";

$buyer_sql = "SELECT d.name, d.dba, d.address1, d.address2, d.city, d.state, d.zip
FROM auctions a, dealers d, bids b WHERE a.id = '$_POST[arb_auction]'
AND a.winning_bid = b.id AND b.dealer_id = '$_SESSION[dealer_id]' AND d.id = b.dealer_id";

$auction_sql = "SELECT a.id, a.title, a.starts, a.ends, a.pays_transport, b.current_bid, c.fee FROM auctions a, bids b, charges c WHERE a.id = c.auction_id AND a.winning_bid = b.id AND c.fee_type = 'buy' AND a.id = '$_POST[arb_auction]'";

$item_sql = "SELECT CONCAT(v.year, ' ', v.make, ' ', v.model) as type, v.vin, v.miles, v.title, v.title_status,
v.long_desc, v.condition_report AS 'condition' FROM vehicles v, auctions a WHERE a.vehicle_id = v.id AND a.id = '$_POST[arb_auction]'";

$seller = mysql_fetch_assoc(mysql_query($seller_sql));
$buyer = mysql_fetch_assoc(mysql_query($buyer_sql));
$auction = mysql_fetch_assoc(mysql_query($auction_sql));
$item = mysql_fetch_assoc(mysql_query($item_sql));

setlocale(LC_MONETARY, 'en_US');

?>

<h3>Step 5: Review Information</h3>
<p>Please review the following information for accuracy.  If all of the information is accurate, continue with the instructions below.
</p><p>A copy of this review will be sent to you, to the respondant, and to the arbitration company.</p>
<style type="text/css">
table.arbitration {
	border: 1px solid #ddd;
	background: lightgrey;
	width: 80%;
	margin-bottom: .5em;
	font-size: 90%;
}

table.arbitration th {
	color: white;
	background: #aaa;
}

.center {
	text-align: center;
}
</style>

<table class="arbitration">
	<tr>
		<th colspan="2">Arbitration Information</th>
	</tr>
	<tr>
		<th>Respondant Information</th>
		<th>Claimant Information</th>
	</tr>
	<tr>
		<td><?php echo $seller['name'] ?></td>
		<td><?php echo $buyer['name'] ?></td>
	</tr>
	<tr>
		<td>d.b.a. <?php echo $seller['dba'] ?></td>
		<td>d.b.a. <?php echo $buyer['dba'] ?></td>
	</tr>
		<tr>
		<td><?php echo $seller['address1'] ?></td>
		<td><?php echo $buyer['address1'] ?></td>
	</tr>
		<tr>
		<td><?php echo $seller['address2'] ?></td>
		<td><?php echo $buyer['address2'] ?></td>
	</tr>
	<tr>
		<td><?php echo "$seller[city] $seller[state] $seller[zip]" ?></td>
		<td><?php echo "$buyer[city] $buyer[state] $buyer[zip]" ?></td>
	</tr>
	<tr>
		<th>Took Possession of Item</th>
		<td><?php echo date('M d Y', strtotime($_POST['arb_recdate'])); ?></td>
	</tr>
	<tr>
		<th>Complaint</th>
		<td><?php echo $_POST['arb_claim'] ?></td>
	</tr>
	<tr>
		<th>Proposed Resolution</th>
		<td><?php echo $_POST['arb_resolution']; ?>
	</tr>
</table>

<table class="arbitration">
	<tr>
		<th colspan="4">Auction Information</th>
	</tr>
	<tr>
		<th>ID</th>
		<td><?php echo $auction['id'] ?></td>
		<th>Title</th>
		<td><?php echo $auction['title'] ?></td>
	</tr>
	<tr>
		<th>Started</th>
		<td><?php echo date('m/d/Y', strtotime($auction['starts'])) ?></td>
		<th>Ended</th>
		<td><?php echo date('m/d/Y', strtotime($auction['ends'])) ?></td>
	</tr>
	<tr>
		<th>Auction Closed At</th>
		<td><?php echo money_format('%.2n', $auction['current_bid']) ?></td>
		<th>Buy Fee</th>
		<td><?php echo money_format('%.2n', $auction['fee']) ?></td>
	</tr>
		<tr>
		<th colspan="2">Who Pays Transport</th>
		<td colspan="2"><?php echo $auction['pays_transport'] ?></td>
	</tr>
</table>

<table class="arbitration">
	<tr>
		<th colspan="4">Item Information</th>
	</tr>
	<tr>
		<td colspan="4" class="center"><?php echo $item['type'] ?></td>
	</tr>
	<tr>
		<th>VIN/HIN</th>
		<td><?php echo $item['vin']?></td>
		<th>Miles/Hours</th>
		<td><?php echo $item['miles']?></td>
	</tr>
	<tr>
		<th>Title</th>
		<td><?php echo $item['title'] ?></td>
		<th>Title Status</th>
		<td><?php echo $item['title_status'] ?></td>
	</tr>
	<tr>
		<th>Description</th>
		<td colspan="3"><?php echo $item['long_desc'] ?></td>
	</tr>
</table>

<table class="arbitration">
	<tr>
		<th colspan="2">Item Condition</th>
	</tr>
	<tr>
		<th>Condition:</th>
		<td><?php echo $item['condition'] ?></td>
	</tr>
	<tr>
		<td colspan="2" class="center"><?php echo_condition_report($_POST['arb_auction']) ?></td>
	</tr>
</table>

<form method="post">
By submitting this form you confirm that you understand the following:
	<strong>Submitting this form begins the arbitration process</strong>.  The arbitration company will be in contact with you within two business days and will communicate with you directly.  A $100 arbitration fee is mandatory and will be discussed with you upon contact from the arbitration company.
   <br /><br />
   <strong>Claims
	for less than $400 worth of damage are not arbitratable.</strong>
<br /><br />
	<input type="submit" name="finalsubmit" value="Okay, submit my arbitration claim." />
	<input type="hidden" name="arb_step" value="6" />
	<input type="hidden" name="arb_auction" value="<?php echo $_POST['arb_auction']; ?>" />
	<input type="hidden" name="arb_recdate" value="<?php echo $_POST['arb_recdate']; ?>" />
	<input type="hidden" name="arb_claim" value="<?php echo $_POST['arb_claim']; ?>" />
	<input type="hidden" name="arb_resolution" value="<?php echo $_POST['arb_resolution']; ?>" />
</form>
