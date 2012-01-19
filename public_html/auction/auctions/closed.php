<?php
include('../../../include/session.php');
include('../../../include/db.php');
db_connect();
extract(defineVars("all", "sort", "delbox"));    // Added by RJM 1/1/10
extract(defineVars( "q",  "no_menu"));    // Added by RJM 1/4/10
extract(defineVars("sort", "dir", "filter", "search", "category", "submit", "filter", "Stock_Number", "Auction_Title", "Username"));  //JJM 1/12/2010 Added, there is a form that submits to this page


function deleteFromAuctionList ($id)
{
  db_do("UPDATE auctions SET active='no' WHERE id='$id'" );
  return;
}

if (empty($dir))
	$dir = 'asc';

if ($dir == 'asc')
  $otherdir = 'desc';
else
  $otherdir = 'asc';


$page_title = 'Closed Auctions';



if (!empty($sort))
	$SortListBy = $sort;
else
	$SortListBy = "auctions.id, auctions.current_bid";



if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (count($delbox) > 0) {
	$count=count($delbox);
	for ($i=0;$i<$count;$i++)
		 deleteFromAuctionList($delbox[$i]);

	header("Location: closed.php");
	exit();
}

if(empty($filter))
	$sql = "SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id' AND status='closed' AND auctions.active='yes'";
else {
    $field = $$category;
	$sql = "SELECT COUNT(*) FROM auctions, categories, users, vehicles
			WHERE auctions.dealer_id='$dealer_id' AND auctions.status='closed' AND auctions.category_id=categories.id
				AND auctions.user_id=users.id AND vehicles.id=auctions.vehicle_id AND auctions.active='yes' AND $field LIKE \"%$search%\""; }

include('../../../include/list.php');
include('../header.php');

