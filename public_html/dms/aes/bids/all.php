<?php
include('../../../../include/session.php');
include('../../../../include/db.php');
db_connect();

$sql = "SELECT COUNT(*) FROM auctions, bids, users 
		WHERE bids.dealer_id='$did' AND auctions.id=bids.auction_id AND bids.user_id=users.id";

include('../../../../include/list.php');
include('../../header.php');

$result = db_do("SELECT bids.id, auctions.id, auctions.title, " .
    "users.username, auctions.current_bid, auctions.winning_bid, " .
    "auctions.reserve_price, auctions.status, auctions.chaching, " .
    "bids.current_bid, bids.opening_bid, bids.maximum_bid FROM auctions, " .
    "bids, users WHERE bids.dealer_id='$did' AND " .
    "auctions.id=bids.auction_id AND bids.user_id=users.id ORDER BY " .
    "auctions.id DESC, auctions.id DESC, bids.current_bid DESC, bids.id DESC, bids.maximum_bid DESC LIMIT " .
    "$_start, $limit");
?>
	<html>
	<head>
		<title><?= $page_title ?></title>
		<link rel="stylesheet" type="text/css" href="../../../../site.css" title="site" />
	</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <br>
  <p align="center" class="big"><b>Bids for All Auctions</b></p>
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
    <td class="header">Auction Title</td>
    <td class="header">Bidder</td>
    <td class="header">Status</td>
    <td class="header">Current Bid</td>
    <td class="header">Opening Bid</td>
    <td class="header">Maximum Bid</td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($bid, $aid, $title, $un, $current_bid, $winning_bid,
	    $reserve_price, $status, $chaching, $my_bid, $opening_bid,
	    $maximum_bid) = db_row($result)) {
		
		$result_max = db_do("SELECT id FROM bids 
			WHERE dealer_id='$did' AND auction_id='$aid'
			ORDER BY current_bid DESC, id DESC, maximum_bid DESC");
			
		list($highest_bid) = db_row($result_max);
		db_free($result_max);
			
	    	    	    
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		if ( $bid != $highest_bid )
			$outcome = '^';
			
		elseif ($status == 'closed') {
			if ($chaching) {
				if ( $bid == $winning_bid )
					$outcome = 'won';
				else
					$outcome = 'lost';
			} else
				$outcome = 'lost';
		}
		
		elseif ($status == 'open') {
			if ( $bid == $winning_bid ) {
				if ($my_bid >= $reserve_price)
					$outcome = 'winning';
				else
					$outcome = 'reserve not met';
			} else
				$outcome = 'losing';
		}
		
		elseif ($status == 'pulled')
			$outcome = 'pulled';
		
		else
			$outcome = '--';

		$my_bid = number_format($my_bid, 2);
		$opening_bid = number_format($opening_bid, 2);
		$maximum_bid = number_format($maximum_bid, 2);
		$previous_aid = $aid
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><a href="../../../auction/auction.php?id=<?php echo $aid; ?>"><?php echo $title; ?></a></td>
    <td class="normal"><?php tshow($un); ?></td>
    <td align="center" class="normal"><?php tshow($outcome); ?></td>
    <td align="right" class="normal">US $<?php tshow($my_bid); ?></td>
    <td align="right" class="normal">US $<?php tshow($opening_bid); ?></td>
    <td align="right" class="normal">US $<?php tshow($maximum_bid); ?></td>
   </tr>
<?php
	}
}

db_free($result);
db_disconnect();
?>
  </table>
<?php include('../../footer.php'); ?>