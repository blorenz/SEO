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

$page_title = 'AE My Stats';
$page_link = '../docs/chp4.php#Chp4_MyStats';

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: https://demo.godealertodealer.com');
	exit;
}
$result = db_do("SELECT user_id FROM aes WHERE id='$ae_id'");
list($ae_user_id) = db_row($result);

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
<?php include('../header.php'); ?><?php include('_links.php'); ?>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p><br>
<?php include('_links_months.php'); ?>
	<table align="center" border="0" cellspacing="0" cellpadding="5">
		<tr align="center" class="header">
			<td>&nbsp;</td>
			<td>#</td>			
			<td>Commission</td>
		</tr>
	<?php
		
			if(!isset($stats)) {		
            $stats = date('Ym');
         }
         
         if($stats == 'last30') {
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
			}
		
		?>
		<!-- 
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left">Dealer Signups</td>
			<td><?=$signup_count?></td>
			<td align="right">$<?=number_format($signup_com,2)?></td>
		</tr>
		 -->
		<tr align="center" bgcolor="<?=$bgcolor?>" class="normal">
			<td align="left" colspan="3"><u>Transactions</u></td>
		</tr>
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
		<?php $commission=$buy_com+$sell_com+$pull_com+$signup_com; ?>
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