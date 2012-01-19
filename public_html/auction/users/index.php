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
# $srp: godealertodealer.com/htdocs/auction/users/index.php,v 1.6 2002/09/03 00:40:33 steve Exp $
#

include('../../../include/session.php');
extract(defineVars( "q", "no_menu", "s"));    // Added by RJM 1/1/10


if (!has_priv('users', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (empty($s))
	$status = 'active';
else
	$status = $s;

$page_title = ucfirst($status) . ' Users';
$help_page = "chp7.php#Chp7_Manageyourusers";

include('../../../include/db.php');
db_connect();

$sql = "SELECT COUNT(*) FROM users WHERE dealer_id='$dealer_id' AND " .
    "status='$status'";

include('../../../include/list.php');
include('../header.php');

$result = db_do("SELECT id, email, CONCAT(first_name, ' ', last_name), " .
    "phone, fax FROM users WHERE dealer_id='$dealer_id' AND " .
    "users.status='$status' ORDER BY last_name, first_name LIMIT $_start, " .
    "$limit");
?>

  <br>
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include('_links.php'); ?>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No users found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="5"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td>&nbsp;</td>
    <td class="header"><b>Name</b></td>
    <td class="header"><b>Email</b></td>
    <td class="header"><b>Phone</b></td>
    <td class="header"><b>Fax</b></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $email, $name, $phone, $fax)
	    = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center" class="normal"><a href="edit.php?id=<?php echo $id; ?>">edit</a></td>
    <td class="normal"><?php tshow($name); ?></td>
    <td class="normal"><?php tshow($email); ?></td>
    <td class="normal"><?php tshow($phone); ?></td>
    <td class="normal"><?php tshow($fax); ?></td>
   </tr>
<?php
	}
}

db_free($result);
?>
  </table>

<?php
db_disconnect();
include('../footer.php');
?>
