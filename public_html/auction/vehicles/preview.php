<?php
include('../../../include/session.php');
include('../../../include/db.php');
include('../../../include/back2search.php');

extract(defineVars("id","dealer_id")); //JJM 1/31/10

$caption = NULL; //JJM 1/12/2010 - added caption here, because of errors below.  Just needing to preset the variable to blank

if (empty($_GET['id']) || $_GET['id'] <= 0) {
	header('Location: ../index.php');
	exit;
}

$page_title = "Preview Auction for Vehicle #$id";
$help_page = "chp5_place.php";


db_connect();

$result = db_do("SELECT id FROM vehicles WHERE id='$id' AND dealer_id='$dealer_id'");
if (db_num_rows($result) <= 0) {
	 db_free($result);
	$not_yours = true;
} else {
   $not_yours = false;
}

$result = db_do("SELECT categories.name, vehicles.dealer_id, vehicles.year, " .
    		"vehicles.vin, vehicles.make, vehicles.model, vehicles.city, " .
    		"vehicles.state, vehicles.zip, vehicles.photo_id, vehicles.condition_report, " .
    		"vehicles.miles, vehicles.stock_num, vehicles.series, vehicles.body, "  .
			"vehicles.engine, vehicles.transmission, vehicles.interior_color, vehicles.exterior_color, "  .
			"vehicles.warranty, vehicles.title, vehicles.title_status, vehicles.certified, " .
			"vehicles.short_desc, vehicles.long_desc, ".
			"vehicles.seats, vehicles.fuel_type, vehicles.drive_train, vehicles.engine_size, vehicles.engine_make," .
				"vehicles.wheel_size, vehicles.payment_method, vehicles.horsepower, vehicles.hin, " .
				"vehicles.hours, vehicles.hours_unknown, vehicles.trailer, vehicles.length, vehicles.seating, vehicles.boat_use, " .
				"vehicles.engine_mech, vehicles.transmission_mech, vehicles.exhaust, vehicles.tires, " .
				"vehicles.brakes, vehicles.steering, vehicles.ac, vehicles.prop, " .
				"vehicles.gauges, vehicles.plumbing, vehicles.hvac, vehicles.a_seats, vehicles.kitchen, vehicles.bathroom, " .
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
				vehicles.instrument_panel, vehicles.bags_cond, vehicles.radiator, vehicles.windscreen, 		vehicles.warebars, vehicles.bellypan, vehicles.tunnell, vehicles.skis, vehicles.track, vehicles.cond_left, vehicles.cond_right, vehicles.tonguejack
				FROM categories, vehicles WHERE vehicles.id='$id' AND " .
    "vehicles.category_id=categories.id ");

if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}

$vid=$id;
list($category, $did, $year, $vin, $make, $model, $city, $state, $zip,
    $photo, $condition, $miles, $stock_num, $series, $body, $engine, $transmission, $interior_color,
	$exterior_color, $warranty, $title_item, $title_status, $certified, $veh_short_desc, $veh_long_desc,
		$seats, $fuel_type, $drive_train, $engine_size, $engine_make,
		$wheel_size, $payment_method, $horsepower, $hin,
		$hours, $hours_unknown, $trailer, $length, $seating, $boat_use,
		$engine_mech, $transmission_mech, $exhuast, $tires,
		$brakes, $steering, $ac, $prop,
		$gauges, $plumbing, $hvac, $a_seats, $kitchen, $bathroom,
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
		$wheels, $stereo_speakers, $suspension, $primary_drive, $instrument_panel, $bags_cond, $radiator, $windscreen, $warebars, $bellypan, $tunnell, $skis, $track, $left, $right, $tonguejack) = db_row($result);  //JJM tunnell was spelt wrong on this line, it only had one l, needs two to match the other instance
db_free($result);


$miles_format = number_format($miles, 0);
$hours_format = number_format($hours, 0);
if ($hours_unknown == 'yes' && $hours < 1)
	$hours_format = 'Unknown';

