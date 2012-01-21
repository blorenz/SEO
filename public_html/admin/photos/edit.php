<?php

include('../../../include/db.php');
db_connect();

extract(defineVars("id","submit","caption")); //JJM 09/07/2010

if (empty($id) || $id <= 0) {
	header('Location: ../items/index.php');
	exit;
}

$result = db_do("SELECT vehicle_id, caption FROM photos WHERE id='$id'");
list($vid, $old_caption) = db_row($result);
db_free($result);

if (empty($vid) || $vid <= 0) {
	header('Location: ../items/index.php');
	exit;
}

$result = db_do("SELECT dealer_id, short_desc FROM vehicles WHERE id='$vid'");
list($did, $title) = db_row($result);
db_free($result);

if (isset($submit)) {
	db_do("UPDATE photos SET caption='$caption' WHERE id='$id'");

	header("Location: index.php?vid=$vid");
	exit;
}

$result_status = db_do("SELECT status FROM auctions WHERE vehicle_id=$vid");
if (db_num_rows($result_status) > 0)
	list($status) = db_row($result_status);

$help_page = "chp6_activate.php";

?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>

  <br />
  <p align="center" class="normal">[
<?php if ($status!='open') { ?>
  <a href="../items/edit.php?id=<?php echo $vid; ?>">Back to Item</a> |
<?php } ?><a href="index.php?vid=<?php echo $vid; ?>">List of Images</a> ]</p>
  <p align="center" class="header"><?php echo $title; ?></p>
  <form action="<?php echo $PHP_SELF; ?>" method="POST">
   <input type="hidden" name="id" value="<?php echo $id; ?>" />
   <table align="center" border="0" cellpadding="5" cellspacing="0">
    <tr>
     <td align="right" class="header" valign="top">Photo:</td>
     <td class="normal"><img src="../../auction/uploaded/<?php echo $id; ?>.jpg"></td>
    </tr>
    <tr>
     <td align="right" class="header" valign="top">Caption:</td>
     <td class="normal"><textarea name="caption" rows="10" cols="50" wrap="virtual"><?php echo $old_caption; ?></textarea></td>
    </tr>
    <tr>
     <td align="center" class="normal" colspan="2"><input type="submit" name="submit" value=" Update Photo "></td>
    </tr>
   </table>
  </form>