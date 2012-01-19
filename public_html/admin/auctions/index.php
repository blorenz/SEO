<?php
include('../../../include/db.php');
db_connect();
extract(defineVars("s","filter","search","field","start","limit","dir","status","category","Auction_ID","Auction_Title","Dealership","Username","bgcolor","sort","QUERY_STRING")); //JJM added 4/10/2010

if (empty($s)) {
	$status = 'open';
	$s = 'open';
	$reserve = '';
}
elseif($s == 'reserve') {
	$status = 'open';
	$s = 'open';
	$reserve = " AND auctions.current_bid >= auctions.reserve_price AND auctions.current_bid > 0 ";
}
else {
	$status = $s;
	$reserve = '';
}

if (empty($dir))
	$dir = 'asc';

if($dir == 'asc')
{
  $otherdir = 'desc';
}
else
{
  $otherdir = 'asc';
}

if(!empty($_REQUEST['sort']))
	$SortListBy = $_REQUEST['sort'];
else
	$SortListBy = "auctions.category_id, auctions.ends";

$page_title = ucfirst($status) . ' Auctions';

if(empty($filter))
{
    $sql = "SELECT COUNT(*) FROM auctions WHERE " .
   		"auctions.status='$status' $reserve ";
}
else
{
	if ($field!='auctions.id') {
    	$field = $$category;
    	$sql = "SELECT COUNT(*) FROM auctions, categories, dealers, users, vehicles WHERE " .
    	"auctions.status='$status' AND auctions.category_id=categories.id AND " .
   		"auctions.dealer_id=dealers.id AND auctions.user_id=users.id AND auctions.vehicle_id=vehicles.id $reserve " .
		"AND $field LIKE \"%$search%\"";
	}
	else {
    	$field = $$category;
    	$sql = "SELECT COUNT(*) FROM auctions, categories, dealers, users, vehicles WHERE " .
    	"auctions.status='$status' AND auctions.category_id=categories.id AND " .
   		"auctions.dealer_id=dealers.id AND auctions.user_id=users.id AND auctions.vehicle_id=vehicles.id $reserve " .
		"AND auctions.id='$search' ";
	}
}

include('../../../include/list.php');

if(empty($filter))
{
	$result = db_do("SELECT auctions.id, auctions.title, auctions.current_bid, " .
    	"auctions.user_id, auctions.dealer_id, categories.name, dealers.dba, " .
    	"users.username, vehicles.city, vehicles.state, auctions.ends, auctions.current_bid, auctions.reserve_price " .
		"FROM auctions, categories, dealers, users, vehicles WHERE " .
    	"auctions.status='$status' AND auctions.category_id=categories.id AND " .
    	"auctions.dealer_id=dealers.id AND auctions.user_id=users.id AND auctions.vehicle_id=vehicles.id $reserve" .
    	"ORDER BY $SortListBy $dir " .
    	"LIMIT $_start, $limit");
}
else
{
	if ($field!='auctions.id') {
    	$field = $$category;
		$result = db_do("SELECT auctions.id, auctions.title, auctions.current_bid, " .
    	"auctions.user_id, auctions.dealer_id, categories.name, dealers.dba, " .
    	"users.username, vehicles.city, vehicles.state, auctions.ends, auctions.current_bid, auctions.reserve_price " .
		"FROM auctions, categories, dealers, users, vehicles WHERE " .
    	"auctions.status='$status' AND auctions.category_id=categories.id AND " .
    	"auctions.dealer_id=dealers.id AND auctions.user_id=users.id AND auctions.vehicle_id=vehicles.id $reserve " .
		"AND $field LIKE \"%$search%\" " .
    	"ORDER BY $SortListBy $dir " .
    	"LIMIT $_start, $limit");
	}
	else {
	   	$field = $$category;
		$result = db_do("SELECT auctions.id, auctions.title, auctions.current_bid, " .
    	"auctions.user_id, auctions.dealer_id, categories.name, dealers.dba, " .
    	"users.username, vehicles.city, vehicles.state, auctions.ends, auctions.current_bid, auctions.reserve_price " .
		"FROM auctions, categories, dealers, users, vehicles WHERE " .
    	"auctions.status='$status' AND auctions.category_id=categories.id AND " .
    	"auctions.dealer_id=dealers.id AND auctions.user_id=users.id AND auctions.vehicle_id=vehicles.id $reserve " .
		"AND auctions.id='$search' " .
    	"ORDER BY $SortListBy $dir " .
    	"LIMIT $_start, $limit");
	}
}

