<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>


<?php

// Randy added the following //
// DEFINING VARIABLES FROM THE REQUEST   //



$PHP_SELF = $_SERVER['PHP_SELF'];

if(!empty($_REQUEST['status']))
	$status = $_REQUEST['status'];
else
	$status = "";



if(!empty($_REQUEST['id']))
	$id = $_REQUEST['id'];
else
	$id = "";

if(!empty($_REQUEST['name']))
	$name = $_REQUEST['name'];
else
	$name = "";

if(!empty($_REQUEST['dba']))
	$dba = $_REQUEST['dba'];
else
	$dba = "";

if(!empty($_REQUEST['business']))
	$business = $_REQUEST['business'];
else
	$business = "";

if(!empty($_REQUEST['ein']))
	$ein = $_REQUEST['ein'];
else
	$ein = "";

if(!empty($_REQUEST['no_of_stores']))
	$no_of_stores = $_REQUEST['no_of_stores'];
else
	$no_of_stores = "";


if(!empty($_REQUEST['years']))
	$years = $_REQUEST['years'];
else
	$years = "";


if(!empty($_REQUEST['industry']))
	$industry = $_REQUEST['industry'];
else
	$industry = "";

if(!empty($_REQUEST['address1']))
	$address1 = $_REQUEST['address1'];
else
	$address1 = "";


if(!empty($_REQUEST['address2']))
	$address2 = $_REQUEST['address2'];
else
	$address2 = "";


if(!empty($_REQUEST['city']))
	$city = $_REQUEST['city'];
else
	$city = "";

if(!empty($_REQUEST['state']))
	$state = $_REQUEST['state'];
else
	$state = "";

if(!empty($_REQUEST['zip']))
	$zip = $_REQUEST['zip'];
else
	$zip = "";

if(!empty($_REQUEST['zip']))
	$zip = $_REQUEST['zip'];
else
	$zip = "";


if(!empty($_REQUEST['billing_address1']))
	$billing_address1 = $_REQUEST['billing_address1'];
else
	$billing_address1 = "";


if(!empty($_REQUEST['billing_address2']))
	$billing_address2 = $_REQUEST['billing_address2'];
else
	$billing_address2 = "";

if(!empty($_REQUEST['billing_city']))
	$billing_city = $_REQUEST['billing_city'];
else
	$billing_city = "";


if(!empty($_REQUEST['billing_state']))
	$billing_state = $_REQUEST['billing_state'];
else
	$billing_state = "";


if(!empty($_REQUEST['billing_zip']))
	$billing_zip = $_REQUEST['billing_zip'];
else
	$billing_zip = "";


if(!empty($_REQUEST['phone']))
	$phone = $_REQUEST['phone'];
else
	$phone = "";


if(!empty($_REQUEST['fax']))
	$fax = $_REQUEST['fax'];
else
	$fax = "";

if(!empty($_REQUEST['poc_f_name']))
	$poc_f_name = $_REQUEST['poc_f_name'];
else
	$poc_f_name = "";


if(!empty($_REQUEST['poc_m_name']))
	$poc_m_name = $_REQUEST['poc_m_name'];
else
	$poc_m_name = "";


if(!empty($_REQUEST['poc_l_name']))
	$poc_l_name = $_REQUEST['poc_l_name'];
else
	$poc_l_name = "";



if(!empty($_REQUEST['poc_title']))
	$poc_title = $_REQUEST['poc_title'];
else
	$poc_title = "";


if(!empty($_REQUEST['poc_email']))
	$poc_email = $_REQUEST['poc_email'];
else
	$poc_email = "";


if(!empty($_REQUEST['poc_phone']))
	$poc_phone = $_REQUEST['poc_phone'];
else
	$poc_phone = "";

if(!empty($_REQUEST['poc_fax']))
	$poc_fax = $_REQUEST['poc_fax'];
else
	$poc_fax = "";


if(!empty($_REQUEST['topdog_name']))
	$topdog_name = $_REQUEST['topdog_name'];
else
	$topdog_name = "";


if(!empty($_REQUEST['topdog_title']))
	$topdog_title = $_REQUEST['topdog_title'];
else
	$topdog_title = "";


if(!empty($_REQUEST['dl_no']))
	$dl_no = $_REQUEST['dl_no'];
else
	$dl_no = "";


if(!empty($_REQUEST['dl_ex']))
	$dl_ex = $_REQUEST['dl_ex'];
else
	$dl_ex = "";


if(!empty($_REQUEST['vst_no']))
	$vst_no = $_REQUEST['vst_no'];
else
	$vst_no = "";


if(!empty($_REQUEST['vst_ex']))
	$vst_ex = $_REQUEST['vst_ex'];
else
	$vst_ex = "";



if(!empty($_REQUEST['cc_type']))
	$cc_type = $_REQUEST['cc_type'];
