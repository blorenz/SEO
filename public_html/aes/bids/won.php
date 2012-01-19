

<?php

if(!empty($_REQUEST['did']))
	$did = $_REQUEST['did'];
else
	$did = "";

if(!empty($_REQUEST['page_title']))
	$page_title = $_REQUEST['page_title'];
else
	$page_title = "";

?>


<?php

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$sql = "SELECT COUNT(*) FROM auctions, bids WHERE auctions.status='closed' " .
    "AND auctions.chaching=1 AND bids.dealer_id='$did' AND " .
    "auctions.id=bids.auction_id AND auctions.winning_bid=bids.id";

include('../../../include/list.php');
include('../header.php');

$result = db_do("SELECT bids.id, auctions.id, auctions.title, " .
    "users.username, auctions.winning_bid, auctions.status, " .
    "bids.current_bid, bids.opening_bid, bids.maximum_bid, auctions.vehicle_id FROM auctions, " .
    "bids, users WHERE auctions.status='closed' AND auctions.chaching=1 AND " .
    "bids.dealer_id='$did' AND auctions.id=bids.auction_id AND " .
    "auctions.winning_bid=bids.id AND bids.user_id=users.id " .
    "ORDER BY auctions.id DESC, auctions.id LIMIT $_start, $limit");
?>
<html>
	<head>
		<title><?= $page_title ?></title>
		<link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
	</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <p align="center" class="big"><b>Bids for Auctions Won</b></p>
<?php include('_links.php'); ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No bids found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="9"><?php echo $nav_links; ?></td></tr>
   <tr>
   	<td>&nbsp;</td>
    <td class="header">Auction Name</td>
    <td class="header">Bidder</td>
    <td class="header">Winning Bid</td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($bid, $aid, $title, $un, $winning_bid, $status,
	    $current_bid, $opening_bid, $maximum_bid, $vid) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		$r = db_do("SELECT photo_id FROM vehicles WHERE id='$vid'");
		list($photo_id) = db_row($r);
		db_free($r);

		$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
		list($photoid) = db_row($r);
		db_free($r);

		if ($photo_id == 0)
			$photo_id = $photoid;

		if ($photo_id > 0)
			$pic = '<img src="../../../auction/uploaded/thumbnails/'.$photo_id.'.jpg" alt="Click here to view photo" border="0">';
		else
			$pic = '';

		$current_bid = number_format($current_bid, 2);

		if ($status == 'open') {
			if ($bid == $winning_bid)
				$status = 'winning';
			else
				$status = 'losing';
		} elseif ($status == 'closed') {
			if ($bid == $winning_bid)
				$status = 'won';
			else
				$status = 'lost';
		}
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
   	<td align="center" valign="middle"><a href="auction.php?id=<?=$id?>"><?=$pic?></a></td>
    <td class="normal"><a href="../../auction/auction.php?id=<?php echo $aid; ?>"><?php echo $title; ?></a></td>
    <td class="normal"><?php echo $un; ?></td>
    <td align="right" class="normal">US $<?php echo $current_bid; ?></td>
   </tr>
<?php
	}
}

db_free($result);
db_disconnect();
?>
  </table>
<?php include('../footer.php'); ?>
