<?php

include('../../../include/db.php');
db_connect();

extract(defineVars("dir","sort","p","filter",
				   "Auction_Title","Auction_Number","Dealership",
				   "Stock_Number","Year","Make","Model",
				   "search","category","submit","QUERY_STRING")); //JJM added 8/27/2010

if (empty($dir))
	$dir = 'asc';

if ($dir == 'asc')
  $otherdir = 'desc';
else
  $otherdir = 'asc';

 if(!empty($sort))
	$SortListBy = $sort;
else
	$SortListBy = "id";



$page_title = "My Items";
$help_page = "chp6_create.php";

$result = db_do("SELECT id, name FROM categories WHERE deleted='0'");
$categories = array();
while (list($cid, $name) = db_row($result))
	$categories[$cid] = $name;
db_free($result);

if(empty($filter))
	$sql = "SELECT COUNT(*) FROM vehicles WHERE status!='inactive'";
else {
    $field = $$category;
	$sql = "SELECT COUNT(*) FROM vehicles WHERE status!='inactive' AND $field LIKE \"%$search%\""; }

include('../../../include/list.php');

if(empty($filter))
	$result = db_do("SELECT id, category_id, short_desc, condition_report, year, vin, hin, make, model, sell_price, stock_num, photo_id
			FROM vehicles
			WHERE status!='inactive'
			ORDER BY $SortListBy $dir LIMIT $_start, $limit");

else {
    $field = $$category;
	$result = db_do("SELECT id, category_id, short_desc, condition_report, year, vin, hin, make, model, sell_price, stock_num, photo_id
			FROM vehicles
			WHERE status!='inactive' AND $field LIKE \"%$search%\"
			ORDER BY $SortListBy $dir, category_id, year, id LIMIT $_start, $limit"); }

$dir = 'asc'; //JJM 08/27/2010 adding here to set the default for new column sort to ascending
?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>

<p align="center" class="error">To create an auction click 'create auction' below under Your Options. <br>If 'create auction' does not appear, an auction is already pending or open for that item.</p>

<form action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" method="post">
<input type="hidden" name="filter" value="true" />
<input type="hidden" name="Stock_Number" value="stock_num" />
<input type="hidden" name="Auction_Title" value="short_desc" />
<input type="hidden" name="Year" value="year" />
<input type="hidden" name="Make" value="make" />
<input type="hidden" name="Model" value="model" />
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
				<option>Year</option>
				<option>Make</option>
				<option>Model</option></td>
		<td>
			<input type="submit" value="Submit" />
		</td>
		<td>
			<a href="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" title="Clear your search filter">Clear results</a>
		</td>
	</tr>
</table>
</form>

<table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php if (db_num_rows($result) <= 0) { ?>
   <tr><td align="center" class="big">No items found.</td></tr>
<?php } else { ?>
	<tr><td colspan="9"><?php echo $nav_links; ?></td></tr>
	<tr align="center">
		<td class="header">Options</td>
		<td class="header">Auction Status</td>
		<td class="header"><a href="?sort=category_id&dir=<?php if($sort == 'category_id') { echo $otherdir; } else { echo $dir; } ?>">Category</a></td>
		<td class="header"><a href="?sort=stock_num&dir=<?php if($sort == 'stock_num') { echo $otherdir; } else { echo $dir; } ?>">Stock #</a></td>
		<td class="header"><a href="?sort=short_desc&dir=<?php if($sort == 'short_desc') { echo $otherdir; } else { echo $dir; } ?>">Auction Title</a></td>
		<td class="header"><a href="?sort=year&dir=<?php if($sort == 'year') { echo $otherdir; } else { echo $dir; } ?>">Year</a></td>
		<td class="header"><a href="?sort=make&dir=<?php if($sort == 'make') { echo $otherdir; } else { echo $dir; } ?>">Make</a></td>
		<td class="header"><a href="?sort=model&dir=<?php if($sort == 'model') { echo $otherdir; } else { echo $dir; } ?>">Model</a></td>
		<td class="header">VIN/HIN</td>
	</tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $cid, $short_desc, $condition, $year, $vin, $hin, $make, $model, $sell_price, $stock_num, $photo_id) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		$r = db_do("SELECT id FROM photos WHERE vehicle_id='$id'");
		list($photoid) = db_row($r);
		db_free($r);

		if ($photo_id == 0)
			$photo_id = $photoid;

		if ($photo_id > 0)
			$pic = '<a href="../photos/index.php?vid='.$id.'"><img src="../../auction/uploaded/thumbnails/'.$photo_id.'.jpg" border="0"></a>';
		else
			$pic = '';

		$has_bid = 'no';
		$auction_status = '';
		$r = db_do("SELECT id, status, current_bid, reserve_price FROM auctions WHERE vehicle_id=$id ORDER BY created DESC, status DESC LIMIT 1");
		if (db_num_rows($r) > 0) {
			list($aid, $auction_status, $current_bid, $reserve_price) = db_row($r);
			if ($auction_status == 'open')
				if ($current_bid > 0)
					$has_bid = 'yes';
		}
		db_free($r);

		if ($photo_id != 0) {
			$camera = '<a href="../photos/index.php?vid=' . $id .
			    '"><img src="../../../auction/images/camera.jpg" ' .
			    'border="0"></a>';
		} elseif ($auction_status == 'open' || $photo_count == 0) {
			$camera = '<a href="../photos/add.php?vid=' . $id .
			'"><img src="../../../auction/images/camera.jpg" ' .
			'border="0"></a>';
		} else
			$camera = '&nbsp;';

		if (isset($hin) && strlen($hin)>0)
			$in = $hin;
		else
			$in = $vin;
?>
   <tr bgcolor="<?php echo $bgcolor; ?>"  class="small">
    <td align="center" width="80"><?php tshow($pic); ?>
		<br><?php echo $camera; ?><a href="edit.php?id=<?php echo $id; ?>">edit</a> | <a href="remove.php?id=<?php echo $id; ?>">remove</a></td>
		<td class="small" align="center"><?php tshow($auction_status); ?></td>
		<td class="small" align="center"><?php tshow($categories[$cid]); ?></td>
		<td class="normal"><?php tshow($stock_num); ?></td>
		<td class="normal"><?php tshow($short_desc); ?></td>
		<td class="normal"><?php tshow($year); ?></td>
		<td class="normal"><?php tshow($make); ?></td>
		<td class="normal"><?php tshow($model); ?></td>
		<td class="normal" align="center"><?php tshow($in); ?></td>
		<td align="right" class="normal"><?php if ($status == 'sold') echo '$' . number_format($sell_price, 2); ?></td>
	</tr>
<?php
	}
}

db_free($result);
?>
</table>
<?php
db_disconnect();
?>
