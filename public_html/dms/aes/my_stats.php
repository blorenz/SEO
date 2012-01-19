<?php

if(!empty($_REQUEST['bgcolor']))
	$bgcolor = $_REQUEST['bgcolor'];
else
	$bgcolor = "";




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

$page_title = 'District Manager\'s My Stats';

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://demo.godealertodealer.com');
	exit;
}

$result = db_do("SELECT user_id FROM dms WHERE id='$dm_id'");
list($user_id) = db_row($result);
$dm_user_id = $ae_user_id = $user_id;

	$buy_count_total=0;
	$buy_fees_total=0;
	$sell_count_total=0;
	$sell_fees_total=0;

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
	<table align="center" border="0" cellspacing="0" cellpadding="5">
		<tr align="center" class="header">
			<td>&nbsp;</td>
			<td>#</td>
			<td>Commission</td>
		</tr>
	<?php

			if(!isset($stats)) {
				$result = db_do("SELECT SUM(commission), COUNT(*) FROM commission
					WHERE ae_user_id='$ae_user_id' AND fee_type='signup' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($signup_com, $signup_count) = db_row($result);

				$result = db_do("SELECT SUM(commission), COUNT(*) FROM commission
					WHERE ae_user_id='$ae_user_id' AND fee_type='buy' AND dealer_type='buyer' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($buy_com, $buy_count) = db_row($result);

				$result = db_do("SELECT SUM(commission), COUNT(*) FROM commission
					WHERE ae_user_id='$ae_user_id' AND fee_type='buy' AND dealer_type='seller' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($sell_com, $sell_count) = db_row($result);

				$result = db_do("SELECT SUM(commission), COUNT(*) FROM commission
					WHERE ae_user_id='$ae_user_id' AND fee_type='pull' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($pull_com, $pull_count) = db_row($result);

				$result = db_do("SELECT SUM(override), COUNT(*) FROM commission
					WHERE override > 0 AND dm_user_id='$dm_user_id' AND fee_type='signup' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($signup_ovr, $signup_ovr_count) = db_row($result);

				$result = db_do("SELECT SUM(override), COUNT(*) FROM commission WHERE override > 0
					AND dm_user_id='$dm_user_id' AND fee_type='buy' AND dealer_type='buyer' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($buy_ovr, $buy_ovr_count) = db_row($result);

				$result = db_do("SELECT SUM(override), COUNT(*) FROM commission WHERE override > 0
					AND dm_user_id='$dm_user_id' AND fee_type='buy' AND dealer_type='seller' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($sell_ovr, $sell_ovr_count) = db_row($result);

				$result = db_do("SELECT SUM(override), COUNT(*) FROM commission WHERE override > 0
					AND dm_user_id='$dm_user_id' AND fee_type='pull' AND created >= DATE_ADD(NOW(), INTERVAL -30 DAY)");
				list($pull_ovr, $pull_ovr_count) = db_row($result);
			}
			else {
				$result = db_do("SELECT SUM(commission), COUNT(*) FROM commission
					WHERE ae_user_id='$ae_user_id' AND fee_type='signup' AND '$stats'=substring(created,1,6)");
				list($signup_com, $signup_count) = db_row($result);

				$result = db_do("SELECT SUM(commission), COUNT(*) FROM commission
					WHERE ae_user_id='$ae_user_id' AND fee_type='buy' AND dealer_type='buyer' AND '$stats'=substring(created,1,6)");
				list($buy_com, $buy_count) = db_row($result);

				$result = db_do("SELECT SUM(commission), COUNT(*) FROM commission
					WHERE ae_user_id='$ae_user_id' AND fee_type='buy' AND dealer_type='seller' AND '$stats'=substring(created,1,6)");
				list($sell_com, $sell_count) = db_row($result);

				$result = db_do("SELECT SUM(commission), COUNT(*) FROM commission
					WHERE ae_user_id='$ae_user_id' AND fee_type='pull' AND '$stats'=substring(created,1,6)");
				list($pull_com, $pull_count) = db_row($result);

				$result = db_do("SELECT SUM(override), COUNT(*) FROM commission
					WHERE override > 0 AND dm_user_id='$dm_user_id' AND fee_type='signup' AND '$stats'=substring(created,1,6)");
				list($signup_ovr, $signup_ovr_count) = db_row($result);

				$result = db_do("SELECT SUM(override), COUNT(*) FROM commission
					WHERE override > 0 AND dm_user_id='$dm_user_id' AND fee_type='buy' AND dealer_type='buyer' AND '$stats'=substring(created,1,6)");
				list($buy_ovr, $buy_ovr_count) = db_row($result);

				$result = db_do("SELECT SUM(override), COUNT(*) FROM commission
					WHERE override > 0 AND dm_user_id='$dm_user_id' AND fee_type='buy' AND dealer_type='seller' AND '$stats'=substring(created,1,6)");
				list($sell_ovr, $sell_ovr_count) = db_row($result);

				$result = db_do("SELECT SUM(override), COUNT(*) FROM commission
					WHERE override > 0 AND dm_user_id='$dm_user_id' AND fee_type='pull' AND '$stats'=substring(created,1,6)");
				list($pull_ovr, $pull_ovr_count) = db_row($result);
			}

		?>
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left" colspan="3"><u>Override as an DM</u></td>
		</tr>
		<!--
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left"> - Signups</td>
			<td><?=$signup_ovr_count?></td>
			<td align="right">$<?=number_format($signup_ovr,2)?></td>
		</tr>
		 -->
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left"> - Buy</td>
			<td><?=$buy_ovr_count?></td>
			<td align="right">$<?=number_format($buy_ovr,2)?></td>
		</tr>
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left"> - Sell</td>
			<td><?=$sell_ovr_count?></td>
			<td align="right">$<?=number_format($sell_ovr,2)?></td>
		</tr>
		<!--
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left"> - Pull</td>
			<td><?=$pull_ovr_count?></td>
			<td align="right">$<?=number_format($pull_ovr,2)?></td>
		</tr>
		-->
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left" colspan="3"><u>Commission as an AE</u></td>
		</tr>
		<!--
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left"> - Signups</td>
			<td><?=$signup_count?></td>
			<td align="right">$<?=number_format($signup_com,2)?></td>
		</tr>
		-->
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left"> - Buy</td>
			<td><?=$buy_count?></td>
			<td align="right">$<?=number_format($buy_com,2)?></td>
		</tr>
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left"> - Sell</td>
			<td><?=$sell_count?></td>
			<td align="right">$<?=number_format($sell_com,2)?></td>
		</tr>
		<!--
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left"> - Pull</td>
			<td><?=$pull_count?></td>
			<td align="right">$<?=number_format($pull_com,2)?></td>
		</tr>
		-->
		<tr>
		  <td colspan="9"><hr></td>
		</tr>
		<?php $commission=$buy_com+$sell_com+$pull_com+$signup_com+$buy_ovr+$sell_ovr+$pull_ovr+$signup_ovr; ?>
		<tr align="center" class="header">
			<td>&nbsp;</td>
			<td>Totals</td>
			<td align="right">$<?=number_format($commission,2)?></td>
		</tr>
	</table>

<?php db_disconnect();
include('../footer.php'); ?>
</body>
</html>