if(empty($filter))
	$result = db_do("SELECT auctions.id, auctions.title, auctions.current_bid, auctions.reserve_price, auctions.winning_bid,
				categories.name, users.username, vehicles.stock_num, vehicles.id, auctions.chaching, vehicles.photo_id
			FROM auctions, categories, users, vehicles
			WHERE auctions.dealer_id='$dealer_id' AND auctions.status='closed' AND auctions.category_id=categories.id
				AND auctions.user_id=users.id AND vehicles.id=auctions.vehicle_id AND auctions.active='yes'
			ORDER BY $SortListBy $dir, auctions.id LIMIT $_start, $limit");
else {
    $field = $$category;
	$result = db_do("SELECT auctions.id, auctions.title, auctions.current_bid, auctions.reserve_price, auctions.winning_bid,
				categories.name, users.username, vehicles.stock_num, vehicles.id, auctions.chaching, vehicles.photo_id
			FROM auctions, categories, users, vehicles
			WHERE auctions.dealer_id='$dealer_id' AND auctions.status='closed' AND auctions.category_id=categories.id
				AND auctions.user_id=users.id AND vehicles.id=auctions.vehicle_id AND auctions.active='yes' AND $field LIKE \"%$search%\"
			ORDER BY $SortListBy $dir, auctions.id LIMIT $_start, $limit"); }
?>
<br><p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php include('_links.php'); ?><br><br>

<form action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" method="post">
<input type="hidden" name="filter" value="true" />
<input type="hidden" name="Stock_Number" value="vehicles.stock_num" />
<input type="hidden" name="Auction_Title" value="auctions.title" />
<input type="hidden" name="Username" value="users.username" />
<table class="normal" align="center" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td>Search:</td>
		<td>
			<input type="text" name="search" size="20" maxlength="100" />
		</td>
		<td>
			<select size="1" name="category">
				<option>Stock_Number</option>
				<option>Auction_Title</option>
				<option>Username</option></td>
		<td>
			<input type="submit" value="Submit" />
		</td>
		<td>
			<a href="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" title="Clear your search filter">Clear results</a>
		</td>
	</tr>
</table>
</form>
<table align="center" border="0" cellpadding="5" cellspacing="0" width="95%">
<?php if (db_num_rows($result) <= 0) { ?>
	<tr><td align="center" class="big">No auctions found.</td></tr>
<?php } else { ?>
	<tr><td colspan="6"><?php echo $nav_links; ?></td></tr>
	<tr align="center">
		<td align="center" class="small">&nbsp;</td>
		<td class="header">Options</td>
		<td class="header" align="center">Delete<br><a href="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>&all=true">Check All</a></td>
		<td class="header"><a href="?sort=categories.name&dir=<?php if($sort == 'categories.name') { echo $otherdir; } else { echo $dir; } ?>">Category</a></td>
		<td class="header"><a href="?sort=vehicles.stock_num&dir=<?php if($sort == 'vehicles.stock_num') { echo $otherdir; } else { echo $dir; } ?>">Stock #</a></td>
		<td class="header"><a href="?sort=auctions.title&dir=<?php if($sort == 'auctions.title') { echo $otherdir; } else { echo $dir; } ?>">Auction Title</a></td>
		<td class="header"><a href="?sort=auctions.current_bid&dir=<?php if($sort == 'auctions.current_bid') { echo $otherdir; } else { echo $dir; } ?>">High Bid</a></td>
		<td class="header"><a href="?sort=auctions.chaching&dir=<?php if($sort == 'auctions.chaching') { echo $otherdir; } else { echo $dir; } ?>">Result</a></td>
		<td class="header"><a href="?sort=users.username&dir=<?php if($sort == 'users.username') { echo $otherdir; } else { echo $dir; } ?>">Username</a></td>
	</tr>
	<form action="closed.php" method="POST">
<?php
	$bgcolor = '#FFFFFF';
	while (list($aid, $title, $high_bid, $reserve_price, $winning_bid, $category, $un, $stock_num, $vid, $chaching, $photo_id) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
		list($photoid) = db_row($r);
		db_free($r);

		if ($photo_id == 0)
			$photo_id = $photoid;

		if ($photo_id > 0)
			$pic = '<img src="../uploaded/thumbnails/'.$photo_id.'.jpg" alt="Click here to view photo" border="0">';
		else
			$pic = '';

		if ($high_bid <= 0)
			$high_bid = '<center>-&nbsp;-</center>';
		else
			$high_bid = number_format($high_bid, 2);

		if ($chaching > 0)
			$sold_status = '<font color="#009900"><b>Sold</b></font>';
		else
			$sold_status = '<font color="#CC0000"><b>No Sale</b></font>';
?>
	<input type="hidden" name="aid" value="<?php echo $aid; ?>" />
	<tr bgcolor="<?php echo $bgcolor; ?>">
		<td align="center" class="small">
<?php $result_offer = db_do("SELECT id FROM alerts WHERE auction_id='$aid' AND from_user='0' AND to_user='$userid' AND status='pending'");
	if (db_num_rows($result_offer) > 0) { ?>
<strong><a href="../bids/makeoffer.php?id=<?php echo $aid; ?>"><font color="#FF0000">make offer</font></a></strong>
<?php } ?>
		</td>
		<td align="center" class="small"><?php tshow($pic); ?><br>
<?php

$result_active = db_do("SELECT auctions.status FROM auctions, vehicles WHERE vehicles.id=$vid AND vehicles.id=auctions.vehicle_id ");

$current = '';
while (list($status) = db_row($result_active)) {
	if ($status == 'open' || $status == 'pending')
		$current = 'no';
}

if ( $current == 'no' && $sold_status == '<font color="#009900"><b>Sold</b></font>')
	echo "rollback re-listed";
elseif ( $current == 'no')
	echo "currently re-listed";
else { ?>
			<a class="standout" href="../auctions/add.php?vid=<?php echo $vid; ?>">re-list auction</a><?php } ?>
			</td>
		<td class="small" align="center"><input type="checkbox" name="delbox[]" <?php if ($all) echo "checked"; ?> value=<?=$aid?> /></td>
		<td class="small" align="center"><?php tshow($category); ?></td>
		<td class="normal"><?php tshow($stock_num); ?></td>
		<td class="normal"><a href="../auction.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a></td>
		<td class="normal" align="right"><?php tshow($high_bid); ?></td>
		<td class="small" align="center"><?php tshow($sold_status); ?></td>
		<td class="normal"><?php tshow($un); ?></td>
	</tr>
<?php } ?>
	<tr><td></td><td align="center"><input type="submit" name="submit" value="Delete"></td></tr>
<?php }
db_free($result);
db_disconnect();
?>
	</form>
  </table>
<?php include('../footer.php'); ?>
