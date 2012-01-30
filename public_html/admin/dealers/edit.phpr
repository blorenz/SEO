<?php

include('../../../include/db.php');
db_connect();

extract(defineVars("address1","address2","ae_id","aeid","bd_account","bd_name",
				"bd_routing","billing_address1","billing_address2","billing_city",
				"billing_state","billing_zip","business","cc_ex","cc_name","cc_no",
				"cc_type","charter_member","city","dba","dealer","dl_ex","dl_no",
				"dm_id","dmid","ein","fax","feed_provider","id","industry",
				"invoice","name","no_of_stores","notes","phone","PHP_SELF",
				"pmt_method","poc2_cell","poc2_email","poc2_f_name","poc2_fax",
				"poc2_l_name","poc2_m_name","poc2_phone","poc2_title","poc_cell",
				"poc_email","poc_f_name","poc_fax","poc_l_name","poc_m_name",
				"poc_phone","poc_title","sdid","state","status","status_orig",
				"submit","topdog_name","topdog_title","type","vst_ex","vst_no",
				"years","zip","status"));  //JJM added 5/7/2010

if (empty($id) || $id <= 0) {
	header('Location: index.php');
	exit;
}

$page_title = 'Update Dealer';

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
	$name			= trim($name);
	$phone			= trim($phone);
	$poc_email		= trim($poc_email);
	$poc_f_name		= trim($poc_f_name);
	$poc_fax		= trim($poc_fax);
	$poc_m_name		= trim($poc_m_name);
	$poc_l_name		= trim($poc_l_name);
	$poc_phone		= trim($poc_phone);
	$poc_cell		= trim($poc_cell); //JJM added 8/10/2010
	$poc_title		= trim($poc_title);
    $poc2_email		= trim($poc2_email);
	$poc2_f_name	= trim($poc2_f_name);
	$poc2_fax		= trim($poc2_fax);
	$poc2_m_name	= trim($poc2_m_name);
	$poc2_l_name	= trim($poc2_l_name);
	$poc2_phone		= trim($poc2_phone);
	$poc2_cell		= trim($poc2_cell); //JJM added 8/10/2010
	$poc2_title		= trim($poc2_title);
	$state			= trim($state);
	$topdog_name	= trim($topdog_name);
	$topdog_title	= trim($topdog_title);
	$vst_ex			= trim($vst_ex);
	$vst_no			= trim($vst_no);
	$years			= trim($years);
	$zip	   		= trim($zip);
	$type	   		= trim($type);
	$feed_provider	= trim($feed_provider);

$errors = '';

