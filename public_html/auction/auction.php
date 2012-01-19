<?php
#
# $Id: auction.php 571 2006-09-26 13:52:54Z kaneda $
#

include('../../include/session.php');
include('../../include/db.php');
include('../../include/back2search.php');

extract(defineVars("id","add","userid","when","caption","submit"));  //JJM  1/13/10

function addToWatchList ($id, $userid, $when)
{
	$reminder = minus5Hours($when);
  db_do("INSERT INTO watch_list SET user_id='$userid', auction_id='$id', reminder=FROM_UNIXTIME('$reminder') + 0, created=NOW()" );
   return db_insert_id();
}

$page_title = "Auction #$id";
$help_page = "chp5_place.php";


if (empty($id) || $id <= 0) {
	header('Location: index.php');
	exit;
}

db_connect();


if ($add=="1") {  //JJM 1/31/10  took out $_GET reference
	 $wid = addToWatchList($id, $userid, $when);
	 header("Location: auctions/edit_watch.php?id=$wid");
	 exit();
}

$added_to_watch_list = 0;
$result = db_do("SELECT COUNT(*) FROM watch_list WHERE user_id='$userid' and auction_id='$id'");
list($count_watches) = db_row($result);
db_free($result);

if (!empty($count_watches))
	$added_to_watch_list = 1;

$result = db_do("SELECT can_buy FROM dealers WHERE id='$dealer_id'");
list($can_buy) = db_row($result);
db_free($result);

$result = db_do("SELECT categories.name, auctions.title, auctions.status, " .
    "auctions.description, auctions.add_description, auctions.condition_report, auctions.add_condition, " .
		"DATE_FORMAT(auctions.desc_mod, '%a, %e %M %Y %H:%i'), DATE_FORMAT(auctions.cond_mod, '%a, %e %M %Y %H:%i')," .
		"auctions.minimum_bid, auctions.reserve_price, auctions.reserve_lowered, auctions.winning_bid, " .
    	"auctions.buy_now_price, auctions.buy_now_end, auctions.current_bid, auctions.bid_increment, " .
    	"auctions.dealer_id, DATE_FORMAT(auctions.starts, '%a, %e %M %Y %H:%i'), " .
    	"DATE_FORMAT(auctions.ends, '%a, %e %M %Y %H:%i'), auctions.ends, " .
    	"auctions.vehicle_id, auctions.pays_transport, auctions.disable_bid, vehicles.year, " .
    		"vehicles.vin, vehicles.make, vehicles.model, vehicles.city, " .
    		"vehicles.state, vehicles.zip, vehicles.photo_id, vehicles.condition_report, " .
    		"vehicles.miles, vehicles.stock_num, vehicles.series, vehicles.body, "  .
			"vehicles.engine, vehicles.transmission, vehicles.interior_color, vehicles.exterior_color, "  .
			"vehicles.warranty, vehicles.title, vehicles.title_status, vehicles.certified, " .
			"vehicles.short_desc, vehicles.long_desc, dealers.rating, ".
				"vehicles.seats, vehicles.fuel_type, vehicles.drive_train, vehicles.engine_size, vehicles.engine_make," .
				"vehicles.wheel_size, vehicles.payment_method, vehicles.horsepower, vehicles.hin, " .
				"vehicles.hours, vehicles.hours_unknown, vehicles.trailer, vehicles.length, vehicles.seating, vehicles.boat_use, " .
				"vehicles.engine_mech, vehicles.transmission_mech, vehicles.exhaust, vehicles.tires, " .
				"vehicles.brakes, vehicles.steering, vehicles.ac, vehicles.prop, vehicles.generator, " .
				"vehicles.gauges, vehicles.plumbing, vehicles.hvac, vehicles.a_seats, vehicles.floor, vehicles.kitchen, vehicles.bathroom, " .
				"vehicles.furniture, vehicles.hood, vehicles.roof, vehicles.front, vehicles.rear, vehicles.starboard, " .
				"vehicles.port, vehicles.stern, vehicles.bow, vehicles.b_trailer, " .
				"vehicles.front_seats, vehicles.rear_seats, vehicles.carpet,  " .
				"vehicles.headliner, vehicles.dash, vehicles.electronics, " .
				"vehicles.paint, vehicles.hood, vehicles.r_f_fender, vehicles.l_f_fender, " .
				"vehicles.r_door, vehicles.l_door, vehicles.f_fender, vehicles.r_fender, " .
				"vehicles.r_rear, vehicles.l_rear, vehicles.trunk, vehicles.f_bumper, vehicles.r_bumper, vehicles.s_bumper, " .
				"vehicles.grille, vehicles.tongue, vehicles.hitch, vehicles.glass, vehicles.frame, vehicles.hull, " .
				"vehicles.gps, vehicles.fish_finder, vehicles.depth_finder, vehicles.security_system, ".
				"vehicles.slide_out, vehicles.ac_yn, vehicles.sleep_no,
				vehicles.trailer_spare, vehicles.trailer_brakes, vehicles.trailer_material, vehicles.trailer_axle,
				vehicles.trailer_type, vehicles.trailer_year, vehicles.stereo, vehicles.bags,
				vehicles.wheels, vehicles.stereo_speakers, vehicles.suspension, vehicles.primary_drive,
            vehicles.instrument_panel, vehicles.bags_cond, vehicles.radiator, vehicles.windscreen, vehicles.series, vehicles.warebars, vehicles.bellypan, vehicles.tunnell, vehicles.skis, vehicles.track, vehicles.cond_left, vehicles.cond_right, vehicles.tonguejack
				FROM auctions
				LEFT JOIN categories ON auctions.category_id=categories.id
				LEFT JOIN vehicles ON auctions.vehicle_id=vehicles.id
				LEFT JOIN dealers ON auctions.dealer_id=dealers.id
				WHERE auctions.id='$id'");  //JJM 1/31/2010  I altered the where clause from the old style to the explicit join, I also left joined to bring back records in case there isn't a category, etc


if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}

