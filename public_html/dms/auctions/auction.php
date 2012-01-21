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
# $srp: godealertodealer.com/htdocs/auction/vehicles/edit.php,v 1.9 2003/02/24 17:13:39 steve Exp $
#

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

if (empty($aid) || $aid <= 0) {
        header("Location: ../index.php");
        exit;
}

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$ae_array = findAEforDM($dm_id);
if (!in_array($id, $ae_array)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$result = db_do("SELECT can_buy FROM dealers WHERE id='$dealer_id'");
list($can_buy) = db_row($result);
db_free($result);

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
				"vehicles.gps, vehicles.fish_finder, vehicles.depth_finder, vehicles.security_system FROM " .
    "auctions, categories, vehicles, dealers WHERE auctions.id='$aid' AND " .
    "auctions.category_id=categories.id AND auctions.vehicle_id=vehicles.id " .
    "AND auctions.dealer_id=dealers.id");

if (db_num_rows($result) <= 0) {
	header('Location: index.php');
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
		$gps, $fish_finder, $depth_finder, $security_system) = db_row($result);
db_free($result);

$description_report = array("VIN" => $vin, "HIN" => $hin, "Stock Number" => $stock_num, 
		"Boat Length" => $length, "Use" => $boat_use, "Body" => $body, "Exterior Color" => $exterior_color, 
		"Interior Color" => $interior_color, "Seat Surface" => $seats, "Max Seating Capacity" => $seating, "Wheel Size" => $wheel_size, 
		"Miles" => $miles, "Hours" => $hours, "Engine" => $engine, 
		"Engine Size" => $engine_size, "Engine Make" => $engine_make, "Horsepower" => $horsepower, 
		"Drive Train" => $drive_train, "Transmission" => $transmission, "Fuel Type" => $fuel_type, 
		"Title" => $title_item, "Title Status" => $title_status, "Warranty" => $warranty, 
		"Certified" => $certified, "GPS/Navigation System" => $gps, "Security System" => $security_system, 
		"Hitch" => $hitch, "Trailer Included" => $trailer, "Fish Finder" => $fish_finder, "Depth Finder" => $depth_finder);
				
$condition_report = array("Engine" => $engine_mech, "Transmission" => $transmission_mech, "Exhuast" => $exhuast, 
				"Tires" => $tires, "Brakes" => $brakes, "Steering" => $steering, "A/C" => $ac, "Prop" => $prop, 
				"Front Seats" => $front_seats, "Rear Seats" => $rear_seats, "Carpet" => $carpet, 
				"Headliner" => $headliner, "Dash" => $dash, "Electronics" => $electronics, 
				"Paint" => $paint, "Hood" => $hood, "R Front Fender" => $r_f_fender, "L Front Fender" => $l_f_fender, 
				"Right Door" => $r_door, "Left Door" => $l_door, "Front Fender" => $f_fender, "Rear Fender" => $r_fender, 
				"Right Rear" => $r_rear, "Left Rear" => $l_rear, "Trunk" => $trunk, "Front Bumper" => $f_bumper, 
				"Rear Bumper" => $r_bumper, "Side Bumper" => $s_bumper, "Grille" => $grille, "Tongue" => $tongue, 
				"Glass" => $glass, "Frame" => $frame, "Hull" => $hull);
				


db_do("UPDATE auctions SET views=views+1 WHERE id='$aid'");
$result = db_do("SELECT views FROM auctions WHERE id='$aid'");
list($views) = db_row($result);
db_free($result);

$timeleft = timeleft($when);
if (empty($timeleft) || $timeleft < 0)
	$timeleft = '<font color="#FF0000">closed</font>';

$timezone = date('T');

$starts .= " $timezone";
$ends   .= " $timezone";

$result = db_do("SELECT COUNT(*) FROM bids WHERE auction_id='$aid'");
list($count_bids) = db_row($result);
db_free($result);

if (empty($count_bids))
	$count_bids = 0;

if ($current_bid >= $minimum_bid)
	$new_bid = number_format($current_bid + $bid_increment, 2);
else
	$new_bid = number_format($minimum_bid, 2);