?>

<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br />
<?php include('_links.php'); ?>
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
  <form action="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" method="post">
    <input type="hidden" name="filter" value="true" />
    <input type="hidden" name="Auction_ID" value="auctions.id" />
    <input type="hidden" name="Auction_Title" value="auctions.title" />
    <input type="hidden" name="Dealership" value="dealers.dba" />
    <input type="hidden" name="Username" value="users.username" />
    <table class="normal" align="center" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Search:</td>
        <td><input type="text" name="search" size="20" maxlength="100" /></td>
        <td><select size="1" name="category"><option>Auction_ID</option><option>Auction_Title</option><option>Dealership</option><option>Username</option></select></td>
        <td><input type="submit" value="Submit" /></td>
        <td><a href="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" title="Clear your search filter">Clear results</a></td>
      </tr>
    </table>
  </form>
  <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No auctions found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="5"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td class="header">&nbsp;</td>
	<td class="header">&nbsp;</td>
    <td class="header"><a href="?s=<?php echo $status; ?>&sort=categories.name&dir=<?php if($sort == 'categories.name') { echo $otherdir; } else { echo $dir; } ?>">Category</a></td>
    <td class="header"><a href="?s=<?php echo $status; ?>&sort=auctions.title&dir=<?php if($sort == 'auctions.title') { echo $otherdir; } else { echo $dir; } ?>">Auction Title</a></td>
    <td class="header"><a href="?s=<?php echo $status; ?>&sort=auctions.current_bid&dir=<?php if($sort == 'auctions.current_bid') { echo $otherdir; } else { echo $dir; } ?>">High Bid</a></td>
    <td class="header"><a href="?s=<?php echo $status; ?>&sort=dealers.dba&dir=<?php if($sort == 'dealers.dba') { echo $otherdir; } else { echo $dir; } ?>">Dealership</a></td>
	<td class="header"><a href="?s=<?php echo $status; ?>&sort=vehicles.city&dir=<?php if($sort == 'vehicles.city') { echo $otherdir; } else { echo $dir; } ?>">Location</a></td>
	<td class="header"><a href="?s=<?php echo $status; ?>&sort=auctions.ends&dir=<?php if($sort == 'auctions.ends') { echo $otherdir; } else { echo $dir; } ?>">Ends</a></td>
   </tr>
<?php
	while (list($aid, $title, $high_bid, $uid, $did, $category, $dba, $un, $city, $state, $ends, $current_bid, $reserve_price) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$pull_ok = 1;

		$r = db_do("SELECT vehicle_id FROM auctions WHERE id='$aid'");
		list($vid) = db_row($r);
		db_free($r);

		$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
		list($photoid) = db_row($r);
		db_free($r);

		if ($photoid > 0)
			$pic = '<img src="../../auction/uploaded/thumbnails/'.$photoid.'.jpg" alt="Click here to view photo" border="0">';
		else
			$pic = '';

		if ($high_bid <= 0)
			$high_bid = '--';

		$timeleft = timeleft($ends);
		$location = "$city, $state";
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
<?php if ($status == 'pending') { ?>
    <td class="normal"><a href="edit.php?id=<?php echo $aid; ?>">edit</a> | <a href="remove.php?id=<?php echo $aid; ?>">remove</a></td>
<?php } elseif ($status == 'open') { ?>
    <td class="normal"><a href="edit_open.php?id=<?php echo $aid; ?>">edit</a></td>
<?php } else { ?>
    <td class="normal">&nbsp;</td>
<?php } ?>
	<td align="center" valign="middle"><?=$pic?></a></td>
    <td class="normal"><?php tshow($category); ?></td>
    <td class="normal">#<?php echo $aid; ?> <a href="auction.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a>
		<?php if ($current_bid >= $reserve_price && $reserve_price > 0) { echo "<br><font color=#009900>(reserve met)</font>"; }
				elseif ($reserve_price <= 0) { echo "<br><font color=#009900>(no reserve)</font>"; }?></td>
    <td align="right" class="normal">$ <?php echo number_format($high_bid, 2); ?></td>
    <td class="normal"><a href="../dealers/edit.php?id=<?php echo $did; ?>"><?php tshow($dba); ?></td>
	<td class="normal" width="50"><?php tshow($location); ?></td>
	<td class="normal" width="50"><?php tshow($timeleft); ?></td>
   </tr>
<?php
	$pic == '';
	}
}

db_free($result);
db_disconnect();
?>
  </table>
 </body>
</html>