list($category, $title, $status, $description, $add_description, $condition, $add_condition, $desc_mod, $cond_mod,
	$minimum_bid, $reserve_price, $reserve_lowered, $winning_bid,
    $buy_now_price, $buy_now_end, $current_bid, $bid_increment, $did, $starts, $ends, $when,
    $vid, $pays_transport, $invoice, $year, $vin, $make, $model, $city, $state, $zip,
    $photo, $veh_condition, $miles, $stock_num, $series, $body, $engine, $transmission, $interior_color,
	$exterior_color, $warranty, $title_item, $title_status, $certified, $veh_short_desc, $veh_long_desc, $rating,
		$seats, $fuel_type, $drive_train, $engine_size, $engine_make,
		$wheel_size, $payment_method, $horsepower, $hin,
		$hours, $hours_unknown, $trailer, $length, $seating, $boat_use,
		$engine_mech, $transmission_mech, $exhuast, $tires,
		$brakes, $steering, $ac, $prop, $generator,
		$gauges, $plumbing, $hvac, $a_seats, $floor, $kitchen, $bathroom,
		$furniture, $hood, $roof, $front, $rear, $starboard,
		$port, $stern, $bow, $b_trailer,
		$front_seats, $rear_seats, $carpet,
		$headliner, $dash, $electronics,
		$paint, $hood, $r_f_fender, $l_f_fender,
		$r_door, $l_door, $f_fender, $r_fender,
		$r_rear, $l_rear, $trunk, $f_bumper, $r_bumper, $s_bumper,
		$grille, $tongue, $hitch, $glass, $frame, $hull,
		$gps, $fish_finder, $depth_finder, $security_system, $slide_out, $ac_yn, $sleep_no,
		$trailer_spare, $trailer_brakes, $trailer_material, $trailer_axle, $trailer_type, $trailer_year, $stereo, $bags,
      $wheels, $stereo_speakers, $suspension, $primary_drive, $instrument_panel, $bags_cond, $radiator, $windscreen, $series, $warebars, $bellypan, $tunnell, $skis, $track, $left, $right, $tonguejack) = db_row($result); //JJM 1/31/10  had to add an l on the end of tunnel
db_free($result);




$miles_format = number_format($miles, 0);
$hours_format = number_format($hours, 0);
if ($hours_unknown == 'yes' && $hours < 1)
	$hours_format = 'Unknown';

