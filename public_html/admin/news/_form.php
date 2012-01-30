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
# $srp: godealertodealer.com/htdocs/admin/news/_form.php,v 1.2 2002/09/03 00:36:09 steve Exp $
#
?>

<form method="post" action="<?php $PHP_SELF?>">
 <input type="hidden" name="id" value="<?php echo $id; ?>" />
 <table border="0" cellpadding="1" cellspacing="0">
  <tr><td colspan="2">&nbsp;</td></tr>
<?php if (!empty($errors)) { ?>
  <tr>
   <td align="center" colspan="2">
    <table border="0" cellpadding="0" cellspacing="0">
     <tr>
      <td class="error">The following fields were incorrect/incomplete:<br /><ul><?php $errors?></ul></td>
     </tr>
    </table>
   </td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
<?php } ?>
  <tr>
   <td align="right" class="header">Title:</td>
   <td class="normal"><input type="text" name="title" size="50" value="<?php $title?>" /></td>
  </tr>
  <tr>
   <td align="right" class="header" valign="top">Content:</td>
   <td class="normal"><textarea name="content" rows="10" cols="50" wrap="virtual"><?php echo $content; ?></textarea></td>
  </tr>
  <tr>
   <td align="right" class="header">Status:&nbsp;</td>
   <td class="normal">
    <select name="status">
     <option value="pending" <?php if ($status == 'pending') echo 'selected'; ?>>pending</option>
     <option value="active" <?php if ($status == 'active') echo 'selected'; ?>>active</option>
     <option value="suspended" <?php if ($status == 'suspended') echo 'selected'; ?>>suspended</option>
    </select>
   </td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr>
   <td align="center" class="normal" colspan="2"><input type="submit" name="submit" value="<?php echo $page_title; ?>"></td>
  </tr>
 </table>
</form>