else
	$cc_type = "";



if(!empty($_REQUEST['cc_name']))
	$cc_name = $_REQUEST['cc_name'];
else
	$cc_name = "";

if(!empty($_REQUEST['cc_no']))
	$cc_no = $_REQUEST['cc_no'];
else
	$cc_no = "";




if(!empty($_REQUEST['cc_ex']))
	$cc_ex = $_REQUEST['cc_ex'];
else
	$cc_ex = "";



if(!empty($_REQUEST['bd_name']))
	$bd_name = $_REQUEST['bd_name'];
else
	$bd_name = "";


if(!empty($_REQUEST['bd_routing']))
	$bd_routing = $_REQUEST['bd_routing'];
else
	$bd_routing = "";


if(!empty($_REQUEST['bd_account']))
	$bd_account = $_REQUEST['bd_account'];
else
	$bd_account = "";

?>


<?php    if (!empty($errors)) { ?>



       <table align="center" border="0" cellpadding="0" cellspacing="0">
          <tr>
           <td class="error">The following fields were incorrect/incomplete:<br /><ul><?=$errors?></ul></td>
          </tr>
		  <tr><td colspan="2">&nbsp;</td></tr>
</table>





<?php } ?>




	<form method="post" action="<?=$PHP_SELF?>">
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="ae_id" value="<?php echo $ae_id; ?>" />
		<input type="hidden" name="status" value="<?php echo $status; ?>" />
<table width="550" align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td class="big" align="center" colspan="2"><b><u>Company Information</u></b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Owner/Pres./CEO:&nbsp;</td>
		<td class="normal"><input type="text" name="topdog_name" size="25" value="<?=$topdog_name?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> His/Her Title:&nbsp;</td>
		<td class="normal"><input type="text" name="topdog_title" size="25" value="<?=$topdog_title?>" /></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Company Name:&nbsp;</td>
		<td class="normal"><input type="text" name="name" size="50" value="<?=$name?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> DBA:&nbsp;</td>
		<td class="normal"><input type="text" name="dba" size="50" value="<?=$name?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Type of Business:&nbsp;</td>
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
		<td width="175" align="right" class="header"><span class="style1">*</span> Number of Stores:&nbsp;</td>
		<td class="normal"><input type="text" name="no_of_stores" size="50" value="<?=$no_of_stores?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Years of Business:&nbsp;</td>
		<td class="normal"><input type="text" name="years" size="50" value="<?=$years?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Industry:&nbsp;</td>
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
					<td width="175" align="right" class="header"><span class="style1">*</span> Address:&nbsp;</td>
					<td class="normal"><input type="text" name="address1" size="25" value="<?=$address1?>" /></td>
				</tr>
				<tr>
					<td width="175">&nbsp;</td>
					<td class="normal"><input type="text" name="address2" size="25" value="<?=$address2?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header"><span class="style1">*</span> City:&nbsp;</td>
					<td class="normal"><input type="text" name="city" size="25" maxlength="25" value="<?=$city?>" /></td>
			  </tr>
				<tr>
					<td width="175" align="right" class="header"><span class="style1">*</span> State:&nbsp;</td>
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
					<td width="175" align="right" class="header"><span class="style1">*</span> Zip Code:&nbsp;</td>
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
		<td width="115" align="right" class="header"><span class="style1">*</span> Phone Number:&nbsp;</td>
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
		<td width="175" align="right" class="header"><span class="style1">*</span> Contact Name:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_f_name" size="15" value="<?=$poc_f_name?>" />
		<input type="text" name="poc_m_name" size="2" value="<?=$poc_m_name?>" />
		<input type="text" name="poc_l_name" size="15" value="<?=$poc_l_name?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Contact Title:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_title" size="25" value="<?=$poc_title?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Contact Email:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_email" size="25" value="<?=$poc_email?>" /></td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Contact Phone:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_phone" size="25" maxlength="12"  value="<?=$poc_phone?>" />
		*Phone Format: 000-000-0000</td>
	</tr>
	<tr>
		<td width="175" align="right" class="header"><span class="style1">*</span> Contact Cell:&nbsp;</td>
		<td class="normal"><input type="text" name="poc_cell" size="25" maxlength="12"  value="<?=$poc_cell?>" />
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
      <td colspan="2"><div align="center"><span class="big"><b><u>Second Point of Contact Information</u></b></span></div></td>
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
      <td align="right" class="header">Contact Cell:&nbsp;</td>
	  <td class="normal"><input type="text" name="poc2_cell" size="25" maxlength="12"  value="<?=$poc2_cell?>" />
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
		<td class="big" align="center" colspan="2"><b><u>Secure Electronic Payment</u></b></td>
	</tr>
	<tr>
		<td align="center" colspan="2">*Numbers only (No spaces) for Credit Card, Routing and Account #</td>
	</tr>
	<tr>
		<td colspan="2">
        <div align="center">
          <p><strong>This information is for processing Fees only<br>
            </strong>Your account is only billed at the beginning of each month
            for only fees that have been accrued during the previous month.<br>
            REMEMBER - there are:<br>
            <br>
            <strong>NO fee's for your membership <br>
            NO fees to list unit's<br>
            NO fees to sell (only to Dealers!) <br>
            NO fees to pull an auction <br>
            There is only a Buy Fee for Dealers based on the close amount if you
            purchase an item. (Approx $180 for a $10,000 unit) <br>
            Please feel confident that your private information is secure and
            is being encrypted to 256bit AES level.<br>
            <br>
            View the Trusted Security Certificate here:<br>
            <br>
            <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" SRC="//smarticon.geotrust.com/si.js"></SCRIPT>
            </strong></p>
          <p><span class="big"><b><u><span class="style1">Choose at least ONE secure payment type</span></u></b></span></p>
		</div></td>
	</tr>
	<tr>
		<td width="50%">
			<div align="center" class="style1"><strong>Credit Card
			</strong></div>
			<table align="center" cellpadding="1" cellspacing="1" class="normal">
			<tr>
					<td width="175" align="right" class="header"><span class="style1">*</span> Credit Card Type:&nbsp;</td>
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
					<td width="175" align="right" class="header"><span class="style1">*</span> Name on Credit Card:&nbsp;</td>
					<td class="normal"><input type="text" name="cc_name" size="25" value="<?=$cc_name?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header"><span class="style1">*</span> Credit Card Number:&nbsp;</td>
					<td class="normal"><input type="text" name="cc_no" size="25" maxlength="25" value="<?=$cc_no?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header"><span class="style1">*</span> Credit Card Expiration:&nbsp;</td>
					<td class="normal"><input type="text" name="cc_ex" size="5" maxlength="4" value="<?=$cc_ex?>" />
					*Date Format: MMYY</td>
				</tr>
	  </table>	  </td>
		<td>
			<div align="center" class="style1"><strong>Secure Bank Draft
