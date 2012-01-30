<?php
#
# Copyright (c) 2002 Steve Price
# All rights reserved.
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions
# are met:
#
# 1. Redistributions of source code must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
# 2. Redistributions in binary form must reproduce the above copyright
#    notice, this list of conditions and the following disclaimer in the
#    documentation and/or other materials provided with the distribution.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
# ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
# FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
# DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
# OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
# HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
# LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
# OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
# SUCH DAMAGE.
#
# $srp: godealertodealer.com/htdocs/auction/auctions/pending.php,v 1.7 2002/09/03 00:40:30 steve Exp $
#

include('../../../include/session.php');
extract(defineVars( "q",  "no_menu", "dir"));    // Added by RJM 1/4/10
extract(defineVars("dir", "sort", "search", "category", "submit", "filter", "Stock_Number", "Auction_Title", "Username")); //JJM 1/12/2010 found a form on this page, need these vars too.

if (empty($dir))
	$dir = 'asc';

if ($dir == 'asc')
  $otherdir = 'desc';
else
  $otherdir = 'asc';

if (isset($_REQUEST['sort']))
	$SortListBy = $_REQUEST['sort'];
else
	$SortListBy = "auctions.id, auctions.current_bid";

$page_title = 'Pending Auctions';
$help_page = "chp6_activate.php";


if (!has_priv('sell', $privs)) {
	header('Location: ../menu.php');
	exit;
}

include('../../../include/db.php');
db_connect();

if(empty($filter))
	$sql = "SELECT COUNT(*) FROM auctions WHERE dealer_id='$dealer_id' AND status='pending' AND auctions.active='yes'";
else {
    $field = $$category;
	$sql = "SELECT COUNT(*) FROM auctions, categories, users, vehicles
			WHERE auctions.dealer_id='$dealer_id' AND auctions.status='pending' AND auctions.category_id=categories.id
				AND auctions.user_id=users.id AND vehicles.id=auctions.vehicle_id AND auctions.active='yes' AND $field LIKE \"%$search%\"";
}

include('../../../include/list.php');
include('../header.php');

if(empty($filter))
	$result = db_do("SELECT auctions.id, auctions.title, DATE_FORMAT(auctions.starts, '%a %c/%e/%y %l:%i%p'),
				DATE_FORMAT(auctions.ends, '%a %c/%e/%y %l:%i%p'), categories.name, users.username, vehicles.stock_num, vehicles.photo_id, vehicles.id
			FROM auctions, categories, users, vehicles
			WHERE auctions.dealer_id='$dealer_id' AND auctions.status='pending' AND auctions.category_id=categories.id
				AND auctions.user_id=users.id AND vehicles.id=auctions.vehicle_id AND auctions.active='yes'
			ORDER BY $SortListBy $dir, auctions.id LIMIT $_start, $limit");
else {
    $field = $$category;
	$result = db_do("SELECT auctions.id, auctions.title, DATE_FORMAT(auctions.starts, '%a %c/%e/%y %l:%i%p'),
				DATE_FORMAT(auctions.ends, '%a %c/%e/%y %l:%i%p'), categories.name, users.username, vehicles.stock_num, vehicles.photo_id, vehicles.id
			FROM auctions, categories, users, vehicles
			WHERE auctions.dealer_id='$dealer_id' AND auctions.status='pending' AND auctions.category_id=categories.id
				AND auctions.user_id=users.id AND vehicles.id=auctions.vehicle_id AND auctions.active='yes' AND $field LIKE \"%$search%\"
			ORDER BY $SortListBy $dir, auctions.id LIMIT $_start, $limit");
}
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
<?php
if (db_num_rows($result) <= 0) {
?>
	<tr><td align="center" class="big">No auctions found.</td></tr>
<?php
} else {
?>
   <tr><td colspan="9"><?php echo $nav_links; ?></td></tr>
	<tr align="center">
		<td class="header">Options</td>
		<td class="header"><a href="?sort=categories.name&dir=<?php if($sort == 'categories.name') { echo $otherdir; } else { echo $dir; } ?>">Category</a></td>
		<td class="header"><a href="?sort=vehicles.stock_num&dir=<?php if($sort == 'vehicles.stock_num') { echo $otherdir; } else { echo $dir; } ?>">Stock #</a></td>
		<td class="header"><a href="?sort=auctions.title&dir=<?php if($sort == 'auctions.title') { echo $otherdir; } else { echo $dir; } ?>">Auction Title</a></td>
		<td class="header"><a href="?sort=auctions.starts&dir=<?php if($sort == 'auctions.starts') { echo $otherdir; } else { echo $dir; } ?>">Starts</a></td>
		<td class="header"><a href="?sort=auctions.ends&dir=<?php if($sort == 'auctions.ends') { echo $otherdir; } else { echo $dir; } ?>">Ends</a></td>
		<td class="header"><a href="?sort=users.username&dir=<?php if($sort == 'users.username') { echo $otherdir; } else { echo $dir; } ?>">Username</a></td>
	</tr>
<?php
	$pull_ok = 0;
	$bgcolor = '#FFFFFF';
	while (list($aid, $title, $starts, $ends, $category, $un, $stock_num, $photo_id, $vid) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
		list($photoid) = db_row($r);
		db_free($r);

		if ($photo_id == 0)
			$photo_id = $photoid;

		if ($photo_id > 0)
			$pic = '<img src="../uploaded/thumbnails/'.$photo_id.'.jpg" border="0">';
		else
			$pic = '';
?>
	<tr bgcolor="<?php echo $bgcolor; ?>">
		<td class="small"><?php tshow($pic); ?><br><a href="edit.php?id=<?php echo $aid; ?>">edit</a> | <a href="remove.php?id=<?php echo $aid; ?>">remove</a></td>
		<td class="small"><?php tshow($category); ?></td>
		<td class="normal"><?php tshow($stock_num); ?></td>
		<td class="normal"><a href="preview.php?id=<?php echo $aid; ?>"><?php tshow($title); ?></a></td>
		<td class="normal"><?php tshow($starts); ?></td>
		<td class="normal"><?php tshow($ends); ?></td>
		<td class="normal"><?php tshow($un); ?></td>
	</tr>
<?php
	}
}

db_free($result);
db_disconnect();
?>
  </table>
<?php include('../footer.php'); ?>
