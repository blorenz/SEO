<?php

/**
* The first page a user sees
* upon entering the site.
*
*
* $Id: index.php.tmpl 550 2006-09-14 21:36:01Z kaneda $
*/

$PHP_SELF = $_SERVER['PHP_SELF'];

include('../include/db.php');
db_connect();
extract(defineVars("password", "destination", "username", "model"));

$skip_privs = 1;
include('../include/session.php');

$result = db_do("SELECT SUM(no_of_stores) FROM dealers WHERE status='active'");
list($num_users) = db_row($result);
db_free($result);

$result = db_do("SELECT COUNT(*) FROM auctions WHERE status='closed'");
list($num_auctions) = db_row($result);
db_free($result);

$result = db_do("SELECT COUNT(*) FROM vehicles WHERE status='active'");
list($num_vehicles) = db_row($result);
db_free($result);

if (!empty($username) && !empty($password)) {
	$result = db_do("SELECT id, privs, dealer_id, access_level FROM users WHERE " .
	    "username='$username' AND password='$password' " .
	    "AND status='active'");
	if ($result && db_num_rows($result) == 1) {
		list($userid, $privs, $dealer_id, $access_level) = db_row($result);
		$privs = decode_privs($privs);
		$_SESSION['dealer_id']		= $dealer_id;
		$_SESSION['privs']			= $privs;
		$_SESSION['userid']			= $userid;
		$_SESSION['username']		= $username;
		$_SESSION['access_level']	= $access_level;

		if (has_priv('acctexec', $privs)) {
			$res = db_do("SELECT limited FROM aes where user_id =
				'$_SESSION[userid]'");
			list($limited) = db_row($res);
			$_SESSION['limited'] = $limited;
		}

      // log the users login time (defined in /include/db.php)
      gdtd_log_user_login($userid);


		if (!empty($destination)) {
			header("Location: $destination");
			$destination = '';
			session_unregister('destination');
		} elseif (has_priv('rgnalmngr', $privs)) {
		   header("Location: http://$_SERVER[SERVER_NAME]/rms/");
		} elseif (has_priv('dstrctmngr', $privs)) {
			header('Location: dms/index.php');
		} elseif (has_priv('acctexec', $privs)) {
			if ($password == '1234')
				header("Location: aes/tools/reset_pass.php?reset=1");
			else
				header('Location: aes/index.php');
		} else {
			if ($password == '1234')
				header("Location: auction/profile.php?reset=1");
			else
				header('Location: auction/');
		}
		exit;
	db_free($result);
	db_disconnect();
	}

}

if (!empty($username) && !empty($password)) {
	$result = db_do("SELECT COUNT(*) FROM users WHERE username='$username' AND password='$password' AND status='suspended'");
	list($count_sum) = db_row($result);
	if ($count_sum == 1) {
		header('Location: notice.php');
		exit;
	}
	db_free($result);
	db_disconnect();
}

?>

<html>
 <head>
  <title>Go DEALER to DEALER :::::: Log in</title>
  <link rel="stylesheet" type="text/css" href="site.css" title="site" />
<style type="text/css">
<!--
BODY { background: #000000; color: #FFFFFF; }
a:link {font-family:Arial, Helvetica, sans-serif;font-weight: bold;font-size:10pt;color:#FFFFFF;text-decoration:none;display:block;margin-top:0px;margin-bottom:0px;}
a:visited {font-family:Arial, Helvetica, sans-serif;font-weight: bold;font-size:10pt;color:#FFFFFF;text-decoration:none;display:block;margin-top:0px;margin-bottom:0px;}
a:hover {
	font-size: 10pt;
	text-decoration: none;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	background-color: #FF9900;
	color: #000000;
}

a.signup_img:hover {
   background: transparent;
}

.no_hover a:hover {
   background: transparent;
}

//.style1 {color: #33FF00}
.style1 {color: #33FF33}

.signupLinks a {
   text-decoration: none;
   color: blue;
   width: auto;
}
-->
 </style>
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
  <tr>
    <td align="right" valign="top"><font size="-1"><b>
      <?=$num_users?>
      </b> <font size="-2">DEALERS</font> | <b>
      <?=$num_auctions?>
      </b> <font size="-2">COMPLETED AUCTIONS</font> | <b>
      <?=$num_vehicles?>
      </b> <font size="-2">ITEMS</font></font>&nbsp;&nbsp;</td>
  </tr>
</table>

<?php include('header.php'); ?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td background="images/index/4.gif"><img src="images/index/3.gif" height="32" width="738" /></td>
	<td width="100%" background="images/index/4.gif">
   </td>
  </tr>
</table>
<table width="855" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="225" height="208" background="images/index/5.gif" valign="top" class="normal">
      <p></p>
    </td>
    <td width="10"></td>
    <td width="7"></td>
    
    <td width="212" valign="top" class="normal"> 
      <p align="center"><span class="style1  huge">Online Information <br>
        <br>
        </span> 
		<a href="tutorialspage.php">-&nbsp;Video Tutorials</a> 
		<a href="docs/testimonials">-&nbsp;Testimonials</a> 
		<a href="docs/presentations">-&nbsp;Online Presentations </a> 
		<a href="docs/press">-&nbsp;Press Release</a> 
		<a href="docs/about">-&nbsp;About Us</a> 
		<a href="docs/affiliations">-&nbsp;Affiliations</a> 
		<a href="faq.php">-&nbsp;FAQ's</a> 
        <a href="docs/demos">-&nbsp;Online Demos </a> </p>
    </td>
	<td width="10"></td>
    <td width="213" valign="top" class="normal"> 
      <p>&nbsp;</p>
      <p><br>
        <a class=signup_img href="cioletter.php"><img src="images/index/signuphere.jpg" alt="Sign Up HERE!" width="190" height="97" border="0"></a></p>
	  </td>
		
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td background="images/index/7.gif"><img src="images/index/6.gif" height="35" width="738" /></td>
    <td background="images/index/7.gif" width="100%">&nbsp;</td>
   </tr>
   </table>
<div align="center">
  
</div>
<table border="0" cellpadding="0" cellspacing="0">
  
   <tr>
    <td background="images/index/9.gif"><img src="images/index/8.gif" height="20" width="738" /></td>
    <td background="images/index/9.gif" width="100%">&nbsp;</td>
   </tr>
   <tr>
    <td background="images/index/11.gif"><p><img src="images/index/10.gif" height="80" width="738" /></p>
     </td>
    <td background="images/index/11.gif" width="100%">&nbsp;</td>
   </tr>
   <tr align="center">
    <td height="70" colspan="3" class="small"><div align="center">
     
        <p><font color="#FFFFFF"><i>
          <?php include('footer.php'); ?>
          </i></font></p>
    </div></td>
  </tr>
</table>
 
<font color="#FFFFFF"><i></i></font> 
</body>


</html>
