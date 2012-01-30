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
# $srp: godealertodealer.com/htdocs/auction/auctions/preview.php,v 1.9 2003/02/10 23:43:30 steve Exp $
#

$page_title = 'Preview Auction';

include('../../../include/session.php');

include('../../../include/db.php');
db_connect();

$result = db_do("SELECT categories.name, auctions.title, auctions.status, " .
    "auctions.description, auctions.add_description, " .
		"DATE_FORMAT(auctions.desc_mod, '%a, %e %M %Y %H:%i'), " .
		"auctions.minimum_bid, auctions.reserve_price, auctions.reserve_lowered, " .
    	"auctions.buy_now_price, auctions.current_bid, auctions.bid_increment, " .
    	"auctions.dealer_id, DATE_FORMAT(auctions.starts, '%a, %e %M %Y %H:%i'), " .
    	"DATE_FORMAT(auctions.ends, '%a, %e %M %Y %H:%i'), auctions.ends, " .
    	"auctions.vehicle_id, auctions.pays_transport, vehicles.year, " .
    		"vehicles.vin, vehicles.make, vehicles.model, vehicles.city, " .
    		"vehicles.state, vehicles.zip, vehicles.photo_id, vehicles.condition_report, " .
    		"vehicles.miles, vehicles.stock_num, vehicles.series, vehicles.body, "  .
			"vehicles.engine, vehicles.transmission, vehicles.interior_color, vehicles.exterior_color, "  .
			"vehicles.warranty, vehicles.title, vehicles.title_status, vehicles.certified, " .
			"vehicles.short_desc, vehicles.long_desc, dealers.rating, ".
				"vehicles.seats, vehicles.fuel_type, vehicles.drive_train, vehicles.engine_size, vehicles.engine_make," .
				"vehicles.wheel_size, vehicles.payment_method, vehicles.horsepower, vehicles.hin, " .
				"vehicles.hours, vehicles.trailer, vehicles.length, vehicles.seating, vehicles.boat_use, " . 
				"vehicles.engine_mech, vehicles.transmission_mech, vehicles.exhaust, vehicles.tires, " . 
				"vehicles.brakes, vehicles.steering, vehicles.ac, vehicles.prop, " . 
				"vehicles.front_seats, vehicles.rear_seats, vehicles.carpet,  " . 
				"vehicles.headliner, vehicles.dash, vehicles.electronics, " . 
				"vehicles.paint, vehicles.hood, vehicles.r_f_fender, vehicles.l_f_fender, " . 
				"vehicles.r_door, vehicles.l_door, vehicles.f_fender, vehicles.r_fender, " . 
				"vehicles.r_rear, vehicles.l_rear, vehicles.trunk, vehicles.f_bumper, vehicles.r_bumper, vehicles.s_bumper, " . 
				"vehicles.grille, vehicles.tongue, vehicles.hitch, vehicles.glass, vehicles.frame, vehicles.hull, " . 
				"vehicles.gps, vehicles.fish_finder, vehicles.depth_finder, vehicles.security_system, " . 
				"vehicles.slide_out, vehicles.ac_yn, vehicles.sleep_no FROM " .
    "auctions, categories, vehicles, dealers WHERE auctions.id='$id' AND " .
    "auctions.status='pending' AND auctions.category_id=categories.id AND auctions.vehicle_id=vehicles.id ");
		
if (db_num_rows($result) <= 0) {
	header('Location: index.php?s=pending');
	exit;
}

list($category, $title, $status, $description, $add_description, $desc_mod, $minimum_bid, $reserve_price, $reserve_lowered,
    $buy_now_price, $current_bid, $bid_increment, $did, $starts, $ends, $when,
    $vid, $pays_transport, $year, $vin, $make, $model, $city, $state, $zip,
    $photo, $condition, $miles, $stock_num, $series, $body, $engine, $transmission, $interior_color,
	$exterior_color, $warranty, $title_item, $title_status, $certified, $veh_short_desc, $veh_long_desc, $rating,
		$seats, $fuel_type, $drive_train, $engine_size, $engine_make,
		$wheel_size, $payment_method, $horsepower, $hin,
		$hours, $trailer, $length, $seating, $boat_use, 
		$engine_mech, $transmission_mech, $exhuast, $tires, 
		$brakes, $steering, $ac, $prop, 
		$front_seats, $rear_seats, $carpet,
		$headliner, $dash, $electronics, 
		$paint, $hood, $r_f_fender, $l_f_fender, 
		$r_door, $l_door, $f_fender, $r_fender, 
		$r_rear, $l_rear, $trunk, $f_bumper, $r_bumper, $s_bumper, 
		$grille, $tongue, $hitch, $glass, $frame, $hull, 
		$gps, $fish_finder, $depth_finder, $security_system, $slide_out, $ac_yn, $sleep_no) = db_row($result);
db_free($result);

$description_report = array("VIN" => $vin, "HIN" => $hin, "Stock Number" => $stock_num, 
		"Boat Length" => $length, "Use" => $boat_use, "Body" => $body, "Exterior Color" => $exterior_color, 
		"Interior Color" => $interior_color, "Seat Surface" => $seats, "Max Seating Capacity" => $seating, "Wheel Size" => $wheel_size, 
		"Miles" => $miles, "Hours" => $hours, "Engine" => $engine, 
		"Engine Size" => $engine_size, "Engine Make" => $engine_make, "Horsepower" => $horsepower, 
		"Drive Train" => $drive_train, "Transmission" => $transmission, "Fuel Type" => $fuel_type, 
		"Title" => $title_item, "Title Status" => $title_status, "Warranty" => $warranty, 
		"Certified" => $certified, "GPS/Navigation System" => $gps, "Security System" => $security_system, 
		"Hitch" => $hitch, "Trailer Included" => $trailer, "Fish Finder" => $fish_finder, 
		"Depth Finder" => $depth_finder, "Slide Out" => $slide_out, "Air Conditioning" => $ac_yn, "Max Sleeping Capacity" => $sleep_no);
				
