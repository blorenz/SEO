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
# $srp: godealertodealer.com/htdocs/aes/remove_dealer.php,v 1.9 2002/10/14 22:01:15 steve Exp $
#

include('../../../include/session.php');
include('../../../include/defs.php');
include('../../../include/states.php');
include('../../../include/db.php');
db_connect();

$page_title = 'Remove Saved Dealer';

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}
	
if (isset($submit)) {
        if ($confirm == 'yes')
                db_do("DELETE FROM dealers WHERE id='$did'");

        header('Location: dealer.php');
        exit;
}
	
	if(!isset($did)) {
		header('Location: dealer.php');
		exit;
	}
	
	$result = db_do("SELECT business, dba, industry, name, years, status FROM dealers WHERE id='$did'");
			
	list($business, $dba, $industry, $name, $years, $status) = db_row($result);
	
	if($status != 'saved') {
		header('Location: dealer.php');
		exit;
	}

?>

<html>
 <head>
  <title>Administration: <?=$page_title?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>

 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p><br>  
<center><br />
   <div class="error">Are you sure you want to remove this dealer?</div>
   <form action="<?= $PHP_SELF; ?>" method="POST">
    <input type="hidden" name="did" value="<?= $did; ?>">
    <input type="radio" name="confirm" value="yes">Yes <input type="radio" name="confirm" value="no" checked onclick="return goElsewhere('dealer.php');">No<br><p><input type="submit" name="submit" value=" Remove Item "></p>
   </form>
</center>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
    <td align="right" class="header">Company Name:</td>
    <td class="normal"><?php tshow($name); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">DBA:</td>
    <td class="normal"><?php tshow($dba); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Type of Business:</td>
    <td class="normal"><?php tshow($business); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Years of Business:</td>
    <td class="normal"><?php tshow($years); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Industry:</td>
    <td class="normal"><?php tshow($industry); ?></td>
   </tr>
  </table>
<br />
<?php
include('../footer.php');
db_disconnect();
?>
