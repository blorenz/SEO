<?php

include('../../../include/db.php');
db_connect();

extract(defineVars("id","un","un2","uid","pw","email","first_name","last_name",
				   "address1","address2","city","state","zip","phone","fax","ssn",
				   "status","submit"));  //JJM 08/29/2010

$page_title = 'Add District Manager';

$skip_privs = 1;
include('../../../include/session.php');

if (!is_array($_privs))
	$_privs = array();

$un   			= trim($un);
$pw         = trim($pw);
$email      = trim($email);
$first_name = trim($first_name);
$last_name  = trim($last_name);
$address1   = trim($address1);
$address2   = trim($address2);
$city       = trim($city);
$zip        = trim($zip);
$phone      = trim($phone);
$fax        = trim($fax);
$ssn        = trim($ssn);
$errors     = '';

if (isset($submit)) {
  if (empty($un))
		$errors .= '<li>You must supply a username.</li>';

	if (empty($pw))
		$errors .= '<li>You must supply a password.</li>';

	if (!ereg("^.+@.+\\..+$", $email))
		$errors .= '<li>You must supply a valid email address.</li>';

	if (empty($first_name))
		$errors .= '<li>You must supply a first name.</li>';

	if (empty($last_name))
		$errors .= '<li>You must supply a last name.</li>';

	if (empty($address1)) {
		$address2 = '';
		$errors .= '<li>You must supply an address.</li>';
	}

	if (empty($city))
		$errors .= '<li>You must supply a city.</li>';

	if (empty($zip))
		$errors .= '<li>You must supply a zipcode.</li>';

	$phone = clean_phone_number($phone);
	if (empty($phone))
		$errors .= '<li>You must supply a valid phone number.</li>';

	$fax = clean_phone_number($fax);

	if (empty($ssn))
		$errors .= '<li>You must supply a Social Security Number.</li>';

	$result = db_do("SELECT id FROM users WHERE username='$un'");
	if (db_num_rows($result) > 0)
		$errors .= '<li>Username already exists.</li>';
	db_free($result);

	if (empty($errors)) {
		$_privs[] = 'dstrctmngr';
		$p = encode_privs($_privs);

     db_do("INSERT INTO users SET dealer_id='0', " .
		    "username='$un', password='$pw', " .
		    "email='$email', first_name='$first_name', " .
		    "last_name='$last_name', address1='$address1', " .
		    "address2='$address2', city='$city', state='$state', " .
		    "zip='$zip', phone='$phone', fax='$fax', privs='$p', " .
		    "status='$status', modified=NOW(), created=modified");

		 $uid = db_insert_id();

		db_do("INSERT INTO dms SET user_id=$uid, email='$email', " .
		    "first_name='$first_name', last_name='$last_name', " .
		    "address1='$address1', address2='$address2', " .
		    "city='$city', state='$state', zip='$zip', " .
		    "phone='$phone', fax='$fax', ssn='$ssn', " .
		    "status='$status', modified=NOW(), created=modified");

		 $dmid = db_insert_id();

		db_do("INSERT INTO aes SET dm_id='$dmid', user_id=$uid, email='$email', " .
		    "first_name='$first_name', last_name='$last_name', " .
		    "address1='$address1', address2='$address2', " .
		    "city='$city', state='$state', zip='$zip', " .
		    "phone='$phone', fax='$fax', ssn='$ssn', " .
		    "status='$status', modified=NOW(), created=modified");

		db_disconnect();

		header('Location: index.php');
		exit;
	}
} else {
	$useridresult = db_do("SELECT id, username FROM users " .
	    "WHERE status='active' and locate('dstrctmngr', privs) > 0");
}

$email      = stripslashes($email);
$first_name = stripslashes($first_name);
$last_name  = stripslashes($last_name);
$address1   = stripslashes($address1);
$address2   = stripslashes($address2);
$city       = stripslashes($city);
$zip        = stripslashes($zip);
$phone      = stripslashes($phone);
$fax        = stripslashes($fax);
$ssn        = stripslashes($ssn);


if (empty($status))
	$status = 'active';
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
  <p align="center" class="big"><b>Add User</b></p>
<?php include('_form.php'); ?>
 </body>
</html>