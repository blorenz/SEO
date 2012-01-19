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
# $srp: godealertodealer.com/htdocs/admin/help/index.php,v 1.3 2002/09/03 00:36:09 steve Exp $
#

$page_title = 'Help Topics';

include('../../../include/db.php');
db_connect();

$sql = "SELECT COUNT(*) FROM help";

include('../../../include/list.php');

$result = db_do("SELECT id, topic, helptext FROM help ORDER BY topic");
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
  <p align="center" class="big"><b>Help Topics</b></p>
  <table align="center" border="0" cellspacing="3" cellpadding="3" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No help topics found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="5"><?php echo $nav_links; ?></td></tr>
   <tr> 
    <td>&nbsp;</td>
    <td class="header"><b>Topic</b></td>
    <td align="center" class="header"><b>Text</b></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $topic, $helptext) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>"> 
    <td align="center" class="normal"><a href="edit.php?id=<?php echo $id; ?>">edit</a></td>
    <td class="normal"><?php tshow($topic); ?></td>
    <td class="normal"><?php tshow($helptext); ?></td>
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
