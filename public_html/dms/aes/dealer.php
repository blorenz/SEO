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
include('../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$result = db_do("SELECT id, CONCAT(poc_f_name, ' ', poc_l_name), poc_email, name, 
				phone, city, state, DATE_FORMAT(created, '%d-%b-%Y'), status 
				FROM dealers WHERE status='saved' AND ae_id='' AND dm_id='$dm_id'"); 
				
$page_title = "Assign a Dealer to an AE";
?>

<html>
 <head>
  <title><?=$page_title?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p>
<p align="center" class="big"><b><a href="add_dealer.php">Add a New Dealer</a></b></p> 
<table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php if (db_num_rows($result) > 0) { ?>
	<tr><td class="big" colspan="5"><br><u><b>Saved Dealers</b></u></td></tr>
	<tr> 
		<td>&nbsp;</td>
		<td class="header"><b>Dealership Name</b></td>
		<td class="header"><b>City, State</b></td>
		<td class="header"><b>POC Name</b></td>
		<td class="header"><b>POC Email</b></td>
		<td class="header"><b>Phone</b></td>
		<td class="header"><b>Created</b></td>
	</tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($did, $poc_name, $poc_email, $name, $phone, $city, $state, $created) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$created = strtoupper($created);
?>
	<tr bgcolor="<?php echo $bgcolor; ?>"> 
		<td align="center" class="normal"><a href="edit_dealer.php?did=<?=$did?>">edit</a> | 
			<a href="remove_dealer.php?did=<?=$did?>">remove</a></td>
		<td class="normal"><?php tshow($name); ?></td>
		<td class="normal"><?php tshow($city); echo ", "; tshow($state); ?></td>
		<td class="normal"><?php tshow($poc_name); ?></td>
		<td class="normal"><?php tshow($poc_email); ?></td>
		<td class="normal"><?php tshow($phone); ?></td>
		<td class="normal"><?php tshow($created); ?></td>
	</tr>
<?php } } else { ?>
	<tr><td class="big" colspan="5"><br><u><b>No Saved Dealers</b></u></td></tr>
<?php } ?>
</table><br><br>
<?php
	include('../footer.php');
?>