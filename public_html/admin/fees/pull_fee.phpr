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
# $srp: godealertodealer.com/htdocs/admin/fees/pull_fee.php,v 1.4 2002/09/03 00:36:09 steve Exp $
#

$page_title = 'Manage Fees';

include('../../../include/db.php');
db_connect();

extract(defineVars("ids","submit","lows","highs","dollarss","delete",
				   "new_low","new_high","new_dollars")); //JJM 08/28/2010

if (!is_array($ids))
	$ids = array();

if (isset($submit)) {
	$new_low = fix_price($new_low);
	$new_high = fix_price($new_high);

	if ($new_low > 0 && $new_high > $new_low && $new_dollars > 0)
		db_do("INSERT INTO pull_fees SET low='$new_low', " .
		    "high='$new_high', dollars='$new_dollars', " .
		    "modified=NOW(), created=modified");

	while (list(, $id) = each($ids)) {
		$low        = fix_price($lows[$id]);
		$high       = fix_price($highs[$id]);
		$dollars = $dollarss[$id];

		if (empty($low))
			$low = 0;

		if (empty($high))
			$high = 0;

		if (empty($dollars))
			$dollars = 0;

		if ($delete[$id])
			db_do("DELETE FROM pull_fees WHERE id='$id'");
		elseif ($low > 0 && $high > $low && $dollars >0)
			db_do("UPDATE pull_fees SET low='$low', high='$high', " .
			    "dollars='$dollars' WHERE id='$id'");
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
  <?php include('_links.php'); ?>
  <p align="center" class="big"><b>Pull Fees</b></p>
  <form action="<?php echo $PHP_SELF; ?>" method="POST">
   <table align="center" border="0" cellspacing="3" cellpadding="3">
    <tr>
     <td class="normal">&nbsp;</td>
     <td align="center" colspan="4" class="large"><b>Add, edit, or delete Pull Fees.</b></td>
    </tr>
    <tr><td class="normal" colspan="5">&nbsp;</td></tr>
    <tr>
     <td class="normal">&nbsp;</td>
     <td bgcolor="#EEEEEE" class="header">From</td>
     <td bgcolor="#EEEEEE" class="header">To</td>
     <td bgcolor="#EEEEEE" class="header">Dollars</td>
     <td bgcolor="#EEEEEE" class="header">Delete</td>
    </tr>
<?php
$result = db_do("SELECT id, low, high, dollars FROM pull_fees ORDER BY low");
while (list($id, $low, $high, $dollars) = db_row($result)) {
	$low        = number_format($low, 2);
	$high       = number_format($high, 2);
	$dollars = number_format($dollars, 2);
?>
    <tr>
     <td class="normal">&nbsp;<input type="hidden" name="ids[]" value="<?php echo $id; ?>"></td>
     <td class="normal"><input type="text" name="lows[<?php echo $id; ?>]" size="15" value="<?php echo $low; ?>"></td>
     <td class="normal"><input type="text" name="highs[<?php echo $id; ?>]" size="15" value="<?php echo $high; ?>"></td>
     <td class="normal"><input type="text" name="dollarss[<?php echo $id; ?>]" size="15" value="<?php echo $dollars; ?>"></td>
     <td class="normal"><input type="checkbox" name="delete[<?php echo $id; ?>]" value="1"></td>
    </tr>
<?php
}

db_free($result);
db_disconnect();
?>
    <tr>
     <td class="normal">Add</td>
     <td class="normal"><input type="text" name="new_low" size="15"></td>
     <td class="normal"><input type="text" name="new_high" size="15"></td>
     <td class="normal"><input type="text" name="new_dollars" size="15"></td>
     <td class="normal">&nbsp;</td>
    </tr>
    <tr>
     <td class="normal">&nbsp;</td>
     <td align="center" class="normal" colspan="5"><input type="submit" name="submit" value=" Update Pull Fees "></td>
    </tr>
   </table>
  </form>
 </body>
</html>
