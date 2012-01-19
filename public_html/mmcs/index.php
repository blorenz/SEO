

<?php
//Randy added//

$PHP_SELF = $_SERVER['PHP_SELF'];

if(!empty($_REQUEST['poc_name']))
	$poc_name = $_REQUEST['poc_name'];
else
	$poc_name = "";

if(!empty($_REQUEST['poc_title']))
	$poc_title = $_REQUEST['poc_title'];
else
	$poc_title = "";

if(!empty($_REQUEST['poc_email']))
	$poc_email = $_REQUEST['poc_email'];
else
	$poc_email = "";


if(!empty($_REQUEST['topdog_name']))
	$topdog_name = $_REQUEST['topdog_name'];
else
	$topdog_name = "";


if(!empty($_REQUEST['topdog_title']))
	$topdog_title = $_REQUEST['topdog_title'];
else
	$topdog_title = "";

if(!empty($_REQUEST['industry']))
	$industry = $_REQUEST['industry'];
else
	$industry = "";

if(!empty($_REQUEST['dealer']))
	$dealer = $_REQUEST['dealer'];
else
	$dealer = "";

if(!empty($_REQUEST['sdid']))
	$sdid = $_REQUEST[' sdid'];
else
	$sdid = "";

if(!empty($_REQUEST['address1']))
	$address1 = $_REQUEST['address1'];
else
	$address1 = "";


if(!empty($_REQUEST['address2']))
	$address2 = $_REQUEST['address2'];
else
	$address2 = "";


if(!empty($_REQUEST['city']))
	$city = $_REQUEST['city'];
else
	$city = "";

if(!empty($_REQUEST['state']))
	$state = $_REQUEST['state'];
else
	$state = "";

if(!empty($_REQUEST['zip']))
	$zip = $_REQUEST['zip'];
else
	$zip = "";
if(!empty($_REQUEST['phone']))
	$phone = $_REQUEST['phone'];
else
	$phone = "";


if(!empty($_REQUEST['fax']))
	$fax = $_REQUEST['fax'];
else
	$fax = "";

?>



<?php

include('../../include/defs.php');
include('../../include/states.php');

if (isset($submit)) {
	$poc_f_name	= trim($poc_f_name);
	$poc_l_name	= trim($poc_l_name);
	$poc_title	= trim($poc_title);
	$poc_email	= trim($poc_email);
	$topdog_name  = trim($topdog_name);
	$topdog_title = trim($topdog_title);
	$industry	= trim($industry);
	$dealer		= trim($dealer);
	$sdid		= trim($sdid);
	$address1	= trim($address1);
	$address2	= trim($address2);
	$city		= trim($city);
	$state		= trim($state);
	$zip		= trim($zip);
	$phone		= trim($phone);
	$fax		= trim($fax);

	include('../../include/db.php');
	db_connect();

	$errors = '';

	if (empty($poc_f_name))
		$errors .= '<li>Your First Name</li>';
	if (empty($poc_l_name))
		$errors .= '<li>Your Last Name</li>';
	if (empty($poc_title))
		$errors .= '<li>Your Title</li>';
	if (empty($poc_email) || !ereg("^.+@.+\\..+$", $poc_email))
		$errors .= '<li>Your Email Address</li>';
	if (empty($topdog_name))
		$errors .= '<li>Owner Name</li>';
	if (empty($topdog_title))
		$errors .= '<li>Owner Title</li>';
	if (empty($industry))
		$errors .= '<li>industry</li>';
	if (empty($dealer))
		$errors .= '<li>Dealership Name</li>';
	if (empty($address1)) {
		$errors .= '<li>Address</li>';
		$address2 = '';
	}
	if (empty($city))
		$errors .= '<li>City</li>';
	if (empty($state))
		$errors .= '<li>State</li>';
	if (empty($zip))
		$errors .= '<li>Zip</li>';
	if (empty($phone))
		$errors .= '<li>Phone</li>';
	if (!empty($referral_code)) {
		$result = db_do("SELECT COUNT(*) FROM reg_codes WHERE code='$referral_code'");
		list($count_code) = db_row($result);
		if ($count_code < 1)
			$errors .= '<li>Referral Code Does Not Exist</li>';
	}

	if (empty($errors)) {
		db_do("INSERT INTO dealers SET poc_f_name='$poc_f_name', poc_l_name='$poc_l_name'," .
		    "poc_title='$poc_title', poc_email='$poc_email', " .
		    "topdog_name='$topdog_name', industry='$industry', " .
		    "topdog_title='$topdog_title', name='$dealer', " .
		    "sdid='$sdid', address1='$address1', " .
		    "address2='$address2', city='$city', state='$state', " .
		    "zip='$zip', phone='$phone', fax='$fax', referral_code='$referral_code', modified=NOW(), " .
		    "created=modified, status='saved'");

		$id = db_insert_id();
		$msg = "A new dealer has registered for Go DEALER to DEALER and requires your approval.

		This is a MMCS dealer.
---------------------------
Company    - $dealer
Address    - $address1
City/State - $city , $state
Zip        - $zip
---------------------------
Name  - $poc_f_name $poc_l_name
Title - $poc_title
Email - $poc_email
Phone - $phone
---------------------------


http://$SITE_NAME/admin/dealers/edit.php?id=$id
";
		mail('info@goDEALERtoDEALER.com, julia@motorcyclemanagement.com', 'New Dealer - MMCS', $msg, $EMAIL_FROM);

		header('Location: https://' . $_SERVER['SERVER_NAME'] . '/mmcs/thanks.php');
		exit;
	}

	db_disconnect();
}

