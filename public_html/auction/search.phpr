<?php
$PHP_SELF = $_SERVER['PHP_SELF'];


/**
* $Id: search.php 16 2006-04-21 19:40:31Z kaneda $
*/


define('DEBUG', false);

include('../../include/session.php');
include('../../include/db.php');

extract(defineVars("price_low", "price_high", "sleep_no", "length", "seating",
"horsepower", "hours", "miles", "q", "submit_id", "page_title", "first_name",
"p","search_query_udr",

//the following list comes from advanced search
"am_exhaust", "ac_yn", "trailer", "brakes", "transmission", "year_end", "year_start",
"boat_use", "state", "seats", "submit", "security_system", "sid", "cid", "body",
"fuel_type", "engine", "engine_make", "npid", "slide_out", "drive_train", "hand_warmers",
"tonguejack", "sno_trailer", "type", "depth_finder", "warranty", "certified", "gps",
"fish_finder", "hitch", "interior_color", "exterior_color", "title", "title_status",
"studded", "cover","back","npid"));


$search_query = '';



if(isset($_SESSION['search_results']) && isset($back) && $back == 1) {
	//JJM 7/7/2010 You can't write to $_POST and $_GET!!!!!
   extract(unserialize($_SESSION['search_results']));
   extract(unserialize($_SESSION['search_results_get']));
}

if (isset($sid)) {
	$search_query .= " AND ((v.subcategory_id2 = '" . $sid[0] . "'";
	for ($i=1;$i<count($sid);$i++)
		$search_query .= " OR v.subcategory_id2 = '" . $sid[$i] . "'";
	$search_query .= "))";
}

if (!isset($sid)) {
	if (isset($npid)) {
	$pid = explode(',', $npid);
		if ($npid[0] != '') {
			$search_query .= " AND ((v.subcategory_id1 = '$pid[0]'";
			for ($i=1;$i<count($pid);$i++)
				$search_query .= " OR v.subcategory_id1 = '$pid[$i]'";
			$search_query .= "))";
		}
	}
	if (isset($cid)) {
		$search_query .= " AND v.category_id = '$cid'";
	}
}

if (isset($price_low) && $price_low > 0) {
	$price_low = fix_price($price_low);
   $search_query .= " AND (a.current_bid >= '$price_low' OR a.minimum_bid >= '$price_low')";
}
if (isset($price_high) && $price_high > 0) {
	$price_high = fix_price($price_high);
   $search_query .= " AND (a.current_bid <= '$price_high' AND a.minimum_bid <= '$price_high')";
}

if (isset($state)) {
   $search_query .= " AND ((v.state = '{$state[0]}')";
	for ($i=1;$i<count($state);$i++)
		$search_query .= " OR (v.state = '{$state[$i]}')";
	$search_query .= ")";
}


if (isset($boat_use)) {
	$search_query .= " AND (v.boat_use = '{$boat_use[0]}'";
   for ($i=1;$i<count($boat_use);$i++)
		$search_query .= " OR v.boat_use = '{$boat_use[$i]}'";
	$search_query .= ")";
}
if (isset($body)) {
	$search_query .= " AND (v.body = '{$body[0]}'";
   for ($i=1;$i<count($body);$i++)
      $search_query .= " OR v.body = '{$body[$i]}'";
	$search_query .= ")";
}
if (isset($drive_train)) {
	$search_query .= " AND (v.drive_train = '{$drive_train[0]}'";
   for ($i=1;$i<count($drive_train);$i++)
		$search_query .= " OR v.drive_train = '{$drive_train[$i]}'";
	$search_query .= ")";
}
if (isset($engine)) {
	$search_query .= " AND (v.engine = '{$engine[0]}'";
   for ($i=1;$i<count($engine);$i++)
		$search_query .= " OR v.engine = '{$engine[$i]}'";
	$search_query .= ")";
   }
