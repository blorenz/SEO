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
# $srp: godealertodealer.com/htdocs/auction/users/add.php,v 1.3 2002/09/03 00:40:33 steve Exp $
#

include('../../../include/session.php');

extract(defineVars('submit', 'status', 'un', 'pw', 'email', 'first_name', 'last_name', 'address1', 'address2', 'city', 'zip', 'phone', 'fax', 'title', 'id', '_privs', 'no_menu', 'q')); //JJM 1/13/2010 RJM added everything but submit and status

if (!has_priv('users', $privs)) {
	header('Location: ../menu.php');
	exit;
}

$page_title = 'Add User';
$help_page = "chp7.htm#Chp7_Manageyourusers";

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

   if (empty($title)) {
      $errors .= '<li>You must supply a title.</li>';
   }

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

	$result = db_do("SELECT id FROM users WHERE username='$un'");
	if (db_num_rows($result) > 0)
		$errors .= '<li>Username already exists.</li>';
	db_free($result);

	if (empty($errors)) {
		$p = encode_privs($_privs);

		db_do("INSERT INTO users SET dealer_id='$dealer_id', " .
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

	$result = db_do("SELECT name, address1, address2, city, state, zip, phone, fax
						FROM dealers WHERE id='$dealer_id'");

	list($dealer, $address1, $address2, $city, $state, $zip, $phone, $fax) = db_row($result);
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

  <p align="center" class="big"><b>Add a User</b></p>

<?php
include('_links.php');
include('_form.php');
include('../footer.php');
db_disconnect();
?>
