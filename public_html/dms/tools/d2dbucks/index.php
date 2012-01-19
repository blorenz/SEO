<?php

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

if ($_REQUEST['sort'])
	$SortListBy = $_REQUEST['sort'];
else
	$SortListBy = "d2dbucks.id";
	
$page_title = "D2DBucks";

include('../../../../include/session.php');
include('../../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: dealertodealer.com');
	exit;
}

if(empty($filter))
{
    $sql = "SELECT COUNT(*) FROM d2dbucks";
}
else
{
    $field = $$category;
    $sql = "SELECT COUNT(*) FROM d2dbucks, dms 
			WHERE d2dbucks.dm_id=dms.id AND $field LIKE \"%$search%\" and dm_id=$dm_id";
}

include('../../../../include/list.php');

if(empty($filter))
{
	$result = db_do("SELECT d2dbucks.id, d2dbucks.serial_id, d2dbucks.amount, dms.id, CONCAT(dms.first_name, ' ', dms.last_name), d2dbucks.ae_id, 
				d2dbucks.dealer_id, d2dbucks.status, DATE_FORMAT(d2dbucks.modified, '%d-%b-%Y')
			FROM d2dbucks, dms 
			WHERE d2dbucks.dm_id=dms.id and dm_id=$dm_id
			ORDER BY $SortListBy $dir 
			LIMIT $_start, $limit");
}
else
{
    $field = $$category;
	$result = db_do("SELECT d2dbucks.id, d2dbucks.serial_id, d2dbucks.amount, dms.id, CONCAT(dms.first_name, ' ', dms.last_name), d2dbucks.ae_id, 
				d2dbucks.dealer_id, d2dbucks.status, DATE_FORMAT(d2dbucks.modified, '%d-%b-%Y')
			FROM d2dbucks, dms
			WHERE d2dbucks.dm_id=dms.id	AND $field LIKE \"%$search%\" and dm_id=$dm_id
			ORDER BY $SortListBy $dir 
			LIMIT $_start, $limit");
}


?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../../header.php'); ?>
  <br />
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
  <form action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" method="post">
    <input type="hidden" name="filter" value="true" />
    <input type="hidden" name="Serial#" value="d2dbucks.serial_id" />
    <input type="hidden" name="Amount" value="d2dbucks.amount" />
    <input type="hidden" name="DM" value="dms.last_name" />
    <input type="hidden" name="Status" value="d2dbucks.status" />
    <table class="normal" align="center" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Search:</td>
        <td><input type="text" name="search" size="20" maxlength="100" /></td>
        <td><select size="1" name="category">
			<option>Serial#</option>
			<option>Amount</option>
			<option>DM</option>
			<option>Status</option>
		</select></td>
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
		<td colspan="9" align="center" class="big">No D2DBucks found.</td>
	</tr>
<?php
} else {
?>
	<tr><td colspan="9"><?php echo $nav_links; ?></td></tr>
	<tr>
		<td>&nbsp;</td>
		<td class="header" align="right"><a href="?sort=d2dbucks.serial_id&dir=<?php if($sort == 'd2dbucks.serial_id') { echo $otherdir; } else { echo $dir; } ?>"><b>Serial #</b></a></td>
		<td class="header" align="center"><a href="?sort=d2dbucks.amount&dir=<?php if($sort == 'd2dbucks.amount') { echo $otherdir; } else { echo $dir; } ?>"><b>Amount</b></a></td>
		<td class="header"><a href="?sort=dms.last_name&dir=<?php if($sort == 'dms.last_name') { echo $otherdir; } else { echo $dir; } ?>"><b>DM</b></a></td>
		<td class="header"><a href="?sort=d2dbucks.ae_id&dir=<?php if($sort == 'd2dbucks.ae_id') { echo $otherdir; } else { echo $dir; } ?>"><b>AE</b></a></td>
		<td class="header"><a href="?sort=d2dbucks.dealer_id&dir=<?php if($sort == 'd2dbucks.dealer_id') { echo $otherdir; } else { echo $dir; } ?>"><b>Dealership</b></a></td>
		<td class="header"><a href="?sort=d2dbucks.status&dir=<?php if($sort == 'd2dbucks.status') { echo $otherdir; } else { echo $dir; } ?>"><b>Status</b></a></td>
		<td class="header"><a href="?sort=d2dbucks.modified&dir=<?php if($sort == 'd2dbucks.modified') { echo $otherdir; } else { echo $dir; } ?>"><b>Modified</b></a></td>   
	</tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $serial_num, $amount, $dm_id, $dm_name, $ae_id, $dealer_id, $status, $modified) = db_row($result)) {
	
		$edit = "&dm_id=$dm_id";
		
		if ($ae_id > 0) { 
			$result_ae = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM aes WHERE id='$ae_id'");
			list($ae_name) = db_row($result_ae);
			$edit.= "&ae_id=$ae_id";
		}
		else
			$ae_name = 'Not Assigned';
		
		if ($dealer_id > 0) { 
			$result_dealer = db_do("SELECT name FROM dealers WHERE id='$dealer_id'");
			list($dealer_name) = db_row($result_dealer);
			$edit.= "&dealer_id=$dealer_id";
		}
		else
			$dealer_name = 'Not Assigned';
	
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
	<tr bgcolor="<?=$bgcolor?>">
		<td class="normal" align="right"><a href="edit.php?id=<?=$id?><?=$edit?>">edit</a></td>
		<td class="normal" align="right"><?=str_pad($serial_num, 5, "0", STR_PAD_LEFT)?></td>
		<td class="normal" align="right">US $<?=number_format($amount,2)?></td>
		<td class="normal"><?=$dm_name?></td>
		<td class="normal"><?=$ae_name?></td>
		<td class="normal"><?=$dealer_name?></td>
		<td class="normal"><?=$status?></td>
		<td class="normal"><?=$modified?></td>
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

<?php include('../../footer.php'); ?>