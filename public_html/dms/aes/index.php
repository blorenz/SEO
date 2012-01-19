<?php




if(!empty($_REQUEST['order']))
	$order = $_REQUEST['order'];
else
	$order = "";








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
# $srp: godealertodealer.com/htdocs/aes/dealers.php,v 1.8 2002/09/03 00:35:40 steve Exp $
#

$page_title = 'District Manager\'s AE Info';

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

if (!isset($s))
	$s='all';

if (isset($order)) {
	if ($order=='name') {
		$order = ' ORDER BY last_name, first_name';
	}
	if ($order=='email') {
		$order = ' ORDER BY email';
	}
	if ($order=='address') {
		$order = ' ORDER BY address1';
	}
	if ($order=='city') {
		$order = ' ORDER BY city';
	}
	if ($order=='state') {
		$order = ' ORDER BY state';
	}
	if ($order=='zip') {
		$order = ' ORDER BY zip';
	}
	if ($order=='phone') {
		$order = ' ORDER BY phone';
	}
	if ($order=='fax') {
		$order = ' ORDER BY fax';
	}
	if ($order=='hired') {
		$order = ' ORDER BY created';
	}
}

$result = db_do("SELECT id, email, first_name, last_name, CONCAT(address1, ' ', address2), city, state, zip, phone, fax,
				DATE_FORMAT(created, '%d-%b-%Y') FROM aes WHERE status='active' AND dm_id='$dm_id'".$order);
?>

<html>
 <head>
  <title><?=$page_title?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
<?php include('_links.php'); ?>
<br>
<p align="center" class="big"><b><?=$page_title?></b></p>
<?php include('_links_AE.php');
if ($s=='active' || $s=='all') { ?>
<br><br><font class="huge">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Active Account Executives</u></font><br><br>
<?php if (db_num_rows($result) > 0) { ?>
<table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">

   <tr>
   	<td class="header" align="center"><b>Number<br>of Dealers</b></td>
    <td class="header"><b><a href="index.php?s=<?=$s?>&order=name">Name</a></b></td>
	<td class="header"><b><a href="index.php?s=<?=$s?>&order=email">Email</a></b></td>
    <td class="header"><b><a href="index.php?s=<?=$s?>&order=address">Address</a></b></td>
    <td class="header"><b><a href="index.php?s=<?=$s?>&order=city">City</a></b></td>
    <td class="header"><b><a href="index.php?s=<?=$s?>&order=state">State</a></b></td>
    <td class="header"><b><a href="index.php?s=<?=$s?>&order=zip">Zip</a></b></td>
	<td class="header"><b><a href="index.php?s=<?=$s?>&order=phone">Phone</a></b></td>
	<td class="header"><b><a href="index.php?s=<?=$s?>&order=hired">Hired</a></b></td>
    <td class="header"></td>
   </tr>

<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $email, $first_name, $last_name, $address, $city, $state, $zip, $phone, $fax, $created) = db_row($result)) {

		$result_dealer = db_do("SELECT COUNT(*) FROM dealers WHERE status='active' AND ae_id='$id'");
		list($dealer_count) = db_row($result_dealer);


		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
	<tr bgcolor="<?=$bgcolor?>">
		<td class="normal" align="center"><?php tshow($dealer_count); ?></td>
		<td class="normal"><a href="dealers/index.php?id=<?=$id?>"><?php tshow($last_name); ?>, <?php tshow($first_name); ?></a></td>
		<td class="normal"><a href="mailto:<?php tshow($email); ?>"><?php tshow($email); ?></a></td>
		<td class="normal"><?php tshow($address); ?></td>
		<td class="normal"><?php tshow($city); ?></td>
		<td class="normal"><?php tshow($state); ?></td>
		<td class="normal"><?php tshow($zip); ?></td>
		<td class="normal"><?php tshow($phone); ?></td>
		<td class="normal"><?php tshow($created); ?></td>
	</tr>
<?php } ?>
</table>
<?php } else { ?>
<br><br><font class="huge">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>No Active Account Executives</u></font><br><br><?php } }
if ($s=='inactive' || $s=='all') {
$result = db_do("SELECT id, email, first_name, last_name, CONCAT(address1, ' ', address2), city, state, zip, phone, fax,
				DATE_FORMAT(created, '%d-%b-%Y') FROM aes WHERE status='inactive' AND dm_id='$dm_id'");

if (db_num_rows($result) > 0) {
?>
<br><br><font class="huge">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Inactive Account Executives</u></font><br><br>
<table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
	<tr>
		<td class="header">Name</td>
		<td class="header">Email</td>
		<td class="header">Address</td>
		<td class="header">City</td>
		<td class="header">State</td>
		<td class="header">Zip</td>
		<td class="header">Phone</td>
		<td class="header">Fax</td>
		<td class="header">Hired</td>
	</tr>

<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $email, $first_name, $last_name, $address, $city, $state, $zip, $phone, $fax, $created) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
	<tr bgcolor="<?=$bgcolor?>">
		<td class="normal"><a href="dealers/index.php?id=<?=$id?>"><?php tshow($last_name); ?>, <?php tshow($first_name); ?></a></td>
		<td class="normal"><?php tshow($email); ?></td>
		<td class="normal"><?php tshow($address); ?></td>
		<td class="normal"><?php tshow($city); ?></td>
		<td class="normal"><?php tshow($state); ?></td>
		<td class="normal"><?php tshow($zip); ?></td>
		<td class="normal"><?php tshow($phone); ?></td>
		<td class="normal"><?php tshow($fax); ?></td>
		<td class="normal"><?php tshow($created); ?></td>
	</tr>
<?php } ?>
</table>
<?php } else { ?>
<br><br><font class="huge">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>No Inactive Account Executives</u></font><br><br><?php } }?>
<?php include('../footer.php'); ?>