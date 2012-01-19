<?php


include('../../../include/session.php');

extract(defineVars("z", "q", "no_menu", "vid", "main_photo", "delete", "submit", "privs"));    //JJM added 6/17/2010 need variables


if (!has_priv('vehicles', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (empty($vid) || $vid <= 0) {
	header('Location: ../vehicles/index.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$result = db_do("SELECT dealer_id, short_desc FROM vehicles WHERE id='$vid'");
list($did, $title) = db_row($result);
db_free($result);

if ($did != $dealer_id) {
	header('Location: ../vehicles/index.php');
	exit;
}

if (isset($submit)) {
	if (is_array($delete)) {
		while (list(, $id) = each($delete)) {
			if ($main_photo == $id)
				$main_photo=0;

			db_do("DELETE FROM photos WHERE id='$id'");
			unlink("../uploaded/$id.jpg");
		}
	}

	db_do("UPDATE vehicles SET photo_id='$main_photo' WHERE id='$vid'");
}

$has_bid = 'no';
$status = 'closed';
$r = db_do("SELECT id, status, current_bid, reserve_price FROM auctions WHERE vehicle_id=$vid ORDER BY created DESC, status DESC LIMIT 1");
if (db_num_rows($r) > 0) {
	list($aid, $status, $current_bid, $reserve_price) = db_row($r);
	if ($status == 'open')
		if ($current_bid > 0)
			$has_bid = 'yes';
}
db_free($r);

$result = db_do("SELECT photo_id FROM vehicles WHERE id='$vid'");
list($main_photo) = db_row($result);
db_free($result);

$result = db_do("SELECT COUNT(*) FROM photos WHERE vehicle_id='$vid'");
list($num_photos) = db_row($result);
db_free($result);

if ($num_photos <= 0) {
	header("Location: add.php?vid=$vid");
	exit;
}

$help_page = "chp6_activate.php";

include('../header.php');

$result = db_do("SELECT id, caption FROM photos WHERE vehicle_id='$vid'");

?>
  <br />
  <p align="center" class="normal">[ <a href="..">Home</a>
<?php if ($has_bid == 'no') { ?> | <a href="../vehicles/edit.php?id=<?php echo $vid; ?>">Edit This Item</a><?php } ?>
							    | <a href="add.php?vid=<?php echo $vid; ?>">Add More Photos</a>
<?php if ($status=='open' && has_priv('sell', $privs))
		echo " | <a href=\"../auctions/edit_open.php?id=$aid\">Edit This Auction</a>";
	elseif ($status=='pending' && has_priv('sell', $privs))
		echo " | <a href=\"../auctions/edit.php?id=$aid\">Edit This Auction</a>";
	elseif (has_priv('sell', $privs))
		echo " | <a href=\"../auctions/add.php?vid=$vid\">Create This Auction</a>";?> ]</p>
  <p align="center" class="notice">No identifiable company information or advertising is permitted in your photos<br />or listings.  (Ref: Go Dealer To Dealer Membership Agreement, Paragraph 4.4, 4)</p>
  <p align="center" class="normal"><i>Note the photos as shown are half their original size.</p>
  <p align="center" class="header"><?php echo $title; ?></p>
  <form action="<?php echo $PHP_SELF; ?>" method="POST">
   <input type="hidden" name="vid" value="<?php echo $vid; ?>" />
   <table align="center" border="0" cellpadding="5" cellspacing="0">
    <tr>
     <td class="header"><nobr>Main Photo</nobr></td>
<?php if ($status!='open') { ?>
     <td class="header">Delete</td>
<?php } ?>
     <td class="header">Photo/Caption</td>
    </tr>

<?php
$count = 0;
while (list($id, $caption) = db_row($result)) {
	list($width, $height) = getImageSize("../uploaded/$id.jpg");
	$width /= 2;
	$height /= 2;

	$count = $count+1;
  if (empty($main_photo))
	{
		if(count == 0)
				$main_photo = $id;
		$count = $count+1;
	}

	if (empty($caption))
		$caption = '<i>no caption supplied</i>';
?>
    <tr>
     <td align="center" class="normal" valign="top"><input type="radio" name="main_photo" value="<?php echo $id; ?>" <?php if ($main_photo == $id) echo 'checked'; ?>></td>
<?php if ($status!='open') { ?>
     <td align="center" class="normal" valign="top"><input type="checkbox" name="delete[]" value="<?php echo $id; ?>"></td>
<?php } ?>
     <td class="normal"><a href="edit.php?id=<?php echo $id; ?>"><img src="../uploaded/<?php echo $id; ?>.jpg" width="<?php echo $width; ?>" height="<?php echo $height; ?>" border="0"></a></td>
    </tr>
    <tr>
     <td align="right" class="big" colspan="2" valign="top"><a href="edit.php?id=<?php echo $id ?>">edit caption</a></td>
     <td class="normal"><?php echo $caption; ?></td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
<?php
}

db_free($result);
db_disconnect();
?>
    <tr>
     <td align="center" colspan="3"><input type="submit" name="submit" value=" Update Photos "></td>
    </tr>
    <tr>
    	<td align="center" colspan="3">
    		<?php if (has_priv('sell', $privs)) : ?>
    		<a href="../auctions/add.php?vid=<?php echo $vid ?>">Create This Auction</a>
    		<?php endif; ?>
   </table>
  </form>
<?php include('../footer.php'); ?>
