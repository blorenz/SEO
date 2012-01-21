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
# $srp: godealertodealer.com/htdocs/auction/photos/edit.php,v 1.3 2002/09/03 00:40:32 steve Exp $
#

include('../../../include/session.php');

extract(defineVars("id","caption","submit")); //JJM added 7/6/2010

if (!has_priv('vehicles', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (empty($id) || $id <= 0) {
	header('Location: ../vehicles/index.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$result = db_do("SELECT vehicle_id, caption FROM photos WHERE id='$id'");
list($vid, $old_caption) = db_row($result);
db_free($result);

if (empty($vid) || $vid <= 0) {
	header('Location: ../vehicles/index.php');
	exit;
}

$result = db_do("SELECT dealer_id, short_desc FROM vehicles WHERE id='$vid'");
list($did, $title) = db_row($result);
db_free($result);

if ($did != $dealer_id) {
	header('Location: ../vehicles/index.php');
	exit;
}

if (isset($submit)) {
	db_do("UPDATE photos SET caption='$caption' WHERE id='$id'");

	header("Location: index.php?vid=$vid");
	exit;
}

$result_status = db_do("SELECT status FROM auctions WHERE vehicle_id=$vid");
if (db_num_rows($result_status) > 0)
	list($status) = db_row($result_status);


include('../header.php');
db_disconnect();
?>
  <br />
  <p align="center" class="normal">[
<?php if ($status!='open') { ?>
  <a href="../vehicles/edit.php?id=<?php echo $vid; ?>">Back to Item</a> |
<?php } ?><a href="index.php?vid=<?php echo $vid; ?>">List of Images</a> ]</p>
  <p align="center" class="header"><?php echo $title; ?></p>
  <form action="<?php echo $PHP_SELF; ?>" method="POST">
   <input type="hidden" name="id" value="<?php echo $id; ?>" />
   <table align="center" border="0" cellpadding="5" cellspacing="0">
    <tr>
     <td align="right" class="header" valign="top">Photo:</td>
     <td class="normal"><img src="../uploaded/<?php echo $id; ?>.jpg"></td>
    </tr>
    <tr>
     <td align="right" class="header" valign="top">Caption:</td>
     <td class="normal"><textarea name="caption" rows="10" cols="50" wrap="virtual"><?php echo $old_caption; ?></textarea></td>
    </tr>
    <tr>
     <td align="center" class="normal" colspan="2"><input type="submit" name="submit" value=" Update Photo "></td>
    </tr>
   </table>
  </form>
<?php include('../footer.php'); ?>