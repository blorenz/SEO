<?php
/**
 * $Id$
 */

$_pagetitle = "RM Tools";
include "$_SERVER[DOCUMENT_ROOT]/rms/libs/header.php";

$info = $rm->getRMInfo();
?>

<script type="text/javascript">

function checkPass()
{
	oldpass = document.getElementById('oldpass').value;
	newpass1 = document.getElementById('newpass1').value;
	newpass2 = document.getElementById('newpass2').value;
	
	errors = false;
	errorMsg = "The following errors occured:\n";
	if (oldpass != '' AND newpass1 != '') { 
		if (newpass1 != newpass2) {
			errors = true;
			errorMsg += "Old password and new password do not match.\n";
		}
		
		if (oldpass != "<?php echo trim($info[0]['password']); ?>") {
			errors = true;
			errorMsg += "Old password is incorrect.\n";
		}
	
		if (errors) {
			alert(errorMsg);
		}
	}
		
	return !errors;
}

</script>

<?php

if (isset($_POST['submit'])) {
	
   if (!empty($_POST['oldpass']) && !empty($_POST['newpass1']) && !empty($_POST['newpass2'])) {
	   
      $error = false;
	   
      if ($_POST['newpass1'] != $_POST['newpass2']) {
	      $error = true;
      } else {
	   	try {
         	$rm->changePassword($_POST['oldpass'], $_POST['newpass1']);
	   	}
	   	catch (Exception $e) {
	   	   $error = true;
	   	}
	   }
      
	}

	$rm->updateProfile($_POST['corp_name'], $_POST['first_name'], $_POST['last_name'],
		$_POST['address1'], $_POST['address2'], $_POST['city'], $_POST['state'], $_POST['zip'],
		$_POST['email'], $_POST['phone'], $_POST['fax']);

	?>
	<center>
	<h1>Thanks</h1>
	<p>Your information has successfully been updated.</p>
	<?php 
	if($error) {
	   ?>
	   <h1>However</h1>
	   <p>There was an error changing your password -- it has not been changed.</p>
	   <?php
	}
	?>
	</center>
	<?php
	include 'footer.php';
	die();
}
?>

<center>
<h1>My Profile</h1>

<form name="profile" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<table class="dm_info" style="width: 50%;">
	<tr>
		<th colspan="2">Change Password</th>
	</tr>
	<tr>
		<th>Current Password</th>
		<td><input type="password" name="oldpass" id="oldpass" /></td>
	</tr>
	<tr>
		<th>New Password</th>
		<td><input type="password" name="newpass1" id="newpass1" /></td>
	</tr>
	<tr>
		<th>Repeat New Password</th>
		<td><input type="password" name="newpass2" id="newpass2" /></td>
	</tr>
</table>
<br />

<table class="dm_info" style="width: 50%">
	<tr>
		<th colspan="2">Profile</th>
	</tr>
	<tr>
		<th>Company Name:</th>
		<td><input type="text" name="corp_name" value="<?php echo $info[0]['corp_name'] ?>" /></td>
	</tr>
	<tr>
		<th>First Name:</th>
		<td><input type="text" name="first_name" value="<?php echo $info[0]['first_name'] ?>" /></td>
	</tr>
	<tr>
		<th>Last Name:</th>
		<td><input type="text" name="last_name" value="<?php echo $info[0]['last_name'] ?>" /></td>
	</tr>
	<tr>
		<th>Address 1:</th>
		<td><input type="text" name="address1" value="<?php echo $info[0]['address1'] ?>" /></td>
	</tr>
	<tr>
		<th>Address 2:</th>
		<td><input type="text" name="address2" value="<?php echo $info[0]['address2'] ?>" /></td>
	</tr>
	<tr>
		<th>City:</th>
		<td><input type="text" name="city" value="<?php echo $info[0]['city'] ?>" /></td>
	</tr>
	<tr>
		<th>State:</th>
		<td><input type="text" name="state" value="<?php echo $info[0]['state'] ?>" 
			size="3" maxlength="2" /></td>
	</tr>
	<tr>
		<th>ZIP:</th>
		<td><input type="text" name="zip" value="<?php echo $info[0]['zip'] ?>" 
			size="10" maxlength="9" /></td>
	</tr>
	<tr>
		<th>Email:</th>
		<td><input type="text" name="email" value="<?php echo $info[0]['email'] ?>" 
			size="40" /></td>
	</tr>
	<tr>
		<th>Phone:</th>
		<td><input type="text" name="phone" value="<?php echo $info[0]['phone'] ?>" /></td>
	</tr>
	<tr>
		<th>Fax:</th>
		<td><input type="text" name="fax" value="<?php echo $info[0]['fax'] ?>" /></td>
	</tr>
</table>

<input type="submit" value="Update Profile" name="submit" onclick="javascript: return checkPass();" />
</form>
</center>

<?php
include 'footer.php';
?>
