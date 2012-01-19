<?php

if (!is_numeric($_POST['arb_auction'])) {
   // should never occur unless someone's tampering with the POSTstream.
   echo "<p>ERROR 0x0F23F0AD: The auction ID is invalid.</p>";
   die();
}

$seller_sql = "SELECT d.name, d.dba, d.address1, d.address2, d.city, d.state, d.zip, d.poc_email
FROM auctions a, dealers d WHERE a.id = '$_POST[arb_auction]' AND a.dealer_id = d.id";

$buyer_sql = "SELECT d.name, d.dba, d.address1, d.address2, d.city, d.state, d.zip, d.poc_email
FROM auctions a, dealers d, bids b WHERE a.id = '$_POST[arb_auction]'
AND a.winning_bid = b.id AND b.dealer_id = '$_SESSION[dealer_id]' AND d.id = b.dealer_id";

$auction_sql = "SELECT a.id, a.title, a.starts, a.ends, a.pays_transport, b.current_bid,
c.fee FROM auctions a, bids b, charges c WHERE a.id = c.auction_id AND a.winning_bid = b.id
AND c.fee_type = 'buy' AND a.id = '$_POST[arb_auction]'";

$item_sql = "SELECT CONCAT(v.year, ' ', v.make, ' ', v.model) as type, v.vin, v.miles, v.title, v.title_status,
v.long_desc, v.condition_report AS 'condition' FROM vehicles v, auctions a WHERE a.vehicle_id = v.id AND a.id = '$_POST[arb_auction]'";

$seller = mysql_fetch_assoc(mysql_query($seller_sql));
$buyer = mysql_fetch_assoc(mysql_query($buyer_sql));
$auction = mysql_fetch_assoc(mysql_query($auction_sql));
$item = mysql_fetch_assoc(mysql_query($item_sql));

setlocale(LC_MONETARY, 'en_US');
?>

<h3>Arbitration Submitted Successfully</h3>

<p>Your arbitration request is finished.  All of the information has been sent to the
arbitration company, and the point of contact for your and the respondent's dealerships.
</p>
<p>The arbitration company will contact you to proceed with the arbitration, usually
within two business days.</p>
<?php
$posession = date('M d Y', strtotime($_POST['arb_recdate']));
$starts = date('m/d/Y', strtotime($auction['starts']));
$ends = date('m/d/Y', strtotime($auction['ends']));
$current_bid = money_format('%.2n', $auction['current_bid']);
$fee = money_format('%.2n', $auction['fee']);

ob_end_flush();
ob_start();
echo_condition_report($_POST['arb_auction']);
$cond_report = ob_get_contents();
ob_end_clean();
ob_start();

$msg = <<<ENDMSG

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
		<td>$seller[name]</td>
		<td>$buyer[name]</td>
	</tr>
	<tr>
		<td>d.b.a. $seller[dba]</td>
		<td>d.b.a. $buyer[dba]</td>
	</tr>
		<tr>
		<td>$seller[address1]</td>
		<td>$buyer[address1]</td>
	</tr>
		<tr>
		<td>$seller[address2]</td>
		<td>$buyer[address2]</td>
	</tr>
	<tr>
		<td>$seller[city] $seller[state] $seller[zip]</td>
		<td>$buyer[city] $buyer[state] $buyer[zip]</td>
	</tr>
	<tr>
		<th>Took Possession of Item</th>
		<td>$posession</td>
	</tr>
	<tr>
		<th>Complaint</th>
		<td>$_POST[arb_claim]</td>
	</tr>
	<tr>
		<th>Proposed Resolution</th>
		<td>$_POST[arb_resolution]</td>
	</tr>
</table>

<table class="arbitration">
	<tr>
		<th colspan="4">Auction Information</th>
	</tr>
	<tr>
		<th>ID</th>
		<td>$auction[id]</td>
		<th>Title</th>
		<td>$auction[title]</td>
	</tr>
	<tr>
		<th>Started</th>
		<td>$starts</td>
		<th>Ended</th>
		<td>$ends</td>
	</tr>
	<tr>
		<th>Auction Closed At</th>
		<td>$current_bid</td>
		<th>Buy Fee</th>
		<td>$fee</td>
	</tr>
		<tr>
		<th colspan="2">Who Pays Transport</th>
		<td colspan="2">$auction[pays_transport]</td>
	</tr>
</table>

<table class="arbitration">
	<tr>
		<th colspan="4">Item Information</th>
	</tr>
	<tr>
		<td colspan="4" class="center">$item[type]</td>
	</tr>
	<tr>
		<th>VIN/HIN</th>
		<td>$item[vin]</td>
		<th>Miles/Hours</th>
		<td>$item[miles]</td>
	</tr>
	<tr>
		<th>Title</th>
		<td>$item[title]</td>
		<th>Title Status</th>
		<td>$item[title_status]</td>
	</tr>
	<tr>
		<th>Description</th>
		<td colspan="3">$item[long_desc]</td>
	</tr>
</table>

<table class="arbitration">
	<tr>
		<th colspan="2">Item Condition</th>
	</tr>
	<tr>
		<th>Condition:</th>
		<td>$item[condition]</td>
	</tr>
	<tr>
		<td colspan="2" class="center">$cond_report</td>
	</tr>
</table>

ENDMSG;


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= CLAIMS_FROM . "\r\n";

$to = "$buyer[poc_email], $seller[poc_email], claims@godealertodealer.com";

$subject = "Arbitration Initiaition";

mail($to, $subject, $msg, $headers);

?>
