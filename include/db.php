<?php

include_once("defineVars.php");
						// RJM added for checking the variables.  12.29.09



// $Id: db.php 354 2006-07-11 20:59:45Z kaneda $

//define('DB_HOST',		'p50mysql335.secureserver.net');
define('DB_HOST',		'localhost');
//define('DB_NAME', 	'gdtdrestore');
define('DB_NAME',		'godealertodealer');
//define('DB_PASSWORD',		'gdtdlord610');
define('DB_PASSWORD',		'Gdtd6330');
define('DB_USER',			'godealertodealer');



function db_connect() {

        global $db;

        $db = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            or die("Unable to connect to the database server");
        mysql_select_db(DB_NAME, $db)
            or die("Unable to select the database");
}

function db_disconnect() {
        global $db;

        mysql_close($db);
}

function db_do($sql) {
        global $db;

#	error_log("sql = $sql");
        $result = mysql_query($sql, $db)
            or die("Query failed: $sql<br />" . mysql_error());
        return $result;
}

function db_free($result) {
        mysql_free_result($result);
}

function db_insert_id() {
	return mysql_insert_id();
}

function db_num_rows($result) {
	return mysql_num_rows($result);
}

function db_row($result) {
        return mysql_fetch_array($result);
}

function fix_price($price) {
	$price = ereg_replace('^\$', '', $price); # strip leading dollar sign
	$price = ereg_replace(',', '', $price); # strip commas

	return trim($price);
}

function RemoveNonNumericChar($num) {
	// turn string into array
	for($i=0;$i<strlen($num);$i++) {
		if ((is_numeric(substr($num,$i,1))) || ((substr($num,$i,1))==".")) {
			$arr[$i]=substr($num,$i,1);
		}
	}
	if (isset($arr)) {
		$num=implode($arr);
		return $num;
	}
}


function RemoveSlash($var) {
	// turn string into array
	for($i=0;$i<strlen($var);$i++) {
		if (substr($var,$i,1)!="\\") {
			$arr[$i]=substr($var,$i,1);
		}
	}
	if (isset($arr)) {
		$var=implode($arr);
		return $var;
	}
}

function timeleft($when) {
	$y    = substr($when,  0, 4);
	$m    = substr($when,  5, 2);
	$d    = substr($when,  8, 2);
	$h    = substr($when, 11, 2);
	$min  = substr($when, 14, 2);
	$sec  = substr($when, 17, 2);

	$diff  = mktime($h, $min, $sec, $m, $d, $y) - time();
	if ($diff <= 0)
		return '';

	$days  = intval($diff / 86400);
	$diff  = $diff - ($days * 86400);
	$hours = intval($diff / 3600);
	$diff  = $diff - ($hours * 3600);
	$mins  = intval($diff / 60);
	$diff  = $diff - ($mins * 60);

	$str = '';
	if ($days > 1)
		$str .= "$days days ";
	elseif ($days == 1)
		$str .= "1 day ";

	if ($hours > 1)
		$str .= "$hours hours ";
	elseif ($hours == 1)
		$str .= "1 hour";

	if ($mins > 1)
		$str .= "$mins mins ";
	elseif ($mins == 1)
		$str .= "1 min";

	return $str;
}

function timeLeftLessThan5Min($when) {
	$y    = substr($when,  0, 4);
	$m    = substr($when,  5, 2);
	$d    = substr($when,  8, 2);
	$h    = substr($when, 11, 2);
	$min  = substr($when, 14, 2);
	$sec  = substr($when, 17, 2);

	$diff  = mktime($h, $min, $sec, $m, $d, $y) - time();
	if ($diff <= 0)
		return false;

	$days  = intval($diff / 86400);
	$diff  = $diff - ($days * 86400);
	$hours = intval($diff / 3600);
	$diff  = $diff - ($hours * 3600);
	$mins  = intval($diff / 60);

	$lessThan5Min = true;
	if ($days >= 1)
		$lessThan5Min = false;
	else if ($hours >= 1)
		$lessThan5Min = false;
	else if ($mins >= 5)
		$lessThan5Min = false;

	return $lessThan5Min;
}