if ($category != 'Marine') {
	$description_report = array("VIN" => $vin, "HIN" => $hin,
		"bOAT lEngth" => $length, "Use" => $boat_use, "Body" => $body, "Exterior Color" => $exterior_color,
		"Interior Color" => $interior_color, "Seat Surface" => $seats, "Max Seating Capacity" => $seating, "Wheel Size" => $wheel_size,
		"Miles" => $miles_format, "Hours" => $hours_format, "Engine" => $engine,
		"Engine Size" => $engine_size, "Engine Make" => $engine_make, "Horsepower" => $horsepower,
		"Drive Train" => $drive_train, "Transmission" => $transmission, "Fuel Type" => $fuel_type,
		"Title" => $title_item, "Title Status" => $title_status, "Warranty" => $warranty,
		"Certified" => $certified, "GPS/Navigation System" => $gps, "Security System" => $security_system,
		"Hitch" => $hitch, "Trailer Included" => $trailer, "Fish Finder" => $fish_finder,
		"Depth Finder" => $depth_finder, "Slide Out" => $slide_out, "Air Conditioning" => $ac_yn,
		"Stereo" => $stereo, "Bags" => $bags, "Max Sleeping Capacity" => $sleep_no);
} else {
	$description_report = array("VIN" => $vin, "HIN" => $hin,
		"Boat Length" => $length, "Use" => $boat_use, "Hull Material" => $body, "Exterior Color" => $exterior_color,
		"Interior Color" => $interior_color, "Seat Surface" => $seats, "Max Seating Capacity" => $seating, "Wheel Size" => $wheel_size,
		"Miles" => $miles_format, "Hours" => $hours_format, "Engine" => $engine,
		"Engine Size" => $engine_size, "Engine Make" => $engine_make, "Horsepower" => $horsepower,
		"Drive Train" => $drive_train, "Transmission" => $transmission, "Fuel Type" => $fuel_type,
		"Title" => $title_item, "Title Status" => $title_status, "Warranty" => $warranty,
		"Certified" => $certified, "GPS/Navigation System" => $gps, "Security System" => $security_system,
		"Hitch" => $hitch, "Trailer Included" => $trailer, "Fish Finder" => $fish_finder,
		"Depth Finder" => $depth_finder, "Slide Out" => $slide_out, "Air Conditioning" => $ac_yn, "Max Sleeping Capacity" => $sleep_no);
}

$condition_report = array("Engine" => $engine_mech, "Transmission" => $transmission_mech, "Exhuast" => $exhuast,
				"Tires" => $tires, "Brakes" => $brakes, "Steering" => $steering, "Prop" => $prop,  "Generator" => $generator,
				"Gauges" => $gauges, "plumbing" => $plumbing, "A/C" => $ac, "Wheels" => $wheels, "Stereo/Speakers" => $stereo_speakers,
				"Suspension" => $suspension, "Primary Drive" => $primary_drive, "Instrument Panel" => $instrument_panel, "HVAC" => $hvac,
				"Front Seats" => $front_seats, "Rear Seats" => $rear_seats, "Seats" => $a_seats, "Floor" => $floor,
				"Headliner" => $headliner, "Carpet" => $carpet,  "Dash" => $dash,
				"Kitchen" => $kitchen, "Bathroom" => $bathroom, "Furniture" => $furniture, "Electronics" => $electronics,
				"Paint" => $paint, "Hood" => $hood, "R Front Fender" => $r_f_fender, "L Front Fender" => $l_f_fender,
				"Roof" => $roof, "Front" => $front, "Rear" => $rear, "Starboard" => $starboard, "Port" => $port,
				"Stern" => $stern, "Bow" => $bow, "Trailer" => $b_trailer,
				"Right Door" => $r_door, "Left Door" => $l_door, "Front Fender" => $f_fender, "Rear Fender" => $r_fender,
				"Right Rear" => $r_rear, "Left Rear" => $l_rear, "Trunk" => $trunk, "Front Bumper" => $f_bumper,
				"Rear Bumper" => $r_bumper, "Side Bumper" => $s_bumper, "Grille" => $grille, "Tongue" => $tongue,
            	"Glass" => $glass, "Frame" => $frame, "Bags" => $bags_cond, "Radiator" => $radiator, "Windscreen" => $windscreen,
            	"Hull" => $hull, "Warebars" => $warebars, "Bellypan" => $bellypan, "Tunnell" => $tunnell, "Skis" => $skis,
            	"Track" => $track, "Left" => $left, "Right" => $right, "Tongue Jack" => $tonguejack);


