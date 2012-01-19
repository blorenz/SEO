<?php if (!empty($errors)) { ?>
       <table align="center" border="0" cellpadding="0" cellspacing="0">
          <tr>
           <td class="error">The following fields were incorrect/incomplete:<br /><ul><?=$errors?></ul></td>
          </tr>
		  <tr><td colspan="2">&nbsp;</td></tr>
         </table>
<?php } ?>
	<form method="post" action="<?=$PHP_SELF?>">
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="did" value="<?php echo $did; ?>" />

<table align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td class="big" align="center" colspan="2"><b><u>Finanical Bank Information</u></b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td align="right" class="header">Dealer Name:&nbsp;</td>
		<td class="normal"><?=$name?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Name:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_name" size="25" value="<?=$fb_name?>" /></td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Address:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_address1" size="25" value="<?=$fb_address1?>" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="normal"><input type="text" name="fb_address2" size="25" value="<?=$fb_address2?>" /></td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank City:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_city" size="25" maxlength="25" value="<?=$fb_city?>" /></td>
  </tr>
	<tr>
		<td align="right" class="header">Financial Bank State:&nbsp;</td>
		<td class="normal">
			<select name="fb_state">
			<option value="" selected>Choose State</option>
				<?php
					reset($STATES);
					while (list($key, $value) = each($STATES)) {
						echo "          <option value=\"$key\"";
						if ($fb_state == $key)
						echo " selected";
						echo ">$value</option>\n";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Zip Code:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_zip" size="25" value="<?=$fb_zip?>" /></td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Phone Number:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_phone" size="25" maxlength="12" value="<?=$fb_phone?>" />
		*Phone Format: 000-000-0000</td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Fax:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_fax" size="25"  maxlength="12" value="<?=$fb_fax?>">
		*Fax Format: 000-000-0000</td>
	</tr>
	<tr>
		<td align="right" class="header">Financial Bank Account#:&nbsp;</td>
		<td class="normal"><input type="text" name="fb_account" size="25"  maxlength="12" value="<?=$fb_account?>"></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td align="center" class="normal" colspan="2"><input type="submit" name="submit" value=" Submit">
		</td></tr>
</table>
</form>
