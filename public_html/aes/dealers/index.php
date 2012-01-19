
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
# $srp: godealertodealer.com/htdocs/aes/dealers.php,v 1.8 2002/09/03 00:35:40 steve Exp $
#
include('../../../include/session.php');

$page_title = 'AE Dealer Info';
$page_link = '../docs/chp4.php#Chp4_DealerInfo';

include('../../../include/db.php');
db_connect();
extract(defineVars("nav_links", "order"));


$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

if (isset($order)) {
	if ($order=='dname') {
		$order = " ORDER BY dealers.dba"; }
	if ($order=='loc') {
		$order = " ORDER BY dealers.state, dealers.city"; }
	if ($order=='pname') {
		$order = " ORDER BY dealers.poc_l_name, dealers.poc_f_name"; }
	if ($order=='pemail') {
		$order = " ORDER BY dealers.poc_email"; }
	if ($order=='phone') {
		$order = " ORDER BY dealers.phone"; }
	if ($order=='created') {
		$order = " ORDER BY dealers.created"; }
}

if (isset($submit)) {
	if ($category=='POC Name') {
		$order = " AND (dealers.poc_l_name LIKE '%$search%' OR dealers.poc_f_name LIKE '%$search%')".$order; }
	else {
		$order = " AND dealers.dba LIKE '%$search%'".$order; }
}
if (!isset($s)) {
	$s='all'; }

if ($s=='all') {
	$result = db_do("SELECT dealers.id, CONCAT(dealers.poc_f_name, ' ', dealers.poc_l_name), dealers.poc_email, dealers.dba, dealers.phone, dealers.city, dealers.state, DATE_FORMAT(dealers.created, '%d-%b-%Y'), dealers.status FROM dealers, users, aes WHERE users.username = '$username' and aes.user_id = users.id and dealers.ae_id = aes.id".$order); 	}
else {
	$result = db_do("SELECT dealers.id, CONCAT(dealers.poc_f_name, ' ', dealers.poc_l_name), dealers.poc_email, dealers.dba, dealers.phone, dealers.city, dealers.state, DATE_FORMAT(dealers.created, '%d-%b-%Y'), dealers.status FROM dealers, users, aes WHERE users.username = '$username' and aes.user_id = users.id and dealers.ae_id = aes.id AND dealers.status='$s'".$order); }

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
	case 'saved':
		$saved[] = $row;
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
<?php include('../header.php'); ?>
<?php include('_links.php'); ?>
<br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include ('_links_dealer.php'); ?>
<br>
<center>
<form action="index.php?s=<?=$s?>" method="post">
Search:
<input type="text" name="search">
<select name="category">
<option>POC Name</option>
<option>Dealership Name</option>
</select>
<input type="submit" name="submit" value="Submit">
</form>
</center>
<br>
<table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php if (count($active) > 0) { ?>
	 <tr><td class="big" colspan="5"><u><b>Active Dealers</b></u></td></tr>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>

   <tr>
    <td>&nbsp;</td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>


<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($active)) {
		list($id, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><a href="../charges/invoice.php?id=<?php echo $id; ?>">charges</a> | <a href="../users/index.php?did=<?php echo $id; ?>">users</a><br><a href="../auctions/index.php?did=<?php echo $id; ?>">auctions</a> | <a href="../vehicles/index.php?did=<?php echo $id; ?>">items</a> | <a href="../bids/index.php?did=<?php echo $id; ?>">bids</a></td>
    <td class="normal"><?php tshow($name); ?></td>
	<td class="normal"><?php tshow($city); echo ", "; tshow($state); ?></td>
    <td class="normal"><?php tshow($poc_name); ?></td>
    <td class="normal"><a href="mailto:<?php tshow($poc_email); ?>"><?php tshow($poc_email); ?></a></td>
	<td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($created); ?></td>
   </tr>
<?php
	}
?>
<?php } else { if (isset($s) && $s == 'active') {?>
	 <tr><td class="big" colspan="5"><u><b>No Active Dealers</b></u></td></tr>
<?php } } ?>

