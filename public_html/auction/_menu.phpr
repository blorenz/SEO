<?php

/**
* Controls the control panel on the side of every page
*
* $Id: _menu.php 332 2006-06-23 18:34:41Z kaneda $
*
**/


if (has_priv('acctexec', $privs)) {?>
<p><center><br><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/aes/index.php"><b>Account Executive Home</b></a></center></p>
<?php }
$result_alert = db_do("SELECT id FROM alerts WHERE (to_user='$userid' AND from_user!='0') and status='pending'");
$result_auc_request = db_do("SELECT id FROM alerts WHERE to_user='$userid' and title='Auction Request' and status='pending'");
$result_make_offer = db_do("SELECT id FROM alerts WHERE (from_user = '$userid' AND auction_id > '0' AND offer_value > 0) and status='pending'");


if(mysql_num_rows($result_alert) > 0 || mysql_num_rows($result_auc_request) > 0 || mysql_num_rows($result_make_offer) > 0) { ?>

<hr>

	<?php if (mysql_num_rows($result_alert) > 0) { ?>
  <center><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/auction/alerts.php"><span style="color: red; font-weight: bold;">You Have Unread Alerts</span></a>&nbsp;(<?php echo mysql_num_rows($result_alert);?>)</center>
	<?php } ?>

	<?php if (mysql_num_rows($result_make_offer) > 0) { ?>
	<center><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/auction/alerts.php"><span style="color: red; font-weight: bold;">Make Offers Pending</span></a>&nbsp;(<?php echo mysql_num_rows($result_make_offer);?>)</center>
	<?php } ?>
   
   <?php if(mysql_num_rows($result_auc_request) > 0) { ?>
   <center><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/auction/alerts.php"><span style="color: red; font-weight: bold;">Auctions Requested</span></a>&nbsp;(<?php echo mysql_num_rows($result_auc_request)?>)</center>
   <?php } ?>
   
<hr>
   
<?php } ?>

<?php 
?>
<p><b>Buying</center></b></p>
<ul>
<?php
if (has_priv('buy', $privs)) {
	echo "<li><a href=\"/auction/bids/index.php\">My Bids</a></li>\n";
	echo "<li><a href=\"/auction/auctions/watch.php\">My Watch List</a></li>\n";
	echo "<li><a href=\"/auction/ratings/index.php\">Rate Sellers</a></li>\n";
   echo '<li><a href="/auction/arbitration/">Arbitration</a>';
}
?>
</ul>
<hr>
<p><b>Selling</center></b></p>
<ul>
<?php
if (has_priv('vehicles', $privs))
	echo "<li><a href=\"/auction/vehicles/category.php\">Add a Wholesale Item</a></li>\n";
if (has_priv('sell', $privs)) {
	echo "<li><a href=\"/auction/auctions/index.php\">My Wholesale Auctions</a></li>\n";
}
if (has_priv('vehicles', $privs)) {
	echo "<li><a href=\"/auction/vehicles/index.php\">My Items</a></li>\n";
}
?>
</ul>
<hr>
<p><b>My Account</center></b></p>
<ul>
<?php
if (has_priv('sell', $privs)) {
	echo "<li><a href=\"/auction/ratings.php\">My Rating History</a></li>\n";
	echo "<li><a href=\"/auction/fees/invoice.php\">My Invoice History</a></li>\n";	
}
if (has_priv('users', $privs)) {
	echo "<li><a href=\"/auction/dealer.php\">Edit My Company Profile</a></li>\n";
}
?>
<li><a href="/auction/profile.php">Edit My Personal Profile</a></li>
<?php
if (has_priv('users', $privs)) {
	echo "<li><a href=\"/auction/users/index.php\">Manage My Users</a></li>\n";
}
?>
	<li><a href="/auction/ae.php">My Account Executive</a></li>
</ul>
<hr>
<ul>
<li><a href="/auction/logout.php">Logout</a></li>
</ul>
<p></p>
