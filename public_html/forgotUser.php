<?php

include('../include/defs.php');
include('../include/defineVars.php'); //JJM 08/28/2010
extract(defineVars("email"));

$title = 'Forgot Username';

if (!empty($email) && isset($email)) {
	include('../include/db.php');

	db_connect();
	$result = mysql_query("SELECT username, password FROM users WHERE " .
	    "email='$email' AND status='active'");

      while ($row = mysql_fetch_assoc($result)) {
         $resreset = mysql_query("UPDATE users SET password = '1234' WHERE username = '$row[username]' LIMIT 1");

		$msg = "Hello,

This is an auto-reply from goDEALERtoDEALER.

In response to your request, your username and password information
are as follows:

        username: $row[username]
        password: 1234

Please keep these for your records.  In order to access the auctions
to buy, sell, or simply browse all the great deals you'll need to have
these handy.

If you've received this email in error, please login with the provided
username and password and immediately change your password.

Thanks,
Go DEALER to DEALER
";
		mail("$email", "GoDEALERtoDEALER password information",
		    $msg, $EMAIL_FROM);
	}

	db_free($result);
	db_disconnect();

	header('Location: reminder.php');
	exit;
}
?>

<html>
 <head>
  <title><?=$title?></title>
  <link rel="stylesheet" type="text/css" href="site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('header.php'); ?>
  <br />
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
   <tr>
    <td align="center">
     <form method="post" action="<?=$PHP_SELF?>">
      <table align="center" border="0" cellpadding="1" cellspacing="0">
       <tr>
        <td align="center" class="huge" colspan="2"><b><?=$title?></b></td>
       </tr>
       <tr><td colspan="2"></td></tr>
       <tr>
        <td align="right" class="big"><b>Your Email Address:&nbsp;</b></td>
        <td class="big"><input type="text" name="email" size="32"></td>
       </tr>
       <tr>
        <td colspan="2"><p>Note: if you have more than one account linked to this email address, you will receive an email for each account.</p></td>
        </tr>
        <tr>
        <td class="big" colspan="2" align="center"><input type="submit" name="submit" value=" Send Reminder "></td>
       </tr>
      </table>
     </form>
    </td>
    <td>&nbsp;</td>
   </tr>
   <tr><td>&nbsp;</td></tr>
   <tr>
    <td align="center" class="small" colspan="2"><i><?php include('footer.php'); ?></i></td>
   </tr>
  </table>
 </body>
<html>
