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
     <td class="normal"><?php echo $id; ?><input type="hidden" name="uid" value="<?php echo $uid; ?>" size="35"></td>
    </tr>
<?php } ?>
    <tr>
     <td align="right" class="header">District Manager:</td>
     <td class="normal">
	 	<select name="dm_id">
			<?php $result_dm = db_do('SELECT id, CONCAT(first_name, " ", last_name) FROM dms');
				while(list($dmid, $dmname) = db_row($result_dm)) { ?>
					<option value="<?=$dmid?>" <?php if ($dm_id == $dmid) echo 'selected'?>><?=$dmname?> </option>
			<?php } ?>
		</select>
		</td>
	</tr>
	<tr>
     <td align="right" class="header">Username:</td>
     <td class="normal"><input type="text" name="un" value="<?php echo $un; ?>" size="35">
	 <input type="hidden" name="un2" value="<?php echo $un2; ?>" size="35"></td>
    </tr>
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
    <tr>
  		<td align="right" class="header">Limited ("Corporate Account"):</td>
  		<td class="normal"><input type="checkbox" name="limited" value="1"
  			<?php if ($limited == 1) { echo 'checked="checked"'; } ?> /></td>
    	</tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
     <td>&nbsp;</td>
     <td class="normal"><input type="submit" name="submit" value="<?php echo $page_title; ?>" /></td>
    </tr>
   </table>
  </form>
