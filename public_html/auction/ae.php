
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
# $srp: godealertodealer.com/htdocs/auction/dealer.php,v 1.7 2002/10/15 06:24:42 steve Exp $
#

$page_title = 'Contact My Account Executive';
$help_page = "chp7.php#Chp7_MyAccountExec";

include('../../include/session.php');
include('../../include/db.php');
extract(defineVars("q", "no_menu", "sendmessage", "title", "description", "no_menu"));


db_connect();

include('header.php');

if ($sendmessage)
{
	$result = db_do("SELECT id FROM users WHERE username='$username'");
	list($from_user) = db_row($result);
	db_free($result);

	$result = db_do("SELECT aes.user_id FROM aes, dealers WHERE dealers.id='$dealer_id' AND dealers.ae_id=aes.id");
	list($to_user) = db_row($result);
	db_free($result);

	db_do("INSERT INTO alerts SET to_user='$to_user', from_user='$from_user',
				title='$title', description='$description', modified=NOW()");

	echo "<br><br><p align=\"center\">Message Sent.";
}
else
{

	$result = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM aes, dealers WHERE dealers.id='$dealer_id' AND dealers.ae_id=aes.id");
	list($full_name) = db_row($result);
	db_free($result);

?>
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p><br>
   <table align="center" border="0" cellpadding="1" cellspacing="0">
    <tr>
     <td align="right" class="header">Account Executive:&nbsp;</td>
     <td class="normal"><?php echo $full_name; ?></td>
    </tr>
</table><br>
<form action="<?php echo $PHP_SELF; ?>" method="post">
    <table align="center" border="0" cellpadding="1" cellspacing="0">
      <tr>
        <td valign="top" class="normal">Subject: </td>
        <td class="normal"><input name="title" size="40" value="<?=$title?>">
        </td>
      </tr>
      <tr>
	  	<td valign="top" class="normal">Message: </td>
        <td class="normal"><textarea name="description" cols="40" rows="15" wrap="VIRTUAL"><?=$description?></textarea>
        </td>
      </tr>
      <tr align="center" >
	  	<td valign="top" class="normal"></td>
        <td class="normal"><input type="submit" name="sendmessage" value="Send Message" />
        </td>
      </tr>
    </table>
</form>
  <?php
}
db_disconnect();
include('footer.php');
?>
</div>