if (isset($engine_make)) {
	$search_query .= " AND (v.engine_make = '{$engine_make[0]}'";
   for ($i=1;$i<count($engine_make);$i++)
		$search_query .= " OR v.engine_make = '{$engine_make[$i]}'";
	$search_query .= ")";
}
if (isset($exterior_color)) {
	$search_query .= " AND (v.exterior_color = '{$exterior_color[0]}'";
   for ($i=1;$i<count($exterior_color);$i++)
		$search_query .= " OR v.exterior_color = '{$exterior_color[$i]}'";
	$search_query .= ")";
}
if (isset($fuel_type)) {
	$search_query .= " AND (v.fuel_type = '{$fuel_type[0]}'";
   for ($i=1;$i<count($fuel_type);$i++)
		$search_query .= " OR v.fuel_type = '{$fuel_type[$i]}'";
	$search_query .= ")";
}
if (isset($hitch)) {
	$search_query .= " AND (v.hitch = '{$hitch[0]}'";
   for ($i=1;$i<count($hitch);$i++)
		$search_query .= " OR v.hitch = '{$hitch[$i]}'";
	$search_query .= ")";
}
if (isset($interior_color)) {
	$search_query .= " AND (v.interior_color = '{$interior_color[0]}'";
   for ($i=1;$i<count($interior_color);$i++)
		$search_query .= " OR v.interior_color = '{$interior_color[$i]}'";
	$search_query .= ")";
}
if (isset($seats)) {
	$search_query .= " AND (v.seats = '{$seats[0]}'";
   for ($i=1;$i<count($seats);$i++)
		$search_query .= " OR v.seats = '{$seats[$i]}'";
	$search_query .= ")";
}
if (isset($title)) {
	$search_query .= " AND (v.title = '{$title[0]}'";
   for ($i=1;$i<count($title);$i++)
		$search_query .= " OR v.title = '{$title[$i]}'";
	$search_query .= ")";
}
if (isset($title_status)) {
	$search_query .= " AND (v.title_status = '{$title_status[0]}'";
   for ($i=1;$i<count($title_status);$i++)
		$search_query .= " OR v.title_status = '{$title_status[$i]}'";
	$search_query .= ")";
}
if (isset($transmission)) {
	$search_query .= " AND (v.transmission = '{$transmission[0]}'";
   for ($i=1;$i<count($transmission);$i++)
		$search_query .= " OR v.transmission = '{$transmission[$i]}'";
	$search_query .= ")";
}

if (isset($warranty)) {
	$search_query .= " AND v.warranty='Yes'";
}
if (isset($certified)) {
	$search_query .= " AND v.certified='Yes'";
}
if (isset($security_system)) {
	$search_query .= " AND v.security_system='Yes'";
}
if (isset($gps)) {
	$search_query .= " AND v.gps='Yes'";
}
if (isset($hitch)) {
	$search_query .= " AND v.hitch='Yes'";
}
if (isset($trailer)) {
	$search_query .= " AND v.trailer='Yes'";
}
if (isset($fish_finder)) {
	$search_query .= " AND v.fish_finder='Yes'";
}
if (isset($depth_finder)) {
	$search_query .= " AND v.depth_finder='Yes'";
}
if (isset($slide_out)) {
	$search_query .= " AND v.slide_out='Yes'";
}
if (isset($ac_yn)) {
	$search_query .= " AND v.ac_yn='Yes'";
}


if (isset($sleep_no) && $sleep_no>0) {
   $search_query .= " AND v.sleep_no>='$sleep_no'";
}
if (isset($length) && $length>0) {
   $search_query .= " AND v.length>='$length'";
}
if (isset($seating) && $seating>0) {
   $search_query .= " AND v.seating>='$seating'";
}
if (isset($horsepower) && $horsepower>0) {
	$search_query .= " AND v.horsepower>='$horsepower'";
}
if (isset($hours) && $hours>0) {
	$search_query .= " AND v.hours<='$hours'";
}
if (isset($miles) && $miles>0) {
	$search_query .= " AND v.miles<='$miles'";
}
if (isset($year_start)) {
	$search_query .= " AND v.year>='$year_start'";
}
if (isset($year_end)) {
	$search_query .= " AND v.year<='$year_end'";
}

