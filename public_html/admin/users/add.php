<?php

$page_title = 'Add User';

$skip_privs = 1;
include('../../../include/session.php');

extract(defineVars("PHP_SELF","first_name","last_name","address1","phone","fax",
				   "email","address2","city","state","zip","un","did","pw",
				   "_privs","title","id","un2","submit","id","un2","title","status"));


if (!is_array($_privs))
	$_privs = array();

$un   = trim($un);
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
$errors     = '';

include('../../../include/db.php');
db_connect();

if (isset($submit)) {
	if (empty($did))
		$errors .= '<li>You must select a dealer.</li>';

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

	if (empty($title))
		$errors .= '<li>You must supply a title.</li>';

	if (empty($address1)) {
		$address2 = '';
		$errors .= '<li>You must supply an address.</li>';
	}

	if (empty($city))
		$errors .= '<li>You must supply a city.</li>';

	if (empty($zip))
		$errors .= '<li>You must supply a zipcode.</li>';

	if (!ereg("^.+@.+\\..+$", $email))
		$errors .= '<li>You must supply a valid email address.</li>';

	$p = clean_phone_number($phone);
	if (empty($p))
		$errors .= '<li>You must supply a valid phone number.</li>';
	else
		$phone = $p;

	$result = db_do("SELECT id FROM users WHERE username='$un'");
	if (db_num_rows($result) > 0)
		$errors .= '<li>Username already exists.</li>';
	db_free($result);

	if (empty($errors)) {
		$p = encode_privs($_privs);

		db_do("INSERT INTO users SET dealer_id='$did', " .
		    "username='$un', password='$pw', " .
		    "email='$email', first_name='$first_name', " .
		    "last_name='$last_name', title='$title', address1='$address1', " .
		    "address2='$address2', city='$city', state='$state', " .
		    "zip='$zip', phone='$phone', fax='$fax', privs='$p', " .
		    "status='$status', modified=NOW(), created=modified");

		db_disconnect();

		header('Location: index.php');
		exit;
	}
}
else {

	$result = db_do("SELECT address1, address2, city, state, zip, phone, fax FROM dealers WHERE id='$did'");

	list($address1, $address2, $city, $state, $zip, $phone, $fax) = db_row($result);
	db_free($result);
}

$un         = stripslashes($un);
$pw         = stripslashes($pw);
$email      = stripslashes($email);
$first_name = stripslashes($first_name);
$last_name  = stripslashes($last_name);
$address1   = stripslashes($address1);
$address2   = stripslashes($address2);
$city       = stripslashes($city);
$zip        = stripslashes($zip);
$phone      = stripslashes($phone);
$fax        = stripslashes($fax);

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
