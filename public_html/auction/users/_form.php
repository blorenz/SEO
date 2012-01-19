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
# $srp: godealertodealer.com/htdocs/auction/users/_form.php,v 1.2 2002/09/03 00:40:33 steve Exp $
#
?>

<?php if (!empty($errors)) { ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
    <td class="error">The following errors occurred:<br /><ul><?php echo $errors; ?></ul></td>
   </tr>
  </table>
<?php } ?>
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <input type="hidden" name="id" value="<?php echo $id; ?>" />
   <input type="hidden" name="dealer" value="<?php echo $dealer; ?>" />
   <table align="center" border="0" cellspacing="0" cellpadding="2">
    <tr>
     <td align="right" class="header">Dealer:</td>
     <td class="big"><?php echo $dealer; ?></td>
    </tr>
<?php if (empty($id)) { ?>
    <tr>
     <td align="right" class="header">Username:</td>
     <td class="normal"><input type="text" name="un" value="<?php echo $un; ?>" size="35"></td>
    </tr>
<?php } else { ?>
    <tr>
     <td align="right" class="header">Username:</td>
     <td class="big"><?php echo $un; ?></td>
    </tr>
<?php } ?>
    <tr>
     <td align="right" class="header">Password:</td>
     <td class="normal"><input type="text" name="pw" value="<?php echo $pw; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">First Name:</td>
     <td class="normal"><input type="text" name="first_name" value="<?php echo $first_name; ?>" size="35" /></td>
    </tr>
    <tr>
     <td align="right" class="header">Last Name:</td>
     <td class="normal"><input type="text" name="last_name" value="<?php echo $last_name; ?>" size="35" /></td>
    </tr>
     <tr>
     <td align="right" class="header">Title:</td>
     <td class="normal"><input type="text" name="title" value="<?php echo $title; ?>" size="35" /></td>
    </tr>
    <tr>
     <td align="right" class="header">E-mail Address:</td>
     <td class="normal"><input type="text" name="email" value="<?php echo $email; ?>" size="35" /></td>
    </tr>
    <tr>
     <td align="right" class="header">Address:</td>
     <td class="normal"><input type="text" name="address1" value="<?php echo $address1; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">&nbsp;</td>
     <td class="normal"><input type="text" name="address2" value="<?php echo $address2; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">City:</td>
     <td class="normal"><input type="text" name="city" value="<?php echo $city; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">State:&nbsp;</td>
     <td class="normal">
      <select name="state">
<?php
include('../../../include/states.php');

reset($STATES);
while (list($key, $value) = each($STATES)) {
	echo "     <option value=\"$key\"";
	if ($state == $key)
		echo " selected";
	echo ">$value</option>\n";
}
?>
      </select>
     </td>
    </tr>
    <tr>
     <td align="right" class="header">Zip:</td>
     <td class="normal"><input type="text" name="zip" value="<?php echo $zip; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">Phone:</td>
     <td class="normal"><input type="text" name="phone" value="<?php echo $phone; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header"></td>
     <td class="normal">*Phone Format: 000-000-0000</td>
    </tr>
    <tr>
     <td align="right" class="header">Fax:</td>
     <td class="normal"><input type="text" name="fax" value="<?php echo $fax; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header"></td>
     <td class="normal">*Fax Format: 000-000-0000</td>
    </tr>
    <tr>
     <td align="right" class="header">Privileges:</td>
     <td class="normal"><input type="checkbox" name="_privs[]" value="buy" <?php if (has_priv('buy', $_privs)) echo 'checked'; ?> /> Buy Items</td>
    </tr>
    <tr>
     <td>&nbsp;</td>
     <td class="normal"><input type="checkbox" name="_privs[]" value="sell" <?php if (has_priv('sell', $_privs)) echo 'checked'; ?> /> Sell Items</td>
    </tr>
    <tr>
     <td>&nbsp;</td>
     <td class="normal"><input type="checkbox" name="_privs[]" value="vehicles" <?php if (has_priv('vehicles', $_privs)) echo 'checked'; ?> /> Manage Items</td>
    </tr>
    <tr>
     <td>&nbsp;</td>
     <td class="normal"><input type="checkbox" name="_privs[]" value="users" <?php if (has_priv('users', $_privs)) echo 'checked'; ?> /> Manage Users</td>
    </tr>
	<tr>
     <td>&nbsp;</td>
     <td class="normal"><input type="checkbox" name="_privs[]" value="view" <?php if (has_priv('view', $_privs)) echo 'checked'; ?> /> View Only</td>
    </tr>
    <tr>
     <td align="right" class="header">Status:</td>
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
     <td>&nbsp;</td>
     <td class="normal"><input type="submit" name="submit" value="<?php echo $page_title; ?>" /></td>
    </tr>
   </table>
  </form>
