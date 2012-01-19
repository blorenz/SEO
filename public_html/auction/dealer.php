<?php

$page_title = 'Edit My Company Profile';
$help_page = "chp7.php#Chp7_Edityourcompanyprofile";

include('../../include/session.php');
extract(defineVars("address1", "address2", "bd_account", "bd_name", "bd_routing", "billing_address1", "billing_address2", "billing_city", "billing_state", "billing_zip", "business", "cc_ex", "cc_name", "cc_no", "cc_type", "city", "dba", "dealer", "dealer_name", "dl_ex", "dl_no", "ein", "fax", "industry", "phone", "pmt_method", "poc_email", "poc_f_name", "poc_fax", "poc_l_name", "poc_m_name", "poc_phone", "poc_title", "sdid", "state", "submit", "topdog_name", "topdog_title", "vst_ex", "vst_no", "years", "zip"));

if (!has_priv('users', $privs)) {
	header('Location: menu.php');
	exit;
}

	$address1		= trim($address1);
	$address2		= trim($address2);
	$bd_account		= trim($bd_account);
	$bd_name		= trim($bd_name);
	$bd_routing		= trim($bd_routing);
	$billing_address1 = trim($billing_address1);
	$billing_address2 = trim($billing_address2);
	$billing_city	= trim($billing_city);
	$billing_state	= trim($billing_state);
	$billing_zip	= trim($billing_zip);
	$business		= trim($business);
	$cc_ex			= trim($cc_ex);
	$cc_name		= trim($cc_name);
	$cc_no			= trim($cc_no);
	$cc_type		= trim($cc_type);
	$city			= trim($city);
	$dba			= trim($dba);
	$dl_ex			= trim($dl_ex);
	$dl_no			= trim($dl_no);
	$ein			= trim($ein);
	$fax			= trim($fax);
	$industry		= trim($industry);
	$phone			= trim($phone);
	$poc_email		= trim($poc_email);
	$poc_f_name		= trim($poc_f_name);
	$poc_fax		= trim($poc_fax);
	$poc_m_name		= trim($poc_m_name);
	$poc_l_name		= trim($poc_l_name);
	$poc_phone		= trim($poc_phone);
	$poc_title		= trim($poc_title);
	$state			= trim($state);
	$topdog_name	= trim($topdog_name);
	$topdog_title	= trim($topdog_title);
	$vst_ex			= trim($vst_ex);
	$vst_no			= trim($vst_no);
	$years			= trim($years);
	$zip			= trim($zip);
	$errors       = '';

include('../../include/db.php');
db_connect();

