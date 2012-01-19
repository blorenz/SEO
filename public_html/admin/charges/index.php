<?php
include('../../../include/db.php');
db_connect();

extract(defineVars("status","s","sort","type","dir","filter",
				   "Auction_Title","Auction_Number","Dealership",
				   "search","category","submit"));

if (empty($type))
	$type = 'buy';

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

if (!empty($sort))
	$SortListBy = $sort;
else
	$SortListBy = "dealers.name, charges.created";

$page_title = 'Unpaid ' . ucfirst($type) . ' Charges';


if (isset($submit)) {
	if (is_array($paid)) {
		while (list(, $cid) = each($paid))
			db_do("UPDATE charges SET status='closed' WHERE id='$cid'");
	}
}

if(empty($filter))
{
    $sql = "SELECT COUNT(*) FROM auctions, charges, dealers WHERE " .
    	"charges.status='open' AND charges.fee_type='$type' AND " .
    	"charges.auction_id=auctions.id AND charges.dealer_id=dealers.id ";
}
else
{
    $field = $$category;
    $sql = "SELECT COUNT(*) FROM auctions, charges, dealers WHERE " .
    	"charges.status='open' AND charges.fee_type='$type' AND " .
    	"charges.auction_id=auctions.id AND charges.dealer_id=dealers.id " .
		"AND $field LIKE \"%$search%\"";
}

include('../../../include/list.php');

if(empty($filter))
{
	$result = db_do("SELECT auctions.title, charges.id, charges.auction_id, " .
 	   "charges.dealer_id, charges.fee, DATE_FORMAT(charges.created, '%Y%m%d'), " .
    	"dealers.name FROM auctions, charges, dealers WHERE " .
	    "charges.status='open' AND charges.fee_type='$type' AND " .
    	"charges.auction_id=auctions.id AND charges.dealer_id=dealers.id " .
    	"ORDER BY $SortListBy $dir LIMIT $_start, $limit");
}
else
{
    $field = $$category;
	$result = db_do("SELECT auctions.title, charges.id, charges.auction_id, " .
 	   "charges.dealer_id, charges.fee, DATE_FORMAT(charges.created, '%Y%m%d'), " .
    	"dealers.name FROM auctions, charges, dealers WHERE " .
	    "charges.status='open' AND charges.fee_type='$type' AND " .
    	"charges.auction_id=auctions.id AND charges.dealer_id=dealers.id " .
		"AND $field LIKE \"%$search%\"" .
    	"ORDER BY $SortListBy $dir LIMIT $_start, $limit");
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
    <input type="hidden" name="Auction_Title" value="auctions.title" />
    <input type="hidden" name="Auction_Number" value="charges.auction_id" />
    <input type="hidden" name="Dealership" value="dealers.name" />
    <table class="normal" align="center" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Search:</td>
        <td><input type="text" name="search" size="20" maxlength="100" /></td>
        <td><select size="1" name="category"><option>Auction_Title</option><option>Auction_Number</option><option>Dealership</option></td>
        <td><input type="submit" value="Submit" /></td>
        <td><a href="<?php echo $PHP_SELF . '?' . $QUERY_STRING; ?>" title="Clear your search filter">Clear results</a></td>
      </tr>
    </table>
  </form>
  <form action="index.php" method="get">
   <input type="hidden" name="type" value="<?php echo $type; ?>" />
   <table align="center" border="0" cellspacing="0" cellpadding="5" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
    <tr>
     <td align="center" class="big">No charges found.</td>
    </tr>
<?php
} else {
?>
    <tr><td colspan="9"><?php echo $nav_links; ?></td></tr>
    <tr>
	 <td></td>
     <td class="header">Paid</td>
     <td class="header"><a href="?s=<?php echo $status; ?>&sort=charges.id&type=<?php echo $type; ?>&dir=<?php if($sort == 'charges.id') { echo $otherdir; } else { echo $dir; } ?>"><b>Invoice Number</b></a></td>
     <td align="right" class="header"><a href="?s=<?php echo $status; ?>&sort=charges.fee&type=<?php echo $type; ?>&dir=<?php if($sort == 'charges.fee') { echo $otherdir; } else { echo $dir; } ?>"><b>Fee (US $)</b></a></td>
     <td class="header"><a href="?s=<?php echo $status; ?>&sort=auctions.title&type=<?php echo $type; ?>&dir=<?php if($sort == 'auctions.title') { echo $otherdir; } else { echo $dir; } ?>"><b>Auction Title</b></a></td>
     <td class="header"><a href="?s=<?php echo $status; ?>&sort=charges.auction_id&type=<?php echo $type; ?>&dir=<?php if($sort == 'charges.auction_id') { echo $otherdir; } else { echo $dir; } ?>"><b>Auction #</b></a></td>
     <td class="header"><a href="?s=<?php echo $status; ?>&sort=dealers.name&type=<?php echo $type; ?>&dir=<?php if($sort == 'dealers.name') { echo $otherdir; } else { echo $dir; } ?>"><b>Dealership</b></a></td>
    </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($title, $cid, $aid, $did, $fee, $created, $dealer)
	    = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';
		$invoice_num = "$created-$cid";
?>
    <tr bgcolor="<?php echo $bgcolor; ?>">
	 <td align="center" class="normal"><strong><a href="edit.php?cid=<?=$cid?>">edit</a></strong></td>
     <td align="center" class="normal"><input type="hidden" name="id" value="<?php echo $dealer; ?>" />
	 <input type="checkbox" name="paid[]" value="<?php echo $cid; ?>" /></td>
     <td class="normal"><?php echo $invoice_num; ?></td>
     <td align="right" class="normal"><?php tshow($fee); ?></td>
     <td class="normal"><a href="../auctions/auction.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a></td>
     <td align="center" class="normal"><?php echo $aid; ?></td>
     <td class="normal"><a href="../dealers/edit.php?id=<?php echo $did; ?>"><?php tshow($dealer); ?></a></td>
    </tr>
<?php
	}
}

db_free($result);
db_disconnect();
?>
    <tr>
     <td align="center" class="normal" colspan="6"><input type="submit" name="submit" value=" Update Charges " /></td>
    </tr>
   </table>
  </form>
 </body>
</html>
