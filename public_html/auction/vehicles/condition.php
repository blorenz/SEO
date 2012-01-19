<?php

include('../../../include/session.php');
include('../../../include/db.php');

extract(defineVars("a_floor_i","a_floor_t","a_seats_i","a_seats_t","ac_m","ac_t","add_photo",
"address1","address2","b_trailer_e","b_trailer_t","bags_cond_e","bags_cond_t",
"bathroom_i","bathroom_t","bd_account","bd_name","bd_routing","bellypan_e","bellypan_t",
"billing_address1","billing_address2","billing_city","billing_state","billing_zip",
"bow_e","bow_t","brakes_m","brakes_t","business","carpet_i","carpet_t","cc_ex","cc_name",
"cc_no","cid","city","condition","dash_i","dash_t","dba","dealer","did",
"dl_ex","dl_no","e","ein","electronics_i","electronics_t","engine_m","engine_t",
"exhaust_m","exhaust_t","f_bumper_e","f_bumper_t","f_fender_e","f_fender_t",
"fax","frame_e","frame_t","front_e","front_seats_i","front_seats_t","front_t",
"furniture_i","furniture_t","gauges_m","gauges_t","generator_m","generator_t",
"glass_e","glass_t","grille_e","grille_t","headliner_i","headliner_t","hood_e","hood_t",
"hull_e","hull_t","hvac_m","hvac_t","id","industry","instrument_panel_m","instrument_panel_t",
"kitchen_i","kitchen_t","l_door_e","l_door_t","l_f_fender_e","l_f_fender_t",
"l_rear_e","l_rear_t","left_e","left_t","name","no_of_stores","page_title","paint_e","paint_t",
"phone","plumbing_m","plumbing_t","poc_email","poc_f_name","poc_m_name","poc_name","poc_phone",
"poc_title","port_e","port_t","primary_drive_m","primary_drive_t","prop_m","prop_t",
"r_bumper_e","r_bumper_t","r_door_e","r_door_t","r_f_fender_e","r_f_fender_t",
"r_fender_e","r_fender_t","r_rear_e","r_rear_t","radiator_e","radiator_t","rear_e",
"rear_seats_i","rear_seats_t","rear_t","right_e","right_t","roof_e","roof_t",
"s_bumper_e","s_bumper_t","sdid","skis_e","skis_t","short_desc","starboard_e","starboard_t",
"state","status","steering_m","steering_t","stereo_speakers_m","stereo_speakers_t",
"stern_e","stern_t","subcid1","subcid2","submit","suspension_m","suspension_t",
"tires_m","tires_t","tongue_e","tongue_t","tonguejack_e","tonguejack_t",
"topdog_name","topdog_title","track_e","track_t","transmission_m","transmission_t",
"trunk_e","trunk_t","tunnell_e","tunnell_t","vid","vst_ex","vst_no",
"warebars_e","warebars_t","wheels_m","wheels_t","windscreen_e","windscreen_t","years","zip",
"errors"));  //hmm, not sure if errors will ever be passed in, but there is a $errors .= down below


if (!has_priv('vehicles', $privs)) {
	header('Location: ../menu.php');
	exit;
}


db_connect();

$page_title = 'Edit Wholesale Item Condition';
$help_page = "chp6.php";

$has_bid = 'no';
$status = 'closed';
$r = db_do("SELECT id, status, current_bid, reserve_price FROM auctions WHERE vehicle_id='$vid' ORDER BY created DESC, status DESC LIMIT 1");
if (db_num_rows($r) > 0) {
	list($aid, $status, $current_bid, $reserve_price) = db_row($r);
	if ($status == 'open')
		if ($current_bid >= $reserve_price) {
			$has_bid = 'yes';
         header('Location: index.php');
			exit;
		}
}
db_free($r);


