<?php
/**
 * Notation - 
 *  13 September 2006 by Jon Canady
 *  If you're editing this file you'll probably also want to edit the file 
 *  one level above this file.
 *  
 *  dms/
 *   aes/ 
 *     _form_dealer.php (you want to be here too)
 *     dealers/
 * 	   _form_dealer.php (you are here)
 */
?>

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
		<input type="hidden" name="ae_id" value="<?php echo $ae_id; ?>" />		
		<input type="hidden" name="status" value="<?php echo $status; ?>" />
<table width="550" align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td class="big" align="center" colspan="2"><b><u>Company Information</u></b></td>
	</tr>
	<tr>
		<td colspan/="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">Company Name:&nbsp;</td>
		<td class="normal"><input type="text" name="name" size="50" value="<?=$name?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">DBA:&nbsp;</td>
		<td class="normal"><input type="text" name="dba" size="50" value="<?=$dba?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">Type of Business:&nbsp;</td>
		<td class="normal"><select name="business">
			<option value='' <?php if ($business == '') echo 'selected'; ?>>Choose One</option>
			<option value="Sole Proprietorship" <?php if ($business == 'Sole Proprietorship') echo 'selected'; ?>>Sole Proprietorship</option>
			<option value="Partnership" <?php if ($business == 'Partnership') echo 'selected'; ?>>Partnership</option>
			<option value="LLC" <?php if ($business == 'LLC') echo 'selected'; ?>>LLC</option>
			<option value="Corporation" <?php if ($business == 'Corporation') echo 'selected'; ?>>Corporation</option>
			<option value="Other" <?php if ($business == 'Other') echo 'selected'; ?>>Other</option></select>		</td>
	</tr>
	<tr>
	  <td align="right" class="header">Type of Dealership:</td>
	  <td class="normal"><select name="type">
        <option value="Franchise" <?php if ($type == 'Franchise') echo 'selected'; ?>>Franchise</option>
        <option value="Independent" <?php if ($type == 'Independent') echo 'selected'; ?>>Independent</option>
      </select></td>
    </tr>
	<tr>
		<td width="175" align="right" class="header">Federal EIN#:&nbsp;</td>
		<td class="normal"><input type="text" name="ein" size="50" value="<?=$ein?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">Number of Stores:&nbsp;</td>
		<td class="normal"><input type="text" name="no_of_stores" size="50" value="<?=$no_of_stores?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">Years of Business:&nbsp;</td>
		<td class="normal"><input type="text" name="years" size="50" value="<?=$years?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">Industry:&nbsp;</td>
		<td class="normal"><select name="industry">
			<option value='' <?php if ($industry == '') echo 'selected'; ?>>Choose One</option>
			<option value="Aircraft" <?php if ($industry == 'Aircraft') echo 'selected'; ?>>Aircraft</option>
			<option value="Motorcycle" <?php if ($industry == 'Motorcycle') echo 'selected'; ?>>Motorcycle</option>
			<option value="Marine" <?php if ($industry == 'Marine') echo 'selected'; ?>>Marine</option>
			<option value="Power Sports" <?php if ($industry == 'Power Sports') echo 'selected'; ?>>Power Sports</option>
			<option value="Automotive" <?php if ($industry == 'Automotive') echo 'selected'; ?>>Automotive</option>
			<option value="RV" <?php if ($industry == 'RV') echo 'selected'; ?>>RV</option>
			<option value="Truck" <?php if ($industry == 'Truck') echo 'selected'; ?>>Truck</option>
			<option value="Fleet" <?php if ($industry == 'Fleet') echo 'selected'; ?>>Fleet</option>
			<option value="Rental" <?php if ($industry == 'Rental') echo 'selected'; ?>>Rental</option>
			<option value="Financial" <?php if ($industry == 'Financial') echo 'selected'; ?>>Financial</option>
			<option value="Other" <?php if ($industry == 'Other') echo 'selected'; ?>>Other</option></select></td>
	</tr>
	<tr>
	  <td align="right" class="header">Inventory Management Company:&nbsp;</td>
	  <td class="normal"><input type="text" name="feed_provider" size="50" value="<?=$feed_provider?>" /></td>
    </tr>
	<tr><td colspan="2"><hr></td></tr>
	</table>
