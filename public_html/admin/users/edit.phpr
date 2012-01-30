<?php
#
# Copyright (c) 2002 Steve Price
# All rights reserved.
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions
# are met:
#
# 1. Redistributions of source code must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
# 2. Redistributions in binary form must reproduce the above copyright
#    notice, this list of conditions and the following disclaimer in the
#    documentation and/or other materials provided with the distribution.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
# ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
# FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
# DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
# OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
# HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
# LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
# OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
# SUCH DAMAGE.
#
# $srp: godealertodealer.com/htdocs/admin/users/edit.php,v 1.5 2002/10/14 23:52:53 steve Exp $
#

$page_title = 'Update User';

if (!empty($_REQUEST['id']))
	$id = $_REQUEST['id'];

if (empty($id) || $id <= 0) {
	header('Location: index.php');
	exit;
}

$skip_privs = 1;
include('../../../include/session.php');

if(!empty($_POST['did']))
	$did = $_POST['did'];

if(!empty($_POST['status']))
	$status = $_POST['status'];

if(!empty($_POST['_privs']))
	$_privs = $_POST['_privs'];

if (!isset($_privs) || !is_array($_privs))
	$_privs = array();

if(isset($_POST['un']))
	$un         = trim($_POST['un']);
if(isset($_POST['un2']))
	$un2         = trim($_POST['un2']);
if(isset($_POST['pw']))
	$pw         = trim($_POST['pw']);
if(isset($_POST['email']))
	$email      = trim($_POST['email']);
if(isset($_POST['first_name']))
	$first_name = trim($_POST['first_name']);
if(isset($_POST['last_name']))
	$last_name  = trim($_POST['last_name']);
if(isset($_POST['address1']))
	$address1   = trim($_POST['address1']);
if(isset($_POST['address2']))
	$address2   = trim($_POST['address2']);
if(isset($_POST['city']))
	$city       = trim($_POST['city']);
if(!empty($_POST['state']))
	$state = $_POST['state'];
if(isset($_POST['zip']))
	$zip        = trim($_POST['zip']);
if(isset($_POST['phone']))
	$phone      = trim($_POST['phone']);
if(isset($_POST['fax']))
	$fax        = trim($_POST['fax']);
if(isset($_POST['title']))
	$title        = trim($_POST['title']);
$errors     = '';

include('../../../include/db.php');
db_connect();

if (isset($_POST['submit'])) {
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

	$phone = clean_phone_number($phone);
	if (empty($phone))
		$errors .= '<li>You must supply a valid phone number.</li>';

	if($un != $un2)
	{
		$result = db_do("SELECT id FROM users WHERE username='$un'");
		if (db_num_rows($result) > 0)
			$errors .= '<li>Username already exists.</li>';
		db_free($result);
	}

	if (empty($errors)) {
		$p = encode_privs($_privs);

		db_do("UPDATE users SET dealer_id='$did', username='$un', " .
		    "password='$pw', email='$email', " .
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
	$result = db_do("SELECT dealer_id, username, password, email, " .
	    "first_name, last_name, address1, address2, city, state, zip, " .
	    "phone, fax, privs, status, title FROM users WHERE id='$id'");

	list($did, $un, $pw, $email, $first_name, $last_name, $address1,
	    $address2, $city, $state, $zip, $phone, $fax, $_privs, $status, $title) =
	    db_row($result);

	$un2 = $un;

	$_privs = decode_privs($_privs);
}

$un         = stripslashes($un);
$un2        = stripslashes($un2);
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
<?php include('_form.php'); ?>
 </body>
</html>