if (empty($photo)) {
	$result = db_do("SELECT id FROM photos WHERE vehicle_id='$vid' " .
	    "ORDER BY id LIMIT 1");

	if (db_num_rows($result) == 1)
		list($photo) = db_row($result);

	db_free($result);
}

if (!empty($photo) && file_exists("../../auction/uploaded/$photo.jpg")) {
	$image = "<img src=\"../../auction/uploaded/$photo.jpg\">";

	$result = db_do("SELECT caption FROM photos WHERE id='$photo'");
	list($caption) = db_row($result);
	db_free($result);
} else
	$image = '&nbsp;';

?>
<html>
 <head>
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p><br>
<table width="600" align="center" border="0" cellpadding="2" cellspacing="0">
 <tr>
  <td class="big"><b><nobr><?php echo $title; ?></nobr></b></td>
  <td align="right" class="big">Auction #<?php echo $aid; ?></td>
 </tr>
  <td class="normal" colspan="2"><?php echo $image; ?><br /><?php echo $caption; ?></td>
 </tr>
 <tr><td class="small" colspan="2">&nbsp;</td></tr>
 <tr><td class="small" colspan="2">&nbsp;</td></tr>
<?php if ($rating > 0) { ?>
 <tr>
  <td class="normal"><b>Seller Rating: </b><?php echo $rating; ?><br><br></td>
 </tr>
<?php } ?>
 <tr>
  <td class="normal"><b>Auction Details</b></td>
 <?php if ($reserve_lowered == 'yes' && $current_bid < $reserve_price) { ?>
				<td class="normal"><img src="images/reserveLowered_small.gif" align='left'><font color="#0E5907"><b>The seller lowered <br>the reserve price</b></font></td>
				<td class="small" colspan="2">&nbsp;</td>
				<td class="small" colspan="2">&nbsp;</td>
 <?php } ?>
 </tr>
 <tr>
  <td colspan="2">
   <table border="0" cellpadding="4" cellspacing="0">
    <tr>
     <td>
      <table border="0" cellpadding="2" cellspacing="0">
<?php
if ($status == 'open') {
	if ($current_bid >= $minimum_bid) {
		if ($current_bid < $reserve_price) {
					$foo = '&nbsp;&nbsp;<font color="#FF0000"><b>' .
			    		 '(reserve not met)</b></font>';
		}
		elseif ($reserve_price > 0)
			$foo = '&nbsp;&nbsp;<font color="#0E5907"><b>' .
			    '(reserve met)</b></font>';
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
			 <tr><td class="small" colspan="2">&nbsp;</td></tr>
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
        <td class="normal">Buy Now Price</td>
        <td class="normal"><b>US $<?php echo number_format($buy_now_price, 2); ?></b></td>
      </tr>
<?php
}
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
        <td class="normal">Location</td>
        <td class="normal"><b><?php echo "$city, $state $zip"; ?></b></td>
	</tr>
	<tr>
        <td class="normal">Who pays transport?</td>
        <td class="normal"><b><?php echo ucfirst($pays_transport); ?></b></td>
       </tr>
 			 <tr><td class="small" colspan="2">&nbsp;</td>
		</tr>
      </table>
     </td>
     <td valign="top">
     </td>
    </tr>
   </table>
   </td>
  </tr>
  <tr>
    <td class="small" colspan="2"><hr></td></tr>
 <tr>
  <td class="normal" colspan="2" align="center"><b>Item Description </b></td>
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
	 <?php if (!empty($add_description)) { ?>
	 <tr>
 <td class="normal" colspan="2"><b>The dealer added the following information on <?php echo $desc_mod ?></b></td>
 </tr>
	 <tr>
 <td colspan="2" class="normal"><?php echo $add_description; ?></td>
	 </tr>
	 <?php } ?>	 
  <tr>
    <td class="small" colspan="2"><hr></td></tr>
 <tr>
  <td class="normal" colspan="2" align="center"><b>Condition Report </b></td>
 </tr>
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
    <td class="normal" colspan="2"><img src="../../../auction/uploaded/<?php echo $pid; ?>.jpg"><br />
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
<?php
	include('../footer.php');
?>
 </body>
</html>