db_do("UPDATE auctions SET views=views+1 WHERE id='$id'");
$result = db_do("SELECT views FROM auctions WHERE id='$id'");
list($views) = db_row($result);
db_free($result);

$timezone = date('T');

$starts .= " $timezone";
$ends   .= " $timezone";

$timeleft = timeleft($when);
if (empty($timeleft) || $timeleft < 0)
	$timeleft = '<font color="#FF0000">closed</font>';
if ($status == 'pulled') {
	$timeleft = '<font color="#009900">pulled</font>';
	$ends = '<font color="#003300">N/A</font>';
}

echo "<!-- INVOICE:$invoice, TIMELEFT: $timeleft -->";

$result = db_do("SELECT COUNT(*) FROM bids WHERE auction_id='$id'");
list($count_bids) = db_row($result);
db_free($result);

if (empty($count_bids))
	$count_bids = 0;

if ($current_bid >= $minimum_bid) {
	$new_bid = number_format($current_bid + $bid_increment, 2);
	$newbid = $current_bid + $bid_increment;
} else {
	$new_bid = number_format($minimum_bid, 2);
	$newbid = $minimum_bid;
}

if (empty($photo)) {
	$result = db_do("SELECT id FROM photos WHERE vehicle_id='$vid' " .
	    "ORDER BY id LIMIT 1");

	if (db_num_rows($result) == 1)
		list($photo) = db_row($result);

	db_free($result);
}

if (!empty($photo) && file_exists("uploaded/$photo.jpg")) {
	$image = "<img src=\"uploaded/$photo.jpg\">";

	$result = db_do("SELECT caption FROM photos WHERE id='$photo'");
	list($caption) = db_row($result);
	db_free($result);
} else
	$image = '&nbsp;';

$payment_method = str_replace(",",", ",$payment_method);

include('header.php');
?>

<?php back2search(); ?>

<center><h2><?php echo $title; ?></h2></center>
<table align="center" border="0" cellpadding="2" cellspacing="0" style="width: 100%;">
  <tr>
    <td class="normal"  style="width: 50%;"><nobr><h3 style="margin: 0;"><?php echo "$year $make $model $series"; ?>
    </h3>
    </nobr>
    <h4 style="margin: 0;"><?php echo "$city $state $zip"; ?></h4></td>
    <?php if ( $added_to_watch_list == 1 ) { ?>
    <td align="left" class="normal" style="width: 50%">
      <?php echo "Auction #$id"; ?><br />
       This auction has been added to your watch list</td>
    <?php } else { ?>
    <td align="left" class="normal" style="width: 50%">
      <?php echo "Auction #$id"; ?>
      <?php if ($can_buy && has_priv('buy', $privs) && $status == 'open') { ?>

      <form action="auction.php?add=1" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
        <input type="hidden" name="when" value="<?php echo $when; ?>" />
        <input type="submit" name="submit" value="Add to my watch list">
    </form><?php } // end can-buy if ?></td>
    <?php } ?>
  </tr>
  <td class="normal" colspan="2"><?php echo $image; ?><br />
          <?php echo $caption; ?></td>
  </tr>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
    <?php if ($winning_bid > 0 && $current_bid >= $reserve_price) {
			$result_bid = db_do("SELECT dealer_id FROM bids WHERE id='$winning_bid' ");
			list($bid_did) = db_row($result_bid);
			if ($bid_did == $dealer_id) { ?>
  <tr>
    <td align="center" colspan="2" class="header"><font color="#006600">You Are Currently Winning This Auction.</font><br>&nbsp;</td>
  </tr>
  <?php
			}
		} ?>

