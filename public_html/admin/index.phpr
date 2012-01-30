<?php

$page_title = 'Admin Home';

#print phpinfo();


if(!empty($_REQUEST['saved_dealers']))
	$saved_dealers = $_REQUEST['saved_dealers'];
else
	$saved_dealers = "";


include('../../include/db.php');

db_connect();

$num_auctions     = 0;
$pending_auctions = 0;
$open_auctions    = 0;
$closed_auctions  = 0;
$pulled_auctions  = 0;
$reserve_auctions = 0;

$result = db_do("SELECT status FROM auctions");
while (list($status) = db_row($result)) {
	$num_auctions++;

	switch ($status) {
	case 'pending':
		$pending_auctions++;
		break;
	case 'open':
		$open_auctions++;
		break;
	case 'closed':
		$closed_auctions++;
		break;
	case 'pulled':
		$pulled_auctions++;
		break;
	}
}
db_free($result);

$result = db_do("SELECT COUNT(*) FROM auctions WHERE current_bid >= reserve_price AND current_bid > 0 AND ends > NOW()");
list ($reserve_auctions) = db_row($result);
db_free($result);

$num_dealers       = 0;
$pending_dealers   = 0;
$active_dealers    = 0;
$suspended_dealers = 0;

$result = db_do("SELECT status FROM dealers");
while (list($status) = db_row($result)) {
	$num_dealers++;

	switch ($status) {
	case 'pending':
		$pending_dealers++;
		break;
	case 'active':
		$active_dealers++;
		break;
	case 'saved':
		$saved_dealers++;
		break;
	case 'suspended':
		$suspended_dealers++;
		break;
	}
}
db_free($result);

$num_users       = 0;
$pending_users   = 0;
$active_users    = 0;
$suspended_users = 0;



$result = db_do("SELECT status FROM users");
while (list($status) = db_row($result)) {
	$num_users++;

	switch ($status) {
	case 'pending':
		$pending_users++;
		break;
	case 'active':
		$active_users++;
		break;
	case 'suspended':
		$suspended_users++;
		break;
	}
}
db_free($result);



$result = db_do("SELECT COUNT(*) FROM auctions WHERE status='closed' AND chaching=1");
list($num_sales) = db_row($result);
db_free($result);

$result = db_do("SELECT COUNT(*) FROM auctions WHERE status='closed' AND " .
    "current_bid < reserve_price");
list($num_no_sales) = db_row($result);
db_free($result);

$result = db_do("SELECT SUM(fee) FROM charges WHERE status='closed'");
list($paid_fees) = db_row($result);
db_free($result);

if ($paid_fees <= 0)
	$paid_fees = '0.00';

$result = db_do("SELECT SUM(fee) FROM charges WHERE status='open'");
list($unpaid_fees) = db_row($result);
db_free($result);

if ($unpaid_fees <= 0)
	$unpaid_fees = '0.00';

$result = db_do("SELECT COUNT(*) FROM auctions WHERE status='open' AND " .
    "ends <= DATE_ADD(NOW(), INTERVAL 24 HOUR)");
list($closing_soon) = db_row($result);
db_free($result);

$result = db_do("SELECT COUNT(*) FROM auctions WHERE status='closed' AND " .
    "ends >= DATE_SUB(NOW(), INTERVAL 24 HOUR)");
list($recent_closings) = db_row($result);
db_free($result);

$result = db_do("SELECT COUNT(*) FROM auctions WHERE status='pending' AND " .
    "starts <= DATE_ADD(NOW(), INTERVAL 24 HOUR)");
list($opening_soon) = db_row($result);
db_free($result);

db_disconnect();
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('header.php'); ?>
  <br />
  <p align="center" class="big"><b>Administration</b></p>
