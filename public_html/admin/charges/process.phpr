<?php
ob_start();
include('../../../include/db.php');
db_connect();

?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />

<?php

foreach($_POST['pay'] as $cid) {
   $sql = "UPDATE charges SET status='closed' WHERE id = '$cid'";
   db_do($sql);
}

header('Location: paid.php?s=open');

?>
  
 </body>
</html>
