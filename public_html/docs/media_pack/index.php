<?php
#
# Copyright (c) 2006 Go DEALER to DEALER
# All rights reserved.
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions
# are met:
#
# 1. Redistributions of source code must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
# 2. Redistributions in binary form must reproduce the above copyright
#    notice, this list of conditions and the following disclaimer in the
#    documentation and/or other materials provided with the distribution.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
# ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
# FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
# DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
# OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
# HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
# LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
# OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
# SUCH DAMAGE.
#
# $srp: godealertodealer.com/htdocs/aes/index.php,v 1.21 2002/10/08 05:42:49 steve Exp $
#

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$no_menu = 1;
$page_title = "Media Pack";

$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$num_auctions     = 0;
$pending_auctions = 0;
$open_auctions    = 0;
$closed_auctions  = 0;
$pulled_auctions  = 0;

#Auction Query with Totals
$result = db_do("SELECT COUNT(*) FROM auctions, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id 
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id and auctions.status='open'");
list($open_auctions) = db_row($result);

$result = db_do("SELECT COUNT(*) FROM auctions, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id 
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id and auctions.status='pending'");
list($pending_auctions) = db_row($result);

$result = db_do("SELECT COUNT(*) FROM auctions, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id 
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id 
				and auctions.status='closed' AND auctions.ends >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
list($closed_auctions) = db_row($result);

$result = db_do("SELECT COUNT(*) FROM auctions, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id 
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id and auctions.chaching=1 
				and auctions.status='closed' AND auctions.ends >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
list($closed_auctions_with_sale) = db_row($result);

$result = db_do("SELECT COUNT(*) FROM auctions, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id 
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id 
				and auctions.status='pulled' AND auctions.ends >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
list($pulled_auctions) = db_row($result);

$num_auctions = + $pending_auctions + $open_auctions + $closed_auctions + $pulled_auctions;
	
db_free($result);

$num_dealers		= 0;
$pending_dealers	= 0;
$active_dealers		= 0;
$suspended_dealers	= 0;
$saved_dealers		= 0;

#Dealers Query with Totals
$result = db_do("SELECT dealers.status FROM aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id 
				and dealers.ae_id = aes.id ");
		
while (list($status) = db_row($result)) {
	$num_dealers++;

	switch ($status) {
	case 'pending':
		$pending_dealers++;
		break;
	case 'active':
		$active_dealers++;
		break;
	case 'suspended':
		$suspended_dealers++;
		break;
	case 'saved':
		$saved_dealers++;
		break;		
	}
}
db_free($result);

#Closed auctions with sale
$result = db_do("SELECT COUNT(*) FROM auctions, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id 
				and dealers.ae_id = aes.id and auctions.dealer_id = dealers.id 
				and auctions.status='closed' AND auctions.current_bid >= auctions.reserve_price");
		
list($num_sales) = db_row($result);
db_free($result);

#Closed auctions without sale
$result = db_do("SELECT COUNT(*) FROM auctions, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id and dealers.ae_id = aes.id 
				and auctions.dealer_id = dealers.id and auctions.status='closed' AND auctions.current_bid < auctions.reserve_price");
list($num_no_sales) = db_row($result);
db_free($result);

#Paid Charges (US $)
$result = db_do("SELECT SUM(charges.fee) FROM charges, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id and dealers.ae_id = aes.id 
				and charges.dealer_id = dealers.id and charges.status='closed'");
list($paid_fees) = db_row($result);
db_free($result);

$paid_fees = number_format($paid_fees, 2);

#Unpaid Charges (US $)
$result = db_do("SELECT SUM(charges.fee) FROM charges, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id and dealers.ae_id = aes.id 
				and charges.dealer_id = dealers.id and charges.status='open'");
list($unpaid_fees) = db_row($result);
db_free($result);

$unpaid_fees = number_format($unpaid_fees, 2);

#Auctions closing in next 24 hours
$result = db_do("SELECT COUNT(*) FROM auctions, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id and dealers.ae_id = aes.id 
				and auctions.dealer_id = dealers.id and auctions.status='open' AND auctions.ends <= DATE_ADD(NOW(), INTERVAL 1 DAY)");
list($closing_soon) = db_row($result);
db_free($result);

#Auctions closed in last 24 hours
$result = db_do("SELECT COUNT(*) FROM auctions, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id and dealers.ae_id = aes.id 
				and auctions.dealer_id = dealers.id and auctions.status='closed' AND auctions.ends >= DATE_SUB(NOW(), INTERVAL 1 DAY)");
list($recent_closings) = db_row($result);
db_free($result);

#Auctions opening in next 24 hours
$result = db_do("SELECT COUNT(*) FROM auctions, aes, dealers, users 
				WHERE users.username = '$username' and aes.user_id = users.id and dealers.ae_id = aes.id 
				and auctions.dealer_id = dealers.id and auctions.status='pending' AND auctions.starts <= DATE_ADD(NOW(), INTERVAL 1 DAY)");
list($opening_soon) = db_row($result);

$alert_ds = 0;
$alert_dm = 0;
$alert_ae = 0;
$alert_dl = 0;

$dm_user_ids = findDMuserids();
$ae_user_ids = findAEuserids();

$result_alerts = db_do("SELECT from_user FROM alerts WHERE to_user='$userid' AND from_user!='0'");
while (list($from_user) = db_row($result_alerts)) {
	if(in_array($from_user, $dm_user_ids))
		$alert_dm++;
	elseif(in_array($from_user, $ae_user_ids))
		$alert_ae++;
	else
		$alert_dl++;
}

$total_alerts = $alert_ds + $alert_dm + $alert_ae + $alert_dl;

db_free($result);
?>
<html>
 <head>
  <title>Account Executive Summary: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
  <style type="text/css">
<!--
.style1 {
	font-size: 12px;
	font-weight: bold;
}
-->
  </style>
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../../dms/header.php'); ?><br>
<p align="center" class="big"><b><?=$page_title?></b></p>
<p align="center" class="style1"><a href="../../dms/tools/documents.php">Back to Online Library </a></p>
<p align="center" class="style1">&nbsp;</p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr valign="top">
	
		<!-- Left Column -->
		<td bgcolor="#EEEEEE" width="20%">
			<table border="0" cellpadding="3" cellspacing="0" width="100%">
				<tr>
					<?php if ($total_alerts > 0) { ?>
					<td colspan="2" align="center" bgcolor="#CC0000"><font color="#FFFFFF" size="-1"><b>You have <?=$total_alerts?> Alerts</b></font></td>
					<?php } else { ?>
					<td colspan="2" align="center" bgcolor="#000066"><font color="#FFFFFF" size="-1"><b>No Alerts</b></font></td>
					<?php } db_free($result_alerts); ?>
				</tr>
				<tr valign="top" class="normal">
					<td></td>
				</tr>
				<tr valign="top" class="normal">
					<td>New Dealer Signup</td><td><?=$alert_ds;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="message/alerts.php">Alerts From District Manager</a></td><td><?=$alert_dm;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="message/alerts.php">Alerts From Other AEs</a></td><td><?=$alert_ae;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="message/alerts.php">Alerts From Dealerships</a></td><td><?=$alert_dl;?></td>					
				</tr>
			</table>
		</td>
		
		<!-- Middle Column -->
		<td valign="top" width="60%">			
			<table align="center" border="1" cellpadding="3" cellspacing="0" class="normal">
				<tr>
				  <td width="24">&nbsp;</td>
				  <td width="153"><div align="center"><strong>Title</strong></div></td>
			    <td width="276"><div align="center"><strong>Description</strong></div></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="auctioncostcalc/auction_costs_calculator.htm" target="_blank">Auction Cost Calculator </a></td>
					<td>Hand out showing difference in Physical Auctions vs. Go DEALER to DEALER </td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="buyfees/buy_fees.htm" target="_blank">Buy Fees </a></td>
			    <td>Document of the Buy Fee schedule only </td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="dealertraining/dealer_training.htm" target="_blank">Dealer Training</a></td>
					<td>List of items about the site for training the Dealer</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="handsonlab/hands_on_lab_dealer.htm" target="_blank">Hands On Lab </a></td>
			    <td>Exercise to follow to ensure proper training </td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="http://demo.godealertodealer.com/quiz" target="_blank">Quiz</a></td>
					<td>Agent quiz to ensure proper training was conducted and necessary information is understood </td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="nmda/nmda_signs_jv.htm" target="_blank">NMDA Joint Venture </a></td>
				  <td>Print out of the National Motorcycle Dealers Association Joint Venture with Go DEALER to DEALER. Good hand out for motorcycle dealers </td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="dealer_to_dealer_ad_car.jpg" target="_blank">Evolve ad (Auto) </a></td>
				  <td>Advertisment for automotive dealers </td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="dealertodealer_ad_bike.jpg" target="_blank">Evolve ad (Motorcycle) </a></td>
				  <td>Advertisment for motorcycle dealers </td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="powersportsad/powersport_ad.htm" target="_blank">Power Sports ad </a></td>
				  <td>Advertisment for Power Sports dealers</td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="brochure/front1.jpg" target="_blank">Brochure (front) </a></td>
				  <td>Front page of the Brochure </td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="brochure/inside.jpg" target="_blank">Brochure (inside) </a></td>
				  <td>Inside page of the Brochure </td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><a href="brochure/back.jpg" target="_blank">Brochure (back) </a></td>
				  <td>Back page of the Brochure </td>
			  </tr>
			</table>
			<a href="dealer_training.doc"><br><br><br><br><br><br><br><br><br><br>&nbsp;
		</a></td>
		
		<!-- Right Column -->
		<td width="20%" valign="top" bgcolor="#EEEEEE">		
			<table border="0" cellpadding="3" cellspacing="0" width="100%">
				<tr>
					<td align="center" bgcolor="#000066"><a href="dealer_training.doc"><font color="#FFFFFF" size="-1"><b>Internal News</b></font></a></td>
				</tr>
			</table>
		</td>
		
	</tr>
</table>

<a href="dealer_training.doc"><?php
db_disconnect();
include('../../dms/footer.php');
?></a>