<!--
  <table align="center" border="0" cellpadding="3" cellspacing="0" width="95%">
   <tr>
    <td class="normal">
     <p>Choose from the links above, <a href="dealers/add.php">go here</a> to add a dealer, or <a href="dealers/index.php?s=pending">go here</a> for a list of pending dealers. The following are simple stats or factoids that represent a macro view of what's going on with the site.</p>
    </td>
   </tr>
  </table>
  <br />
  -->
  <table align="center" border="0" cellpadding="3" cellspacing="0">
   <tr><td colspan="2"><hr /></td></tr>
   <tr>
    <td class="normal"><a href="auctions/index.php?s=pending">Auctions - Pending</a></td>
    <td align="right" class="normal"><?php echo $pending_auctions; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="auctions/index.php">Auctions - Open</a></td>
    <td align="right" class="normal"><?php echo $open_auctions; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="auctions/index.php?s=reserve">Auctions - Reserve Met</a></td>
    <td align="right" class="normal"><?php echo $reserve_auctions ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="auctions/index.php?s=closed">Auctions - Closed</a></td>
    <td align="right" class="normal"><?php echo $closed_auctions; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="auctions/index.php?s=pulled">Auctions - Pulled</a></td>
    <td align="right" class="normal"><?php echo $pulled_auctions; ?></td>
   </tr>
   <tr>
    <td class="header">Total Auctions</td>
    <td align="right" class="normal"><?php echo $num_auctions; ?></td>
   </tr>
   <tr><td colspan="2"><hr /></td></tr>
   <tr>
    <td class="normal"><a href="dealers/index.php?s=pending">Dealers - Pending</a></td>
    <td align="right" class="normal"><?php echo $pending_dealers; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="dealers/index.php">Dealers - Active</a></td>
    <td align="right" class="normal"><?php echo $active_dealers; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="dealers/index.php?s=suspended">Dealers - Suspended</a></td>
    <td align="right" class="normal"><?php echo $suspended_dealers; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="dealers/index.php?s=saved">Dealers - Saved</a></td>
    <td align="right" class="normal"><?php echo $saved_dealers; ?></td>
   </tr>
   <tr>
    <td class="header">Total Dealers</td>
    <td align="right" class="normal"><?php echo $num_dealers; ?></td>
   </tr>
   <tr><td colspan="2"><hr /></td></tr>
   <tr>
    <td class="normal"><a href="users/index.php?s=pending">Users - Pending</a></td>
    <td align="right" class="normal"><?php echo $pending_users; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="users/index.php">Users - Active</a></td>
    <td align="right" class="normal"><?php echo $active_users; ?></td>
   </tr>
   <tr>
    <td class="normal"><a href="users/index.php?s=suspended">Users - Suspended</a></td>
    <td align="right" class="normal"><?php echo $suspended_users; ?></td>
   </tr>
   <tr>
    <td class="header">Total Users</td>
    <td align="right" class="normal"><?php echo $num_users; ?></td>
   </tr>
   <tr><td colspan="2"><hr /></td></tr>
<!--
   <tr>
    <td class="normal">Dealer with most auctions</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="normal">Dealer with most sales</td>
    <td class="normal">&nbsp;</td>
   </tr>
   <tr>
    <td class="normal">Dealer with most purchases</td>
    <td class="normal">&nbsp;</td>
   </tr>
  -->
   <tr>
    <td class="normal"><a href="charges/paid.php?s=open">Closed auctions with sale</a></td>
    <td align="right" class="normal"><?php echo $num_sales; ?></td>
   </tr>
   <tr>
    <td class="normal">Closed auctions without sale</td>
    <td align="right" class="normal"><?php echo $num_no_sales; ?></td>
   </tr>
   <tr>
    <td class="normal">Auctions closing in next 24 hours</td>
    <td align="right" class="normal"><?php echo $closing_soon; ?></td>
   </tr>
   <tr>
    <td class="normal">Auctions closed in last 24 hours</td>
    <td align="right" class="normal"><?php echo $recent_closings; ?></td>
   </tr>
   <tr>
    <td class="normal">Auctions opening in next 24 hours</td>
    <td align="right" class="normal"><?php echo $opening_soon; ?></td>
   </tr>
   <tr>
    <td class="normal">Paid Charges (US $)</td>
    <td align="right" class="normal"><?php echo $paid_fees; ?></td>
   </tr>
   <tr>
    <td class="normal">Unpaid Charges (US $)</td>
    <td align="right" class="normal"><?php echo $unpaid_fees; ?></td>
   </tr>
  </table>
 </body>
</html>
