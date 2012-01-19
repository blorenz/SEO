<?php

include('../../../../include/session.php');
include('../../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$ae_array = findAEforDM($dm_id);
if (!in_array($id, $ae_array)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$result = db_do("SELECT user_id FROM aes WHERE id='$id'");
list($ae_user_id) = db_row($result);

	$buy_count_total=0;
	$buy_fees_total=0;
	$sell_count_total=0;
	$sell_fees_total=0;

$result_ae_name = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM aes WHERE aes.id='$id'");
list($ae_name) = db_row($result_ae_name);
$page_title = "AE $ae_name's Stats";
?>

<html>
	<head>
		<title><?= $page_title ?></title>
		<link rel="stylesheet" type="text/css" href="../../../../site.css" title="site" />
	</head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../../header.php'); ?>
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
include('../../footer.php'); ?>
</body>
</html>
