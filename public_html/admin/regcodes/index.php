<?php

$page_title = 'Registration Codes';

include('../../../include/db.php');
db_connect();

extract(defineVars("ids","submit","new_code","new_description","codes","descriptions","delete"));

if (!is_array($ids))
	$ids = array();

if (!empty($submit)) {

	if (!empty($new_code))
		db_do("INSERT INTO reg_codes SET code='$new_code', description='$new_description', modified=NOW(), created=modified");

	while (list(, $id) = each($ids)) {
		$code        = $codes[$id];
		$description = $descriptions[$id];

		if ($delete[$id])
			db_do("DELETE FROM reg_codes WHERE id='$id'");

		db_do("UPDATE reg_codes SET code='$code', description='$description' WHERE id='$id'");
	}
}
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <p align="center" class="big"><b>Registration Fees</b></p>
  <form action="<?php echo $PHP_SELF; ?>" method="POST">
   <table align="center" border="0" cellspacing="3" cellpadding="3">
    <tr>
     <td class="normal">&nbsp;</td>
     <td align="center" colspan="4" class="large"><b>Add, edit, or delete Registration Codes.</b></td>
    </tr>
    <tr><td class="normal" colspan="5">&nbsp;</td></tr>
    <tr>
     <td class="normal">&nbsp;</td>
     <td bgcolor="#EEEEEE" class="header">Code</td>
     <td bgcolor="#EEEEEE" class="header">Description</td>
     <td bgcolor="#EEEEEE" class="header">Delete</td>
    </tr>
<?php
$result = db_do("SELECT id, code, description FROM reg_codes ORDER BY description");
while (list($id, $code, $description) = db_row($result)) {
?>
    <tr>
     <td class="normal"><input type="hidden" name="ids[]" value="<?php echo $id; ?>"></td>
     <td class="normal"><input type="text" name="codes[<?php echo $id; ?>]" size="15" value="<?php echo $code; ?>"></td>
     <td class="normal"><input type="text" name="descriptions[<?php echo $id; ?>]" size="15" value="<?php echo $description; ?>"></td>
     <td class="normal"><input type="checkbox" name="delete[<?php echo $id; ?>]" value="1"></td>
    </tr>
<?php
}

db_free($result);
db_disconnect();
?>
    <tr>
     <td class="normal">Add</td>
     <td class="normal"><input type="text" name="new_code" size="15"></td>
     <td class="normal"><input type="text" name="new_description" size="15"></td>
     <td class="normal">&nbsp;</td>
    </tr>
    <tr>
     <td class="normal">&nbsp;</td>
     <td align="center" class="normal" colspan="5"><input type="submit" name="submit" value=" Update Reg Codes "></td>
    </tr>
   </table>
  </form>
 </body>
</html>
