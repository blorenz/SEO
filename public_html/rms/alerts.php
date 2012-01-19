<?php

/**
 * $Id$ 
 */

$_pagetitle = "My Alerts";
include "$_SERVER[DOCUMENT_ROOT]/rms/libs/header.php";

$alerts = $rm->getAlerts();
?>



<?php

/* Deleted! */
if (isset($_POST['delete_submit']) && !empty($_POST['delete'])) {
   $rm->deleteMessages($_POST['delete']);
   header('Location: ' . $_SERVER['PHP_SELF']);
}

/* No alerts */

if (empty($alerts)) {
   ?>
   <div style="text-align: center;">
   <h2>No Alerts</h2>
   <p>Perhaps you wanted to <a href="sendMessage.php">send</a> an alert?</p>
   </div>
   <?php
   include 'footer.php';
   die();
}

/* alerts */

$makeoffers = array();
$aucrequests = array();
$messages = array();

// sort out the alerts
foreach ($alerts as $al) {
   if ($al['auction_id'] > 0) {
      $makeoffers[] = $al;
   } elseif ($al['auction_id'] == 0 && !empty($al['vehicle_id'])) {
      $aucrequests[] = $al; 
   } else {
      $messages[] = $al;
   }
}
?>

<form method="post">

<?php
if (!empty($messages)) {
   ?>
   <table summary="Incoming messages." class="dm_info">
	<tr>
		<th colspan="4">Messages</th>
	</tr>
	<?php 
	foreach ($messages as $message) {
	   ?>

		<tr>
			<td><?php echo date('M d Y', strtotime($message['modified'])); ?></td>
			<td><input type="checkbox" name="delete[]" value="<?php echo $message['id'] ?>" /></td>
			<td>From: <?php echo $message['from_name'] ?></td>
			<td><a href="viewMessage.php?msg=<?php echo $message['id'] ?>">
				<?php echo $message['title'] ?></a></td>
		</tr>
	   <?php
	}
	?>
	</table>
	<?php
}
?>
<center>
<input type="submit" name="delete_submit" value="Delete Checked" />
</center>
</form>


<?php
include 'footer.php';
?>