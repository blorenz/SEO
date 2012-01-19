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
# $srp: godealertodealer.com/htdocs/auction/help.php,v 1.5 2002/09/03 00:37:29 steve Exp $
#

include('../../include/session.php');
include('../../include/db.php');
db_connect();

if (empty($topic))
	$topic = 'General';

$help_page = "help.php";
include("header.php");
?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
 <tr><td>&nbsp;</td></tr>
 <tr><td align="center" class="big"><b>Help - <?=$topic?></b></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr>
  <td class="normal">
<?php
$result = db_do("SELECT helptext FROM help WHERE topic='$topic'");

if (list($helptext) = db_row($result))
	echo "   $helptext\n";
else
	echo "   <center><i>No text available.</i></center>\n";

db_free($result);
?>
  </td>
 </tr>
 <tr><td>&nbsp;</td></tr>
 <tr>
  <td align="center" class="normal">
<?php
$result = db_do("SELECT topic FROM help ORDER BY topic");

if (db_num_rows($result) > 0) {
	echo "   <b>Other Help Topics</b><br />\n";
	while (list($topic) = db_row($result))
		echo "   <a href=\"help.php?topic=$topic\">$topic</a><br />\n";
}

db_free($result);
?>
  </td>
 </tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td>&nbsp;</td></tr>
</table>

<?php include('footer.php'); ?>
