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
# $srp: godealertodealer.com/htdocs/auction/auctions/remove.php,v 1.5 2002/10/08 06:45:34 steve Exp $
#

$page_title = 'Remove Pending Auction';
$help_page = "chp6_activate.php";

include('../../../include/session.php');

extract(defineVars("id","submit","confirm"));

if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (empty($id) || $id <= 0) {
	header('Location: index.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$result = db_do("SELECT status FROM auctions WHERE id='$id' AND " .
    "dealer_id='$dealer_id'");
list($status) = db_row($result);
db_free($result);

if ($status != 'pending') {
	header('Location: index.php');
	exit;
}

if (isset($submit)) {
	if ($confirm == 'yes')
		db_do("DELETE FROM auctions WHERE id='$id'");

	header('Location: pending.php');
	exit;
}

$result = db_do("SELECT categories.name, title, DATE_FORMAT(starts, " .
    "'%a, %e %M %Y %H:%i'), DATE_FORMAT(ends, '%a, %e %M %Y %H:%i') " .
    "FROM auctions, categories WHERE auctions.id='$id' AND " .
    "auctions.category_id=categories.id");
list($category, $title, $starts, $ends) = db_row($result);
db_free($result);

$timezone = date('T');

$starts .= " $timezone";
$ends   .= " $timezone";

include('../header.php');
?>

  <br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include('_links.php'); ?>

  <center>
   <div class="big">Are you sure you want to remove this pending auction?</div>
   <form action="<?= $PHP_SELF; ?>" method="POST">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <input type="radio" name="confirm" value="yes">Yes <input type="radio" name="confirm" value="no" checked>No<br><p><input type="submit" name="submit" value=" Remove Auction "></p>
   </form>
  </center>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
    <td align="right" class="header">Category:</td>
    <td class="normal"><?php tshow($category); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction Title:</td>
    <td class="normal"><?php tshow($title); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction starts:</td>
    <td class="normal"><?php tshow($starts); ?></td>
   </tr>
   <tr>
    <td align="right" class="header">Auction ends:</td>
    <td class="normal"><?php tshow($ends); ?></td>
   </tr>
  </table>

<?php
include('../footer.php');
db_disconnect();
?>