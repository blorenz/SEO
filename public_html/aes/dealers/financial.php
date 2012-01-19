<?php

include('../../../include/session.php');
include('../../../include/defs.php');
include('../../../include/states.php');
include('../../../include/db.php');
db_connect();
	
if (empty($id)) {
	header('Location: index.php');
	exit;
}

if (isset($submit)) {
	$fb_name	= trim($fb_name);
	$fb_address1 = trim($fb_address1);
	$fb_address2 = trim($fb_address2);
	$fb_city	= trim($fb_city);
	$fb_state	= trim($fb_state);
	$fb_zip		= trim($fb_zip);
	$fb_phone	= trim($fb_phone);
	$fb_fax		= trim($fb_fax);
	$fb_account	= trim($fb_account);

	$errors = '';
	
	if (empty($fb_name))
		$errors .= '<li>Financial Bank Name</li>';
	if (empty($fb_address1)) {
		$errors .= '<li>Financial Bank Address</li>';
		$fb_address2 = '';
	}
	if (empty($fb_city))
		$errors .= '<li>Financial Bank City</li>';
	if (empty($fb_state))
		$errors .= '<li>Financial Bank State</li>';
	if (empty($fb_zip))
		$errors .= '<li>Financial Bank Zip</li>';
	if (empty($fb_phone))
		$errors .= '<li>Financial Bank Phone</li>';
	if (empty($fb_fax))
		$errors .= '<li>Financial Bank Fax</li>';
	if (empty($fb_account))
		$errors .= '<li>Financial Bank Account #</li>';		
		
	if (empty($errors)) {
		db_do("UPDATE dealers SET fb_name='$fb_name', fb_address1='$fb_address1', fb_address2='$fb_address2', fb_city='$fb_city', 
				fb_state='$fb_state', fb_zip='$fb_zip', fb_phone='$fb_phone', fb_fax='$fb_fax', fb_account='$fb_account' WHERE id='$id'");

		header('Location: index.php');
		exit;
	}

	db_disconnect();
}
else {
	
	if(!isset($id)) {
		header('Location: index.php');
		exit;
	}
	
	$result = db_do("SELECT id FROM users WHERE username='$username'");
	list($user_id) = db_row($result);
	db_free($result);
	
	$result = db_do("SELECT id FROM aes WHERE user_id='$user_id'");
	list($ae_id) = db_row($result);
	db_free($result);
	
	$result = db_do("SELECT id FROM dealers WHERE ae_id='$ae_id' AND id='$id'");
	if (db_num_rows($result) <= 0) {
		header('Location: index.php');
		exit;
	}
	db_free($result);
	
	$result = db_do("SELECT name, fb_name, fb_address1, fb_address2, fb_city, fb_state,
					fb_zip, fb_phone, fb_fax, fb_account FROM dealers WHERE id='$id'");
	
	list($name, $fb_name, $fb_address1, $fb_address2, $fb_city, $fb_state,
					$fb_zip, $fb_phone, $fb_fax, $fb_account) = db_row($result);
}
$page_title = 'AE Edit Financial Info';

?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?><?php include('_links.php'); ?>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p> 
  <?php include('_form_financial.php'); ?>
  <?php include('../footer.php'); ?> 
 </body>
</html>	