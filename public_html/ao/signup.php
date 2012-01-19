<?php

if(!empty($_REQUEST['username']))
	$username = $_REQUEST['username'];
else
	$username = "";

if(!empty($_REQUEST['page_title']))
	$page_title = $_REQUEST['page_title'];
else
	$page_title = "";

?><?php

$skip_privs = 1;
include('../../include/defs.php');
include('../../include/states.php');
include('../../include/db.php');
db_connect();


if (isset($save)) {

	if (!isset($pmt_method))
			$pmt_method = array();
		else
			$payment_method = implode(",", $pmt_method);

	db_do("INSERT INTO dealers SET address1='$address1', address2='$address2', bd_account='$bd_account', " .
		"bd_name='$bd_name', bd_routing='$bd_routing', billing_address1='$billing_address1', " .
		"billing_address2='$billing_address2', billing_city='$billing_city', billing_state='$billing_state', " .
		"billing_zip='$billing_zip', business='$business', cc_ex='$cc_ex', cc_name='$cc_name', cc_no='$cc_no', " .
		"cc_type='$cc_type', city='$city', dba='$dba', dl_ex='$dl_ex', dl_no='$dl_no', ein='$ein', fax='$fax', " .
		"industry='$industry', name='$name', phone='$phone', poc_email='$poc_email', poc_f_name='$poc_f_name', poc_m_name='$poc_m_name', " .
		"poc_fax='$poc_fax', poc_l_name='$poc_l_name', poc_phone='$poc_phone', poc_title='$poc_title', state='$state', " .
		"topdog_name='$topdog_name', topdog_title='$topdog_title', vst_ex='$vst_ex', vst_no='$vst_no', " .
		"years='$years', zip='$zip', payment_method='$payment_method', charter_member='$charter_member', invoice='$invoice', no_of_stores='$no_of_stores',
		modified=NOW(), created=modified, status='saved', ae_id='$ae_id', notes='$notes'");

		header('Location: http://'.$_SERVER['SERVER_NAME'].'/ao/thanks.php');
		exit;
}


elseif (isset($submit)) {
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
	$poc_title		= trim($poc_title);
	$state			= trim($state);
	$topdog_name	= trim($topdog_name);
	$topdog_title	= trim($topdog_title);
	$vst_ex			= trim($vst_ex);
	$vst_no			= trim($vst_no);
	$years			= trim($years);
	$zip			= trim($zip);

	$errors = '';

	if (empty($name))
		$errors .= '<li>Dealership Name</li>';
	if (empty($dba))
		$errors .= '<li>Doing Business As</li>';
	if (empty($business))
		$errors .= '<li>Type of Business</li>';
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


	if (empty($errors)) {

		if (!isset($pmt_method))
			$pmt_method = array();
		else
			$payment_method = implode(",", $pmt_method);

		db_do("INSERT INTO dealers SET address1='$address1', address2='$address2', bd_account='$bd_account', " .
			"bd_name='$bd_name', bd_routing='$bd_routing', billing_address1='$billing_address1', " .
			"billing_address2='$billing_address2', billing_city='$billing_city', billing_state='$billing_state', " .
			"billing_zip='$billing_zip', business='$business', cc_ex='$cc_ex', cc_name='$cc_name', cc_no='$cc_no', " .
			"cc_type='$cc_type', city='$city', dba='$dba', dl_ex='$dl_ex', dl_no='$dl_no', ein='$ein', fax='$fax', " .
			"industry='$industry', name='$name', phone='$phone', poc_email='$poc_email', poc_f_name='$poc_f_name', poc_m_name='$poc_m_name', " .
			"poc_fax='$poc_fax', poc_l_name='$poc_l_name', poc_phone='$poc_phone', poc_title='$poc_title', state='$state', " .
			"topdog_name='$topdog_name', topdog_title='$topdog_title', vst_ex='$vst_ex', vst_no='$vst_no', " .
			"years='$years', zip='$zip', payment_method='$payment_method', charter_member='$charter_member', invoice='$invoice', no_of_stores='$no_of_stores',
			modified=NOW(), created=modified, status='pending', ae_id='$ae_id', notes='$notes'");

		$id = db_insert_id();
		$msg = "A new dealer has singed up online to the Go DEALER to DEALER network.

This is an Auto Opportuntiy dealer

---------------------------
Company    - $name
Address    - $address1
City/State - $city , $state
Zip        - $zip
---------------------------
Name  - $poc_f_name $poc_l_name
Title - $poc_title
Email - $poc_email
Phone - $phone
---------------------------

http://$SITE_NAME/admin/dealers/edit.php?id=$id
";
		mail('info@godealertodealer.com, daviddraeger@cox.net, jack@estesservices.com', 'New Dealer Signup - Auto Opportunity', $msg, $EMAIL_FROM);

		header('Location: http://' . $_SERVER['SERVER_NAME'] . '/ao/thanks1.php');
		exit;
	}

	db_disconnect();
}
else {

	if(isset($id)) {
		header('Location: index.php');
		exit;
	}

	$result = db_do("SELECT id FROM users WHERE username='$username'");
	list($user_id) = db_row($result);
	db_free($result);

	$result = db_do("SELECT id FROM aes WHERE user_id='$user_id'");
	list($ae_id) = db_row($result);
	db_free($result);

}


$title = 'Dealer / Financial Company Application';

?>

<html>
 <head>
  <title>Sign Up Form: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../site.css" title="site" />
 </head>
<?php include('../header.php'); ?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <?php include('_form_dealer.php'); ?>
<center><?php include('../footer.php'); ?></center>
 </body>
</html>