<?php if(!has_priv('view', $privs)) { ?>
<?php
    if ($category == "Passenger Vehicles") { ?>
<tr>
    <td class="normal">
    <a href="http://www.carfax.com/cfm/ccc_displayhistoryrpt.cfm?partner=DTD_0&vin=<?php echo $vin ?>" style="border: none" target="_blank"><img src="/images/carfax.gif" alt="Click here for a CARFAX report on this vehicle!" style="border: none;" /></a>
    </td>
   <?php } ?>
</tr>
<?php if ($rating > 0) { ?>
 <tr>
    <td class="normal"><b>Seller Rating: </b><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/auction/ratings.php?id=<?php echo $id; ?>"> <?php echo $rating; ?> </a></td>
</tr>
<?php } ?>
 <tr>

<td colspan="8">
<?php if ($can_buy && has_priv('buy', $privs) && $status == 'open' &&  $did != $dealer_id) { ?>
            <table width="200" border="0" cellpadding="0" cellspacing="0" align="left">
			<?php $result_fee = db_do("SELECT percentage FROM fees WHERE low<='$newbid' AND high>='$newbid'");
					list($buy_fee_per) = db_row($result_fee);

					$buy_fee = ($newbid * $buy_fee_per) / 100; ?>
              <form action="bid.php" method="post">
			  <tr>
                <td align="left" class="small">

                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="amount" value="<?=$new_bid?>" />&nbsp;&nbsp;
                    <?php if (!empty($timeleft) && $timeleft > 0 && $invoice=='no') { ?>
                    <input name="submit2" type="submit" value=" Place Bid of US $<?php echo $new_bid; ?>" />
					<tr><td class="small" align="left">Estimated Buy Fee: <b>$<?php echo number_format($buy_fee,2); ?><br>&nbsp;</b>
				</td>
			</tr>
                    <?php } ?></td>
			  </tr>

			</form>
              <?php if ((($current_bid < $buy_now_end)
			  			|| $invoice=='yes') && $buy_now_price > 0
						&& !empty($timeleft) && $timeleft > 0 ) {
			  	$result_fee = db_do("SELECT percentage FROM fees WHERE low<='$buy_now_price' AND high>='$buy_now_price'");
				list($buy_now_fee_per) = db_row($result_fee);

				$buy_now_fee = ($buy_now_price * $buy_now_fee_per) / 100; ?>
              <form action="buy_now.php" method="post"><tr>
                <td align="left" class="small">
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />&nbsp;&nbsp;
                    <input name="submit" type="submit" value=" Buy Now for US $<?php echo number_format($buy_now_price, 2); ?> " />
				</td>
              </tr>
					<tr><td class="small" align="left">Buy Now Fee: <b>$<?php echo number_format($buy_now_fee,2); ?>&nbsp;</b>
                </td>
              </tr></form>
              <?php } ?>
            </table>
            <?php } ?>

</td>
</tr>
<tr>

    <td class="normal">
    <hr />
    <b>Auction Details</b></td>
    <?php if ($reserve_lowered == 'yes' && $current_bid < $reserve_price) { ?>
    <td class="normal"><img src="images/reserveLowered_small.gif" align='left'><font color="#0E5907"><b>The seller lowered <br>
      the reserve price</b></font></td>

    <?php } ?>
  </tr>
  <tr>
    <td colspan="2">
      <table border="0" cellpadding="4" cellspacing="0">
        <tr>
          <td><?php if ($can_buy && has_priv('buy', $privs) && $status == 'open') { ?>
        <!--    <table border="0" cellpadding="2" cellspacing="0"> -->
              <?php
if ($status == 'open') {
	if ($current_bid >= $minimum_bid) {
		if ($current_bid < $reserve_price) {
			$foo = '&nbsp;&nbsp;<font color="#FF0000"><b><br>(reserve not met)</b></font>';
		}
		elseif ($reserve_price >= 0)
			$foo = '&nbsp;&nbsp;<font color="#0E5907"><b><br>(reserve met)</b></font>';
		else
			$foo = '';
?>
              <tr>
                <td class="normal">Current bid</td>
                <td class="normal"><b>US $<?php echo number_format($current_bid, 2); ?></b><?php echo $foo; ?></td>
              </tr>
              <?php
	} else {
?>
              <tr>
                <td class="normal">Bidding starts at</td>
                <td class="normal"><b>US $<?php echo number_format($minimum_bid, 2); ?></b></td>
              </tr>
              <tr>
                <td class="small" colspan="2">&nbsp;</td>
              </tr>
              <?php
	}
}
?>
              <?php
if ($did == $dealer_id && (has_priv('buy', $privs) ||
    has_priv('sell', $privs))) {
?>
              <tr>
                <td class="normal">Bid Increment</td>
                <td class="normal"><b>US $<?php echo number_format($bid_increment, 2); ?></b></td>
              </tr>
              <tr>
                <td class="normal">Reserve Price</td>
                <td class="normal"><b>US $<?php echo number_format($reserve_price, 2); ?></b></td>
              </tr>
              <tr>
                <td class="normal">Buy Now End Price</td>
                <td class="normal"><b>US $<?php echo number_format($buy_now_end, 2); ?></b></td>
              </tr>
              <tr>
                <td class="normal">Buy Now Price</td>
                <td class="normal"><b>US $<?php echo number_format($buy_now_price, 2); ?></b></td>
              </tr>
              <?php
}
?> <!-- </table> --> <?php
} //end if status == open
?>
              <tr>
                <td class="normal">Number of bids</td>
                <td class="normal"><b><?php echo $count_bids; ?></b></td>
              </tr>
              <tr>
                <td class="normal">Time left</td>
                <td class="normal"><b><?php echo $timeleft; ?></b></td>
              </tr>
              <tr>
                <td class="normal">Starts</td>
                <td class="normal"><b><?php echo $starts; ?></b></td>
              </tr>
              <tr>
                <td class="normal">Ends</td>
                <td class="normal"><b><?php echo $ends; ?></b></td>
              </tr>
              <tr>
                <td class="normal">Who pays transport?</td>
                <td class="normal"><b><?php echo ucfirst($pays_transport); ?></b></td>
              </tr>
			  <tr>
                <td class="normal">Payment methods:</td>
                <td class="normal"><b><?php echo $payment_method; ?></b></td>
              </tr>
             </td>

          <td colspan="2" valign="top">
          </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="small" colspan="2"><hr></td>
  </tr>
  <?php } ?>
  <tr>
    <td class="normal" colspan="2" align="center"><b>Item Description </b></td>
  </tr>

  <tr>
    <td colspan="2" align="center">
    </td>
  </tr>
  <?php
  		$first_column = TRUE;
		do {
			if (current($description_report)) {
				if ($first_column == TRUE) {
					echo "<tr><td width='50%' class=normal>".key($description_report).": <b>".current($description_report)."</b></td>";
					$first_column = FALSE;
				}
				else {
					echo "<td width='50%' class=normal>".key($description_report).": <b>".current($description_report)."</b></td></tr>";
					$first_column = TRUE;
				}
			}
			next($description_report);

			if(key($description_report) == "Miles" || key($description_report) == "Title"){
				if ($first_column = TRUE)
					echo "<tr>";
				echo "<td>&nbsp;</td></tr>";
				$first_column = TRUE;
			}


		}while (key($description_report));

		if ($trailer == 'Yes') {

			if ($trailer_spare == '')
				$trailer_spare = 'N/A';
			if ($trailer_brakes == '')
				$trailer_brakes = 'N/A';
			if ($trailer_material == '')
				$trailer_material = 'N/A';
			if ($trailer_axle == '')
				$trailer_axle = 'N/A';
			if ($trailer_type == '')
				$trailer_type = 'N/A';
			if (!($trailer_year > 0))
				$trailer_year = 'N/A';

			?>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td class="normal" align="left">Trailer Year: <strong><?=$trailer_year?></strong></td>
				<td class="normal" align="left">Trailer Material: <strong><?=$trailer_material?></strong></td>
			</tr>
			<tr>
				<td class="normal" align="left">Trailer Type: <strong><?=$trailer_type?></strong></td>
				<td class="normal" align="left">Trailer Brakes: <strong><?=$trailer_brakes?></strong></td>
			</tr>
			<tr>
				<td class="normal" align="left">Traler Spare Tire: <strong><?=$trailer_spare?></strong></td>
				<td class="normal" align="left">Trailer Axle: <strong><?=$trailer_axle?></strong></td>
			</tr>
		<?php }
