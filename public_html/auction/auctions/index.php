<?php
include('../../../include/session.php');
include('../../../include/db.php');
extract(defineVars( "q",  "no_menu"));    // Added by RJM 1/4/10
extract(defineVars("dir", "sort", "search", "category", "submit", "filter",
				   "Stock_Number", "Auction_Title", "Username")); //JJM 1/12/2010 found a form on this page, need these vars too.



if (empty($dir))
	$dir = 'asc';

if ($dir == 'asc')
  $otherdir = 'desc';
else
  $otherdir = 'asc';

if (isset($_REQUEST['sort']))
	$SortListBy = ($_REQUEST['sort']);
else
	$SortListBy = "auctions.id, auctions.current_bid";

$page_title = 'Open Auctions';
$help_page = "chp7.php#Chp7_Youropenauctions";

db_connect();

if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if(empty($filter))
	$sql = "SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id' AND status='open' AND auctions.active='yes' ";
else {
    $field = $$category;
	$sql = "SELECT COUNT(*) FROM auctions, categories, users, vehicles WHERE auctions.dealer_id='$dealer_id' AND auctions.status='open'
				AND auctions.category_id=categories.id AND auctions.user_id=users.id
				AND vehicles.id = auctions.vehicle_id AND auctions.active='yes' AND $field LIKE \"%$search%\""; }

include('../../../include/list.php');
include('../header.php');

if(empty($filter))
	$result = db_do("SELECT auctions.id, auctions.title, auctions.current_bid, auctions.reserve_price, auctions.current_bid,
				auctions.ends, categories.name, users.username, vehicles.stock_num, vehicles.photo_id, vehicles.id
			FROM auctions, categories, users, vehicles
			WHERE auctions.dealer_id='$dealer_id' AND auctions.status='open' AND auctions.category_id=categories.id
				AND auctions.user_id=users.id AND vehicles.id = auctions.vehicle_id AND auctions.active='yes'
			ORDER BY $SortListBy $dir LIMIT $_start, $limit");
else {
    $field = $$category;
	$result = db_do("SELECT auctions.id, auctions.title, auctions.current_bid, auctions.reserve_price, auctions.current_bid,
				auctions.ends, categories.name, users.username, vehicles.stock_num, vehicles.photo_id, vehicles.id
			FROM auctions, categories, users, vehicles
			WHERE auctions.dealer_id='$dealer_id' AND auctions.status='open' AND auctions.category_id=categories.id
				AND auctions.user_id=users.id AND vehicles.id = auctions.vehicle_id AND auctions.active='yes' AND $field LIKE \"%$search%\"
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
		<td class="header" width="75">Options</td>
		<td class="header"><a href="?sort=categories.name&dir=<?php if($sort == 'categories.name') { echo $otherdir; } else { echo $dir; } ?>">Category</a></td>
		<td class="header"><a href="?sort=vehicles.stock_num&dir=<?php if($sort == 'vehicles.stock_num') { echo $otherdir; } else { echo $dir; } ?>">Stock #</a></td>
		<td class="header"><a href="?sort=auctions.title&dir=<?php if($sort == 'auctions.title') { echo $otherdir; } else { echo $dir; } ?>">Auction Title</a></td>
      <td class="header">Num Bids</td>
		<td class="header"><a href="?sort=auctions.current_bid&dir=<?php if($sort == 'auctions.current_bid') { echo $otherdir; } else { echo $dir; } ?>">High Bid</a></td>
		<td class="header">Reserve</td>
		<td class="header"><a href="?sort=users.username&dir=<?php if($sort == 'users.username') { echo $otherdir; } else { echo $dir; } ?>">Username</a></td>
		<td class="header">Watching</td>
		<td class="header"><a href="?sort=auctions.ends&dir=<?php if($sort == 'auctions.ends') { echo $otherdir; } else { echo $dir; } ?>">Ends</a></td>
	</tr>
<?php
	$bgcolor = '#FFFFFF';

	while (list($aid, $title, $high_bid, $reserve_price, $current_bid, $ends, $category, $un, $stock_num, $photo_id, $vid) = db_row($result)) {
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


		$pull_ok = 1;
		$timeleft = timeleft($ends);
		if ($current_bid == 0 && $reserve_price == 0)
			$status = "<font color='#666666'><b>no reserve</b></font>";
		elseif ($current_bid >= $reserve_price)
			$status = "<font color='#009900'><b>met</b></font>";
		else
			 $status = "<font color='#CC0000'><b>not met</b></font>";

		if ($high_bid > 0) {
			if ($high_bid >= $reserve_price)
				$pull_ok = 0;
			$high_bid = number_format($high_bid, 2);
		} else
			$high_bid = '<center>-&nbsp;-</center>';

?>
	<tr bgcolor="<?php echo $bgcolor; ?>" align="left">
		<td class="small"><?php tshow($pic); ?><br>&bull;&nbsp;<a href="edit_open.php?id=<?php echo $aid; ?>">edit</a>
		<?php if ($pull_ok) { ?> | &bull;&nbsp;<font color="#00FF00"><a href="pull.php?id=<?php echo $aid; ?>">pull</a></font><?php } ?>
		<?php if ($current_bid+1 < $reserve_price) { ?><br>&bull;&nbsp;<a href="lower.php?aid=<?=$aid?>">Next Bid Wins</a><?php } ?></td>
		<td class="small" align="center"><?php tshow($category); ?></td>
		<td class="normal"><?php tshow($stock_num); ?></td>
		<td class="normal"><a href="../auction.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a></td>
      <?php
         list($num_bids) = db_row(db_do("SELECT COUNT(*) FROM bids WHERE auction_id = '$aid'"));
      ?>
      <td class="normal" align="center"><?php tshow($num_bids); ?></td>
		<td class="normal" align="right"><?php tshow($high_bid); ?></td>
		<td class="small" align="center"><?php tshow($status); ?></td>
		<td class="normal"><?php tshow($un); ?></td>
<?php
list($watch) = db_row(db_do("SELECT COUNT(*) FROM watch_list WHERE watch_list.auction_id='$aid'"));
?>
		<td class="normal"><?php tshow($watch); ?></td>
		<td class="normal" width="50"><?php tshow($timeleft); ?></td>
	</tr>
<?php
	}
}

db_free($result);
db_disconnect();
?>
  </table>
<?php include('../footer.php'); ?>
