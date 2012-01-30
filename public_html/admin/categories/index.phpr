
<?php
/**
* Controls the categories administration section
*
* $Id: index.php 69 2006-05-05 15:28:06Z kaneda $
*/

$page_title = 'Manage Categories';

$PHP_SELF = $_SERVER['PHP_SELF'];

include('../../../include/db.php');
db_connect();
extract(defineVars("ids","pid","spid","submit","new_name","delete","names"));  //JJM 08/28/2010


if (!is_array($ids))
	$ids = array();

if (empty($pid))
	$pid = 0;

if (empty($spid))
	$spid = 0;


if (isset($submit)) {
	if (!empty($new_name))
	{
		if($spid == 0)
		{
			db_do("INSERT INTO categories SET name='$new_name', parent_id='$pid'");
		}
		else
		{
			db_do("INSERT INTO categories SET name='$new_name', parent_id='$spid', subparent_id='$pid'");
		}

	}

	while (list(, $id) = each($ids)) {
		$name = $names[$id];

		if ($delete[$id])
			delete_categories(array($id));
		elseif (!empty($name))
			db_do("UPDATE categories SET name='$name' " .
			    "WHERE id='$id'");
	}
}

function delete_categories($ids) {
	while (list(, $id) = each($ids)) {
		db_do("UPDATE categories SET deleted=1 WHERE id='$id'");

		$result = db_do("SELECT id FROM categories WHERE " .
		    "parent_id='$id'");
		$foo = array();
		while (list($id) = db_row($result))
			$foo[] = $id;

		db_free($result);
		delete_categories($foo);
	}
}

$nav_links = '';

if ($pid > 0) {
	$mother = $pid;
	$count = 0;

	do {
		$result = db_do("SELECT id, name, parent_id FROM categories " .
		    "WHERE id='$mother'");
		list($id, $name, $parent_id) = db_row($result);
		db_free($result);

		if (!$count)
			$nav_links .= "$name ";
		else
			$nav_links = '<a href="index.php?pid=' . $id . '">' .
			    $name . '</a> &gt; ' . $nav_links;

		$count++;
		$mother = $parent_id;
	} while ($mother > 0);
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
  <p><a href="vehicles.php">Fix Vehicles With Incorrect Model ID</a></p>
  <p align="center" class="big"><b>Categories</b></p>
  <form action="<?php echo $PHP_SELF; ?>" method="POST">
   <input type="hidden" name="pid" value="<?php echo $pid; ?>">
   <input type="hidden" name="spid" value="<?php echo $spid; ?>">
   <table align="center" border="0" cellspacing="3" cellpadding="3">
    <tr>
     <td class="normal">&nbsp;</td>
     <td align="center" colspan="2" class="large"><b>Add, edit, or delete categories.</b></td>
    </tr>
    <tr><td class="normal" colspan="3">&nbsp;</td></tr>
<?php if ($pid != 0) { ?>
    <tr>
     <td class="normal">&nbsp;</td>
     <td class="normal" colspan="2"><a href="index.php">Categories: </a><?php echo $nav_links; ?></td>
    </tr>
<?php } ?>
    <tr>
     <td class="normal">&nbsp;</td>
     <td bgcolor="#EEEEEE" class="header">Description</td>
     <td bgcolor="#EEEEEE" class="header">Delete</td>
    </tr>
<?php

if($spid == 0)
{
  $result = db_do("SELECT id,parent_id,subparent_id,name FROM categories WHERE parent_id='$pid' AND subparent_id='0' AND " .
    "deleted=0 ORDER BY name");
}
else
{
  $result = db_do("SELECT id,parent_id,subparent_id,name FROM categories WHERE parent_id='$spid' AND subparent_id='$pid' AND " .
    "deleted=0 ORDER BY name");
}

while (list($id, $pid, $spid, $name) = db_row($result)) {
?>
    <tr>
     <td align="right" class="normal"><a href="index.php?pid=<?php echo $id; ?>&spid=<?php echo $pid; ?>"><img src="../../images/plus.gif" border="0"></a><input type="hidden" name="ids[]" value="<?php echo $id; ?>"></td>
     <td class="normal"><input type="text" name="names[<?php echo $id; ?>]" size="30" value="<?php echo $name; ?>"></td>
     <td class="normal"><input type="checkbox" name="delete[<?php echo $id; ?>]" value="1"></td>
    </tr>
<?php
}

db_free($result);
db_disconnect();
?>
    <tr>
     <td class="normal">Add</td>
     <td class="normal"><input type="text" name="new_name" size="30"></td>
     <td class="normal">&nbsp;</td>
    </tr>
    <tr>
     <td class="normal">&nbsp;</td>
     <td align="center" class="normal" colspan="2"><input type="submit" name="submit" value=" Update Categories "></td>
    </tr>
   </table>
  </form>
 </body>
</html>
