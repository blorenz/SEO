<?php

include('../../../include/db.php');
db_connect();

extract(defineVars("s","dir","sort","status","limit","id")); //JJM 08/30/2010

if (empty($s))
	$status = 'active';
else
	$status = $s;

if (empty($dir))
	$dir = 'asc';

if($dir == 'asc')
{
  $otherdir = 'desc';
}
else
{
  $otherdir = 'asc';
}

if ($sort)
	$SortListBy = $_REQUEST['sort'];
else
	$SortListBy = "name";

$page_title = ucfirst($status) . ' Dealers';

$sql = "SELECT COUNT(*) FROM dealers WHERE ae_id='$id' AND status='$status'";

include('../../../include/list.php');

$result = db_do("SELECT id, poc_l_name, poc_email, name, phone, fax, rating, DATE_FORMAT(created, '%d-%b-%Y')
				FROM dealers
				WHERE ae_id='$id' AND status='$status'
				ORDER BY $SortListBy $dir
				LIMIT $_start, $limit");

?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include('_links_accounts.php'); ?>
  <p align="center" class="big"><b>Dealers/Financial Companies</b></p>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td colspan="9" align="center" class="big">No dealers found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="9"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td>&nbsp;</td>
    <td class="header"><b><a href="?id=<?php echo $id; ?>&s=<?php echo $status; ?>&sort=name&dir=<?php if($sort == 'name') { echo $otherdir; } else { echo $dir; } ?>">Dealership Name</a></b></td>
    <td class="header"><b><a href="?id=<?php echo $id; ?>&s=<?php echo $status; ?>&sort=poc_l_name&dir=<?php if($sort == 'poc_l_name') { echo $otherdir; } else { echo $dir; } ?>">POC Name</a></b></td>
    <td class="header"><b><a href="?id=<?php echo $id; ?>&s=<?php echo $status; ?>&sort=poc_email&dir=<?php if($sort == 'poc_email') { echo $otherdir; } else { echo $dir; } ?>">POC Email</a></b></td>
    <td class="header"><b><a href="?id=<?php echo $id; ?>&s=<?php echo $status; ?>&sort=rating&dir=<?php if($sort == 'rating') { echo $otherdir; } else { echo $dir; } ?>">Seller Rating</a></b></td>
    <td class="header"><b><a href="?id=<?php echo $id; ?>&s=<?php echo $status; ?>&sort=phone&dir=<?php if($sort == 'phone') { echo $otherdir; } else { echo $dir; } ?>">Phone</a></b></td>
    <td class="header"><b><a href="?id=<?php echo $id; ?>&s=<?php echo $status; ?>&sort=fax&dir=<?php if($sort == 'fax') { echo $otherdir; } else { echo $dir; } ?>">Fax</a></b></td>
    <td class="header"><b><a href="?id=<?php echo $id; ?>&s=<?php echo $status; ?>&sort=created&dir=<?php if($sort == 'created') { echo $otherdir; } else { echo $dir; } ?>">Created</a></b></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($did, $poc_l_name, $poc_email, $name, $phone, $fax,
	   $rating, $created) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="small"><a href="../charges/dealer.php?id=<?php echo $did; ?>">charges</a> | <a href="../dealers/users.php?did=<?php echo $did; ?>">users</a> | <a href="../dealers/edit.php?id=<?php echo $did; ?>">edit</a>
    <?php if (strtolower($status) == 'pending') : ?>
    | <a href="../dealers/application_form.php?id=<?php echo $did; ?>">Print Application Form</a><br></td>
    <?php endif; ?>
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><?php tshow($poc_l_name); ?></td>
    <td class="normal"><a href="mailto:<?php tshow($poc_email); ?>"><?php tshow($poc_email); ?></a></td>
    <td class="normal"><?php tshow($rating); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($fax); ?></td>
    <td class="normal"><?php tshow($created); ?></td>
   </tr>
<?php
	}
}

db_free($result);
db_disconnect();
?>
  </table>
 </body>
</html>
