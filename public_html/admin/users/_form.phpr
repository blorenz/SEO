<?php
//RJM Added
$PHP_SELF = $_SERVER['PHP_SELF'];
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
    <tr>
     <td align="right" class="header">Dealer:</td>
     <td class="normal">
      <select name="did">
	  <option value="">Choose A Dealer</option>
<?php
$result = db_do("SELECT id, name FROM dealers WHERE status='active' ORDER BY name");
while (list($_id, $name) = db_row($result)) {
?>
       <option value="<?php echo $_id; ?>" <?php if ($did == $_id) echo 'selected'; ?>><?php echo $name; ?></option>
<?php
}

db_free($result);
db_disconnect();
?>
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
