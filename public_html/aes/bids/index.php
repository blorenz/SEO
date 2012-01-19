
<?php
include('../../../include/session.php');
include('../../../include/db.php');
db_connect();
extract(defineVars("page_title", "did"));

$sql = "SELECT COUNT(DISTINCT(auction_id)) FROM auctions, bids WHERE " .
    "bids.dealer_id='$did' AND bids.auction_id=auctions.id AND " .
    "auctions.status='open'";

include('../../../include/list.php');
include('../header.php');

$result = db_do("SELECT bids.auction_id, auctions.title, auctions.winning_bid, auctions.reserve_price, auctions.vehicle_id
				FROM auctions, bids
				WHERE auctions.id=bids.auction_id AND auctions.status='open' AND bids.dealer_id='$did'
				GROUP BY bids.auction_id
				ORDER BY auctions.id DESC LIMIT $_start, $limit");
?>
	<html>
	<head>
		<title><?= $page_title ?></title>
		<link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
	</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <br>
  <p align="center" class="big"><b> Bids for Open Auctions</b></p>
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
   <tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
   <tr>
   	<td>&nbsp;</td>
    <td class="header">Auction Title</td>
    <td class="header">Auction #</td>
    <td class="header">Bidder</td>
    <td class="header">Status</td>
    <td class="header">Current Bid</td>
    <td class="header">Maximum Bid</td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($aid, $title, $winning_bid, $reserve_price, $vid) = db_row($result)) {

		$result_max = db_do("SELECT bids.id, bids.current_bid, bids.maximum_bid, users.username FROM bids, users
			WHERE bids.dealer_id='$did' AND bids.auction_id='$aid' AND bids.user_id=users.id
			ORDER BY bids.current_bid DESC, bids.maximum_bid DESC");

		list($highest_bid, $bid, $maximum_bid, $un) = db_row($result_max);
		db_free($result_max);

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

		if ($winning_bid == $highest_bid) {
			if ($bid >= $reserve_price)
				$outcome = 'winning';
			else
				$outcome = 'reserve not met';
		} else
			$outcome = 'losing';

		$bid = number_format($bid, 2);
		$maximum_bid = number_format($maximum_bid, 2);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
   	<td align="center" valign="middle"><a href="auction.php?id=<?=$id?>"><?=$pic?></a></td>
    <td class="normal"><a href="../../auction/auction.php?id=<?php echo $aid; ?>"><?php echo $title; ?></a></td>
    <td align="center" class="normal"><?php echo $aid; ?></td>
    <td class="normal"><?php echo $un; ?></td>
    <td class="normal"><?php echo $outcome; ?></td>
    <td align="right" class="normal">US $<?php echo $bid; ?></td>
    <td align="right" class="normal">US $<?php echo $maximum_bid; ?></td>
   </tr>
<?php
	}
}
db_free($result);
db_disconnect();
?>
  </table>
<?php include('../footer.php'); ?>