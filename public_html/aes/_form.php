<?php
#
# Copyright (c) 2006 Go DEALER to DEALER
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
# $srp: godealertodealer.com/htdocs/admin/aes/_form.php,v 1.1 2002/10/15 05:44:47 Exp $
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
   <table align="center" border="0" cellspacing="0" cellpadding="2">
<?php if (!empty($id)) { ?>
    <tr>
     <td align="right" class="header">Account Executive Number:</td>
     <td class="normal"><?php echo $id; ?></td>
    </tr>
<?php } ?>
<?php if (!empty($useridresult)) { ?>
		<tr>
     <td align="right" class="header">Username:</td>
     <td class="normal">
      <select name="uid">
<?php 
while (list($userid, $uname ) = db_row($useridresult)) {
?>
			<option value=<?php tshow($userid); ?> <?php if ($user_id == $userid) echo 'selected'; ?>><?php tshow($uname); ?></option>
<?php } ?>			
			</select>
     </td>
		</tr>
<?php } ?>
    <tr>
     <td align="right" class="header">First Name:</td>
     <td class="normal"><input type="text" name="first_name" value="<?php echo $first_name; ?>" size="35" /></td>
    </tr>
    <tr>
     <td align="right" class="header">Last Name:</td>
     <td class="normal"><input type="text" name="last_name" value="<?php echo $last_name; ?>" size="35" /></td>
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
     <td align="right" class="header">Social Security Number:</td>
     <td class="normal"><input type="text" name="ssn" value="<?php echo $ssn; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">Status:</td>
     <td class="normal">
      <select name="status">
       <option value="active" <?php if ($status == 'active') echo 'selected'; ?>>active</option>
       <option value="inactive" <?php if ($status == 'inactive') echo 'selected'; ?>>inactive</option>
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