<table align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td class="big" align="center" colspan="2"><b><u>Company Addresses</u></b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="50%">
			<table align="center" cellpadding="1" cellspacing="1" class="normal">
				<tr>
					<td width="175" align="right" class="header">Address:&nbsp;</td>
					<td class="normal"><input type="text" name="address1" size="25" value="<?=$address1?>" /></td>
				</tr>
				<tr>
					<td width="175">&nbsp;</td>
					<td class="normal"><input type="text" name="address2" size="25" value="<?=$address2?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">City:&nbsp;</td>
					<td class="normal"><input type="text" name="city" size="25" maxlength="25" value="<?=$city?>" /></td>
			  </tr>
				<tr>
					<td width="175" align="right" class="header">State:&nbsp;</td>
					<td class="normal">
						<select name="state">
						<option value="" selected>Choose State</option>
							<?php
								reset($STATES);
								while (list($key, $value) = each($STATES)) {
									echo "          <option value=\"$key\"";
									if ($state == $key)
									echo " selected";
									echo ">$value</option>\n";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">Zip Code:&nbsp;</td>
					<td class="normal"><input type="text" name="zip" size="25" value="<?=$zip?>" /></td>
				</tr>
			</table>
		</td>
		<td>
			<table align="center" cellpadding="1" cellspacing="1" class="normal">
				<tr>
					<td width="175" align="right" class="header">Billing Address:&nbsp;</td>
					<td class="normal"><input type="text" name="billing_address1" size="25" value="<?=$billing_address1?>" /></td>
				</tr>
				<tr>
					<td width="175">&nbsp;</td>
					<td class="normal"><input type="text" name="billing_address2" size="25" value="<?=$billing_address2?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">Billing City:&nbsp;</td>
					<td class="normal"><input type="text" name="billing_city" size="25" maxlength="25" value="<?=$billing_city?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">Billing State:&nbsp;</td>
					<td class="normal">
                      <select name="billing_state">
                        <option value="" selected>Choose State</option>
                        <?php
								reset($STATES);
								while (list($key, $value) = each($STATES)) {
									echo "          <option value=\"$key\"";
									if ($billing_state == $key)
									echo " selected";
									echo ">$value</option>\n";
								}
							?>
                   	  </select>
					</td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">Billing Zip:&nbsp;</td>
					<td class="normal"><input type="text" name="billing_zip" size="25" value="<?=$billing_zip?>" /></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table width="600" align="center" cellpadding="1" cellspacing="1" class="normal">	
	<tr>
		<td width="115" align="right" class="header">Phone Number:&nbsp;</td>
		<td class="normal"><input type="text" name="phone" size="25" maxlength="25" value="<?=$phone?>" />
		*Phone Format: 000-000-0000</td>
	</tr>
	<tr>
		<td width="115" align="right" class="header">Fax:&nbsp;</td>
		<td class="normal"><input type="text" name="fax" size="25"  maxlength="25" value="<?=$fax?>">
		*Fax Format: 000-000-0000</td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
</table>
<table width="550" align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td class="big" align="center" colspan="2"><b><u>Point of Contact Information</u></b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">Contact Name:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_f_name" size="15" value="<?=$poc_f_name?>" />
		<input type="text" name="poc_m_name" size="2" value="<?=$poc_m_name?>" />
		<input type="text" name="poc_l_name" size="15" value="<?=$poc_l_name?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">Contact Title:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_title" size="25" value="<?=$poc_title?>" /></td>
	</tr>
	<tr>		
		<td width="175" align="right" class="header">Contact Email:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_email" size="25" value="<?=$poc_email?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">Contact Phone:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_phone" size="25" maxlength="12"  value="<?=$poc_phone?>" />
		*Phone Format: 000-000-0000</td>
	</tr>

	<tr>	
		<td width="175" align="right" class="header">Contact Fax:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_fax" size="25" maxlength="12" value="<?=$poc_fax?>" />
		*Fax Format: 000-000-0000</td>
	</tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
    </tr>
	<tr>
		<td colspan="2"><div align="center"><b><u>Second Point of Contact Information</u></b></div></td>
	</tr>
	<tr>
      <td align="right" class="header">Contact Name:&nbsp;</td>
	  <td class="normal"><input type="text" name="poc2_f_name" size="15" value="<?=$poc2_f_name?>" />
          <input type="text" name="poc2_m_name" size="2" value="<?=$poc2_m_name?>" />
          <input type="text" name="poc2_l_name" size="15" value="<?=$poc2_l_name?>" /></td>
    </tr>
	<tr>
      <td align="right" class="header">Contact Title:&nbsp;</td>
	  <td class="normal"><input type="text" name="poc2_title" size="25" value="<?=$poc2_title?>" /></td>
    </tr>
	<tr>
      <td align="right" class="header">Contact Email:&nbsp;</td>
	  <td class="normal"><input type="text" name="poc2_email" size="25" value="<?=$poc2_email?>" /></td>
    </tr>
	<tr>
      <td align="right" class="header">Contact Phone:&nbsp;</td>
	  <td class="normal"><input type="text" name="poc2_phone" size="25" maxlength="12"  value="<?=$poc2_phone?>" />
	    *Phone Format: 000-000-0000</td>
    </tr>
	<tr>
      <td align="right" class="header">Contact Fax:&nbsp;</td>
	  <td class="normal"><input type="text" name="poc2_fax" size="25" maxlength="12" value="<?=$poc2_fax?>" />
	    *Fax Format: 000-000-0000</td>
    </tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
    </tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
    </tr>
	<tr>
		<td width="175" align="right" class="header">Owner/Pres./CEO:&nbsp;</td>
		<td class="normal"><input type="text" name="topdog_name" size="25" value="<?=$topdog_name?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">His/Her Title:&nbsp;</td>
		<td class="normal"><input type="text" name="topdog_title" size="25" value="<?=$topdog_title?>" /></td>
	</tr>
</table>
<table align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr><td colspan="2"><hr></td></tr>
	<tr>
		<td class="big" align="center" colspan="2"><b><u>Dealer/Vendor Information</u></b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="50%">
			<table align="center" cellpadding="1" cellspacing="1" class="normal">
				<tr>
					<td width="175" align="right" class="header">Dealer License#:&nbsp;</td>		
					<td class="normal"><input type="text" name="dl_no" size="25" value="<?=$dl_no?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">Dealer License Expiration:&nbsp;</td>
					<td class="normal"><input type="text" name="dl_ex" size="5" maxlength="4" value="<?=$dl_ex?>" />
					*Date Format: MMYY</td>
				</tr>
				<tr>
			</table>
		</td>
		<td>
			<table align="center" cellpadding="1" cellspacing="1" class="normal">
				<tr>
					<td width="175" align="right" class="header">Vendor/State Tax#:&nbsp;</td>
					<td class="normal"><input type="text" name="vst_no" size="25" value="<?=$vst_no?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">&nbsp;&nbsp;&nbsp;Vendor/State Tax Expiration:&nbsp;</td>
					<td class="normal"><input type="text" name="vst_ex" size="5" maxlength="4" value="<?=$vst_ex?>" />
					*Date Format: MMYY</td>
				</tr>
				<tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
</table>	
<table align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td class="big" align="center" colspan="2"><b><u>Electronic Payment (Insert At Least One Payment Type)</u></b></td>
	</tr>
	<tr>
		<td align="center" colspan="2">*Numbers only (No spaces) for Credit Card, Routing and Account #</td>
	</tr>
	<tr>
		<td colspan="2"><div align="center">This is for processing FEES only</div></td>
	</tr>
	<tr>
		<td width="50%">
			<table align="center" cellpadding="1" cellspacing="1" class="normal">
				<tr>
					<td width="175" align="right" class="header">Credit Card Type:&nbsp;</td>
					<td lass="normal">
						<select name="cc_type">
						<option value='' <?php if ($cc_type == '') echo 'selected'; ?>>Choose One</option>
						<option value="Mastercard" <?php if ($cc_type == 'Mastercard') echo 'selected'; ?>>Mastercard</option>
						<option value="Visa" <?php if ($cc_type == 'Visa') echo 'selected'; ?>>Visa</option>
						<option value="Discover" <?php if ($cc_type == 'Discover') echo 'selected'; ?>>Discover</option>
						<option value="American Express" <?php if ($cc_type == 'American Express') echo 'selected'; ?>>American Express</option>
						</select>
					</td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">Name on Credit Card:&nbsp;</td>
					<td class="normal"><input type="text" name="cc_name" size="25" value="<?=$cc_name?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">Credit Card Number:&nbsp;</td>
					<td class="normal"><input type="text" name="cc_no" size="25" maxlength="25" value="<?=$cc_no?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">Credit Card Expiration:&nbsp;</td>
					<td class="normal"><input type="text" name="cc_ex" size="5" maxlength="4" value="<?=$cc_ex?>" />
					*Date Format: MMYY</td>
				</tr>
			</table>
		</td>
		<td>
			<table align="center" cellpadding="1" cellspacing="1" class="normal">
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">Bank Draft Name:&nbsp;</td>
					<td class="normal"><input type="text" name="bd_name" size="25" value="<?=$bd_name?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">Bank Draft Routing:&nbsp;</td>
					<td class="normal"><input type="text" name="bd_routing" size="25" maxlength="15" value="<?=$bd_routing?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header">Bank Draft Account:&nbsp;</td>
					<td class="normal"><input type="text" name="bd_account" size="25" maxlength="15" value="<?=$bd_account?>" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
    	<td colspan="2"><hr></td>
	</tr>
</table>
<table align="center" cellpadding="1" cellspacing="1" class="normal">
          <tr>
            <?php	
if (!isset($pmt_method))
	$pmt_method = array();
?>
          <tr>
            <td class="big" align="center" colspan="2"><b><u>Accepted Payment Methods</u></b></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td class="normal">
              <input type="checkbox" name="pmt_method[]" value="Cash" <?php if (in_array("Cash", $pmt_method)) echo 'checked'; ?>>
              Cash
              <input type="checkbox" name="pmt_method[]" value="Money Order" <?php if (in_array("Money Order", $pmt_method)) echo 'checked'; ?>>
              Money Order<br>
              <input type="checkbox" name="pmt_method[]" value="Cashiers Check" <?php if (in_array("Cashiers Check", $pmt_method)) echo 'checked'; ?>>
              Cashiers Check
              <input type="checkbox" name="pmt_method[]" value="Personal Check" <?php if (in_array("Personal Check", $pmt_method)) echo 'checked'; ?>>
              Personal Check
              <input type="checkbox" name="pmt_method[]" value="Corporate Check" <?php if (in_array("Corporate Check", $pmt_method)) echo 'checked'; ?>>
              Corporate Check<br>
              <input type="checkbox" name="pmt_method[]" value="Visa" <?php if (in_array("Visa", $pmt_method)) echo 'checked'; ?>>
              Visa
              <input type="checkbox" name="pmt_method[]" value="MasterCard" <?php if (in_array("MasterCard", $pmt_method)) echo 'checked'; ?>>
              MasterCard
              <input type="checkbox" name="pmt_method[]" value="American Express" <?php if (in_array("American Express", $pmt_method)) echo 'checked'; ?>>
              American Express
              <input type="checkbox" name="pmt_method[]" value="Discover" <?php if (in_array("Discover", $pmt_method)) echo 'checked'; ?>>
              Discover<br>
              <input type="checkbox" name="pmt_method[]" value="PayPal" <?php if (in_array("PayPal", $pmt_method)) echo 'checked'; ?>>
              PayPal
              <input type="checkbox" name="pmt_method[]" value="BidPay" <?php if (in_array("BidPay", $pmt_method)) echo 'checked'; ?>>
              BidPay
              <input type="checkbox" name="pmt_method[]" value="Wire Transfer" <?php if (in_array("Wire Transfer", $pmt_method)) echo 'checked'; ?>>Wire Transfer
            </td>
          </tr>
      </table>
<table width="550" align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td colspan="2"><hr></td>
	</tr>
	<tr>
		<td class="big" align="center" colspan="2"><b><u>Personnal Notes</u></b></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="normal"><textarea name="notes" cols="75" rows="5" wrap="VIRTUAL"><?=$notes?></textarea></td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
</table>
<table width="600" align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td align="center" class="normal" colspan="2">
			<?php if ($status != 'pending') { echo "<input type='submit' name='save' value='Save Information'>"; } ?>
			<?php if (!isset($id)) { echo "&nbsp;&nbsp;&nbsp;<input type='reset' value='Clear'>"; } ?>
			&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value=" Submit Application ">
		</td>
	</tr>
</table>

<input type="hidden" name="charter_member" value="yes" />
<input type="hidden" name="invoice" value="no" />
</form>