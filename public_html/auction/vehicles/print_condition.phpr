<?php

include('../../../include/session.php');
include('../../../include/db.php');

//extract(defineVars("hull_e", "hull_t",  "l_rear_t", "prop_m", "prop_t", "steering_t", "rear_seats_t", "dealer_id", "condition", "in", "did", "vid", "z", "short_desc", "engine_m", "engine_t", "transmission_m", "transmission_t", "exhaust_m", "exhaust_t", "tires_m", "tires_t", "brakes_m", "brakes_t", "steering_m", "ac_m", "ac_t", "front_seats_i", "front_seats_t", "carpet_i", "carpet_t", "headliner_i", "headliner_t", "dash_i", "dash_t", "electronics_i", "electronics_t", "paint_e", "paint_t", "hood_e", "hood_t", "r_f_fender_e", "r_f_fender_t", "l_f_fender_e", "l_f_fender_t", "r_door_e", "r_door_t", "l_door_e", "l_door_t", "r_rear_e", "r_rear_t", "l_rear_e", "trunk_e", "trunk_t", "f_bumper_e", "f_bumper_t", "r_bumper_e", "r_bumper_t",  "grille_e", "grille_t",  "glass_e", "glass_t",  "frame_e", "frame_t",  "condition"));
extract(defineVars("vid")); //JJM 08/27/2010



if (!has_priv('vehicles', $privs)) {
	header('Location: ../menu.php');
	exit;
}

$condition     = trim($condition);

db_connect();

if(isset($vid)) {
//JJM removed the following 2 lines 8/27/2010
//	$result = db_do("SELECT stock_num, vin, hin, condition_report, dealer_id, category_id, subcategory_id1, subcategory_id2, short_desc FROM vehicles WHERE id='$vid'");
//	list($stock_num, $vin, $hin, $condition, $did, $cid, $subcid1, $subcid2, $short_desc) = db_row($result);

//JJM added the rest of this section to populate the print_condition page, the _form_print_cond.php called at the bottom needs alot of cleanup
	$result = db_do("SELECT stock_num, vin, hin, condition_report, dealer_id, category_id, subcategory_id1, subcategory_id2, short_desc," .
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

	list($stock_num, $vin, $hin, $condition, $did, $cid, $subcid1, $subcid2, $short_desc,
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

$condition     = stripslashes($condition);

include('_form_print_cond.php');
db_disconnect();
?>
