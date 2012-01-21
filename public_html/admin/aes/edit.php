<?php

include('../../../include/db.php');
db_connect();

extract(defineVars("un","uid","pw","email","first_name","last_name",
				   "address1","address2","city","zip","phone","fax",
				   "ssn","limited","submit","id","dm_id","un2","status",
				   "limited","submit")); //JJM 8/30/2010

$page_title = 'Update Account Executive';

if (empty($id) || $id <= 0) {
	header('Location: index.php');
	exit;
}

$un   		= trim($un);
$uid		= trim($uid);
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
$limited        = trim($limited);
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
	if($un != $un2)
	{
		$result = db_do("SELECT id FROM users WHERE username='$un'");
		if (db_num_rows($result) > 0)
			$errors .= '<li>Username already exists.</li>';
		db_free($result);
	}

	if (empty($uid))
		$errors .= '<li>You must supply a User Name.</li>';

	if (empty($status))
		$errors .= '<li>You must supply a Status.</li>';

	if (empty($errors)) {

		if ( $status == 'inactive' )
			$status_user = 'suspended';
		else
			$status_user = $status;

		db_do("UPDATE aes SET dm_id='$dm_id', user_id=$uid, email='$email', first_name='$first_name', last_name='$last_name',
			address1='$address1', address2='$address2', city='$city', state='$state', zip='$zip', phone='$phone', fax='$fax',
			ssn='$ssn', status='$status', limited='$limited'  WHERE id='$id'");
		db_do("UPDATE users SET username='$un', password='$pw', email='$email', first_name='$first_name', last_name='$last_name',
			address1='$address1', address2='$address2', city='$city', state='$state', zip='$zip', phone='$phone', fax='$fax',
			status='$status_user' WHERE id='$uid'");


		db_disconnect();

		header('Location: index.php');
		exit;
	}
} else {
	$result = db_do("SELECT dm_id, user_id, email, first_name, last_name, address1, address2, city, state, zip, phone, fax, ssn, status, limited
					FROM aes WHERE id='$id'");
	list($dm_id, $user_id, $email, $first_name, $last_name, $address1, $address2, $city, $state, $zip, $phone, $fax, $ssn, $status, $limited) = db_row($result);

	$result = db_do("SELECT users.id, users.username, users.password FROM users, aes WHERE aes.id='$id' AND aes.user_id = users.id");
	list($uid, $un, $pw) = db_row($result);
	$un2 = $un;
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
<?php include('_form.php'); ?>
 </body>
</html>