$r = db_do("SELECT short_desc, year, make, model, vin, miles, body, engine, fuel_type,
            drive_train, seats, long_desc, category_id FROM vehicles WHERE id = '$vid'");
while($data = mysql_fetch_array($r)) {
   if($data['category_id'] == 16) {
      foreach($data as $row) {
         if($row == 'null' || $row == '') {
            header("Location: http://$_SERVER[SERVER_NAME]/auction/vehicles/edit.php?id=$vid");
         }
      }
   }
}


if (isset($_REQUEST['submit'])) {

	if (empty($condition))
		$errors .= '<li>You must specify the condition of this item.</li>';

	if (empty($errors)) {
		$engine_mech = $engine_m.",".$engine_t;
		$transmission_mech = $transmission_m.",".$transmission_t;
		$exhaust = $exhaust_m.",".$exhaust_t;
		$tires = $tires_m.",".$tires_t;
		$brakes = $brakes_m.",".$brakes_t;
		$steering = $steering_m.",".$steering_t;
		$ac = $ac_m.",".$ac_t;
		$prop = $prop_m.",".$prop_t;
		$gauges = $gauges_m.",".$gauges_t;
		$plumbing = $plumbing_m.",".$plumbing_t;
		$hvac = $hvac_m.",".$hvac_t;
		$a_seats = $a_seats_i.",".$a_seats_t;
		$floor = $a_floor_i.",".$a_floor_t;
		$kitchen = $kitchen_i.",".$kitchen_t;
		$bathroom = $bathroom_i.",".$bathroom_t;
		$furniture = $furniture_i.",".$furniture_t;
		$front_seats = $front_seats_i.",".$front_seats_t;
		$rear_seats = $rear_seats_i.",".$rear_seats_t;
		$carpet = $carpet_i.",".$carpet_t;
		$headliner = $headliner_i.",".$headliner_t;
		$dash = $dash_i.",".$dash_t;
		$electronics = $electronics_i.",".$electronics_t;
		$paint = $paint_e.",".$paint_t;
		$hood = $hood_e.",".$hood_t;
		$r_f_fender = $r_f_fender_e.",".$r_f_fender_t;
		$l_f_fender = $l_f_fender_e.",".$l_f_fender_t;
		$r_door = $r_door_e.",".$r_door_t;
		$l_door = $l_door_e.",".$l_door_t;
		$f_fender = $f_fender_e.",".$f_fender_t;
		$r_fender = $r_fender_e.",".$r_fender_t;
		$r_rear = $r_rear_e.",".$r_rear_t;
		$l_rear = $l_rear_e.",".$l_rear_t;
		$trunk = $trunk_e.",".$trunk_t;
		$f_bumper = $f_bumper_e.",".$f_bumper_t;
		$r_bumper = $r_bumper_e.",".$r_bumper_t;
		$s_bumper = $s_bumper_e.",".$s_bumper_t;
		$grille = $grille_e.",".$grille_t;
		$tongue = $tongue_e.",".$tongue_t;
		$tonguejack = $tonguejack_e.",".$tonguejack_t;
		$glass = $glass_e.",".$glass_t;
		$frame = $frame_e.",".$frame_t;
		$hull = $hull_e.",".$hull_t;
		$roof = $roof_e.",".$roof_t;
		$front = $front_e.",".$front_t;
		$rear = $rear_e.",".$rear_t;
		$left = $left_e.",".$left_t;
		$right = $right_e.",".$right_t;
		$starboard = $starboard_e.",".$starboard_t;
		$port = $port_e.",".$port_t;
		$stern = $stern_e.",".$stern_t;
		$bow = $bow_e.",".$bow_t;
		$b_trailer = $b_trailer_e.",".$b_trailer_t;
		$generator = $generator_m.",".$generator_t;

		$wheels = $wheels_m.",".$wheels_t;
		$stereo_speakers = $stereo_speakers_m.",".$stereo_speakers_t;
		$suspension = $suspension_m.",".$suspension_t;
		$primary_drive = $primary_drive_m.",".$primary_drive_t;
		$instrument_panel = $instrument_panel_m.",".$instrument_panel_t;
		$bags_cond = $bags_cond_e.",".$bags_cond_t;
		$radiator = $radiator_e.",".$radiator_t;
		$windscreen = $windscreen_e.",".$windscreen_t;
      $warebars = $warebars_e.",".$warebars_t;
      $bellypan = $bellypan_e.",".$bellypan_t;
      $tunnell = $tunnell_e.",".$tunnell_t;
      $skis = $skis_e.",".$skis_t;
      $track = $track_e.",".$track_t;


		db_do("UPDATE vehicles SET condition_report='$condition', engine_mech='$engine_mech', transmission_mech='$transmission_mech', " .
					"exhaust='$exhaust', tires='$tires', brakes='$brakes', steering='$steering', ac='$ac', prop='$prop', generator='$generator'," .
					"gauges='$gauges',  plumbing='$plumbing', hvac='$hvac', a_seats='$a_seats', floor='$floor', kitchen='$kitchen', bathroom='$bathroom', " .
					"furniture='$furniture', roof='$roof', front='$front', rear='$rear', cond_left='$left', cond_right='$right', starboard='$starboard', " .
					"port='$port', stern='$stern', bow='$bow', b_trailer='$b_trailer', " .
					"front_seats='$front_seats', rear_seats='$rear_seats', carpet='$carpet', " .
					"headliner='$headliner', dash='$dash', electronics='$electronics', paint='$paint', " .
					"hood='$hood', r_f_fender='$r_f_fender', l_f_fender='$l_f_fender', r_door='$r_door', l_door='$l_door', " .
					"f_fender='$f_fender', r_fender='$r_fender', r_rear='$r_rear', l_rear='$l_rear', trunk='$trunk', " .
					"f_bumper='$f_bumper', r_bumper='$r_bumper', s_bumper='$s_bumper', grille='$grille', " .
					"tongue='$tongue', tonguejack='$tonguejack', glass='$glass', frame='$frame', hull='$hull',
					wheels='$wheels', stereo_speakers='$stereo_speakers', suspension='$suspension', primary_drive='$primary_drive',
					instrument_panel='$instrument_panel', bags_cond='$bags_cond', radiator='$radiator', windscreen='$windscreen', warebars='$warebars', bellypan='$bellypan', tunnell='$tunnell', skis='$skis', track='$track'
					WHERE id=$vid");

		db_do("UPDATE auctions SET condition_report='$condition' WHERE vehicle_id='$vid' AND status='open'");

		db_disconnect();

		if ($add_photo == 'yes') {
					header("Location: ../photos/add.php?vid=$vid");
		}
		else {
					header("Location: http://$_SERVER[SERVER_NAME]/auction/auctions/add.php?vid=$vid");
		}
		exit;
	}
}
elseif(isset($vid))
{

	$result = db_do("SELECT condition_report, dealer_id, category_id, subcategory_id1, subcategory_id2, short_desc," .
					"engine_mech, transmission_mech, exhaust, tires, brakes, steering, ac, prop, generator, " .
					"gauges, plumbing, hvac, a_seats, kitchen, bathroom, " .
					"furniture, roof, front, rear, starboard, " .
					"port, stern, bow, b_trailer, floor, " .
					"front_seats, rear_seats, carpet, headliner, dash, electronics, " .
					"paint, hood, r_f_fender, l_f_fender, r_door, l_door, f_fender, r_fender, " .
					"r_rear, l_rear, trunk, f_bumper, r_bumper, s_bumper, grille, tongue, glass, frame, " .
					"hull, wheels, stereo_speakers, suspension, primary_drive, " .
					"instrument_panel, bags_cond, radiator, windscreen, warebars, " .
               "bellypan, tunnell, skis, track, cond_left, cond_right, tonguejack FROM vehicles WHERE id='$vid'");

	list($condition, $did, $cid, $subcid1, $subcid2, $short_desc,
			$engine_mech, $transmission_mech, $exhaust, $tires, $brakes, $steering, $ac, $prop, $generator,
			$gauges, $plumbing, $hvac, $a_seats, $kitchen, $bathroom,
			$furniture, $roof, $front, $rear, $starboard,
			$port, $stern, $bow, $b_trailer, $floor,
			$front_seats, $rear_seats, $carpet, $headliner, $dash, $electronics,
			$paint, $hood, $r_f_fender, $l_f_fender, $r_door, $l_door, $f_fender, $r_fender,
			$r_rear, $l_rear, $trunk, $f_bumper, $r_bumper, $s_bumper, $grille, $tongue, $glass, $frame,
			$hull, $wheels, $stereo_speakers, $suspension, $primary_drive, $instrument_panel, $bags_cond, $radiator, $windscreen, $warebars, $bellypan, $tunnell, $skis, $track, $left, $right, $tonguejack) = db_row($result);

			if(!empty($engine_mech))
			{
				$a = explode(',', $engine_mech, 2);
				$engine_m = $a[0]; $engine_t = $a[1];
			}
			if(!empty($ac))
			{
			$a = explode(',', $ac, 2);
			$ac_m = $a[0]; $ac_t = $a[1];
   			}
			if(!empty($brakes))
			{
			$a = explode(',', $brakes, 2);
			$brakes_m = $a[0]; $brakes_t = $a[1];
   			}
			if(!empty($carpet))
			{
			$a = explode(',', $carpet, 2);
			$carpet_i = $a[0]; $carpet_t = $a[1];
   			}
			if(!empty($dash))
			{
			$a = explode(',', $dash, 2);
			$dash_i = $a[0]; $dash_t = $a[1];
   			}
			if(!empty($electronics))
			{
			$a = explode(',', $electronics, 2);
			$electronics_i = $a[0]; $electronics_t = $a[1];
   			}
			if(!empty($exhaust))
			{
			$a = explode(',', $exhaust, 2);
			$exhaust_m = $a[0]; $exhaust_t = $a[1];
   			}
			if(!empty($f_bumper))
			{
			$a = explode(',', $f_bumper, 2);
			$f_bumper_e = $a[0]; $f_bumper_t = $a[1];
   			}
			if(!empty($f_fender))
			{
			$a = explode(',', $f_fender, 2);
			$f_fender_e = $a[0]; $f_fender_t = $a[1];
   			}
			if(!empty($frame))
			{
			$a = explode(',', $frame, 2);
			$frame_e = $a[0]; $frame_t = $a[1];
   			}
			if(!empty($front_seats))
			{
			$a = explode(',', $front_seats, 2);
			$front_seats_i = $a[0]; $front_seats_t = $a[1];
   			}
			if(!empty($glass))
			{
			$a = explode(',', $glass, 2);
			$glass_e = $a[0]; $glass_t = $a[1];
   			}
			if(!empty($grille))
			{
			$a = explode(',', $grille, 2);
			$grille_e = $a[0]; $grille_t = $a[1];
   			}
			if(!empty($headliner))
			{
			$a = explode(',', $headliner, 2);
			$headliner_i = $a[0]; $headliner_t = $a[1];
   			}
			if(!empty($hood))
			{
			$a = explode(',', $hood, 2);
			$hood_e = $a[0]; $hood_t = $a[1];
   			}
			if(!empty($hull))
			{
			$a = explode(',', $hull, 2);
			$hull_e = $a[0]; $hull_t = $a[1];
   			}
			if(!empty($l_door))
			{
			$a = explode(',', $l_door, 2);
			$l_door_e = $a[0]; $l_door_t = $a[1];
   			}
			if(!empty($l_f_fender))
			{
			$a = explode(',', $l_f_fender, 2);
			$l_f_fender_e = $a[0]; $l_f_fender_t = $a[1];
   			}
			if(!empty($l_rear))
			{
			$a = explode(',', $l_rear, 2);
			$l_rear_e = $a[0]; $l_rear_t = $a[1];
   			}
			if(!empty($paint))
			{
			$a = explode(',', $paint, 2);
			$paint_e = $a[0]; $paint_t = $a[1];
   			}
			if(!empty($prop))
			{
			$a = explode(',', $prop, 2);
			$prop_m = $a[0]; $prop_t = $a[1];
   			}
			if(!empty($r_bumper))
			{
			$a = explode(',', $r_bumper, 2);
			$r_bumper_e = $a[0]; $r_bumper_t = $a[1];
   			}
			if(!empty($r_door))
			{
			$a = explode(',', $r_door, 2);
			$r_door_e = $a[0]; $r_door_t = $a[1];
   			}
			if(!empty($r_f_fender))
			{
			$a = explode(',', $r_f_fender, 2);
			$r_f_fender_e = $a[0]; $r_f_fender_t = $a[1];
   			}
			if(!empty($r_fender))
			{
			$a = explode(',', $r_fender, 2);
			$r_fender_e = $a[0]; $r_fender_t = $a[1];
   			}
			if(!empty($r_rear))
			{
			$a = explode(',', $r_rear, 2);
			$r_rear_e = $a[0]; $r_rear_t = $a[1];
   			}
			if(!empty($rear_seats))
			{
			$a = explode(',', $rear_seats, 2);
			$rear_seats_i = $a[0]; $rear_seats_t = $a[1];
   			}
			if(!empty($s_bumper))
			{
			$a = explode(',', $s_bumper, 2);
			$s_bumper_e = $a[0]; $s_bumper_t = $a[1];
   			}
			if(!empty($steering))
			{
			$a = explode(',', $steering, 2);
			$steering_m = $a[0]; $steering_t = $a[1];
   			}
			if(!empty($tires))
			{
			$a = explode(',', $tires, 2);
			$tires_m = $a[0]; $tires_t = $a[1];
   			}
			if(!empty($tongue))
			{
			$a = explode(',', $tongue, 2);
			$tongue_e = $a[0]; $tongue_t = $a[1];
   			}
			if(!empty($transmission_mech))
			{
			$a = explode(',', $transmission_mech, 2);
			$transmission_m = $a[0]; $transmission_t = $a[1];
   			}
			if(!empty($trunk))
			{
			$a = explode(',', $trunk, 2);
			$trunk_e = $a[0]; $trunk_t = $a[1];
   			}
			if(!empty($gauges))
			{
			$a = explode(',', $gauges, 2);
			$gauges_m = $a[0]; $gauges_t = $a[1];
   			}
			if(!empty($plumbing))
			{
			$a = explode(',', $plumbing, 2);
			$plumbing_m = $a[0]; $plumbing_t = $a[1];
   			}
			if(!empty($hvac))
			{
			$a = explode(',', $hvac, 2);
			$hvac_m = $a[0]; $hvac_t = $a[1];
   			}
			if(!empty($a_seats))
			{
			$a = explode(',', $a_seats, 2);
			$a_seats_i = $a[0]; $a_seats_t = $a[1];
   			}
			if(!empty($kitchen))
			{
			$a = explode(',', $kitchen, 2);
			$kitchen_i = $a[0]; $kitchen_t = $a[1];
   			}
			if(!empty($bathroom))
			{
			$a = explode(',', $bathroom, 2);
			$bathroom_i = $a[0]; $bathroom_t = $a[1];
   			}
			if(!empty($furniture))
			{
			$a = explode(',', $furniture, 2);
			$furniture_i = $a[0]; $furniture_t = $a[1];
   			}
			if(!empty($roof))
			{
			$a = explode(',', $roof, 2);
			$roof_e = $a[0]; $roof_t = $a[1];
   			}
			if(!empty($front))
			{
			$a = explode(',', $front, 2);
			$front_e = $a[0]; $front_t = $a[1];
   			}
			if(!empty($rear))
			{
			$a = explode(',', $rear, 2);
			$rear_e = $a[0]; $rear_t = $a[1];
   			}
			if(!empty($starboard))
			{
			$a = explode(',', $starboard, 2);
			$starboard_e = $a[0]; $starboard_t = $a[1];
   			}
			if(!empty($port))
			{
			$a = explode(',', $port, 2);
			$port_e = $a[0]; $port_t = $a[1];
   			}
			if(!empty($stern))
			{
			$a = explode(',', $stern, 2);
			$stern_e = $a[0]; $stern_t = $a[1];
   			}
			if(!empty($bow))
			{
			$a = explode(',', $bow, 2);
			$bow_e = $a[0]; $bow_t = $a[1];
   			}
			if(!empty($b_trailer))
			{
			$a = explode(',', $b_trailer, 2);
			$b_trailer_e = $a[0]; $b_trailer_t = $a[1];
   			}
			if(!empty($floor))
			{
			$a = explode(',', $floor, 2);
			$a_floor_i = $a[0]; $a_floor_t = $a[1];
   			}
			if(!empty($generator))
			{
			$a = explode(',', $generator, 2);
			$generator_m = $a[0]; $generator_t = $a[1];
   			}
			if(!empty($wheels))
			{

			$a = explode(',', $wheels, 2);
			$wheels_m = $a[0]; $wheels_t = $a[1];
   			}
			if(!empty($stereo_speakers))
			{
			$a = explode(',', $stereo_speakers, 2);
			$stereo_speakers_m = $a[0]; $stereo_speakers_t = $a[1];
   			}
			if(!empty($suspension))
			{
			$a = explode(',', $suspension, 2);
			$suspension_m = $a[0]; $suspension_t = $a[1];
   			}
			if(!empty($primary_drive))
			{
			$a = explode(',', $primary_drive, 2);
			$primary_drive_m = $a[0]; $primary_drive_t = $a[1];
   			}
			if(!empty($instrument_panel))
			{
			$a = explode(',', $instrument_panel, 2);
			$instrument_panel_m = $a[0]; $instrument_panel_t = $a[1];
   			}
			if(!empty($bags_cond))
			{
			$a = explode(',', $bags_cond, 2);
			$bags_cond_e = $a[0]; $bags_cond_t = $a[1];
   			}
			if(!empty($radiator))
			{
			$a = explode(',', $radiator, 2);
			$radiator_e = $a[0]; $radiator_t = $a[1];
   			}
			if(!empty($windscreen))
			{
			$a = explode(',', $windscreen, 2);
			$windscreen_e = $a[0]; $windscreen_t = $a[1];
   			}
			if(!empty($warebars))
			{
         $a = explode(',', $warebars, 2);
         $warebars_e = $a[0]; $warebars_t = $a[1];
   			}
			if(!empty($bellypan))
			{
         $a = explode(',', $bellypan, 2);
         $bellypan_e = $a[0]; $bellypan_t = $a[1];
   			}
			if(!empty($tunnell))
			{
         $a = explode(',', $tunnell, 2);
         $tunnell_t = $a[0]; $tunnell_t = $a[1];
   			}
			if(!empty($skis))
			{
         $a = explode(',', $skis, 2);
         $skis_e = $a[0]; $skis_t = $a[1];
   			}
			if(!empty($track))
			{
         $a = explode(',', $track, 2);
         $track_e = $a[0]; $track_t = $a[1];
   			}
			if(!empty($left))
			{
         $a = explode(',', $left, 2);
         $left_e = $a[0]; $left_t = $a[1];
   			}
			if(!empty($right))
			{
         $a = explode(',', $right, 2);
         $right_e = $a[0]; $right_t = $a[1];
   			}
			if(!empty($tonguejack))
			{
         $a = explode(',', $tonguejack, 2);
         $tonguejack_e = $a[0]; $tonguejack_t = $a[1];
			}

}
elseif(!isset($vid))
{
	header('Location: index.php');
	exit;
}

$result_status = db_do("SELECT status FROM auctions WHERE vehicle_id='$vid'");
list($auction_status) = db_row($result_status);

if ($did != $dealer_id /* || $auction_status == 'open' */)
{
	header('Location: index.php');
	exit;
}

$condition     = stripslashes($condition);

$photo_id = '';

include('../header.php');
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {color: #FFFFFF; font-weight: bold; }
.style4 {font-size: 12px}
-->
</style>


  <br>
<p align="center" class="big"><b><?php echo $page_title; ?> - <a target="_blank" href="print_condition.php?vid=<?=$vid?>">Printable Condition Report</a></b></p>
<p align="center" class="big"><strong>Condition Chart Guidelines</strong></p>
<table width="614" border="1" align="center">
  <tr>
    <td width="54" bgcolor="#00FF00"><div align="center"><strong>Excellent</strong></div></td>
    <td width="544"><p class="style4">&ldquo;Excellent&rdquo; condition means that this topic looks, smells,  or is in excellent mechanical and visual condition and needs no reconditioning or  service. No work has been done to restore this topic to the best of your  knowledge. No noticeable blemishes, leaks, or defects occur.</p></td>
  </tr>
  <tr>
    <td bgcolor="#0033FF"><div align="center" class="style1">
      <div align="center"><strong>Good</strong></div>
    </div></td>
    <td><p class="style4">&ldquo;Good&rdquo; condition means that this topic is free from any  major defects. Any prior major damages, leaks, odor, or mechanical deficiencies  have been corrected. Only minor (if any) blemishes or defects may still be  present. A good condition might need very little service or reconditioning to  be retail ready.</p></td>
  </tr>
  <tr>
    <td bgcolor="#FFFF00"><div align="center"><strong>Average</strong></div></td>
    <td><p class="style4">&ldquo;Average&rdquo; condition means that this topic has some  mechanical, visual, or odor defects and will need servicing or reconditioning  but is still in reasonable running or working condition. &nbsp;</p></td>
  </tr>
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="style2">Poor</div></td>
    <td><p class="style4">&ldquo;Poor&rdquo; condition means that this topic has severe  mechanical, visual, or odor defieiencies. This topic is in poor running or  working condition and has very noticeable blemishes, leaks or other defects.  This topic will need to be replaced or complete reconditioning and in some  cases will not be able to be repaired as in frame damage or rust-through. </p></td>
  </tr>
</table>
<p align="center" class="big">&nbsp; </p>
<?php
include('_form_cond.php');
include('../footer.php');
db_disconnect();
?>