?>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="normal" colspan="2"><b>Item Description</b></td>
  </tr>
  <tr>
    <td colspan="2" class="normal"><?php echo $description; ?></td>
  </tr>
  <?php if (!empty($add_description)) { ?>
  <td colspan="2">&nbsp;</td>
  <tr>
    <td class="normal" colspan="2"><b>The dealer added the following information on <?php echo $desc_mod ?></b></td>
  </tr>
  <tr>
    <td colspan="2" class="normal"><?php echo $add_description; ?></td>
  </tr>
  <?php } ?>
  <tr>
     <td class="small" colspan="2"><hr></td>
  </tr>
  <tr>
    <td class="normal" colspan="2" align="center"><b>Condition Report </b></td>
  </tr>
  <td class="normal" colspan="2"><b>Item Condition</b></td>
  </tr>
  <tr>
    <td colspan="2" class="normal"><?php echo $condition; ?></td>
  </tr>
  <?php if (!empty( $add_condition)) { ?>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="normal" colspan="2"><b>The dealer added the following information on <?php echo $cond_mod ?></b></td>
  </tr>
  <tr>
    <td colspan="2" class="normal"><?php echo $add_condition; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
</table>
<table align="center" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td align="center" bgcolor="#00cc00"><font color="#FFFFFF"><b>&nbsp;Excellent&nbsp;</b></font></td>
			<td align="center" bgcolor="#0000cc"><font color="#FFFFFF"><b>&nbsp;Good&nbsp;</b></font></td>
			<td align="center" bgcolor="#ffff00"><b>&nbsp;Average&nbsp;</b></font></td>
			<td align="center" bgcolor="#cc0000"><font color="#FFFFFF"><b>&nbsp;Poor&nbsp;</b></font></td>
		</tr>
</table><br>
 <table align="center" border="0" cellpadding="4" cellspacing="0">
 <tr>
  <td colspan="2" class="normal"><b><u>Mechanics</u></b></td>
 </tr>
  <?php
  		$any_ratings = FALSE;
      foreach ($condition_report as $con_key => $con_value) {
			$a = explode(',', $con_value, 2);
			if($con_key == "Front Seats") {
				if ($any_ratings == FALSE)
					echo "<td colspan=3 class=normal align=left>&nbsp;&nbsp;No Ratings for this section</td>";
				echo "<tr><td colspan=3 class=normal><b><u>Interior</u></b></td></tr>";
				$any_ratings = FALSE;
			}
			if($con_key == "Paint") {
				if ($any_ratings == FALSE)
						echo "<td colspan=3 class=normal align=left>&nbsp;&nbsp;No Ratings for this section</td>";
				echo "<tr><td colspan=3 class=normal><b><u>Exterior</u></b></td></tr>";
				$any_ratings = FALSE;
			}
			$p1 = $a[0];

			//JJM 2/2/2010 added if statement to prevent undefined offset
			if(count($a)>1)
		         $p2 = $a[1];
		    else
		    	$p2 = "";

			if($p1 != "Not Rated" && $p1 != ""){
				$any_ratings = TRUE;
				echo "<tr><td class=normal><b>&nbsp;&nbsp;".$con_key.":</b></td>";
				if ($p1 == "Excellent")
					echo "<td align=center bgcolor=#00cc00><font color=#FFFFFF><b>E</b></font></td><td>";
				if ($p1 == "Good")
					echo "<td align=center bgcolor=#0000cc><font color=#FFFFFF><b>G</b></font></td><td>";
				if ($p1 == "Average")
					echo "<td align=center bgcolor=#ffff00><b>A</b></font></td><td>";
				if ($p1 == "Poor")
					echo "<td align=center bgcolor=#cc0000><font color=#FFFFFF><b>P</b></font></td><td>";
				if ($p2 != "")
					echo $p2;
				echo "</td></tr>";
			}
		}
		if ($any_ratings == FALSE)
			echo "<tr><td colspan=3 class=normal align=left>&nbsp;&nbsp;No Ratings for this section</td></tr>";?>
 </table>
 <table align="center" border="0" cellpadding="4" cellspacing="0">  <?php
$result = db_do("SELECT id, caption FROM photos WHERE vehicle_id='$vid' AND " .
    "id!='$photo'");
if (db_num_rows($result) > 0) {
?>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normal"><b>Additional Pictures</b></td>
  </tr>
  <?php
	while (list($pid, $caption) = db_row($result)) {
?>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="normal" colspan="2"><img src="uploaded/<?php echo $pid; ?>.jpg"><br />
        <?php echo $caption; ?></td>
  </tr>
  <?php
	}
}

db_free($result);
db_disconnect();
?>
  <tr>
    <td class="small" colspan="2"></td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="normal">
      <?php
if ($views <= 9999)
	$views = sprintf("%04d", $views);

for ($i = 0; $i < strlen($views); $i++)
	echo '<img src="/digits/' . $views[$i] . '.gif">';
?>
    </td>
  </tr>
</table>

<?php back2search(); ?>

<?php include('footer.php'); ?>