(E-Check) </strong></div>
			<table align="center" cellpadding="1" cellspacing="1" class="normal">
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td width="175" align="right" class="header"><span class="style1">*</span> Bank Draft Name:&nbsp;</td>
					<td class="normal"><input type="text" name="bd_name" size="25" value="<?=$bd_name?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header"><span class="style1">*</span> Bank Draft Routing:&nbsp;</td>
					<td class="normal"><input type="text" name="bd_routing" size="25" value="<?=$bd_routing?>" /></td>
				</tr>
				<tr>
					<td width="175" align="right" class="header"><span class="style1">*</span> Bank Draft Account:&nbsp;</td>
					<td class="normal"><input type="text" name="bd_account" size="25" value="<?=$bd_account?>" /></td>
				</tr>
	  </table>	  </td>
	</tr>
	<tr><td colspan="2"><div align="center"><img src="../images/creditcards1.gif" width="400" height="59" border="0" usemap="#Map">	  </div>
	  <hr></td></tr>
</table>
<table align="center" cellpadding="1" cellspacing="1" class="normal">
          <tr>
            <?php
if (!isset($pmt_method))
	$pmt_method = array();
?>
          <tr>
            <td class="big" align="center" colspan="2"><span class="style1"><b><u>*</u></b></span><b><u> Accepted Payment Methods</u></b></td>
          </tr>
          <tr>
            <td colspan="2"><div align="center">Default settings for this dealers auctions</div></td>
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
	      <input type="checkbox" name="pmt_method[]" value="Wire Transfer" <?php if (in_array("Wire Transfer", $pmt_method)) echo 		      'checked'; ?>>Wire Transfer
	      </td>
          </tr>
      </table>
<table width="550" align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr><td><hr></td></tr>
</table>
<table width="600" align="center" cellpadding="1" cellspacing="1" class="normal">
	<tr>
		<td align="center" class="normal" colspan="2">
			<?php if ($status != 'pending') { echo "<input type='submit' name='submit' value='Submit Information'>"; } ?>
			<?php if (!isset($id)) { echo "&nbsp;&nbsp;&nbsp;<input type='reset' value='Clear'>"; } ?>
&nbsp;&nbsp;&nbsp;		</td>
	</tr>
</table>
<input type="hidden" name="invoice" value="yes" />
<input type="hidden" name="charter_member" value="yes" />
</form>
    <map name="Map">
      <area shape="rect" coords="11,3,126,55" href="http://www.americanexpress.com" target="_blank">
      <area shape="rect" coords="146,7,216,52" href="http://www.visa.com" target="_blank">
      <area shape="rect" coords="232,8,305,53" href="http://www.mastercard.com" target="_blank">
      <area shape="rect" coords="320,8,393,53" href="http://www.discovercard.com" target="_blank">
    </map>
