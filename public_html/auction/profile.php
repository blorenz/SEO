<?php
#
# Copyright (c) 2006 Go DEALER to DEALER
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
# $srp: godealertodealer.com/htdocs/auction/profile.php,v 1.6 2002/10/14 23:52:21 Exp $
#

$page_title = 'My Profile Data';
$help_page = "chp7.php#Chp7_Edityourpersonaldata";


$PHP_SELF = $_SERVER['PHP_SELF'];

include('../../include/session.php');
extract(defineVars("first_name", "last_name", "pw1", "pw2", "email", "address1",
"address2", "city", "state", "zip",  "phone", "fax", "submit",
 "q", "no_menu", "reset"));


$pw1        = trim($pw1);
$pw2        = trim($pw2);
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

include('../../include/db.php');
db_connect();

if (isset($submit)) {
	if (!empty($pw1) && !empty($pw2) && $pw1 != $pw2) {
		$errors .= '<li>Passwords must match.</li>';
		$pw1 = '';
		$pw2 = '';
	}

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

	$p = clean_phone_number($phone);
	if (empty($p))
		$errors .= '<li>You must supply a valid phone number.</li>';
	else
		$phone = $p;

	$fax = clean_phone_number($fax);

	if (empty($errors)) {
		db_do("UPDATE users SET email='$email', " .
		    "first_name='$first_name', last_name='$last_name', " .
		    "address1='$address1', address2='$address2', " .
		    "city='$city', state='$state', zip='$zip', " .
		    "phone='$phone', fax='$fax' WHERE id='$userid'");

		if (!empty($pw1))
			db_do("UPDATE users SET password='$pw1' WHERE " .
			    "id='$userid'");

		db_disconnect();

		header('Location: index.php');
		exit;
	}
} else {
	$result = db_do("SELECT email, first_name, last_name, " .
	    "users.address1, users.address2, users.city, users.state, " .
	    "users.zip, users.phone, users.fax, dealers.name FROM " .
	    "users, dealers WHERE users.id='$userid' AND " .
	    "dealers.id='$dealer_id'");

	list($email, $first_name, $last_name, $address1, $address2, $city,
	    $state, $zip, $phone, $fax, $dealer_name) = db_row($result);
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

include('header.php');
?>
  <p align="center" class="big"><b>Edit My Personal Profile</b></p>
  <?php if ($reset == '1') { ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
    <td class="error">Please Confirm that all your information is correct and Create a new Password.<br></td>
   </tr>
  </table>  <? } ?>
  <?php if (!empty($errors)) { ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
    <td class="error">The following errors occurred:<br /><ul><?php echo $errors; ?></ul></td>
   </tr>
  </table>
<?php } ?>
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <input type="hidden" name="dealer_name" value="<?php echo $dealer_name; ?>" />
   <table align="center" border="0" cellspacing="0" cellpadding="2">
    <tr>
     <td align="right" class="header">Dealer:</td>
     <td class="big"><?php echo $dealer_name; ?></td>
    </tr>
    <tr>
     <td align="right" class="header">Username:</td>
     <td class="big"><?php echo $username; ?></td>
    </tr>
    <tr>
     <td align="right" class="header">Password:</td>
     <td class="normal"><input type="password" name="pw1" value="" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">Password again:</td>
     <td class="normal"><input type="password" name="pw2" value="" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">First Name:</td>
     <td class="normal"><input type="text" name="first_name" value="<?php echo $first_name; ?>" size="35" /></td>
    </tr>
    <tr>
     <td align="right" class="header">Last Name:</td>
     <td class="normal"><input type="text" name="last_name" value="<?php echo $last_name; ?>" size="35" /></td>
    </tr>
    <tr>
     <td align="right" class="header">E-mail Address:</td>
     <td class="normal"><input type="text" name="email" value="<?php echo $email; ?>" size="35" /></td>
    </tr>
    <tr>
     <td align="right" class="header">Address:</td>
     <td class="normal"><input type="text" name="address1" value="<?php echo $address1; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">&nbsp;</td>
     <td class="normal"><input type="text" name="address2" value="<?php echo $address2; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">City:</td>
     <td class="normal"><input type="text" name="city" value="<?php echo $city; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">State:&nbsp;</td>
     <td class="normal">
      <select name="state">
<?php
include('../../include/states.php');

reset($STATES);
while (list($key, $value) = each($STATES)) {
	echo "     <option value=\"$key\"";
	if ($state == $key)
		echo " selected";
	echo ">$value</option>\n";
}
?>
      </select>
     </td>
    </tr>
    <tr>
     <td align="right" class="header">Zip:</td>
     <td class="normal"><input type="text" name="zip" value="<?php echo $zip; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">Phone:</td>
     <td class="normal"><input type="text" name="phone" value="<?php echo $phone; ?>" size="35"></td>
    </tr>
    <tr>
     <td align="right" class="header">Fax:</td>
     <td class="normal"><input type="text" name="fax" value="<?php echo $fax; ?>" size="35"></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
     <td>&nbsp;</td>
     <td class="normal"><input type="submit" name="submit" value=" Update Profile " /></td>
    </tr>
   </table>
  </form>

<?php
db_disconnect();
include('footer.php');
?>