$title = 'Dealership Forms';

$poc_name	= stripslashes($poc_name);
$poc_title	= stripslashes($poc_title);
$poc_email	= stripslashes($poc_email);
$topdog_name	= stripslashes($topdog_name);
$topdog_title	= stripslashes($topdog_title);
$industry   = stripslashes($industry);
$dealer		= stripslashes($dealer);
$sdid		= stripslashes($sdid);
$address1	= stripslashes($address1);
$address2	= stripslashes($address2);
$city		= stripslashes($city);
$state		= stripslashes($state);
$zip		= stripslashes($zip);
$phone		= stripslashes($phone);
$fax		= stripslashes($fax);
?>

<html>
 <head>
  <title>Dealership Forms:::: MMCS</title>
  <link rel="stylesheet" type="text/css" href="../site.css" title="site" />
<style type="text/css">
<!--
BODY { background: #000000; color: #FFFFFF; }
a:link {font-family:Arial, Helvetica, sans-serif;font-weight: bold;font-size:10pt;color:#FFFFFF;text-decoration:none;margin-top:0px;margin-bottom:0px;}
a:visited {font-family:Arial, Helvetica, sans-serif;font-weight: bold;font-size:10pt;color:#FFFFFF;text-decoration:none;margin-top:0px;margin-bottom:0px;}
a:hover {
	font-size:10pt;
	text-decoration:underline;
	color:#FF9900;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
//.style1 {color: #FF8000}
.style1 {
	font-size: 24pt;
	font-weight: bold;
	color: #FF6600;
}
-->
 </style>
 </head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td background="../images/index/4.gif"><img src="../images/index/3.gif" height="32" width="738" /></td>
		<td width="100%" background="../images/index/4.gif">&nbsp;</td>
	</tr>
</table>
<table width="100%" height="354" border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td height="354" align="center">
     <form method="post" action="<?=$PHP_SELF?>">
      <table border="0" cellpadding="1" cellspacing="0">
       <tr>
        <td align="center" class="big"><p class="huge style1">Motorcycle Management Consulting Services </p>
          <p><b>
                <?=$title?>
</b></p>
          <p>To request more infomation, click <a href="request.php">HERE</a></p>
          <p>To sign up for the Online Wholesale Auction system for Dealers Only, click <a href="signup.php">HERE</a> </p></td>
       </tr>
<?php if (!empty($errors)) { ?>
<?php } ?>
	     <tr>
	     <td height="92"><div align="center">
	       <p><HR></p>
	       <p>Click <a href="../docs/useragreement.htm" target="_blank"><u>HERE</u></a> to view the <a href="../docs/useragreement.htm"><u>USER AGREEMENT</u></a><u><br>
	           </u>Click <a href="../docs/privacy_policy.html"><u>HERE</u></a> to view the <a href="../docs/privacy_policy.html"><u>PRIVACY
	           POLICY</u></a><u>
               <br>
               </u>Click <a href="../docs/arbitration_policy.htm"><u>HERE</u></a> to
               view the <a href="../docs/arbitration_policy.htm"><u>ARBITRATION POLICY</u></a> </p>
	     </div></td>
	   </tr>
      </table>
     </form>    </td>
    <td>&nbsp;</td>
   </tr>
</table>
<br>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td colspan="2"><img src="../images/index/6.gif" height="35" width="738" /></td>
		<td background="../images/index/7.gif" width="100%"></td>
	</tr>
	<tr>
		<td colspan="2"><img src="../images/index/8.gif" height="68" width="738" /></td>
		<td background="../images/index/9.gif" width="100%"></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" colspan="3" class="small"><font color="#FFFFFF"><i><?php include('../footer.php'); ?></i></font></td>
	</tr>
</table>
</body>
</html>
