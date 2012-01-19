<?php

/**
 * $Id$
 */

$_pagetitle = "My DMs";
include "$_SERVER[DOCUMENT_ROOT]/rms/libs/header.php";

$dms = $rm->getDMInfo();

if (!empty($_POST['percentage'])) {
   $rm->updateDMPercentages($_POST['id'], $_POST['percentage']);
}

?>

<script type="text/javascript">

function checkInput() 
{
	list = document.getElementsByTagName('input');
	errors = false;
	
	for (var i = 1; i < list.length; i++) {
		if (list[i].name == 'percentage[]' && (list[i].value < 0 || list[i].value > 1)) {
			list[i].style.fontWeight = 'bold';
			list[i].style.background = 'red';
			list[i].style.color = 'white';
			errors = true;
		}
	}
	
	if (errors) {
		alert("The highlighted percentages are invalid, please reenter.");
		return false;
	}
	
	return true;
}
</script>
		

<h2>My District Managers</h2>

<p style="text-align: center">Below is all the information on your DMs, current as of the time that the page loaded.  
From here you can also update the DMs Percentage.</p>

<div class="ie_center">
<form method="post">
<table class="dm_info">
	<tr>
		<th>Name (username)</th>
		<th>Percentage</th>
		<th>Address</th>
		<th>Phone</th>
		<th>Dealers</th>
		<th>AEs</th>
		<th>Make Offers</th>
		<th>Auction Requests</th>
		<th>Active Auctions</th>
		<th>Active Items</th>
	</tr>
<?php

$row = ' class="altrow"';
foreach ($dms as $dm) {
   if ($row != '') {
      $row = '';
   } else {
      $row = ' class="altrow"';
   }	
   
   $dm_stats = new gdtd_DM($dm['user_id'])
   ?>
 	<tr<?php echo $row; ?>>
 		<td><a href="/rms/become.php?id=<?php echo $dm['user_id'] ?>">
   		<?php echo $dm['name'];  ?> 
   		(<?php echo $dm['username']; ?>) 
      </a>
 		</td>
 		<td><input type="text" name="percentage[]" value="<?php echo $dm_stats->getPercentage(); ?>"
 			size=3" <?php if ($dm_stats->getPercentage() == 0) { echo 'style="color: red"'; } ?>/></td>
 		<td><?php echo $dm['address']; ?></td>
		<td><?php echo $dm['phone']; ?></td>
		<td class="numeric"><?php echo $dm_stats->getNumDealers(); ?></td>
		<td class="numeric"><?php echo $dm['ae_count']; ?></td>
		<td class="numeric"><?php echo $dm_stats->getMakeOffers(); ?></td>
		<td class="numeric"><?php echo $dm_stats->getAuctionRequests(); ?></td>
		<td class="numeric"><?php echo $dm_stats->getActiveAuctions(); ?></td>
		<td class="numeric"><?php echo $dm_stats->getNumItems(); ?></td>
		<input type="hidden" name="id[]" value="<?php echo $dm['dm_id']; ?>" />
	</tr>
   <?php
}
?>
</table>

<input type="submit" name="update" value="Update Percentages" onclick="javascript: return checkInput();" />


</form>
</div>

<?php 
include 'footer.php';
?>


