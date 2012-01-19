<?php
#
# Copyright (c) 2002 Steve Price
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
# $srp: godealertodealer.com/htdocs/aes/dealers.php,v 1.8 2002/09/03 00:35:40 steve Exp $
#

$page_title = 'District Manager\'s AE Stats';

include('../../../include/session.php');
extract(defineVars("bgcolor"));
include('../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$active_items_total=0;
$open_auctions_total=0;
$opened_auctions_total=0;
$pulled_auctions_total=0;
$sold_auctions_total=0;
$bought_auctions_total=0;
$fees_total=0;

$result_aes = db_do("SELECT id, last_name, first_name FROM aes WHERE dm_id='$dm_id' AND status='active'");

?>

<html>
	<head>
		<title><?= $page_title ?></title>
		<link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
	</head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p><br>
<?php include('_links_months.php'); ?>
<?php if (db_num_rows($result_aes) > 0) { ?>
<font class="huge">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Active Account Executives</u></font><br><br>
	<table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
		<tr align="center" class="header">
			<td align="left">Name</td>
			<td>Rating</td>
			<td>Active Items</td>
			<td>Open Auctions</td>
			<td>Created Auctions</td>
			<td>Pulled Auctions</td>
			<td>Sold Auctions</td>
			<td>Bought Auctions</td>
			<td align="right">Charges</td>
		</tr>
	<?php while (list($ae_id, $last_name, $first_name) = db_row($result_aes)) {

			if(!isset($stats)) {
				$result_ave_rating = db_do("SELECT AVG(rating) FROM dealers WHERE ae_id='$ae_id' AND rating>0");
				list($rating) = db_row($result_ave_rating);
				$rating = number_format($rating, 2);

				$result_active_items = db_do("SELECT COUNT(*) FROM dealers, vehicles
					WHERE dealers.ae_id='$ae_id' AND vehicles.status='active' AND vehicles.dealer_id=dealers.id");
				list($active_items) = db_row($result_active_items);

				$result_open_auctions = db_do("SELECT COUNT(*) FROM dealers, auctions
					WHERE dealers.ae_id='$ae_id' AND auctions.dealer_id=dealers.id AND auctions.status='open'");
				list($open_auctions) = db_row($result_open_auctions);

				$result_opened_auctions = db_do("SELECT COUNT(*) FROM dealers, auctions
					WHERE dealers.ae_id='$ae_id' AND auctions.dealer_id=dealers.id AND starts >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($opened_auctions) = db_row($result_opened_auctions);

				$result_pulled_auctions = db_do("SELECT COUNT(*) FROM dealers, auctions
					WHERE dealers.ae_id='$ae_id' AND auctions.dealer_id=dealers.id
					AND auctions.status='pulled' AND auctions.modified >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($pulled_auctions) = db_row($result_pulled_auctions);

				$result_sold_auctions = db_do("SELECT COUNT(*) FROM dealers, auctions, bids
					WHERE dealers.ae_id='$ae_id' AND auctions.dealer_id=dealers.id
					AND auctions.chaching=1 AND bids.id=auctions.winning_bid AND bids.created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($sold_auctions) = db_row($result_sold_auctions);

				$result_bought_auctions = db_do("SELECT COUNT(*) FROM dealers, auctions, bids
					WHERE bids.dealer_id=dealers.id AND dealers.ae_id='$ae_id'
					AND auctions.chaching=1 AND bids.id=auctions.winning_bid AND bids.created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($bought_auctions) = db_row($result_bought_auctions);

				$result_fees = db_do("SELECT SUM(fee) FROM dealers, charges
					WHERE dealers.ae_id='$ae_id' AND charges.dealer_id=dealers.id
 					AND charges.created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($fees) = db_row($result_fees);
				if (!isset($fees)) { $fees = 0.00; }
			}
			else {
				$result_ave_rating = db_do("SELECT AVG(rating) FROM dealers WHERE ae_id='$ae_id' AND rating>0");
				list($rating) = db_row($result_ave_rating);
				$rating = number_format($rating, 2);

				$result_active_items = db_do("SELECT COUNT(*) FROM dealers, vehicles
					WHERE dealers.ae_id='$ae_id' AND vehicles.status='active' AND vehicles.dealer_id=dealers.id");
				list($active_items) = db_row($result_active_items);

				$result_open_auctions = db_do("SELECT COUNT(*) FROM dealers, auctions
					WHERE dealers.ae_id='$ae_id' AND auctions.dealer_id=dealers.id AND auctions.status='open'");
				list($open_auctions) = db_row($result_open_auctions);

				$result_opened_auctions = db_do("SELECT COUNT(*) FROM dealers, auctions
					WHERE dealers.ae_id='$ae_id' AND auctions.dealer_id=dealers.id AND '$stats'=substring(auctions.starts,1,6)");
				list($opened_auctions) = db_row($result_opened_auctions);

				$result_pulled_auctions = db_do("SELECT COUNT(*) FROM dealers, auctions
					WHERE dealers.ae_id='$ae_id' AND auctions.dealer_id=dealers.id
					AND auctions.status='pulled' AND '$stats'=substring(auctions.modified,1,6)");
				list($pulled_auctions) = db_row($result_pulled_auctions);

				$result_sold_auctions = db_do("SELECT COUNT(*) FROM dealers, auctions, bids
					WHERE dealers.ae_id='$ae_id' AND auctions.dealer_id=dealers.id
					AND auctions.chaching=1 AND bids.id=auctions.winning_bid AND '$stats'=substring(bids.created,1,6)");
				list($sold_auctions) = db_row($result_sold_auctions);

				$result_bought_auctions = db_do("SELECT COUNT(*) FROM dealers, auctions, bids
					WHERE bids.dealer_id=dealers.id AND dealers.ae_id='$ae_id'
					AND auctions.chaching=1 AND bids.id=auctions.winning_bid AND '$stats'=substring(bids.created,1,6)");
				list($bought_auctions) = db_row($result_bought_auctions);

				$result_fees = db_do("SELECT SUM(fee) FROM dealers, auctions, charges
					WHERE '$stats'=substring(charges.created,1,6) AND dealers.ae_id='$ae_id'
					AND charges.dealer_id=dealers.id AND charges.auction_id=auctions.id");
				list($fees) = db_row($result_fees);
				if (!isset($fees)) { $fees = 0.00;	}
			}

			$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF'; ?>
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left"><a href="dealers/dealer_stats.php?id=<?=$ae_id?>"><?=$last_name.", ".$first_name?></a></td>
			<td><?=$rating?></td>
			<td><?=$active_items?></td>
			<td><?=$open_auctions?></td>
			<td><?=$opened_auctions?></td>
			<td><?=$pulled_auctions?></td>
			<td><?=$sold_auctions?></td>
			<td><?=$bought_auctions?></td>
			<td align="right">$<?=number_format($fees, 2)?></td>
		</tr>
	<?php
			$active_items_total+=$active_items;
			$open_auctions_total+=$open_auctions;
			$opened_auctions_total+=$opened_auctions;
			$pulled_auctions_total+=$pulled_auctions;
			$sold_auctions_total+=$sold_auctions;
			$bought_auctions_total+=$bought_auctions;
			$fees_total+=$fees;
	} ?>
		<tr><td colspan="9"><hr></td></tr>
		<tr align="center" class="header">
			<td align="center">Totals</td>
			<td></td>
			<td><?=$active_items_total?></td>
			<td><?=$open_auctions_total?></td>
			<td><?=$opened_auctions_total?></td>
			<td><?=$pulled_auctions_total?></td>
			<td><?=$sold_auctions_total?></td>
			<td><?=$bought_auctions_total?></td>
			<td align="right">US $<?=number_format($fees_total, 2)?></td>
	</tr>
</table>
<?php } else { ?>
<br><br><font class="huge">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>No Active Account Executives</u></font><br><br>
<?php }

$active_items_total=0;
$open_auctions_total=0;
$opened_auctions_total=0;
$pulled_auctions_total=0;
$sold_auctions_total=0;
$bought_auctions_total=0;
$fees_total=0;

$result_aes = db_do("SELECT id, last_name, first_name FROM aes WHERE dm_id='$dm_id' AND status='inactive'");

if (db_num_rows($result_aes) > 0) { ?>

<br><br><font class="huge">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Inactive Account Executives</u></font><br><br>
	<table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
		<tr align="center" class="header">
			<td align="left">Name</td>
			<td>Rating</td>
			<td>Active Items</td>
			<td>Open Auctions</td>
			<td>Created Auctions</td>
			<td>Pulled Auctions</td>
			<td>Sold Auctions</td>
			<td>Bought Auctions</td>
			<td align="right">Charges</td>
		</tr>
	<?php while (list($ae_id, $last_name, $first_name) = db_row($result_aes)) {

			if(!isset($stats)) {
				$result_active_items = db_do("SELECT COUNT(*) FROM vehicles WHERE dealer_id='$dealer_id' AND status='active'");
				list($active_items) = db_row($result_active_items);

				$result_open_auctions = db_do("SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id' AND status='open'");
				list($open_auctions) = db_row($result_open_auctions);

				$result_opened_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE dealer_id='$dealer_id' AND starts >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($opened_auctions) = db_row($result_opened_auctions);

				$result_pulled_auctions = db_do("SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id'
					AND status='pulled' AND modified >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($pulled_auctions) = db_row($result_pulled_auctions);

				$result_sold_auctions = db_do("SELECT COUNT(*) FROM auctions, bids WHERE auctions.dealer_id='$dealer_id'
					AND auctions.chaching=1 AND bids.id=auctions.winning_bid AND bids.created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($sold_auctions) = db_row($result_sold_auctions);

				$result_bought_auctions = db_do("SELECT COUNT(*) FROM auctions, bids WHERE bids.dealer_id='$dealer_id'
					AND auctions.chaching=1 AND bids.id=auctions.winning_bid AND bids.created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($bought_auctions) = db_row($result_bought_auctions);

				$result_fees = db_do("SELECT SUM(fee) FROM charges WHERE dealer_id='$dealer_id' and charges.status='open'");
				list($fees) = db_row($result_fees);
				if (!isset($fees)) { $fees = 0.00; }
			}
			else {
				$result_opened_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE '$stats'=substring(starts,1,6) AND dealer_id='$dealer_id'");
				list($opened_auctions) = db_row($result_opened_auctions);

				$result_pulled_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE '$stats'=substring(modified,1,6) AND dealer_id='$dealer_id' AND status='pulled'");
				list($pulled_auctions) = db_row($result_pulled_auctions);

				$result_sold_auctions = db_do("SELECT COUNT(*) FROM auctions
					WHERE '$stats'=substring(created,1,6) AND dealer_id='$dealer_id' AND chaching=1");
				list($sold_auctions) = db_row($result_sold_auctions);

				$result_bought_auctions = db_do("SELECT COUNT(*) FROM auctions, bids
					WHERE '$stats'=substring(auctions.modified,1,6) AND bids.dealer_id='$dealer_id' AND auctions.chaching=1 AND bids.id=auctions.winning_bid");
				list($bought_auctions) = db_row($result_bought_auctions);

				$result_fees = db_do("SELECT SUM(fee) FROM charges
					WHERE '$stats'=substring(created,1,6) AND '$stats'=substring(created,1,6) AND dealer_id='$dealer_id' and charges.status='open'");
				list($fees) = db_row($result_fees);
				if (!isset($fees)) { $fees = 0.00;	}
			}

			$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF'; ?>
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left"><a href="dealers/index.php?id=<?=$ae_id?>"><?=$last_name.", ".$first_name?></a></td>
			<td><?=$rating?></td>
			<td><?=$active_items?></td>
			<td><?=$open_auctions?></td>
			<td><?=$opened_auctions?></td>
			<td><?=$pulled_auctions?></td>
			<td><?=$sold_auctions?></td>
			<td><?=$bought_auctions?></td>
			<td align="right">$<?=number_format($fees, 2)?></td>
		</tr>
	<?php
			$active_items_total+=$active_items;
			$open_auctions_total+=$open_auctions;
			$opened_auctions_total+=$opened_auctions;
			$pulled_auctions_total+=$pulled_auctions;
			$sold_auctions_total+=$sold_auctions;
			$bought_auctions_total+=$bought_auctions;
			$fees_total+=$fees;
	 } ?>
		<tr><td colspan="9"><hr></td></tr>
		<tr align="center" class="header">
			<td align="center">Totals</td>
			<td></td>
			<td><?=$active_items_total?></td>
			<td><?=$open_auctions_total?></td>
			<td><?=$opened_auctions_total?></td>
			<td><?=$pulled_auctions_total?></td>
			<td><?=$sold_auctions_total?></td>
			<td><?=$bought_auctions_total?></td>
			<td align="right">US $<?=number_format($fees_total, 2)?></td>
		</tr>
</table>
<?php } else { ?>
<br><br><font class="huge">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>No Inactive Account Executives</u></font><br><br><?php } ?>

<?php db_disconnect();
include('../footer.php'); ?>
</body>
</html>