if($q == '' && $type != 'advanced' && !isset($search_query_udr)) {
   Header('Location: /auction/index.php');
}

if (!empty($q)) {
	$search_query = '';

	$a = explode(' ', $q);
	if (count($a) > 1) {
		while (list(, $val) = each($a)) {
			$search_query .=
				" (a.id = '$val' OR " .
            " v.id = '$val' OR " .
				"a.title LIKE '%$val%' OR " .
		//		"a.description LIKE '%$val%' OR " .
				"c.name LIKE '%$val%' OR " .
				"v.make LIKE '%$val%' OR " .
				"v.model LIKE '%$val%' OR " .
				"v.year LIKE '%$val%')";
         if(current($a) !== false) {
            $search_query .= ' AND';
         }
		}
	} else {
		$search_query .=
			" (a.id = '$q' OR  ".
            " v.id = '$q' OR " .
			"a.title LIKE '%$q%' OR " .
		//	"a.description LIKE '%$q%' OR " .
			"c.name LIKE '%$q%' OR " .
			"v.make LIKE '%$q%' OR " .
			"v.model LIKE '%$q%' OR " .
			"v.year LIKE '%$q%')";
	}
}

if ($submit_id)
	$search_query = " AND (a.id = '$q')";

if (isset($search_query_udr)) {
   $search_query_udr = RemoveSlash($search_query_udr);
   $search_query_udr = str_replace('~', ' ', $search_query_udr);
   $search_query = $search_query_udr;
}

db_connect();

echo substr($search_query, 0, 4) == 'AND';
if(trim(substr($search_query, 0, 4)) == 'AND') {
   $search_query = substr($search_query, 4);
}


$sql = "SELECT COUNT(*) FROM vehicles v " .
   "LEFT OUTER JOIN auctions a ON v.id = a.vehicle_id AND a.status='open' " .
   "LEFT OUTER JOIN categories c ON v.category_id = c.id " .
   "LEFT OUTER JOIN dealers d ON d.id = v.dealer_id WHERE " .
   $search_query . " AND v.status = 'active' AND d.status='active'";

    $help_page = "chp4.php";

    $search_query_udr = str_replace(' ', '~', $search_query);

//JJM 7/6/2010 - had to add an if statement around the serialize, so that if you returned to the page without a posted search lookup, it wouldn't overwrite what you last searched for
if(!isset($_SESSION['search_results']) || !isset($back) || $back != 1) {
    $_SESSION['search_results'] = serialize($_POST);
    $_SESSION['search_results_get'] = serialize($_GET);
}

include('../../include/list.php');
include('header.php');


$search = "SELECT DISTINCT a.id AS a_id, a.title, a.current_bid, a.reserve_price, a.minimum_bid, a.ends, c.name, v.year, v.make, v.model, v.miles, v.hours, v.photo_id, v.id AS v_id, CONCAT( v.city, ',', v.state ) AS location, a.status, v.dealer_id, a.ends IS NULL AS isnull
FROM vehicles v
LEFT OUTER JOIN auctions a ON v.id = a.vehicle_id AND a.status='open'
LEFT OUTER JOIN categories c ON v.category_id = c.id
LEFT OUTER JOIN dealers d ON d.id = v.dealer_id
WHERE $search_query AND v.status = 'active' AND d.status='active'
ORDER BY isnull ASC, a.ends ASC
LIMIT $_start , $limit";

if(DEBUG) echo $search;

$result = db_do($search);
?>

  <br>
  <p align="center" class="big"><b>Your search results</b></p>
  <p align="center" class="normal">

  </p>

  <table align="center" border="0" cellpadding="5" cellspacing="0">
  <tr><td colspan="9" align="center"><a href="advsearch.php">Advanced Search</a> </td></tr>
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No open auctions or vehicles match your search criteria.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="9"><?php echo $nav_links; ?></td></tr>
   <tr>
	<td></td>
    <td class="header"><b>Auction Title</b></td>
    <td class="header"><b>Year</b></td>
    <td class="header"><b>Make</b></td>
    <td class="header"><b>Model</b></td>
    <td class="header"><b>Miles/Hours</b></td>
