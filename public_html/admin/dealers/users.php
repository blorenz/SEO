<?php

include('../../../include/db.php');
db_connect();


extract(defineVars("did","dir","sort","filter","QUERY_STRING","PHP_SELF",
				   "filter","Last_Name","First_Name","Email","Phone",
				   "Privs","Lastlogin","search","category")); //JJM Added 5/8/10

if(!empty($_GET['did']))
	$did = $_GET['did'];

if (empty($did) || $did <= 0) {
	header('Location: index.php');
	exit;
}

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

if (!empty($sort))
	$SortListBy = $_REQUEST['sort'];
else
	$SortListBy = "last_name";


if(empty($filter))
{
    $sql = "SELECT COUNT(*) FROM users WHERE dealer_id='$did'";
}
else
{
    $field = $$category;
    $sql = "SELECT COUNT(*) FROM users WHERE dealer_id='$did' AND $field LIKE \"%$search%\"";
}

include('../../../include/list.php');

if(empty($filter))
{
	$result = db_do("SELECT id, CONCAT(first_name, ' ', last_name) as name, email, phone, privs, lastlogin, status
				FROM users
				WHERE dealer_id='$did'
				ORDER BY $SortListBy $dir LIMIT $_start, $limit");
}
else
{
    $field = $$category;
	$result = db_do("SELECT id, CONCAT(first_name, ' ', last_name) as name, email, phone, privs, lastlogin, status
				FROM users
				WHERE dealer_id='$did' AND $field LIKE \"%$search%\"
				ORDER BY $SortListBy $dir LIMIT $_start, $limit");
}

$pending = array();
$active = array();
$suspended = array();

while ($row = db_row($result)) {
	switch ($row['status']) {
	case 'pending':
		$pending[] = $row;
		break;
	case 'active':
		$active[] = $row;
		break;
	case 'suspended':
		$suspended[] = $row;
		break;
	}
}

$result_dealer_name = db_do("SELECT name FROM dealers WHERE id='$did'");
list($dealer_name) = db_row($result_dealer_name);

$page_title = "Items for $dealer_name";
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
<?php include('_links_users.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p>
<form action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" method="post">
    <input type="hidden" name="filter" value="true" />
	<input type="hidden" name="Last_Name" value="last_name" />
	<input type="hidden" name="First_Name" value="first_name" />
	<input type="hidden" name="Email" value="email" />
    <input type="hidden" name="Phone" value="phone" />
    <input type="hidden" name="Privs" value="privs" />
    <input type="hidden" name="Lastlogin" value="lastlogin" />
    <table class="normal" align="center" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Search:</td>
        <td><input type="text" name="search" size="20" maxlength="100" /></td>
        <td><select size="1" name="category"><option>Last_Name</option><option>First_Name</option><option>Email</option><option>Phone</option><option>Fax</option></select></td>
        <td><input type="submit" value="Submit" /></td>
        <td><a href="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" title="Clear your search filter">Clear results</a></td>
      </tr>
    </table>
  </form>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php if (count($pending) > 0) { ?>
   <tr>
    <td class="big" colspan="5"><b>Pending Users</b></td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=last_name&dir=<?php if($sort == 'last_name') { echo $otherdir; } else { echo $dir; } ?>">Name</a></b></td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=email&dir=<?php if($sort == 'email') { echo $otherdir; } else { echo $dir; } ?>">Email</a></b></td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=phone&dir=<?php if($sort == 'phone') { echo $otherdir; } else { echo $dir; } ?>">Phone</a></b></td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=fax&dir=<?php if($sort == 'privs') { echo $otherdir; } else { echo $dir; } ?>">Privs</a></b></td>
	 <td class="header"><b><a href="?did=<?=$did?>&sort=fax&dir=<?php if($sort == 'lastlogin') { echo $otherdir; } else { echo $dir; } ?>">Last Login</a></b></td>
   </tr>
<?php
$bgcolor = '#FFFFFF';

while (list(, $row) = each($pending)) {
	list($id, $name, $email, $phone, $privs, $lastlogin) = $row;
	$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><a href="../users/become.php?id=<?php echo $id; ?>">become</a> | <a href="../users/edit.php?id=<?php echo $id; ?>">edit</a></td>
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><a href="mailto:<?php tshow($email); ?>"><?php tshow($email); ?></a></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($privs); ?></td>
    <td class="normal"><?php
          if ($lastlogin == '') {
             echo "N/A";
          } else {
             echo date('j M Y H:i',
             strtotime($lastlogin));
          }
    ?></td>
   </tr>
<?php } ?>
   <tr><td colspan="5">&nbsp;</td></tr>
<?php } ?>
<?php if (count($active) > 0) { ?>
   <tr>
    <td class="big" colspan="5"><b>Active Users</b></td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=last_name&dir=<?php if($sort == 'last_name') { echo $otherdir; } else { echo $dir; } ?>">Name</a></b></td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=email&dir=<?php if($sort == 'email') { echo $otherdir; } else { echo $dir; } ?>">Email</a></b></td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=phone&dir=<?php if($sort == 'phone') { echo $otherdir; } else { echo $dir; } ?>">Phone</a></b></td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=privs&dir=<?php if($sort == 'privs') { echo $otherdir; } else { echo $dir; } ?>">Privs</a></b></td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=privs&dir=<?php if($sort == 'lastlogin') { echo $otherdir; } else { echo $dir; } ?>">Last Login</a></b></td>
   </tr>
<?php
$bgcolor = '#FFFFFF';

while (list(, $row) = each($active)) {
	list($id, $name, $email, $phone, $privs, $lastlogin) = $row;
	$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><a href="../users/become.php?id=<?php echo $id; ?>">become</a> | <a href="../users/edit.php?id=<?php echo $id; ?>">edit</a></td>
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><a href="mailto:<?php tshow($email); ?>"><?php tshow($email); ?></a></td>
    <td class="normal"><?php tshow($phone); ?></td>
        <td class="normal"><?php tshow($privs); ?></td>
    <td class="normal"><?php
          if ($lastlogin == '') {
             echo "N/A";
          } else {
             echo date('j M Y H:i',
             strtotime($lastlogin));
          }
    ?></td>
   </tr>
<?php } ?>
   <tr><td colspan="5">&nbsp;</td></tr>
<?php } ?>
<?php if (count($suspended) > 0) { ?>
   <tr>
    <td class="big" colspan="5"><b>Suspended Users</b></td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=last_name&dir=<?php if($sort == 'last_name') { echo $otherdir; } else { echo $dir; } ?>">Name</a></b></td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=email&dir=<?php if($sort == 'email') { echo $otherdir; } else { echo $dir; } ?>">Email</a></b></td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=phone&dir=<?php if($sort == 'phone') { echo $otherdir; } else { echo $dir; } ?>">Phone</a></b></td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=privs&dir=<?php if($sort == 'privs') { echo $otherdir; } else { echo $dir; } ?>">Privs</a></b></td>
    <td class="header"><b><a href="?did=<?=$did?>&sort=privs&dir=<?php if($sort == 'lastlogin') { echo $otherdir; } else { echo $dir; } ?>">Last Login</a></b></td>

   </tr>
<?php
$bgcolor = '#FFFFFF';

while (list(, $row) = each($suspended)) {
	list($id, $name, $email, $phone, $fax, $privs, $lastlogin) = $row;
	$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><a href="../users/become.php?id=<?php echo $id; ?>">become</a> | <a href="../users/edit.php?id=<?php echo $id; ?>">edit</a></td>
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><a href="mailto:<?php tshow($email); ?>"><?php tshow($email); ?></a></td>
        <td class="normal"><?php tshow($phone); ?></td>
        <td class="normal"><?php tshow($privs); ?></td>
    <td class="normal"><?php
          if ($lastlogin == '') {
             echo "N/A";
          } else {
             echo date('j M Y H:i',
             strtotime($lastlogin));
          }
    ?></td>
   </tr>
<?php } ?>
<?php }
db_free($result);
db_disconnect();?>
  </table>
 </body>
</html>