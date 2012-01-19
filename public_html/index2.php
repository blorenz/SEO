
<?php

$PHP_SELF = $_SERVER['PHP_SELF'];


if(!empty($_REQUEST['username']))
	$username = $_REQUEST['username'];
else
	$username = "";


?>



<?php

/**
* The first page a user sees
* upon entering the site.
*
*
* $Id: index.php.tmpl 550 2006-09-14 21:36:01Z kaneda $
*/



include('../include/db.php');
db_connect();

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
		session_register('dealer_id');
		session_register('privs');
		session_register('userid');
		session_register('username');
		session_register('access_level');

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
    <td align="right" valign="top"><font size="-1"><b><?=$num_users?></b>
	   	<font size="-2">DEALERS</font> | <b><?=$num_auctions?></b>
		<font size="-2">COMPLETED AUCTIONS</font> | <b><?=$num_vehicles?></b>
		<font size="-2">ITEMS</font></font>&nbsp;&nbsp;<font color="#FFFFFF" size="-1">
	</td>
  </tr>
</table>

<?php include('header.php'); ?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td background="images/index/4.gif"><img src="images/index/3.gif" height="32" width="738" /></td>
	<td width="100%" background="images/index/4.gif">
   </td>
  </tr>
</table><table width="855" border="0" cellpadding="0" cellspacing="0">
	<tr>
	  <td width="225" height="208" background="images/index/5.gif" valign="top" class="normal"><p></p>
     </td>
		<td width="10"></td>
		<td width="188">
			<table border="0" cellpadding="0" cellspacing="0"><form action="<?=$PHP_SELF?>" method="post">
				<tr>
					<td height="30" valign="bottom" class="big"><font color="#FF9900"><b>Username:&nbsp;</b></font></td>
					<td height="30" valign="bottom" class="normal"><input type="text" name="username" size="16" value="<?=$username?>" /></td>
				</tr>
				<tr>
					<td height="30" valign="bottom" class="big"><font color="#FF9900"><b>Password:&nbsp;</b></font><br></td>
					<td height="30" valign="bottom" class="normal"><input type="password" name="password" size="16" /></td>
				</tr>
            <tr>
					<td></td>
					<td height="30" valign="bottom" class="normal"><input type="submit" name="submit" value="Enter Site" /></td>
				</tr>
            <tr>
               <td colspan="2">
               <a style="display: inline;" href="forgotUser.php">Forgot Username</a> <br /> <a href="forgotPass.php" style="display: inline;">Forgot Password</a>
               </td>
            </tr>
			</form></table>
		</td>
		<td width="7"></td>
		<td width="213" valign="top" class="normal"><p><a class=signup_img href="cioletter.php"><img src="images/index/signuphere.jpg" alt="Sign Up HERE!" width="190" height="97" border="0"></a><br>
		  <a class=signup_img href="register.php"><img src="images/requestinfo.jpg" alt="Request Info" width="199" height="76" border="0"></a>	      </p>
	  </td>
		<td width="212" valign="top" class="normal"><p align="left"><span class="style1  huge">Online Information
			<br>
   		<br>
		    </span>
			<a href="brochure.php">-&nbsp;Online Brochure</a>
			<a href="docs/testimonials">-&nbsp;Testimonials</a>
			<a href="docs/presentations">-&nbsp;Online Presentations <span style="color:red;">NEW!</span></a>
          <a href="docs/businessops">-&nbsp;Business
			Opportunities</a>
			<a href="docs/press">-&nbsp;Press Release</a>			<a href="docs/about">-&nbsp;About
			Us</a>
            <a href="docs/affiliations">-&nbsp;Affiliations</a>
          <a href="faq.php">-&nbsp;FAQ's</a>
		    <a href="docs/demos">-&nbsp;Online Demos <span style="color:red;">NEW!</span></a>
		    <a href="docs/support">-&nbsp;Support</a>
		  </p>
	  </td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td background="images/index/7.gif"><img src="images/index/6.gif" height="35" width="738" /></td>
    <td background="images/index/7.gif" width="100%">&nbsp;</td>
   </tr>
   <tr>
    <td background="images/index/9.gif"><img src="images/index/8.gif" height="68" width="738" /></td>
    <td background="images/index/9.gif" width="100%">&nbsp;</td>
   </tr>
   <tr>
    <td background="images/index/11.gif"><p><img src="images/index/10.gif" height="80" width="738" /></p>
     </td>
    <td background="images/index/11.gif" width="100%">&nbsp;</td>
   </tr>
   <tr align="center">
    <td height="126" colspan="3" class="small"><div align="center">
     <font color="#FFFFFF"><i>

   <div class="no_hover">

	  <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" SRC="//smarticon.geotrust.com/si.js"></SCRIPT>

     </div>

	 <img src="images/e-trust.gif" width="91" height="73" border="0" usemap="#Map"></i></font><font color="#FFFFFF"><i>
<img src="images/echeck1.gif" width="75" height="100"><br>
        <img src="images/creditcards1.gif" width="400" height="59" border="0" usemap="#Map2">        </i></font>
<p><font color="#FFFFFF"><i>
          <?php include('footer.php'); ?>
          </i></font></p>
    </div></td>
  </tr>
</table>
 <font color="#FFFFFF"><i></i></font>
 <map name="Map">
   <area shape="rect" coords="2,1,91,72" href="https://services.choicepoint.net/get.jsp?GT78522760" target="_blank">
 </map>
 <map name="Map2">
   <area shape="rect" coords="12,4,127,56" href="http://www.americanexpress.com" target="_blank">
   <area shape="rect" coords="144,6,215,53" href="http://www.visa.com" target="_blank">
   <area shape="rect" coords="233,7,305,54" href="http://www.mastercard.com" target="_blank">
   <area shape="rect" coords="320,7,393,55" href="http://www.discovercard.com" target="_blank">
 </map>
 </body>


</html>
