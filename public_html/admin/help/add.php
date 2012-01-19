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
# $srp: godealertodealer.com/htdocs/admin/help/add.php,v 1.2 2002/09/03 00:36:09 steve Exp $
#

include('../../../include/db.php');
db_connect();

extract(defineVars("topic","helptext","submit"));

$page_title = 'Add Help Topic';

$topic    = trim($topic);
$helptext = trim($helptext);
$errors   = '';

if (!empty($submit)) {
	if (empty($topic))
		$errors .= '<li>You must supply a topic.</li>';
	if (empty($helptext))
		$errors .= '<li>You must supply content for this help topic.</li>';

	if (empty($errors)) {
		db_do("INSERT INTO help SET topic='$topic', " .
		    "helptext='$helptext', modified=NOW(), created=modified");

		header('Location: index.php');
		exit;
	}

	db_disconnect();
}

$topic    = stripslashes($topic);
$helptext = stripslashes($helptext);
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
  <table align="center" border="0" cellpadding="10" cellspacing="0">
   <tr>
    <td>
<?php include('_form.php'); ?>
    </td>
   </tr>
  </table>
 </body>
</html>