function add5MinToTimeLeft($when) {
	$y    = substr($when,  0, 4);
	$m    = substr($when,  5, 2);
	$d    = substr($when,  8, 2);
	$h    = substr($when, 11, 2);
	$min  = substr($when, 14, 2);
	$sec  = substr($when, 17, 2);

	$newTimeLeft  = mktime($h, $min, $sec, $m, $d, $y) + 300;
	return $newTimeLeft;
}

function minus5Hours($when) {
	$y    = substr($when,  0, 4);
	$m    = substr($when,  5, 2);
	$d    = substr($when,  8, 2);
	$h    = substr($when, 11, 2);
	$min  = substr($when, 14, 2);
	$sec  = substr($when, 17, 2);

	$newHours  = mktime($h, $min, $sec, $m, $d, $y) - 18000;
	return $newHours;
}

function add5MinToNow($when) {
	$newNow = time() + 301;
	return $newNow;
}

function tshow($str) {
	if (empty($str))
		echo '&nbsp;';
	else
		echo $str;
}

function clean_phone_number($phone) {
	#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
	#xxx
	#xxx This works well for the "standard" phone formats for North
	#xxx America but doesn't handle other formats (international) at all.
	#xxx
	#xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

	if (empty($phone) || !preg_match('/^(?:(?:(\d)[ -.])?(\d{3})[ -.]|' .
	    '(?:\((\d{3})\)\s*))(\d{3})[ -.](\d{4})(?:(?:\s*ext\.?\s*|' .
	    '\s*x\.?\s*|\s+)(\d{1,4}))?$/', $phone, $a))
		return '';

	$foo = '';

	if (!empty($a[2])) {
		if (defined($a[1]))
			$foo = "$a[1]-";

		$foo .= "$a[2]-$a[4]-$a[5]";
	} else
		$foo = "$a[3]-$a[4]-$a[5]";

	if (!empty($a[6]))
		$foo .= "x$a[6]";

	return $foo;
}

function findAEforDM($id) {
	$result = db_do("SELECT id FROM aes WHERE dm_id='$id' ORDER BY id");
	$ae_array = array();
	while (list($ae_id) = db_row($result))
		array_push($ae_array, $ae_id);
	return $ae_array;
}

function findDEALERforAE($id) {
	$result = db_do("SELECT id FROM dealers WHERE ae_id='$id' ORDER BY id");
	$dealers_array = array();
	while (list($deaelrs_id) = db_row($result))
		array_push($dealers_array, $deaelrs_id);
	return $dealers_array;
}

function findDMid($username) {
	$result = db_do("SELECT dms.id FROM  dms, users WHERE users.username='$username' and dms.user_id=users.id");
	list($dm_id) = db_row($result);
	return $dm_id;
}

function findAEid($username) {
	$result = db_do("SELECT aes.id FROM  aes, users WHERE users.username='$username' and aes.user_id=users.id");
	list($ae_id) = db_row($result);
	return $ae_id;
}

function findDMuserids() {
	$dm_user_ids = array();
	$result = db_do("SELECT user_id FROM dms");
	while(list($dm_user_id) = db_row($result))
		if(!in_array($dm_user_id, $dm_user_ids))
			array_push($dm_user_ids, $dm_user_id);
	return $dm_user_ids;
}

function findAEuserids() {
	$ae_user_ids = array();
	$result = db_do("SELECT user_id FROM aes");
	while(list($ae_user_id) = db_row($result))
		if(!in_array($ae_user_id, $ae_user_ids))
			array_push($ae_user_ids, $ae_user_id);
	return $ae_user_ids;
}

function br2nl($str) {
   $str = preg_replace("/(\r\n|\n|\r)/", "", $str);
   return preg_replace("=<br */?>=i", "\n", $str);
}

function SendEmailQC($offer_value, $id, $to_user, $from_user) {
	$msg = "Quality Control:

This message is to notify you of a make offer amount over \$1,000,000 for the following closed auction, and may be a phone number.

Auction #:     	$id
Offer Price:   \$".number_format($offer_value, 2)."
To User ID:		$to_user
From User ID:	$from_user

Thank You for looking into this matter,

Go DEALER to DEALER";

	mail('qc@godealertodealer.com', 'Make Offer Amount for Auction #' . $id, $msg, $EMAIL_FROM);
}


