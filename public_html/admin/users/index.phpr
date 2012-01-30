<?php
include('../../../include/defineVars.php');    	//JJM added on 1/31/10 instead of the following three lines
extract(defineVars("sort","s","dir","filter","Lastname","Firstname",
				   "Dealership","Email","Phone","LastLogin","search",
				   "category"));                 //RJM ADDED THIS LINE ON 1/2/10

if (empty($_GET['s']))
	$status = 'active';
else
	$status = $_GET['s'];

if (empty($_GET['dir']))
	$dir = 'asc';
else
	$dir = $_GET['dir'];

if($dir == 'asc')
{
  $otherdir = 'desc';
}
else
{
  $otherdir = 'asc';
}

if (!empty($_REQUEST['sort']))
	$SortListBy = $_REQUEST['sort'];
else
	$SortListBy = "last_name, first_name";

$page_title = ucfirst($status) . ' Users';

include('../../../include/db.php');
db_connect();

if(empty($filter))
{
    $sql = "SELECT COUNT(*) FROM users, " .
    "dealers WHERE dealers.id=users.dealer_id AND users.status='$status'";
}
else
{
    $field = $$category;
    $sql = "SELECT COUNT(*) FROM users, " .
    "dealers WHERE dealers.id=users.dealer_id AND users.status='$status' AND $field LIKE \"%$search%\"";
}

include('../../../include/list.php');

if(empty($filter))
{
	$result = db_do("SELECT users.id, dealer_id, dealers.name, email, " .
    "CONCAT(first_name, ' ', last_name), users.phone, users.lastlogin FROM users, " .
    "dealers WHERE dealers.id=users.dealer_id AND users.status='$status' " .
    "ORDER BY $SortListBy $dir LIMIT $_start, $limit");
}
else
{
    $field = $$category;
	$result = db_do("SELECT users.id, dealer_id, dealers.name, email, " .
    "CONCAT(first_name, ' ', last_name), users.phone, users.lastlogin FROM users, " .
    "dealers WHERE dealers.id=users.dealer_id AND users.status='$status' AND $field LIKE \"%$search%\" " .
    "ORDER BY $SortListBy $dir LIMIT $_start, $limit");
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
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
  <form action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" method="post">
    <input type="hidden" name="filter" value="true" />
    <input type="hidden" name="Lastname" value="last_name" />
    <input type="hidden" name="Firstname" value="first_name" />
    <input type="hidden" name="Dealership" value="dealers.name" />
    <input type="hidden" name="Email" value="users.email" />
    <input type="hidden" name="Phone" value="users.phone" />
    <input type="hidden" name="LastLogin" value="users.lastlogin" />
    <table class="normal" align="center" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Search:</td>
        <td><input type="text" name="search" size="20" maxlength="100" /></td>
        <td><select size="1" name="category"><option>Firstname</option><option>Lastname</option><option>Dealership</option><option>Email</option><option>Phone</option><option>LastLogin</option></select></td>
        <td><input type="submit" value="Submit" /></td>
        <td><a href="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" title="Clear your search filter">Clear results</a></td>
      </tr>
    </table>
  </form>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No users found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="5"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td>&nbsp;</td>
    <td class="header"><a href="?s=<?php echo $status; ?>&sort=last_name&dir=<?php if($sort == 'last_name') { echo $otherdir; } else { echo $dir; } ?>"><b>Name</b></a></td>
    <td class="header"><a href="?s=<?php echo $status; ?>&sort=dealers.name&dir=<?php if($sort == 'dealers.name') { echo $otherdir; } else { echo $dir; } ?>"><b>Dealership Name</b></a></td>
    <td class="header"><a href="?s=<?php echo $status; ?>&sort=email&dir=<?php if($sort == 'email') { echo $otherdir; } else { echo $dir; } ?>"><b>Email</b></a></td>
    <td class="header"><a href="?s=<?php echo $status; ?>&sort=phone&dir=<?php if($sort == 'phone') { echo $otherdir; } else { echo $dir; } ?>"><b>Phone</b></a></td>
    <td class="header"><a href="?s=<?php echo $status; ?>&sort=lastlogin&dir=<?php if($sort == 'lastlogin') { echo $otherdir; } else { echo $dir; } ?>"><b>Last Login</b></a></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $dealer_id, $dealer, $email, $name, $phone, $lastlogin)
	    = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><a href="become.php?id=<?php echo $id; ?>">become</a> | <a href="edit.php?id=<?php echo $id; ?>">edit</a></td>
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><a href="../dealers/edit.php?id=<?php echo $dealer_id; ?>"><?php tshow($dealer); ?></a></td>
    <td class="normal"><a href="mailto:<?php tshow($email); ?>"><?php tshow($email); ?></a></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal">
    <?php
    if ($lastlogin == '') {
       echo "N/A";
    } else {
       echo date('j M Y H:i', strtotime($lastlogin));
    }
    ?>
    </td>
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

<?php
?>