if (isset($submit)) {
	if (empty($dealer_name))
		$errors .= '<li>Dealership Name</li>';
	if (empty($dba))
		$errors .= '<li>Doing Business As</li>';
	if (empty($business))
		$errors .= '<li>Type of Business</li>';
	if (empty($ein))
		$errors .= '<li>Federal EIN Number</li>';
	if (empty($years))
		$errors .= '<li>Years of Business</li>';
	if (empty($industry))
		$errors .= '<li>Industry</li>';

	if (empty($poc_f_name))
		$errors .= '<li>Contact First Name</li>';
	if (empty($poc_l_name))
		$errors .= '<li>Contact Last Name</li>';
	if (empty($poc_title))
		$errors .= '<li>Contact Title</li>';
	if (empty($poc_email) || !ereg("^.+@.+\\..+$", $poc_email))
		$errors .= '<li>Contact Email</li>';
	if (empty($poc_phone))
		$errors .= '<li>Contact Phone</li>';
	if (empty($topdog_name))
		$errors .= '<li>Owner Name</li>';
	if (empty($topdog_title))
		$errors .= '<li>Owner Title</li>';

	if (empty($vst_ex))
		$errors .= '<li>Vendor/State Tax Expiration Date</li>';
	if (empty($vst_no))
		$errors .= '<li>Vendor/State Tax Number</li>';

	if (empty($address1)) {
		$errors .= '<li>Address</li>';
		$address2 = '';
	}
	if (empty($city))
		$errors .= '<li>City</li>';
	if (empty($state))
		$errors .= '<li>State</li>';
	if (empty($zip))
		$errors .= '<li>Zip</li>';
	if (empty($phone))
		$errors .= '<li>Phone</li>';

	if (empty($billing_address1)) {
		$errors .= '<li>Billing Address</li>';
		$billing_address2 = '';
	}
	if (empty($billing_city))
		$errors .= '<li>Billing City</li>';
	if (empty($billing_state))
		$errors .= '<li>Billing State</li>';
	if (empty($billing_zip))
		$errors .= '<li>Billing Zip</li>';

	if (empty($errors)) {

		if (!isset($pmt_method))
			$pmt_method = array();
		else
			$payment_method = implode(",", $pmt_method);

		db_do("UPDATE dealers SET address1='$address1', address2='$address2', billing_address1='$billing_address1', " .
				"billing_address2='$billing_address2', billing_city='$billing_city', billing_state='$billing_state', " .
				"billing_zip='$billing_zip', business='$business', city='$city', dba='$dba', dl_ex='$dl_ex', dl_no='$dl_no', ein='$ein', fax='$fax', " .
				"industry='$industry', name='$dealer_name', phone='$phone', poc_email='$poc_email', poc_f_name='$poc_f_name', poc_m_name='$poc_m_name', " .
				"poc_fax='$poc_fax', poc_l_name='$poc_l_name', poc_phone='$poc_phone', poc_title='$poc_title', state='$state', " .
				"topdog_name='$topdog_name', topdog_title='$topdog_title', vst_ex='$vst_ex', vst_no='$vst_no', " .
				"years='$years', zip='$zip', payment_method='$payment_method', modified=NOW(), created=modified WHERE id='$dealer_id'");

		header('Location: index.php');
		exit;
	}
} else {
	$result = db_do("SELECT address1, address2, billing_address1, billing_address2, billing_city,
			billing_state, billing_zip, business, city, dba, dl_ex, dl_no, ein, fax, industry,
			name, phone, poc_email, poc_f_name, poc_fax, poc_m_name, poc_l_name, poc_phone, poc_title, state, topdog_name, topdog_title,
			vst_ex, vst_no, years, zip, payment_method FROM dealers WHERE id='$dealer_id'");

	list($address1, $address2, $billing_address1, $billing_address2, $billing_city,
			$billing_state, $billing_zip, $business, $city, $dba, $dl_ex, $dl_no, $ein, $fax, $industry,
			$dealer_name, $phone, $poc_email, $poc_f_name, $poc_fax, $poc_m_name, $poc_l_name, $poc_phone, $poc_title, $state, $topdog_name, $topdog_title,
			$vst_ex, $vst_no, $years, $zip, $payment_method) = db_row($result);

	$pmt_method = explode(',', $payment_method);

}

$poc_l_name     = stripslashes($poc_l_name);
$poc_title    = stripslashes($poc_title);
$poc_email    = stripslashes($poc_email);
$topdog_name  = stripslashes($topdog_name);
$topdog_title = stripslashes($topdog_title);
$dealer       = stripslashes($dealer);
$sdid         = stripslashes($sdid);
$address1     = stripslashes($address1);
$address2     = stripslashes($address2);
$city         = stripslashes($city);
$state        = stripslashes($state);
$zip          = stripslashes($zip);
$phone        = stripslashes($phone);
$fax          = stripslashes($fax);

include('header.php');
include('../../include/states.php');

?>
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
  <form method="post" action="<?=$PHP_SELF?>">
   <table align="center" border="0" cellpadding="1" cellspacing="0">
    <tr><td colspan="2">&nbsp;</td></tr>
<?php if (!empty($errors)) { ?>
    <tr>
     <td align="center" colspan="2">
      <table border="0" cellpadding="0" cellspacing="0">
       <tr>
        <td class="error">The following fields were incorrect/incomplete:<br /><ul><?=$errors?></ul></td>
       </tr>
      </table>
     </td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
<?php } ?>
    <tr>
		<td class="big" align="center" colspan="2"><b><u>Company Information</u></b></td>
	</tr>


	<tr>
			<td width="175" align="right" class="header">Owner/Pres./CEO:&nbsp;</td>
			<td class="normal"><input type="text" name="topdog_name" size="25" value="<?=$topdog_name?>" /></td>
		</tr>
		<tr>
			<td width="175" align="right" class="header">His/Her Title:&nbsp;</td>
			<td class="normal"><input type="text" name="topdog_title" size="25" value="<?=$topdog_title?>" /></td>
	</tr>

	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">Company Name:&nbsp;</td>
		<td class="normal"><input type="text" name="dealer_name" size="50" value="<?=$dealer_name?>" /></td>
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
			<option value="Other" <?php if ($business == 'Other') echo 'selected'; ?>>Other</option></select>
		</td>
	</tr>
	<tr>
		<td width="175" align="right" class="header">Federal EIN#:&nbsp;</td>
		<td class="normal"><input type="text" name="ein" size="50" value="<?=$ein?>" /></td>
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
		<td class="normal"><input type="text" name="phone" size="25" maxlength="12" value="<?=$phone?>" />
		*Phone Format: 000-000-0000</td>
	</tr>
	<tr>
		<td width="115" align="right" class="header">Fax:&nbsp;</td>
		<td class="normal"><input type="text" name="fax" size="25"  maxlength="12" value="<?=$fax?>">
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
      <td colspan="2">
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
			  <input type="checkbox" name="pmt_method[]" value="Wire Transfer" <?php if (in_array("Wire Transfer", $pmt_method)) echo 'checked'; ?>>Wire Transfer</td>
          </tr>
        </table>
        <br>
        <div align="center">
          <input class="header" type="submit" name="submit" value=" Submit ">
      </div></td>
    </tr>
  </table>
  </form> <br><br><br><br><br>

<?php
db_disconnect();
include('footer.php');
?>