/**
 * log_user_login (namespace gdtd)
 * updates the `lastlogin` field of `users` table.
 *
 * @param $id The users userid
 * @returns void
 * @author Kaneda
 */
function gdtd_log_user_login($id)
{
   // assume an open db connection
   $sql = "UPDATE `users` SET lastlogin = NOW() WHERE id = '$id'";
   db_do($sql);
}

/**
 * generate the "condition report" table
 * requires an open db connection via the db_connect() function
 *
 * I hate this function with a pure, perfect passion.
 * I am not proud of it.
 * This is not representative of my work.
 *
 * @returns string HTML for the condition report tables
 * @param int The auction ID
 * @author Kaneda
 */
function echo_condition_report($id)
{
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
            vehicles.instrument_panel, vehicles.bags_cond, vehicles.radiator, vehicles.windscreen, vehicles.series, vehicles.warebars, vehicles.bellypan, vehicles.tunnell, vehicles.skis, vehicles.track
				FROM auctions, categories, vehicles, dealers WHERE auctions.id='$id' AND " .
    "auctions.category_id=categories.id AND auctions.vehicle_id=vehicles.id " .
    "AND auctions.dealer_id=dealers.id");

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
      $wheels, $stereo_speakers, $suspension, $primary_drive, $instrument_panel, $bags_cond, $radiator, $windscreen, $series, $warebars, $bellypan, $tunnell, $skis, $track) = db_row($result);

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
            "Glass" => $glass, "Frame" => $frame, "Bags" => $bags_cond, "Radiator" => $radiator, "Windscreen" => $windscreen, "Hull" => $hull, "Warebars" => $warebars, "Bellypan" => $bellypan, "Tunnell" => $tunnell, "Skis" => $skis, "Track" => $track);

   ?>
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
  		do {
			$a = explode(',', current($condition_report), 2);
			if(key($condition_report) == "Front Seats") {
				if ($any_ratings == FALSE)
					echo "<td colspan=3 class=normal align=left>&nbsp;&nbsp;No Ratings for this section</td>";
				echo "<tr><td colspan=3 class=normal><b><u>Interior</u></b></td></tr>";
				$any_ratings = FALSE;
			}
			if(key($condition_report) == "Paint") {
				if ($any_ratings == FALSE)
						echo "<td colspan=3 class=normal align=left>&nbsp;&nbsp;No Ratings for this section</td>";
				echo "<tr><td colspan=3 class=normal><b><u>Exterior</u></b></td></tr>";
				$any_ratings = FALSE;
			}
			$p1 = $a[0]; $p2 = $a[1];
			if($p1 != "Not Rated" && $p1 != ""){
				$any_ratings = TRUE;
				echo "<tr><td class=normal><b>&nbsp;&nbsp;".key($condition_report).":</b></td>";
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
		}while (next($condition_report));
		if ($any_ratings == FALSE)
			echo "<tr><td colspan=3 class=normal align=left>&nbsp;&nbsp;No Ratings for this section</td></tr>";?>
 </table>
 <?php
}

/**
 * Validates an auction ID based on several parameters
 *
 * @param int the Auction ID to be validated
 * @param string The auction status (optional)
 * @returns boolean true/false
 * @author Kaneda
 */
function is_auctionid_valid($id, $status = null)
{
   if (!is_numeric($id)) {
      throw new Exception("Auction ID is not valid");
   }

   $valid_status = array('open', 'closed', 'pending', 'pulled');
   if ($status != null && !in_array(strtolower($status), $valid_status)) {
      throw new Exception("Please pass a valid status.");
   }

   $sql = "SELECT id FROM auctions WHERE id = '$id'";
   if ($status != null) {
      $sql .= " AND status = '$status'";
   }

   $res = db_do($sql);

   if (db_num_rows($res) > 0) {
      return true;
   } else {
      return false;
   }
}

?>