$condition_report = array("Engine" => $engine_mech, "Transmission" => $transmission_mech, "Exhuast" => $exhuast, 
				"Tires" => $tires, "Brakes" => $brakes, "Steering" => $steering, "A/C" => $ac, "Prop" => $prop, 
				"Front Seats" => $front_seats, "Rear Seats" => $rear_seats, "Carpet" => $carpet, 
				"Headliner" => $headliner, "Dash" => $dash, "Electronics" => $electronics, 
				"Paint" => $paint, "Hood" => $hood, "R Front Fender" => $r_f_fender, "L Front Fender" => $l_f_fender, 
				"Right Door" => $r_door, "Left Door" => $l_door, "Front Fender" => $f_fender, "Rear Fender" => $r_fender, 
				"Right Rear" => $r_rear, "Left Rear" => $l_rear, "Trunk" => $trunk, "Front Bumper" => $f_bumper, 
				"Rear Bumper" => $r_bumper, "Side Bumper" => $s_bumper, "Grille" => $grille, "Tongue" => $tongue, 
				"Glass" => $glass, "Frame" => $frame, "Hull" => $hull);
	
$minimum_bid = number_format($minimum_bid, 2);

$timezone = date('T');

$starts .= " $timezone";
$ends   .= " $timezone";

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
<p class="error" align="center">This auction will begin at <?php echo $starts; ?>. <br>To make any needed changes before the auction starts, click above on Your Pending Auctions.</p>
<table align="center" cellpadding="2" cellspacing="0">
 <tr>
  <td class="big"><b><nobr><?php echo $title; ?></nobr></b></td>
  <td align="right" class="big">Auction #<?php echo $id; ?></td>
 </tr>
 <tr>
  <td class="normal"><nobr><?php echo "$year $make $model $series"; ?></nobr></td>
  <td class="normal">&nbsp;</td>
 </tr>
 <tr>
  <td class="normal" colspan="2"><?php echo $image; ?><br /><?php echo $caption; ?></td>
 </tr>
 <tr><td class="small" colspan="2">&nbsp;</td></tr>
 <tr>
  <td class="big" colspan="2"><b><?php echo $title; ?></b></td>
 </tr>
 <tr><td class="small" colspan="2">&nbsp;</td></tr>
 <tr>
  <td class="normal" colspan="2"><b>Auction Details</b></td>
 </tr>
 <tr>
  <td colspan="2">
   <table border="0" cellpadding="4" cellspacing="0">
    <tr>
     <td class="normal">Bids start at</td>
     <td class="normal">$<?php echo $minimum_bid; ?></td>
    </tr>
    <tr>
     <td class="normal">Bid Increment</td>
     <td class="normal">$<?php echo $bid_increment; ?></td>
    </tr
    ><tr>
     <td class="normal">Reserve Price</td>
     <td class="normal">$<?php echo $reserve_price; ?></td>
    </tr>
    <tr>
     <td class="normal">Buy Now Price</td>
     <td class="normal">$<?php echo $buy_now_price; ?></td>
    </tr>
    <tr>
     <td class="normal">Starts</td>
     <td class="normal"><?php echo $starts; ?></td>
    </tr>
    <tr>
     <td class="normal">Ends</td>
     <td class="normal"><?php echo $ends; ?></td>
    </tr>
    <tr>
     <td class="normal">Location</td>
     <td class="normal"><?php echo "$city, $state $zip"; ?></td>
    </tr>
   </table>
  </td>
 </tr>
<tr><td class="small" colspan="2">&nbsp;</td></tr>
 <tr><td class="small" colspan="2"><hr></td></tr>
 <tr>
  <td class="normal" colspan="2" align="center"><b>Item Details</b></td>
 </tr>
 <tr><td colspan="2">&nbsp;</td></tr> 
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
?>
 <tr><td colspan="2">&nbsp;</td></tr>
  <tr>
  <td class="normal" colspan="2"><b>Item Description</b></td>
 </tr>
 <tr>
  <td colspan="2" class="normal"><?php echo $veh_long_desc; ?></td>
 </tr>
 <tr><td class="small" colspan="2">&nbsp;</td></tr>
 <tr>
  <td class="normal" colspan="2"><b>Item Condition</b></td>
 </tr>
 <tr>
  <td colspan="2" class="normal"><?php echo $condition; ?></td>
 </tr>
 <tr><td class="small" colspan="2">&nbsp;</td></tr> 
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
 <table align="center" border="0" cellpadding="4" cellspacing="0">
<?php
$result = db_do("SELECT id, caption FROM photos WHERE vehicle_id='$vid' AND " .
    "id!='$photo'");
if (db_num_rows($result) > 0) {
?>
 <tr><td class="small" colspan="2">&nbsp;</td></tr>
 <tr>
  <td colspan="2" class="normal"><b>Additional Pictures</b></td>
 </tr>
<?php
	while (list($pid, $caption) = db_row($result)) {
?>
 <tr><td class="small" colspan="2">&nbsp;</td></tr>
 <tr>
  <td class="normal" colspan="2"><img src="../uploaded/<?php echo $pid; ?>.jpg"><br /><?php echo $caption; ?></td>
 </tr>
<?php
	}
}

db_free($result);
?>
</table>
</body>
</html>
<?php
db_disconnect();
?>
