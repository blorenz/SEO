
<?php

$PHP_SELF = $_SERVER['PHP_SELF'];

 ?>



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
# $srp: godealertodealer.com/htdocs/auction/feedback.php,v 1.7 2003/02/10 23:44:57 steve Exp $
#

$page_title = "Contact Us";
$help_page = "chp9.php";
$send_ae=FALSE;
include('../../include/session.php');
extract(defineVars("no_menu", "q", "message", "send_email", "submit"));

if (isset($submit) && !empty($message) && !empty($send_email)) {
	$to = '';
	$buyer_email = $username."@godealertodealer.com";
	for($i = 0 ; $send_email[$i] != null; $i++) {
		if ($send_email[$i] == qc) {
			$qc_email = 'qc@godealertodealer.com';
			$to = "$to, $qc_email";
		}
		if ($send_email[$i] == support) {
			$support_email = 'support@godealertodealer.com';
			$to = "$to, $support_email";
		}
		if ($send_email[$i] == ae) {
			$ae_email = '';
			$send_ae=TRUE;

			include('../../include/db.php');
			db_connect();

			$result = db_do("SELECT aes.email FROM dealers, aes WHERE " .
	    		"dealers.id='$dealer_id' AND dealers.ae_id=aes.id");

			if (db_num_rows($result))
				list($ae_email) = db_row($result);

			db_free($result);

			$bResult = db_do("SELECT email FROM users WHERE id='$userid'");
			list($buyer_email) = db_row($bResult);
			db_free($bResult);

			db_disconnect();

			if (!empty($ae_email))
				$to = "$to, $ae_email";
		}
	}
	if (!$send_ae) {
			include('../../include/db.php');
			db_connect();

			$bResult = db_do("SELECT email FROM users WHERE id='$userid'");
			list($buyer_email) = db_row($bResult);
			db_free($bResult);

			db_disconnect();
	}

	mail($to, "Feedback from $username", $message,
	    "From: $buyer_email");
	header("Location: thanks.php");
	exit;
}

include('../../include/db.php');
db_connect();
include('header.php');
db_disconnect();
?>
  <p align="center" class="big">
  <b>Contact Us</b>
  </p>
  <p align="center" class="big"><b>Comments?  Suggestions?  Let us know.</b></p>
  <p align="center" class="normal">

  </p>
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <table align="center" border="0" cellpadding="2" cellspacing="0">
    <tr>
     <td align="right" class="header" valign="top"> Message:</td>
     <td class="normal"><textarea name="message" rows="10" cols="50" wrap="virtual"><?php echo $message; ?></textarea></td>
    </tr>
    <tr valign="top">
	<td class="header"><br>Send to Who:</td>
     <td align="left" class="normal">
	<br>
	   <input type="checkbox" value="ae" name="send_email[]">&nbsp;My Account Executive
	<br>
	<input type="checkbox" value="support" name="send_email[]">&nbsp;Technical Support
	<br>
    <input type="checkbox" value="qc" name="send_email[]">&nbsp;Comments & Suggestions
	<br>
	<br>
	</tr>
	<tr>
     <td align="center" class="normal" colspan="2"><input type="submit" name="submit" value=" Send Message " /></td>
    </tr>
   </table>
  </form>
<?php include('footer.php'); ?>
