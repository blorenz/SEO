<?php
#
# Copyright (c) 2002 Steve Price
# All rights reserved.
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions
# are met:
#
# 1. Redistributions of source code must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
# 2. Redistributions in binary form must reproduce the above copyright
#    notice, this list of conditions and the following disclaimer in the
#    documentation and/or other materials provided with the distribution.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
# ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
# FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
# DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
# OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
# HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
# LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
# OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
# SUCH DAMAGE.
#
# $srp: godealertodealer.com/htdocs/admin/increments/index.php,v 1.4 2002/09/03 00:36:09 steve Exp $
#

$page_title = 'Manage Bid Increments';

include('../../../include/db.php');
db_connect();

extract(defineVars("ids","submit","new_increment","increments","delete")); //JJM added 7/6/2010

if (!is_array($ids))
	$ids = array();

if (isset($submit)) {
	if ($new_increment > 0)
		db_do("INSERT INTO increments SET " .
		    "increment='$new_increment', modified=NOW(), " .
		    "created=modified");

	while (list(, $id) = each($ids)) {
		$increment = $increments[$id];

		if (empty($increment))
			$increment = 0;
		else
			$increment = ereg_replace(',', '', $increment);

		if ($delete[$id])
			db_do("DELETE FROM increments WHERE id='$id'");
		elseif ($increment > 0)
			db_do("UPDATE increments SET increment='$increment' " .
			    "WHERE id='$id'");
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
  <br />
  <p align="center" class="big"><b>Bid Increments</b></p>
  <p align="center" class="large"><b>Add, edit, or delete bid increments.</b></p>
  <form action="<?php echo $PHP_SELF; ?>" method="POST">
   <table align="center" border="0" cellspacing="3" cellpadding="3">
    <tr><td class="normal" colspan="3">&nbsp;</td></tr>
    <tr>
     <td class="normal">&nbsp;</td>
     <td bgcolor="#EEEEEE" class="header">Increment</td>
     <td bgcolor="#EEEEEE" class="header">Delete</td>
    </tr>
<?php
$result = db_do("SELECT id, increment FROM increments ORDER BY increment");
while (list($id, $increment) = db_row($result)) {
	$increment = number_format($increment, 2);
?>
    <tr>
     <td class="normal">&nbsp;<input type="hidden" name="ids[]" value="<?php echo $id; ?>"></td>
     <td class="normal"><input type="text" name="increments[<?php echo $id; ?>]" size="10" value="<?php echo $increment; ?>"></td>
     <td class="normal"><input type="checkbox" name="delete[<?php echo $id; ?>]" value="1"></td>
    </tr>
<?php
}

db_free($result);
db_disconnect();
?>
    <tr>
     <td class="normal">Add</td>
     <td class="normal"><input type="text" name="new_increment" size="10"></td>
     <td class="normal">&nbsp;</td>
    </tr>
    <tr>
     <td align="center" class="normal" colspan="3"><input type="submit" name="submit" value=" Update Increments "></td>
    </tr>
   </table>
  </form>
 </body>
</html>
