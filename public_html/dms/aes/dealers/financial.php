<?php

include('../../../../include/session.php');
include('../../../../include/defs.php');
include('../../../../include/states.php');
include('../../../../include/db.php');
db_connect();
	
if (!isset($did)) {
	header("Location: index.php?id=$id");
	exit;
}

$dm_id = findDMid($username);
if (empty($dm_id)) {
	header('Location: https://www.godealertodealer.com');
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
				fb_state='$fb_state', fb_zip='$fb_zip', fb_phone='$fb_phone', fb_fax='$fb_fax', fb_account='$fb_account' WHERE id='$did'");

		header("Location: index.php?id=$id");
		exit;
	}

	db_disconnect();
}
else {
	
	if(!isset($did)) {
		header("Location: index.php?id=$id");
		exit;
	}
	
	$result = db_do("SELECT id FROM users WHERE username='$username'");
	list($user_id) = db_row($result);
	db_free($result);
	
	$result = db_do("SELECT id FROM aes WHERE user_id='$user_id'");
	list($ae_id) = db_row($result);
	db_free($result);
	
	$result = db_do("SELECT id FROM dealers WHERE ae_id='$ae_id' AND id='$did'");
	
	if (db_num_rows($result) <= 0) {
		$result = db_do("SELECT id FROM dms WHERE user_id='$user_id'");
		list($dm_id) = db_row($result);
		db_free($result);
		
		$result = db_do("SELECT dealers.id FROM dealers, aes, dms WHERE dealers.ae_id=aes.id " .
		"AND aes.dm_id = dms.id AND dealers.id='$did'");

	}
	if (db_num_rows($result) <= 0) {
		header("Location: index.php?id=$id");
		exit;
	}
	db_free($result);
	
	$result = db_do("SELECT name, fb_name, fb_address1, fb_address2, fb_city, fb_state,
					fb_zip, fb_phone, fb_fax, fb_account FROM dealers WHERE id='$did'");
	
	list($name, $fb_name, $fb_address1, $fb_address2, $fb_city, $fb_state,
					$fb_zip, $fb_phone, $fb_fax, $fb_account) = db_row($result);
}
$page_title = 'Dealer / Financial Account / Financial Release';

?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>

 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../../header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p><br>
  <?php include('_form_financial.php'); ?>
  <?php include('../../footer.php'); ?> 
 </body>
</html>	