


<?php
$PHP_SELF = $_SERVER['PHP_SELF'];

include('../../../include/db.php');
db_connect();
extract(defineVars("page_title", "fee_display", "status_display", "cid"));


if (isset($submit)) {

	db_do("UPDATE charges
		SET auction_id='$auction_id', dealer_id='$dealer_id', user_id='$user_id', vehicle_id='$vehicle_id',
			fee='$fee', fee_type='$fee_type', status='$status'
		WHERE id='$cid' ");

	if ($remove_commission == 'Yes')
		db_do("DELETE FROM commission WHERE type_id='$auction_id' AND fee_type!='signup'");

	header("Location: index.php");
	exit;

} else {
	$result = db_do("SELECT auction_id, dealer_id, user_id, vehicle_id, fee, fee_type, status, DATE_FORMAT(created, '%Y%m%d')
					FROM charges WHERE id='$cid' ");
	list($auction_id, $dealer_id, $user_id, $vehicle_id, $fee, $fee_type, $status, $created) = db_row($result);

	$result = db_do("SELECT dealer_id, user_id FROM auctions WHERE id='$auction_id' ");
	list($a_dealer_id, $a_user_id) = db_row($result);
}
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
<?php include('_links.php'); ?>
<br />
<form action="<?php echo $PHP_SELF; ?>" method="post">
<input type="hidden" name="cid" value="<?=$cid?>" />
<table align="center" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td class="header" colspan="9" align="center">Invoice:&nbsp;<?php echo "$created-$cid"; ?></td>
	</tr>
	<tr>
		<td class="header" colspan="9" align="center">&nbsp;</td>
	</tr>
	<tr>
		<td class="header"></td>
		<td class="header" align="center"><u>Currently</u></td>
		<td class="header" align="center"><u>Change To</u></td>
		<td class="header" align="center"><u>To Swap</u></td>
	</tr>
	<tr>
		<td class="header">Auction ID:</td>
		<td class="normal"><?=$auction_id?></td>
		<td class="normal"><input class="normal" type="text" name="auction_id" value="<?=$auction_id?>" size="10"></td>
		<td></td>
	</tr>
	<tr>
		<td class="header">Vehicle ID:</td>
		<td class="normal"><?=$vehicle_id?></td>
		<td class="normal"><input class="normal" type="text" name="vehicle_id" value="<?=$vehicle_id?>" size="10"></td>
		<td></td>
	</tr>
	<tr>
		<td class="header">Dealer ID:</td>
		<td class="normal"><?=$dealer_id?></td>
		<td class="normal"><input class="normal" type="text" name="dealer_id" value="<?=$dealer_id?>" size="10"></td>
		<td class="normal"><?=$a_dealer_id?></td>
	</tr>
	<tr>
		<td class="header">User ID:</td>
		<td class="normal"><?=$user_id?></td>
		<td class="normal"><input class="normal" type="text" name="user_id" value="<?=$user_id?>" size="10"></td>
		<td class="normal"><?=$a_user_id?></td>
	</tr>
	<tr>
		<td class="header">Fee ($):</td>
		<td class="normal"><?=$fee?></td>
		<td class="normal"><input class="normal" type="text" name="fee" value="<?=$fee?>" size="10"></td>
		<td></td>
	</tr>
	<?php
		if ($fee_type == 'buy')
			$fee_display = 'Buy';
		elseif ($fee_type == 'pull')
			$fee_display = 'Pull';
		elseif ($fee_type == 'sell')
			$fee_display = 'Sell';
	?>
	<tr>
		<td class="header">Fee Type:</td>
		<td class="normal"><?=$fee_display?></td>
		<td class="normal"><select name="fee_type" class="normal">
				<option value='buy' <?php if ($fee_type == 'buy') echo 'selected'; ?>>Buy</option>
				<option value='pull' <?php if ($fee_type == 'pull') echo 'selected'; ?>>Pull</option>
				<option value='sell' <?php if ($fee_type == 'sell') echo 'selected'; ?>>Sell</option>
				<option value='reversed' <?php if ($fee_type == 'reversed') echo 'selected'; ?>>Reversal</option>
				<option value='waived' <?php if ($fee_type == 'waived') echo 'selected'; ?>>Waived</option>
				<option value='refund' <?php if ($fee_type == 'refund') echo 'selected'; ?>>Refund</option>
				<option value='membership' <?php if ($fee_type == 'membership') echo 'selected'; ?>>Membership</option>
				<option value='signup' <?php if ($fee_type == 'signup') echo 'selected'; ?>>Signup</option>
			</select></td>
		<td></td>
	</tr>
	<?php
		if ($status == 'open')
			$status_display = 'Unpaid';
		elseif ($status == 'closed')
			$status_display = 'Paid';

	?>
	<tr>
		<td class="header">Status:</td>
		<td class="normal"><?=$status_display?></td>
		<td class="normal"><select name="status" class="normal">
				<option value='open' <?php if ($status == 'open') echo 'selected'; ?>>Unpaid</option>
				<option value='closed' <?php if ($status == 'closed') echo 'selected'; ?>>Paid</option>
			</select></td>
		<td></td>
	</tr>
	<tr>
		<td class="header" colspan="2">Remove Commissions?</td>
		<td class="normal" colspan="2"><input type="checkbox" name="remove_commission" value="Yes">
	</tr>
	<tr>
		<td colspan="9" align="center" class="normal"><input type="submit" name="submit" value="Update" /></td>
    </tr>
</table>
</form>
</body>
</html>