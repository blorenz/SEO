<?php

/**
* $Id: index.php 195 2006-06-09 15:56:05Z kaneda $
*/
include('../../../include/db.php');
db_connect();

extract(defineVars("sort","s","dir","filter","category","search","QUERY_STRING",
				"Dealer_ID","Dealership","POC_Lastname","POC_Firstname","POC_Email",
				"City","State","Phone","Fax","filter","Dealership","POC_Lastname",
				"POC_Firstname","POC_Email","City","State","Phone","Fax")); //JJM added 5/7/2010

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

if (!empty($_REQUEST['sort']))
	$SortListBy = $_REQUEST['sort'];
else
	$SortListBy = "name";

$page_title = ucfirst($status) . ' Dealers/Financial Companies';

if(empty($filter))
{
    $sql = "SELECT COUNT(*) FROM dealers WHERE status='$status'";
}
else
{
    $field = ${$category};
    if($category == 'Dealer_ID') { $field = 'id'; }
	if ($field=='dba')
		$sql = "SELECT COUNT(*) FROM dealers WHERE status='$status' AND (dba LIKE \"%$search%\" or name LIKE \"%$search%\") ";
   elseif ($field == 'id')
      $sql = "SELECT COUNT(*) FROM dealers WHERE status='$status' AND id = $search";
   else
    	$sql = "SELECT COUNT(*) FROM dealers WHERE status='$status' AND $field LIKE \"%$search%\"";
}

include('../../../include/list.php');

if(empty($filter))
{
	$result = db_do("SELECT id, CONCAT(poc_f_name, ' ', poc_l_name), poc_email, name, dba, city, state, phone, fax, " .
		"rating, DATE_FORMAT(created, '%d-%b-%Y') FROM dealers WHERE " .
		"status='$status' ORDER BY $SortListBy $dir LIMIT $_start, $limit");
}
else
{
    $field = ${$category};
    if($category == 'Dealer_ID') {$field = 'id';}
	if ($field=='dba')
	    $result = db_do("SELECT id, CONCAT(poc_f_name, ' ', poc_l_name), poc_email, name, dba, city, state, phone, fax, " .
		"rating, DATE_FORMAT(created, '%d-%b-%Y') FROM dealers WHERE " .
		"status='$status' AND (dba LIKE \"%$search%\" OR name LIKE \"%$search%\") ORDER BY $SortListBy $dir LIMIT $_start, $limit");
	elseif ($field == 'id')
      $result = db_do("SELECT id, CONCAT(poc_f_name, ' ', poc_l_name), poc_email, name, dba, city, state, phone, fax, rating, DATE_FORMAT(created, '%d-%b-%Y') FROM dealers WHERE status = '$status' AND $field = $search ORDER BY $SortListBy $dir LIMIT $_start, $limit");
   else
    	$result = db_do("SELECT id, CONCAT(poc_f_name, ' ', poc_l_name), poc_email, name, dba, city, state, phone, fax, " .
		"rating, DATE_FORMAT(created, '%d-%b-%Y') FROM dealers WHERE " .
		"status='$status' AND $field LIKE \"%$search%\" ORDER BY $SortListBy $dir LIMIT $_start, $limit");
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
<?php include('_links.php'); ?> <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
  <form action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" method="post">
    <input type="hidden" name="filter" value="true" />
    <input type="hidden" name="Dealership" value="dba" />
    <input type="hidden" name="POC_Lastname" value="poc_l_name" />
    <input type="hidden" name="POC_Firstname" value="poc_f_name" />
    <input type="hidden" name="POC_Email" value="poc_email" />
	<input type="hidden" name="City" value="city" />
	<input type="hidden" name="State" value="state" />
    <input type="hidden" name="Phone" value="phone" />
    <input type="hidden" name="Fax" value="fax" />
    <table class="normal" align="center" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Search:</td>
        <td><input type="text" name="search" size="20" maxlength="100" /></td>
        <td><select size="1" name="category"><option>Dealership</option><option>POC_Firstname</option><option>POC_Lastname</option>
		<option>POC_Email</option><option>Dealer_ID</option><option>City</option><option>State</option><option>Phone</option><option>Fax</option></select></td>
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
    <td align="center" class="big">No dealers found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td>&nbsp;</td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=dba&dir=<?php if($sort == 'dba') { echo $otherdir; } else { echo $dir; } ?>">Dealership Name</a></b></td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=poc_f_name&dir=<?php if($sort == 'poc_f_name') { echo $otherdir; } else { echo $dir; } ?>">POC Name</a></b></td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=poc_email&dir=<?php if($sort == 'poc_email') { echo $otherdir; } else { echo $dir; } ?>">POC Email</a></b></td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=rating&dir=<?php if($sort == 'rating') { echo $otherdir; } else { echo $dir; } ?>">Seller Rating</a></b></td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=sdid&dir=<?php if($sort == 'sdid') { echo $otherdir; } else { echo $dir; } ?>">Location</a></b></td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=phone&dir=<?php if($sort == 'phone') { echo $otherdir; } else { echo $dir; } ?>">Phone</a></b></td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=fax&dir=<?php if($sort == 'fax') { echo $otherdir; } else { echo $dir; } ?>">Fax</a></b></td>
    <td class="header"><b><a href="?s=<?php echo $status; ?>&sort=created&dir=<?php if($sort == 'created') { echo $otherdir; } else { echo $dir; } ?>">Created</a></b></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $poc_l_name, $poc_email, $name, $dba, $city, $state, $phone, $fax,
	   $rating, $created) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);

		if (empty($dba)) {
			$dba = $name;
			db_do("UPDATE dealers SET dba=\"$name\" WHERE id='$id'");
		}
		if (empty($name)) {
			$name = $dba;
			db_do("UPDATE dealers SET name=\"$dba\" WHERE id='$id'");
		}
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="left" class="small" width="85">
	&bull;&nbsp;<a href="edit.php?id=<?php echo $id; ?>">edit</a><br>
	&bull;&nbsp;<a href="../charges/dealer.php?id=<?php echo $id; ?>">charges</a>
	&bull;&nbsp;<a href="users.php?did=<?php echo $id; ?>">users</a><br>
	&bull;&nbsp;<a href="auctions.php?did=<?php echo $id; ?>">auctions</a>
	&bull;&nbsp;<a href="items.php?did=<?php echo $id; ?>">items</a></td>
    <td class="normal"><?php tshow($dba); ?><br><font class="small">(<?=$name?>)</font></td>
    <td class="normal"><?php tshow($poc_l_name); ?></td>
    <td class="normal"><a href="mailto:<?php tshow($poc_email); ?>"><?php tshow($poc_email); ?></a></td>
    <td class="normal"><?php tshow($rating); ?></td>
    <td class="normal"><?php echo "$city $state"; ?></td>
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