if ($category != 'Marine') {
	$description_report = array("VIN" => $vin, "HIN" => $hin,
		"Boat Length" => $length, "Use" => $boat_use, "Body" => $body, "Exterior Color" => $exterior_color,
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
				"Tires" => $tires, "Brakes" => $brakes, "Steering" => $steering, "Prop" => $prop,
				"Gauges" => $gauges, "plumbing" => $plumbing, "A/C" => $ac, "Wheels" => $wheels, "Stereo/Speakers" => $stereo_speakers,
				"Suspension" => $suspension, "Primary Drive" => $primary_drive, "Instrument Panel" => $instrument_panel, "HVAC" => $hvac,
				"Front Seats" => $front_seats, "Rear Seats" => $rear_seats, "Seats" => $a_seats,
				"Headliner" => $headliner, "Carpet" => $carpet,  "Dash" => $dash,
				"Kitchen" => $kitchen, "Bathroom" => $bathroom, "Furniture" => $furniture, "Electronics" => $electronics,
				"Paint" => $paint, "Hood" => $hood, "R Front Fender" => $r_f_fender, "L Front Fender" => $l_f_fender,
				"Roof" => $roof, "Front" => $front, "Rear" => $rear, "Starboard" => $starboard, "Port" => $port,
				"Stern" => $stern, "Bow" => $bow, "Trailer" => $b_trailer,
				"Right Door" => $r_door, "Left Door" => $l_door, "Front Fender" => $f_fender, "Rear Fender" => $r_fender,
				"Right Rear" => $r_rear, "Left Rear" => $l_rear, "Trunk" => $trunk, "Front Bumper" => $f_bumper,
				"Rear Bumper" => $r_bumper, "Side Bumper" => $s_bumper, "Grille" => $grille, "Tongue" => $tongue,
				"Glass" => $glass, "Frame" => $frame, "Bags" => $bags_cond, "Radiator" => $radiator, "Windscreen" => $windscreen, "Hull" => $hull, "Warebars" => $warebars, "Bellypan" => $bellypan, "Tunnell" => $tunnell, "Skis" => $skis, "Track" => $track, "Left" => $left, "Right" => $right, "Tongue Jack" => $tonguejack);

if (empty($photo)) {
	$result = db_do("SELECT id FROM photos WHERE vehicle_id='$vid' " .
	    "ORDER BY id LIMIT 1");

	if (db_num_rows($result) == 1)
		list($photo) = db_row($result);

	db_free($result);
}

if (!empty($photo) && file_exists("../uploaded/$photo.jpg")) {
	$image = "<img src=\"../uploaded/$photo.jpg\">";

	$result = db_do("SELECT caption FROM photos WHERE id='$photo'");
	list($caption) = db_row($result);
	db_free($result);
} else
	$image = '&nbsp;';

include('../header.php');
?>

<?php back2search() ?>


<?php /* ************************************************** */
$pending = false;

$res = db_do("SELECT DATE_FORMAT(starts, '%a, %e %M %Y %H:%i') FROM auctions WHERE vehicle_id = $_GET[id] AND status = 'pending'");
if(db_num_rows($res) > 0) {
   list($start_time) = db_row($res);
   $pending = true;
   ?>

   <div class="iecenter">
   <div class="important">
      <h3>This item is scheduled for auction!  The auction will start on
      <span class="time"><?php echo date('j M Y g:ma T', strtotime($start_time))?></span>
      </h3>
   </div>
   </div>
   <?php
}

if(!$pending) {
   $res = db_do("SELECT COUNT(*) FROM request_auction WHERE vehicle_id = $_GET[id] AND dealer_id = $_SESSION[dealer_id]");
   list($rows) = db_row($res);
   ?>
   <?php if($not_yours && $rows < 1) {

      if (!has_priv('buy', $privs)) {
         ?>
         <div class="iecenter">
         <div class="important">
         <h3>A user with buying privileges may request
         an auction for this item.</h3>
         </div>
         </div>
         <?php
      } else {
         ?>
         <div class="iecenter">
         <div class="important">
         <h3>This item is currently <em>not</em> in auction!</h3>
         <form action="request_auction.php" method="POST">
         <input type="hidden" name="vid" value="<?php echo $_GET['id']?>" />
         <input type="submit" value="Request Auction" name="submit">
         </form>
         </div>
         </div>
         <?php
      }

   } else {
      if($rows > 0) {
         ?>
         <div class="iecenter">
         <div class="important">

    <h3>Your dealership has requested an auction for this item.</h3>
  </div>
         </div>
         <?php
      } else {
         ?>
         <div class="iecenter">
         <div class="important">
         <h3>This item belongs to your dealership.</h3>
			 <form action="../auctions/add.php" method="POST">
			 <input type="hidden" name="vid" value="<?php echo $_GET['id']?>" />
			 <input type="submit" value="Create Auction" name="submit1">
			 </form>
         </div>
         </div>

         <?php
      }
   }
}
?>
<?php /* ************************************************** */ ?>




<br />
<table align="center" border="0" cellpadding="2" cellspacing="0">

  <tr>
    <td class="big"><b><nobr><?php echo $title_item; /* JJM 1/11/2010 Added _item, $title wasn't found as is */ ?></nobr></b></td>
    <td align="right" class="big">Preview Auction for Vehicle #<?php echo $id; ?></td>
  </tr>
  <tr>
    <td class="normal" colspan="2"><h3 style="margin: 0"><?php echo "$year $make $model"; ?></h3>
    <h4 style="margin: 0"><?php echo "$city $state $zip" ?></h4>
    </td>
 </tr>

 <?php if (!$not_yours) { ?>
 <tr>
  <td class="normal" width="625" colspan="2"><?php echo $image; ?><br />
          <?php echo $caption; ?></td>
  </tr>
 <?php } ?>

  <tr>
    <td class="small" colspan="2">
      <?php
    if ($category == "Passenger Vehicles") { ?>
      <a href="http://www.carfax.com/cfm/ccc_displayhistoryrpt.cfm?partner=DTD_0&vin=<?php echo $vin ?>" style="border: none" target="_blank"><img src="/images/carfax.gif" alt="Click here for a CARFAX report on this vehicle!" style="border: none;" width="40" height="32" /></a>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="small" colspan="2">&nbsp;</td>
  </tr>
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
    <td colspan="2" class="normal"><?php echo $veh_long_desc; ?></td>
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
			if(count($a) > 1) //JJM 1/31/10 added this if statement, in case there isn't a value
			    $p2 = $a[1];
		    else
		    	$p2 = "";

			if($p1 != "Not Rated" && $p1 != "Not Rated." && trim($p1) != ""){  //JJM 1/11/2010 the middle $p1 used to be $pi, I think this was a typo
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
$result = db_do("SELECT id, caption FROM photos WHERE vehicle_id='$vid' AND id!='$photo'");
if (db_num_rows($result) > 0 && !$not_yours) {
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
    <td class="normal" colspan="2"><img src="../uploaded/<?php echo $pid; ?>.jpg"><br />
        <?php echo $caption; ?></td>
  </tr>
  <?php
	}
}
?>
  <tr>
    <td class="small" colspan="2"></td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="normal">
      <?php
// JJM 1/1/2010 I had to add the following two lines, because they seem to have been missing.
$result = db_do("SELECT views FROM auctions WHERE id='$vid'");
list($views) = db_row($result);

if ($views <= 9999)
	$views = sprintf("%04d", $views);

for ($i = 0; $i < strlen($views); $i++)
	echo '<img src="../../digits/' . $views[$i] . '.gif">';

db_free($result);
db_disconnect();
?>
    </td>
  </tr>
</table>

<?php back2search() ?>

<?php include('../footer.php'); ?>
