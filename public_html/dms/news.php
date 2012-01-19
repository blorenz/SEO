<?php


if(!empty($_REQUEST['page_title']))
	$page_title = $_REQUEST['page_title'];
else
	$page_title = "";







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
# $srp: godealertodealer.com/htdocs/auction/news.php,v 1.4 2002/09/03 00:37:29 steve Exp $
#

include('../../include/session.php');
include('../../include/db.php');
db_connect();

$help_page = "help.htm";

include('header.php');

if (!empty($id) && $id > 0) {
	$result = db_do("SELECT title, content FROM internal_news WHERE id='$id'");
	if (!$result || db_num_rows($result) <= 0) {
	        header('Location: index.php');
	        exit;
	}

	list($title, $content) = db_row($result);
	db_free($result);
?><head>
  <title>Account Executive: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../site.css" title="site" />
 </head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <table bgcolor="#FFFFFF" border=0 cellpadding="0" cellspacing="0" align="center">
 <tr>
  <td>
	<br />
	<br />
   <center class="big"><b><?php echo $title; ?></b></center>
   <br />
   <br />
   <table align="center" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td class="normal"><?php echo $content; ?></td>
    </tr>
   </table>
   <br />
   <br />
   <center class="normal"><a HREF="news.php">View all news</a></center>
   <br />
   <br />
  </td>
 </tr>
</table>

<?php
} else {
?>
 <head>
  <title>Account Executive: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0">
 <tr>
  <td>
  	<br />
   <center class="big"><b>News</b></center>
      <br />
   <table align="center" border="0" cellspacing="0" cellpadding="0">
<?php
	$result = db_do("SELECT id, title FROM internal_news WHERE status='active' " .
	    "ORDER BY created");
	if (!$result || db_num_rows($result) <= 0) {
		header('Location: index.php');
		exit;
	}

	while (list($id, $title) = db_row($result)) {
	?>
     <tr><td class="normal"><strong><big>·</big></strong><a href="news.php?id=<?php echo $id; ?>"><?php echo $title; ?></a></td></tr>
<?php
	}

	db_free($result);
?>
   </table>
  </td>
 </tr>
</table>

<?php
}

db_disconnect();
include('footer.php');
?>