<?php if (count($pending) > 0) {
	if ($s=='all') { ?>
	  <tr><td class="header" colspan="9"><br><hr></td></tr><?php } ?>
	 <tr><td class="big" colspan="5"><br><u><b>Pending Dealers</b></u></td></tr>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td>&nbsp;</td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($pending)) {
		list($id, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td width="120" align="left" class="small">
	&bull;&nbsp;<a href="edit_dealer.php?id=<?php echo $id; ?>">Edit Dealer Info</a><br>
	&bull;&nbsp;<a href="application_form.php?id=<?php echo $id; ?>">Print Application Form</a><br>
	</td>
    <td class="normal"><?php tshow($name); ?></td>
	<td class="normal"><?php tshow($city); echo ", "; tshow($state); ?></td>
    <td class="normal"><?php tshow($poc_name); ?></td>
    <td class="normal"><?php tshow($poc_email); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($created); ?></td>
   </tr>
<?php
	}
?>
<?php } else { if (isset($s) && $s == 'pending') {?>
	<tr>
		<td class="big" colspan="5"><br><u><b>No Pending Dealers</b></u></td>
	</tr>
<?php } } ?>

<?php if (count($saved) > 0) {
	if ($s=='all') { ?>
 <tr><td class="header" colspan="9"><br><hr></td></tr><?php } ?>
 <tr><td class="big" colspan="5"><br><u><b>Saved Dealers</b></u></td></tr>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td>&nbsp;</td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($saved)) {
		list($id, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><a href="edit_dealer.php?id=<?php echo $id; ?>">edit</a> |
	<a href="remove_dealer.php?id=<?=$id?>">remove</a></td>
    <td class="normal"><?php tshow($name); ?></td>
	<td class="normal"><?php tshow($city); echo ", "; tshow($state); ?></td>
    <td class="normal"><?php tshow($poc_name); ?></td>
    <td class="normal"><?php tshow($poc_email); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($created); ?></td>
   </tr>
<?php
	}
?>
<?php } else { if ($s == 'saved') { ?>
	 <tr>
    <td class="big" colspan="5"><br><u><b>No Saved Dealers</b></u></td>
   </tr>
<?php } } ?>

<?php if (count($suspended) > 0) {
	if ($s=='all') { ?>
 <tr><td class="header" colspan="9"><br><hr></td></tr><?php } ?>
 <tr><td class="big" colspan="5"><br><u><b>Suspended Dealers</b></u></td></tr>
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td>&nbsp;</td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=dname">Dealership Name</a></b></td>
	<td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=loc">City, State</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pname">POC Name</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=pemail">POC Email</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=phone">Phone</a></b></td>
    <td class="header"><b><a href="index.php?s=<?php echo $s; ?>&order=created">Created</a></b></td>
    <td class="header"></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list(, $row) = each($suspended)) {
		list($id, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = $row;
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><a href="../charges/invoice.php?id=<?php echo $id; ?>">charges</a> | <a href="../users/index.php?did=<?php echo $id; ?>">users</a><br><a href="../auctions/index.php?did=<?php echo $id; ?>">auctions</a> | <a href="../vehicles/index.php?did=<?php echo $id; ?>">items</a> | <a href="../bids/index.php?did=<?php echo $id; ?>">bids</a></td>
    <td class="normal"><?php tshow($name); ?></td>
	<td class="normal"><?php tshow($city); echo ", "; tshow($state); ?></td>
    <td class="normal"><?php tshow($poc_name); ?></td>
    <td class="normal"><?php tshow($poc_email); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($created); ?></td>
   </tr>
<?php
	}
?>
<?php } else { if (isset($s) && $s == 'suspended') {?>
	 <tr>
    <td class="big" colspan="5"><br><u><b>No Suspended Dealers</b></u></td>
   </tr>
<?php } } ?>

</table>
<?php
	include('../footer.php');
?>