<?php

$title = 'Reminder Sent';
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
     <table border="0" cellpadding="5" cellspacing="0">
      <tr>
       <td align="center" class="huge"><b><?=$title?></b></td>
      </tr>
      <tr>
       <td>
        <p class="big">Your password has been reset, and your login inforamtion has been sent to the email address on file for your username.</p>
        <p class="big"><a href="/">Go back</a> now and enter your username and password to access this site.</p>
       </td>
      </tr>
     </table>
    </td>
    <td>&nbsp;</td>
   </tr>
   <tr><td colspan="2">&nbsp;</td></tr>
   <tr>
    <td align="center" class="small" colspan="2"><i><?php include('footer.php'); ?></i></td>
   </tr>
  </table>
 </body>
</html>
