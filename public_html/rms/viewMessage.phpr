<?php

/**
 * $Id$
 */

$_pagetitle = "View Message";
include "$_SERVER[DOCUMENT_ROOT]/rms/libs/header.php";

if (!isset($_GET['id'])) {
   header("http://$_SERVER[SERVER_NAME]/rms/alerts.php");
}

$alert = $rm->getMessage($_GET['id']);

?>

<center>
<h1>View Alert</h1>
<h2><?php echo $alert['title']; ?></h2>

<p><strong>From:</strong> <?php echo $alert['first_name'] . ' ' . $alert['last_name'] ?></p>
<p><?php echo $alert['description']; ?></p>
</center>

<?php
include 'footer.php';
?>
