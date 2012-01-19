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
# $srp: godealertodealer.com/htdocs/admin/reports/index.php,v 1.3 2002/09/03 00:36:10 steve Exp $
#

$page_title = 'Admin Home';

$links = array(
    'Home' => '/auction/index.php',
    'Admin' => '/admin/index.php',
    'Auctions' => '/admin/auctions/index.php',
    'Dealers' => '/admin/dealers/index.php',
    'Reports' => '/admin/reports/index.php',
    'Users' => '/admin/users/index.php'
);

include('../../../include/db.php');
db_connect();

$num_dealers       = 0;
$pending_dealers   = 0;
$active_dealers    = 0;
$suspended_dealers = 0;

$result = db_do("SELECT status FROM dealers");
while (list($status) = db_row($result)) {
	$num_dealers++;

	switch ($status) {
	case 'pending':
		$pending_dealers++;
	case 'active':
		$active_dealers++;
		break;
	case 'suspended':
		$suspended_dealers++;
		break;
	}
}
db_free($result);

$num_users       = 0;
$pending_users   = 0;
$active_users    = 0;
$suspended_users = 0;

$result = db_do("SELECT status FROM users");
while (list($status) = db_row($result)) {
	$num_users++;

	switch ($status) {
	case 'pending':
		$pending_users++;
	case 'active':
		$active_users++;
		break;
	case 'suspended':
		$suspended_users++;
		break;
	}
}
db_free($result);

db_disconnect();
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
  <table align="center" border="0" cellpadding="3" cellspacing="0" width="95%">
   <tr>
    <td class="normal">
     <p><i>This page is a placeholder for simple stats or factoids that represent a macro view of what's going on with the site.</i></p>
    </td>
   </tr>
  </table>
  <br />
  <table align="center" border="0" cellpadding="3" cellspacing="0">
   <tr>
    <td class="normal">Auctions - Pending</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="normal">Auctions - Open</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="normal">Auctions - Closed</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="header">Total Auctions</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr><td colspan="2"><hr /></td></tr>
   <tr>
    <td class="normal"><a href="../dealers/index.php?s=pending">Dealers - Pending</a></td>
    <td class="normal"><?php echo $pending_dealers; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="../dealers/index.php">Dealers - Active</a></td>
    <td class="normal"><?php echo $active_dealers; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="../dealers/index.php?s=suspended">Dealers - Suspended</a></td>
    <td class="normal"><?php echo $suspended_dealers; ?></td>
   </tr>
   <tr>
    <td class="header">Total Dealers</td>
    <td class="normal"><?php echo $num_dealers; ?></td>
   </tr>
   <tr><td colspan="2"><hr /></td></tr>
   <tr>
    <td class="normal"><a href="../users/index.php?s=pending">Users - Pending</a></td>
    <td class="normal"><?php echo $pending_users; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="../users/index.php">Users - Active</a></td>
    <td class="normal"><?php echo $active_users; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="../users/index.php?s=suspended">Users - Suspended</a></td>
    <td class="normal"><?php echo $suspended_users; ?></td>
   </tr>
   <tr>
    <td class="header">Total Users</td>
    <td class="normal"><?php echo $num_users; ?></td>
   </tr>
   <tr><td colspan="2"><hr /></td></tr>
   <tr>
    <td class="normal">Dealer with most auctions</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="normal">Dealer with most sales</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="normal">Dealer with most purchases</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="normal">Closed auctions with sale</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="normal">Closed auctions without sale</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="normal">Auctions closing in next 24 hours</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="normal">Auctions closed in last 24 hours</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="header">Total Auctions</td>
    <td class="normal">&nbsp;</td>
   </tr>
  </table>
 </body>
</html>
