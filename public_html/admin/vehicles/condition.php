<?php

include('../../../include/db.php');


$condition     = trim($condition);

db_connect();

$page_title = 'Edit Item Condition';

$has_bid = 'no';
$status = 'closed';
$r = db_do("SELECT id, status, current_bid, reserve_price FROM auctions WHERE vehicle_id='$vid' ORDER BY created DESC, status DESC LIMIT 1");
if (db_num_rows($r) > 0) {
	list($aid, $status, $current_bid, $reserve_price) = db_row($r);
	if ($status == 'open')
		if ($current_bid > 0) {
			$has_bid = 'yes';
			header('Location: index.php');
			exit;
		}
}
db_free($r);

	
if (isset($submit)) {
	
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
		$glass = $glass_e.",".$glass_t;
		$frame = $frame_e.",".$frame_t;
		$hull = $hull_e.",".$hull_t;
		$roof = $roof_e.",".$roof_t;
		$front = $front_e.",".$front_t;
		$rear = $rear_e.",".$rear_t;
		$starboard = $starboard_e.",".$starboard_t;
		$port = $port_e.",".$port_t;
		$stern = $stern_e.",".$stern_t;
		$bow = $bow_e.",".$bow_t;
		$b_trailer = $b_trailer_e.",".$b_trailer_t;
		$generator = $generator_m.",".$generator_t;			
		
		db_do("UPDATE vehicles SET condition='$condition', engine_mech='$engine_mech', transmission_mech='$transmission_mech', " . 
					"exhaust='$exhaust', tires='$tires', brakes='$brakes', steering='$steering', ac='$ac', prop='$prop', generator='$generator'," . 
					"gauges='$gauges',  plumbing='$plumbing', hvac='$hvac', a_seats='$a_seats', kitchen='$kitchen', bathroom='$bathroom', " .
					"furniture='$furniture', roof='$roof', front='$front', rear='$rear', starboard='$starboard', " .
					"port='$port', stern='$stern', bow='$bow', b_trailer='$b_trailer', " . 
					"front_seats='$front_seats', rear_seats='$rear_seats', carpet='$carpet', " . 
					"headliner='$headliner', dash='$dash', electronics='$electronics', paint='$paint', " . 
					"hood='$hood', r_f_fender='$r_f_fender', l_f_fender='$l_f_fender', r_door='$r_door', l_door='$l_door', " . 
					"f_fender='$f_fender', r_fender='$r_fender', r_rear='$r_rear', l_rear='$l_rear', trunk='$trunk', " . 
					"f_bumper='$f_bumper', r_bumper='$r_bumper', s_bumper='$s_bumper', grille='$grille', " . 
					"tongue='$tongue', glass='$glass', frame='$frame', hull='$hull' WHERE id=$vid");
	
		db_disconnect();
		
		if ($add_photo == 'yes') {
					header("Location: ../photos/add.php?vid=$vid");
		}
		else {
					header("Location: index.php");					
		}
		exit;
	}
}
elseif(isset($vid))
{

	$result = db_do("SELECT condition, dealer_id, category_id, subcategory_id1, subcategory_id2, short_desc," . 
					"engine_mech, transmission_mech, exhaust, tires, brakes, steering, ac, prop, generator, " . 
					"gauges, plumbing, hvac, a_seats, kitchen, bathroom, " . 
					"furniture, roof, front, rear, starboard, " .
					"port, stern, bow, b_trailer, " .
					"front_seats, rear_seats, carpet, headliner, dash, electronics, " . 
					"paint, hood, r_f_fender, l_f_fender, r_door, l_door, f_fender, r_fender, " . 
					"r_rear, l_rear, trunk, f_bumper, r_bumper, s_bumper, grille, tongue, glass, frame, " . 
					"hull FROM vehicles WHERE id='$vid'");
					
	list($condition, $did, $cid, $subcid1, $subcid2, $short_desc,
			$engine_mech, $transmission_mech, $exhaust, $tires, $brakes, $steering, $ac, $prop, $generator, 
			$gauges, $plumbing, $hvac, $a_seats, $kitchen, $bathroom, 
			$furniture, $roof, $front, $rear, $starboard, 
			$port, $stern, $bow, $b_trailer, 
			$front_seats, $rear_seats, $carpet, $headliner, $dash, $electronics, 
			$paint, $hood, $r_f_fender, $l_f_fender, $r_door, $l_door, $f_fender, $r_fender, 
			$r_rear, $l_rear, $trunk, $f_bumper, $r_bumper, $s_bumper, $grille, $tongue, $glass, $frame, 
			$hull) = db_row($result);
			
			$a = explode(',', $engine_mech, 2);
			$engine_m = $a[0]; $engine_t = $a[1];
			$a = explode(',', $ac, 2);
			$ac_m = $a[0]; $ac_t = $a[1];
			$a = explode(',', $brakes, 2);
			$brakes_m = $a[0]; $brakes_t = $a[1];
			$a = explode(',', $carpet, 2);
			$carpet_i = $a[0]; $carpet_t = $a[1];
			$a = explode(',', $dash, 2);
			$dash_i = $a[0]; $dash_t = $a[1];
			$a = explode(',', $electronics, 2);
			$electronics_i = $a[0]; $electronics_t = $a[1];
			$a = explode(',', $exhaust, 2);
			$exhaust_m = $a[0]; $exhaust_t = $a[1];
			$a = explode(',', $f_bumper, 2);
			$f_bumper_e = $a[0]; $f_bumper_t = $a[1];
			$a = explode(',', $f_fender, 2);
			$f_fender_e = $a[0]; $f_fender_t = $a[1];
			$a = explode(',', $frame, 2);
			$frame_e = $a[0]; $frame_t = $a[1];
			$a = explode(',', $front_seats, 2);
			$front_seats_i = $a[0]; $front_seats_t = $a[1];
			$a = explode(',', $glass, 2);
			$glass_e = $a[0]; $glass_t = $a[1];
			$a = explode(',', $grille, 2);
			$grille_e = $a[0]; $grille_t = $a[1];
			$a = explode(',', $headliner, 2);
			$headliner_i = $a[0]; $headliner_t = $a[1];
			$a = explode(',', $hood, 2);
			$hood_e = $a[0]; $hood_t = $a[1];
			$a = explode(',', $hull, 2);
			$hull_e = $a[0]; $hull_t = $a[1];
			$a = explode(',', $l_door, 2);
			$l_door_e = $a[0]; $l_door_t = $a[1];
			$a = explode(',', $l_f_fender, 2);
			$l_f_fender_e = $a[0]; $l_f_fender_t = $a[1];
			$a = explode(',', $l_rear, 2);
			$l_rear_e = $a[0]; $l_rear_t = $a[1];
			$a = explode(',', $paint, 2);
			$paint_e = $a[0]; $paint_t = $a[1];
			$a = explode(',', $prop, 2);
			$prop_m = $a[0]; $prop_t = $a[1];
			$a = explode(',', $r_bumper, 2);
			$r_bumper_e = $a[0]; $r_bumper_t = $a[1];
			$a = explode(',', $r_door, 2);
			$r_door_e = $a[0]; $r_door_t = $a[1];
			$a = explode(',', $r_f_fender, 2);
			$r_f_fender_e = $a[0]; $r_f_fender_t = $a[1];
			$a = explode(',', $r_fender, 2);
			$r_fender_e = $a[0]; $r_fender_t = $a[1];
			$a = explode(',', $r_rear, 2);
			$r_rear_e = $a[0]; $r_rear_t = $a[1];
			$a = explode(',', $rear_seats, 2);
			$rear_seats_i = $a[0]; $rear_seats_t = $a[1];
			$a = explode(',', $s_bumper, 2);
			$s_bumper_e = $a[0]; $s_bumper_t = $a[1];
			$a = explode(',', $steering, 2);
			$steering_m = $a[0]; $steering_t = $a[1];
			$a = explode(',', $tires, 2);
			$tires_m = $a[0]; $tires_t = $a[1];
			$a = explode(',', $tongue, 2);
			$tongue_e = $a[0]; $tongue_t = $a[1];
			$a = explode(',', $transmission_mech, 2);
			$transmission_m = $a[0]; $transmission_t = $a[1];
			$a = explode(',', $trunk, 2);
			$trunk_e = $a[0]; $trunk_t = $a[1];
			$a = explode(',', $gauges, 2);
			$gauges_m = $a[0]; $gauges_t = $a[1];
			$a = explode(',', $plumbing, 2);
			$plumbing_m = $a[0]; $plumbing_t = $a[1];
			$a = explode(',', $hvac, 2);
			$hvac_m = $a[0]; $hvac_t = $a[1];
			$a = explode(',', $a_seats, 2);
			$a_seats_i = $a[0]; $a_seats_t = $a[1];
			$a = explode(',', $kitchen, 2);
			$kitchen_i = $a[0]; $kitchen_t = $a[1];
			$a = explode(',', $bathroom, 2);
			$bathroom_i = $a[0]; $bathroom_t = $a[1];
			$a = explode(',', $furniture, 2);
			$furniture_i = $a[0]; $furniture_t = $a[1];
			$a = explode(',', $roof, 2);
			$roof_e = $a[0]; $roof_t = $a[1];
			$a = explode(',', $front, 2);
			$front_e = $a[0]; $front_t = $a[1];
			$a = explode(',', $rear, 2);
			$rear_e = $a[0]; $rear_t = $a[1];
			$a = explode(',', $starboard, 2);
			$starboard_e = $a[0]; $starboard_t = $a[1];
			$a = explode(',', $port, 2);
			$port_e = $a[0]; $port_t = $a[1];
			$a = explode(',', $stern, 2);
			$stern_e = $a[0]; $stern_t = $a[1];
			$a = explode(',', $bow, 2);
			$bow_e = $a[0]; $bow_t = $a[1];
			$a = explode(',', $b_trailer, 2);
			$b_trailer_e = $a[0]; $b_trailer_t = $a[1];
			$a = explode(',', $generator, 2);
			$generator_m = $a[0]; $generator_t = $a[1];
			
		
}
elseif(!isset($vid))
{
	header('Location: index.php');
	exit;
}

$result_status = db_do("SELECT status FROM auctions WHERE vehicle_id='$vid'");
list($auction_status) = db_row($result_status);


$condition     = stripslashes($condition);

$photo_id = '';

include('../header.php');
?>

  <br>
<p align="center" class="big"><b><?php echo $page_title; ?> - <a target="_blank" href="print_condition.php?vid=<?=$vid?>">Printable Condition Report</a></b></p>
<?php
include('_form_cond.php');
include('../footer.php');
db_disconnect();
?>