<?php if (!has_priv('view', $privs)) { ?>
    <td align="center" class="header"><b>High Bid (US)</b></td>
    <td align="center" class="header"><b># of Bids</b></td>
<?php } ?>
    <td class="header"><b>Location</b></td>
	<td class="header"><b>Time Left</b></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $title, $current_bid, $reserve_price, $starting_price, $ends, $category, $year, $make,
	    $model, $miles, $hours, $photo_id, $vid, $location,
       $status, $d_id) = db_row($result)) {


		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

      if($status == null) {
         $noauction = true;
      } else {
         $noauction = false;
      }

      /*
      No longer need this check

      if($noauction && ($d_id == $_SESSION['dealer_id'])) {
         continue;
      }
      */

      $page = ($noauction) ? 'vehicles/preview' : 'auction';

      if($noauction) {
         $id = $vid;
         $title = "(Request Auction)";
      }

		$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
		list($photoid) = db_row($r);
		db_free($r);

		if ($photo_id == 0)
			$photo_id = $photoid;

		if ($photo_id > 0)
			$pic = '<img src="uploaded/thumbnails/'.$photo_id.'.jpg" alt="" border="0">';
		else
			$pic = '';


		if (!empty($hours) && $hours != 'Unknown')
			$mh = number_format($hours);
		elseif (!empty($miles))
			$mh = number_format($miles);
      else
         $mh = '';


      if($noauction) {
         $timeleft = 'N/A';
         $current_bid_format = 'N/A';
      } else {
		$timeleft = timeleft($ends);
         if (empty($timeleft) || $timeleft < 0)
            $timeleft = '<font color="#FF0000">closed</font>';

         if (empty($current_bid) || $current_bid <= 0)
            $current_bid_format = '$' . number_format($starting_price, 2);
         else
            $current_bid_format = '$' . number_format($current_bid, 2);
      }


      if($noauction) {
         $num_bids = 'N/A';
      } else {
         $r = db_do("SELECT COUNT(*) FROM bids WHERE auction_id='$id'");
         list($num_bids) = db_row($r);
         db_free($r);
         if(empty($num_bids)) $num_bids = '0';
      }

		$r = db_do("SELECT COUNT(*) FROM photos WHERE " .
		    "vehicle_id='$vid'");
		list($count) = db_row($r);
		db_free($r);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">



	<td class="normal" align="center"><a href="<?php echo $page ?>.php?id=<?php echo $id; ?>"><?php tshow($pic); ?></a></td>

   <td class="normal"><a href="<?php echo $page ?>.php?id=<?php echo $id; ?>"><?php tshow($title); ?></a>


   <?php if(!$noauction) { ?>
		<?php if ($current_bid >= $reserve_price && $reserve_price > 0) { echo "<br><font color=#009900>(reserve met)</font>"; }
				elseif ($reserve_price <= 0) { echo "<br><font color=#009900>(no reserve)</font>"; }?></td>
   <?php } ?>


    <td class="normal"><?php tshow($year); ?></td>

    <td class="normal"><?php tshow($make); ?></td>

    <td class="normal"><?php tshow($model); ?></td>

    <td class="normal"><?php tshow($mh); ?></td>

<?php if (!has_priv('view', $privs)) { ?>
    <td align="center" class="normal"><?php echo $current_bid_format; ?></td>
	<td align="center" class="normal"><?php tshow($num_bids); ?></td>
<?php } ?>

    <td class="normal" width="50"><?php tshow($location); ?></td>

	<td class="normal" width="50"><?php tshow($timeleft); ?></td>

   </tr>
<?php
	}
}

db_free($result);
db_disconnect();
?>
<tr><td colspan="9"><br><?php echo $nav_links; ?></td></tr>
  </table>

<?php include('footer.php'); ?>
