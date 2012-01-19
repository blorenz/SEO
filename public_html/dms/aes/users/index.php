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
# $srp: godealertodealer.com/htdocs/admin/dealers/users.php,v 1.3 2002/09/03 00:36:09 steve Exp $
#
include('../../../../include/session.php');
include('../../../../include/db.php');
db_connect();

if (empty($did) || $did <= 0) {
	header('Location: index.php');
	exit;
}

$page_title = '';

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$ae_array = findAEforDM($dm_id);
if (!in_array($id, $ae_array)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$dealers_array = findDEALERforAE($id);
if (!in_array($did, $dealers_array)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$result = db_do("SELECT name, address1, address2, city, state, zip FROM dealers WHERE id='$did'");
list($dealer, $address1, $address2, $city, $state, $zip) = db_row($result);
db_free($result);

$result = db_do("SELECT id, CONCAT(first_name, ' ', last_name) as name, email, username, phone, fax, status FROM users WHERE dealer_id='$did' ORDER BY last_name, first_name");

$pending = array();
$active = array();
$suspended = array();

while ($row = db_row($result)) {
	switch ($row['status']) {
	case 'pending':
		$pending[] = $row;
		break;
	case 'active':
		$active[] = $row;
		break;
	case 'suspended':
		$suspended[] = $row;
		break;
	}
}

db_free($result);
db_disconnect();

?>

<html>
 <head>
  <title><?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../../header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p><br>
<table align="center" border="0" cellspacing="0" cellpadding="0">
<tr><td align="center" class="huge"><?=$dealer?></td></tr>
<tr><td align="center" class="normal">&nbsp;<br><?=$address1." ".$address2?></td></tr>
<tr><td align="center" class="normal"><?=$city.", ".$state." ".$zip?></td></tr>
</table>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php if (count($active) > 0) { ?>
   <tr>
    <td class="big" colspan="5"><u><b>Active Users</b></u></td>
   </tr>
   <tr> 
    <td class="header"><b>Name</b></td>
    <td class="header"><b>Email</b></td>
		<td class="header"><b>Username</b></td>
    <td class="header"><b>Phone</b></td>
    <td class="header"><b>Fax</b></td>
   </tr>
<?php
$bgcolor = '#FFFFFF';

while (list(, $row) = each($active)) {
	list($uid, $name, $email, $uname, $phone, $fax) = $row;
	$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><?php tshow($email); ?></td>
		<td class="normal"><?php tshow($uname); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($fax); ?></td>
   </tr>
<?php } ?>
<?php } else { ?>
	<tr><td class="big" colspan="5"><u><b>No Active Users</b></u></td></tr>
<?php } ?>
	 <tr><td class="big" colspan="5"><hr></td></tr>
<?php if (count($pending) > 0) { ?>
   <tr>
    <td class="big" colspan="5"><u><b>Pending Users</b></u></td>
   </tr>
   <tr> 
    <td class="header"><b>Name</b></td>
    <td class="header"><b>Email</b></td>
		<td class="header"><b>Username</b></td>
    <td class="header"><b>Phone</b></td>
    <td class="header"><b>Fax</b></td>
   </tr>
<?php
$bgcolor = '#FFFFFF';

while (list(, $row) = each($pending)) {
	list($uid, $name, $email, $uname, $phone, $fax) = $row;
	$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><?php tshow($email); ?></td>
		<td class="normal"><?php tshow($uname); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($fax); ?></td>
   </tr>
<?php } ?>
   
<?php } else { ?>
	<tr><td class="big" colspan="5"><u><b>No Pending Users</b></u></td></tr>
<?php } ?>
<tr><td class="big" colspan="5"><hr></td></tr>
<?php if (count($suspended) > 0) { ?>
   <tr>
    <td class="big" colspan="5"><u><b>Suspended Users</b></u></td>
   </tr>
   <tr> 
    <td class="header"><b>Name</b></td>
    <td class="header"><b>Email</b></td>
		<td class="header"><b>Username</b></td>
    <td class="header"><b>Phone</b></td>
    <td class="header"><b>Fax</b></td>
   </tr>
<?php
$bgcolor = '#FFFFFF';

while (list(, $row) = each($suspended)) {
	list($uid, $name, $email, $uname, $phone, $fax) = $row;
	$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><?php tshow($email); ?></td>
		<td class="normal"><?php tshow($uname); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($fax); ?></td>
   </tr>
<?php } ?>
<?php } else { ?>
	<tr><td class="big" colspan="5"><u><b>No Suspended Users</b></u></td></tr>
<?php } ?>
  </table>
<?php
	include('../../footer.php');
?>