if (isset($submit) && $status=='saved') {

      $sql = "UPDATE dealers SET ae_id='$ae_id', dm_id='', address1='$address1', address2='$address2', bd_account='$bd_account', " .
      "bd_name='$bd_name', bd_routing='$bd_routing', billing_address1='$billing_address1', " .
      "billing_address2='$billing_address2', billing_city='$billing_city', billing_state='$billing_state', " .
      "billing_zip='$billing_zip', business='$business', cc_ex='$cc_ex', cc_name='$cc_name', cc_no='$cc_no', " .
      "cc_type='$cc_type', city='$city', dba='$dba', dl_ex='$dl_ex', dl_no='$dl_no', ein='$ein', fax='$fax', " .
      "industry='$industry', name='$name', phone='$phone', poc_email='$poc_email', poc_f_name='$poc_f_name', poc_m_name='$poc_m_name', " .
      "poc_fax='$poc_fax', poc_l_name='$poc_l_name', poc_phone='$poc_phone', poc_cell='$poc_cell', poc_title='$poc_title', state='$state', " .
      "poc2_email='$poc2_email', poc2_f_name='$poc2_f_name', poc2_m_name='$poc2_m_name', " .
      "poc2_fax='$poc2_fax', poc2_l_name='$poc2_l_name', poc2_phone='$poc2_phone', poc2_cell='$poc2_cell', poc2_title='$poc2_title', " .
      "topdog_name='$topdog_name', topdog_title='$topdog_title', vst_ex='$vst_ex', vst_no='$vst_no', " .
      "years='$years', zip='$zip', charter_member='$charter_member', invoice='$invoice', no_of_stores='$no_of_stores',
                  modified=NOW(), status='$status', notes='$notes', type='$type', feed_provider='$feed_provider' WHERE id='$id'";

		db_do($sql);

		header('Location: index.php');
		exit;

      } elseif (isset($submit) && $status!='saved') {

	$errors = '';

	if (empty($ae_id))
		$errors .= '<li>Assign to an AE</li>';
	if (empty($name))
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
	if (empty($poc_cell))
		$errors .= '<li>Contact Cell</li>';
	if (empty($topdog_name))
		$errors .= '<li>Owner Name</li>';
	if (empty($topdog_title))
		$errors .= '<li>Owner Title</li>';


	if (empty($vst_ex))
		$errors .= '<li>Vendor/State Tax Expiration Date</li>';
	if (empty($vst_no))
		$errors .= '<li>Vendor/State Tax Number</li>';

	if (empty($bd_name) || empty($bd_routing) || empty($bd_account))
	{
		if (empty($cc_ex))
			$errors .= '<li>Credit Card Expiration Date</li>';
		if (empty($cc_type))
			$errors .= '<li>Type of Credit Card</li>';
		if (empty($cc_name))
			$errors .= '<li>Name on Credit Card</li>';
		if (empty($cc_no))
			$errors .= '<li>Credit Card Number</li>';
	}

	if (empty($cc_ex) || empty($cc_type) || empty($cc_name) || empty($cc_no))
	{
		if (empty($bd_name))
			$errors .= '<li>Bank Draft Name</li>';
		if (empty($bd_routing))
			$errors .= '<li>Bank Draft Routing</li>';
		if (empty($bd_account))
			$errors .= '<li>Bank Draft Account</li>';
	}

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

		db_do("UPDATE dealers SET ae_id='$ae_id', dm_id='', address1='$address1', address2='$address2', bd_account='$bd_account', " .
				"bd_name='$bd_name', bd_routing='$bd_routing', billing_address1='$billing_address1', " .
				"billing_address2='$billing_address2', billing_city='$billing_city', billing_state='$billing_state', " .
				"billing_zip='$billing_zip', business='$business', cc_ex='$cc_ex', cc_name='$cc_name', cc_no='$cc_no', " .
				"cc_type='$cc_type', city='$city', dba='$dba', dl_ex='$dl_ex', dl_no='$dl_no', ein='$ein', fax='$fax', " .
				"industry='$industry', name='$name', phone='$phone', poc_email='$poc_email', poc_f_name='$poc_f_name', poc_m_name='$poc_m_name', " .
				"poc_fax='$poc_fax', poc_l_name='$poc_l_name', poc_phone='$poc_phone', poc_cell='$poc_cell', poc_title='$poc_title',
            poc2_email='$poc2_email', poc2_f_name='$poc2_f_name', poc2_m_name='$poc2_m_name', " .
				"poc2_fax='$poc2_fax', poc2_l_name='$poc2_l_name', poc2_phone='$poc2_phone', poc2_cell='$poc2_cell', poc2_title='$poc2_title',
            state='$state', " .
				"topdog_name='$topdog_name', topdog_title='$topdog_title', vst_ex='$vst_ex', vst_no='$vst_no', " .
				"years='$years', zip='$zip', charter_member='$charter_member', invoice='$invoice', no_of_stores='$no_of_stores',
				payment_method='$payment_method', modified=NOW(), status='$status', notes='$notes', type='$type', feed_provider='$feed_provider' WHERE id='$id'");

		if ($status == 'suspended') {
			db_do("UPDATE users SET status='suspended' WHERE dealer_id='$id'");
		}

/*
 		Commented Out: No More Signup Commission!

		if ($status_orig == 'pending' && $status == 'active') {

			$result_info = db_do("SELECT aes.user_id, aes.signup_percentage, dms.user_id, dms.override_signup
			FROM aes, dms, dealers
			WHERE dealers.id='$id' AND dealers.ae_id=aes.id AND aes.dm_id=dms.id");
			list($ae_user_id, $ae_com, $dm_user_id, $dm_ovr) = db_row($result_info);

			$commission = $override = 0;

			if ($charter_member == 'yes')
				$commission = 50;
			else
				$commission = 500 * $ae_com;

			if ($dm_user_id != $ae_user_id)
				$override = $dm_ovr * $commission;

			db_do("INSERT INTO commission
			SET type_id='$id', ae_user_id='$ae_user_id', commission='$commission',
							   dm_user_id='$dm_user_id', override='$override',
			fee_type='signup', dealer_type='signup', modified=NOW(), created=NOW()");
		}
*/

		header('Location: index.php');
		exit;
	}
} else {
	$result = db_do("SELECT ae_id, address1, address2, bd_account, bd_name, bd_routing, billing_address1, billing_address2, billing_city,
			billing_state, billing_zip, business, cc_ex, cc_name, cc_no, cc_type, city, dba, dl_ex, dl_no, ein, fax, industry,
			name, phone, poc_email, poc_f_name, poc_fax, poc_m_name, poc_l_name, poc_phone, poc_cell, poc_title,
         poc2_email, poc2_f_name, poc2_fax, poc2_m_name, poc2_l_name, poc2_cell, poc2_cell, poc2_title, state, topdog_name, topdog_title,
			vst_ex, vst_no, years, zip, status, notes, payment_method, charter_member, invoice, no_of_stores, type, feed_provider FROM dealers WHERE id='$id'");

	list($aeid, $address1, $address2, $bd_account, $bd_name, $bd_routing, $billing_address1, $billing_address2, $billing_city,
			$billing_state, $billing_zip, $business, $cc_ex, $cc_name, $cc_no, $cc_type, $city, $dba, $dl_ex, $dl_no, $ein, $fax, $industry,
			$name, $phone, $poc_email, $poc_f_name, $poc_fax, $poc_m_name, $poc_l_name, $poc_phone, $poc_cell, $poc_title,
         $poc2_email, $poc2_f_name, $poc2_fax, $poc2_m_name, $poc2_l_name, $poc2_phone, $poc2_cell, $poc2_title,
         $state, $topdog_name, $topdog_title,
			$vst_ex, $vst_no, $years, $zip, $status, $notes, $payment_method, $charter_member, $invoice, $no_of_stores, $type, $feed_provider) = db_row($result);

	$pmt_method = explode(',', $payment_method);
	$status_orig = $status;

	db_free($result);
}

$poc_l_name   = stripslashes($poc_l_name);
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

include('../../../include/states.php');
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
<?php include('_links.php'); ?>
  <table align="center" border="0" cellpadding="10" cellspacing="0">
   <tr>
    <td>
      <?php include('_form.php'); ?>
</td>
   </tr>
  </table>
 </body>
</html>
