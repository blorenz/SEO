<?php

include('../../../include/session.php');
extract(defineVars("id", "submit", "un", "pw", "email", "first_name", "last_name", "address1", "address2", "city", "zip", "phone", "fax", "_privs", "status")); //JJM 1/12/2010 Added to get form variables

if (!has_priv('users', $privs)) {
	header('Location: ../menu.php');
	exit;
}

$page_title = 'Update User';
$help_page = "chp7.htm#Chp7_Manageyourusers";

if (empty($id) || $id <= 0) {
	header('Location: index.php');
	exit;
}

if (!is_array($_privs))
	$_privs = array();

$un         = trim($un);
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

	if (!ereg("^.+@.+\\..+$", $email))
		$errors .= '<li>You must supply a valid email address.</li>';

	if (empty($errors)) {
		$p = encode_privs($_privs);

		db_do("UPDATE users SET password='$pw', email='$email', " .
		    "first_name='$first_name', last_name='$last_name', title='$title', " .
		    "address1='$address1', address2='$address2', " .
		    "city='$city', state='$state', zip='$zip', " .
		    "phone='$phone', fax='$fax', privs='$p', " .
		    "status='$status' WHERE id='$id'");

		db_disconnect();

		header('Location: index.php');
		exit;
	}
} else {
	$result = db_do("SELECT username, password, email, first_name, " .
	    "last_name, address1, address2, city, state, zip, phone, fax, " .
	    "privs, status, title FROM users WHERE id='$id' AND " .
	    "dealer_id='$dealer_id'");

	list($un, $pw, $email, $first_name, $last_name, $address1, $address2,
	    $city, $state, $zip, $phone, $fax, $_privs, $status, $title) =
	    db_row($result);

	db_free($result);
	$_privs = decode_privs($_privs);

	$result = db_do("SELECT name FROM dealers WHERE id='$dealer_id'");
	list($dealer) = db_row($result);
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

include('../header.php');
?>
  <br>
<?php
include('_links.php');
include('_form.php');
include('../footer.php');
db_disconnect();
?>
