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

if (empty($vid) || $vid <= 0) {
        header("Location: ../index.php");
        exit;
}

$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$dealers_array = findDEALERforAE($ae_id);
if (!in_array($did, $dealers_array)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$result = db_do("SELECT name FROM dealers WHERE id='$did'");
list($dealer_name) = db_row($result);

$page_title = "Account Executive: View Item for $dealer_name";

$result = db_do("SELECT status FROM vehicles WHERE id='$vid' AND dealer_id='$did'");
if (db_num_rows($result) <= 0) {
	header("Location: ../index.php");
	exit;
}
list($status) = db_row($result);
db_free($result);


$result = db_do("SELECT dealer_id, category_id, subcategory_id1, subcategory_id2, " . 
					"make, model, year, vin, hin, hours, miles, short_desc, long_desc, comments, " . 
					"city, state, zip, stock_num, series, body, " . 
					"engine, engine_make, transmission, seats, interior_color, exterior_color, " . 
					"warranty, title, title_status, certified, fuel_type, drive_train, engine_size, wheel_size, " . 
					"payment_method, horsepower, trailer, length, seating, boat_use, " . 
					"gps, security_system, fish_finder, depth_finder, hitch,
					slide_out, ac_yn, sleep_no FROM vehicles WHERE id='$vid'");

list($dealer_id, $cid, $subcid1, $subcid2, 
		$make, $model, $year, $vin, $hin, $hours, $miles, $short_desc, $long_desc, $comments, 
		$city, $state, $zip, $stock_num, $series, $body, 
		$engine, $engine_make, $transmission, $seats, $interior_color, $exterior_color, 
		$warranty, $title, $title_status, $certified, $fuel_type, $drive_train, $engine_size, $wheel_size, 
		$payment_method, $horsepower, $trailer, $length, $seating, $boat_use, 
		$gps, $security_system, $fish_finder, $depth_finder, $hitch, $slide_out, $ac_yn, $sleep_no) = db_row($result);

db_free($result);

$make          = stripslashes($make);
$model         = stripslashes($model);
$year          = stripslashes($year);
$vin           = stripslashes($vin);
$miles		   = RemoveNonNumericChar($miles);
$short_desc    = stripslashes($short_desc);
$long_desc     = stripslashes($long_desc);
$comments      = stripslashes($comments);
$city          = stripslashes($city);
$zip           = stripslashes($zip);
$stock_num     = stripslashes($stock_num);
$series        = stripslashes($series);
$body          = stripslashes($body);
$engine        = stripslashes($engine);
$transmission  = stripslashes($transmission);
$trans_other   = stripslashes($trans_other);
$interior_color= stripslashes($interior_color);
$exterior_color= stripslashes($exterior_color);
$warranty      = stripslashes($warranty);
$title         = stripslashes($title);
$title_status  = stripslashes($title_status);
$certified     = stripslashes($certified);
$hin           = stripslashes($hin);
$hours		   = RemoveNonNumericChar($hours);
$fuel_type	   = stripslashes($fuel_type);
$drive_train   = stripslashes($drive_train);
$engine_size   = stripslashes($engine_size);
$wheel_size    = stripslashes($wheel_size);
$payment_method= stripslashes($payment_method);
$horsepower	   = stripslashes($horsepower);
$trailer	   = stripslashes($trailer);
$length		   = stripslashes($length);
$seating	   = stripslashes($seating);
$boat_use	   = stripslashes($boat_use);

?>
<html>
 <head>
  <title>Account Executive: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?><?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p><br>
<?php

if(isset($cid))
{
	$result = db_do("SELECT name FROM categories WHERE id=$cid");
	list($z) = db_row($result);
}

if(isset($subcid1))
{
	$result = db_do("SELECT name FROM categories WHERE id=$subcid1");
	list($y) = db_row($result);
}

if(isset($subcid2))
{
	$result = db_do("SELECT name FROM categories WHERE id=$subcid2");
	list($x) = db_row($result);
}

?> 
  </p>
   <table align="center" border="0" cellspacing="0" cellpadding="2">
    <tr>
		<td align="right" class="header">Category:</td><td class="normal">

			<?php
				echo "$z";
			if (isset($y) AND $subcid1 > 1)
			{
				echo " : $y ";
				if (isset ($x) AND $subcid2 > 1)
				echo " : $x";
			}?>
		</td>
    </tr>
	
	<tr>
		<td align="right" class="header">Auction Title:</td>
		<td class="normal"><?php echo $short_desc; ?></td>
    </tr>
	
	<tr>
		<td align="right" class="header">Year:</td>
		<td class="normal"><?php echo $year; ?></td>
    </tr>
	
    <tr>
		<td align="right" class="header">Manufacturer:</td>
		<td class="normal">
<?php if ($cid == 16 && $subcid1 > 1 && $y != "Other")
			echo $y;
		elseif ($cid == 15 && $subcid1 > 1 && $y != "Other")
			echo $y;
		elseif ($cid == 14 && $y == "Personal Watercraft" && $x != "Other")
			echo $x;
		elseif ($cid == 12 && $subcid1 > 1 && $y != "Other")
			echo $y;
		else 
			echo $make; ?>
		</td>
    </tr>
	
    <tr>
		<td align="right" class="header">Model:</td>
		<td class="normal">
<?php if ($cid == 16 && $subcid2 > 1 && $x != "Other")
			echo $x;
	elseif ($cid == 15 && $subcid2 > 1 && $x != "Other")
			echo $x;
	else
			echo $model; ?>
		</td>
    </tr>
	
	<tr>
		<td align="right" class="header">Series:</td>
		<td class="normal"><?php echo $series; ?></td>
    </tr>
	
<?php if ($cid != 14) { ?>
    <tr>
		<td align="right" class="header">VIN:</td>
		<td class="normal"><?php echo $vin; ?></td>
    </tr>
<?php } ?>
<?php if ($cid == 14) { ?>
	<tr>
		<td align="right" class="header">HIN:</td>
		<td class="normal"><?php echo $hin; ?></td>
    </tr>
<?php } ?>

	<tr>
		<td align="right" class="header">Stock Number:</td>
		<td class="normal"><?php echo $stock_num; ?></td>
    </tr>

<?php if ($cid != 14 && $cid != 11 && $cid != 19) { ?>	
	<tr>
		<td align="right" class="header">Miles:</td>
		<td class="normal"><?php echo $miles; ?></td>
	</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 11) { ?>	
	<tr>
		<td align="right" class="header">Hours:</td>
		<td class="normal"><?php echo $hours; ?></td>
	</tr>
<?php } ?>
	
<?php if ($cid >= 13  && $cid != 17) { ?>
	<tr>
		<td align="right" class="header">Body:</td>
		<td class="normal"><?php echo $body; ?></td>
    </tr>
<?php } ?>
<?php if ($cid >= 11 || $cid == 16 || $cid <= 17) { ?>
	<tr>
		<td align="right" class="header">Engine:</td>
		<td class="normal"><?php echo $engine; ?></td>
	</tr>
<?php } ?>
<?php if ($cid != 19) { ?>	
	<tr>
		<td align="right" class="header">Engine Size:</td>
		<td class="normal"><?php echo $engine_size; ?></td>
	</tr>
<?php } ?>
<?php if ($cid == 14) { ?>
	<tr>
		<td align="right" class="header">Engine Make:</td>
		<td class="normal"><?php echo $engine_make; ?></td>
	</tr>
<?php } ?>

<?php if ($cid != 19) { ?>	
	<tr>
		<td align="right" class="header">Fuel Type:</td>
		<td class="normal"><?php echo $fuel_type; ?></td>
	</tr>
<?php } ?>
<?php if ($cid >= 13 && $cid <= 18) { ?>	
	<tr>
		<td align="right" class="header">Drive Train:</td>
		<td class="normal"><?php echo $drive_train; ?></td>
	</tr>
<?php } ?>
<?php if ($cid != 14 && $cid != 11 && $cid != 19) { ?>
	<tr>
     <td align="right" class="header">Transmission:</td>
		<td class="normal"><?php echo $transmission; ?></td>
    </tr>
<?php } ?>

<?php if ($cid == 14 || $cid == 11) { ?>	
	<tr>
		<td align="right" class="header">Horsepower:</td>
		<td class="normal"><?php echo $horsepower; ?></tr>
<?php } ?>
<?php if ($cid == 14) { ?>	
	<tr>
		<td align="right" class="header">Use:</td>
		<td class="normal"><?php echo $boat_use; ?></td>
	</tr>
<?php } ?>
<?php if ($cid == 14) { ?>	
	<tr>
		<td align="right" class="header">Boat Length:</td>
		<td class="normal"><?php echo $length; ?></td>
	</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 11) { ?>	
	<tr>
		<td align="right" class="header">Max Seating Capacity:</td>
		<td class="normal"><?php echo $seating; ?></td>
	</tr>
<?php } ?>
<?php if ($cid != 19) { ?>	
	<tr>
		<td align="right" class="header">Seat Surface:</td>
		<td class="normal"><?php echo $seats; ?></td>
	</tr>
<?php } ?>
<?php if ($cid != 12 && $cid != 15 && $cid != 19) { ?>	
	<tr>
		<td align="right" class="header">Interior Color:</td>
		<td class="normal"><?php echo $interior_color; ?></td>
    </tr>
<?php } ?>
	<tr>
     <td align="right" class="header">Exterior Color:</td>
		<td class="normal"><?php echo $exterior_color; ?></td>
    </tr>
<?php if ($cid != 14) { ?>	
	<tr>
		<td align="right" class="header">Wheel Size:</td>
		<td class="normal"><?php echo $wheel_size; ?></td>
	</tr>
<?php } ?>
<?php if ($cid == 19) { ?>	
	<tr>
		<td align="right" class="header">Hitch:</td>
		<td class="normal"><?php echo $hitch; ?></td>
    </tr>
	<tr>
		<td align="right" class="header">Max Sleeping Capacity:</td>
		<td class="normal"><?php echo $sleep_no; ?></td>
    </tr>
<?php } ?>
	<tr>
		<td align="right" class="header">Title:</td>
		<td class="normal"><?php echo $title; ?></td>
    </tr>
	
	<tr>
		<td align="right" class="header">Title Status:</td>
		<td class="normal"><?php echo $title_status; ?></td>
    </tr>
	
	<tr>
		<td align="right" valign="top" class="header">Warranty:</td>
		<td class="normal"><?php echo $warranty; ?></td>
	</tr>
	
	<tr>
		<td align="right" valign="top" class="header">Certified:</td>
		<td class="normal"><?php echo $certified; ?></td>
	</tr>
	
	<tr>
		<td align="right" valign="top" class="header">Security System:</td>
		<td class="normal"><?php echo $security_system; ?></td>
	</tr>
<?php if ($cid != 17 && $cid != 19) { ?>		
	<tr>
		<td align="right" valign="top" class="header">GPS/Navigation System:</td>
		<td class="normal"><?php echo $gps; ?></td>
	</tr>
<?php } ?>	

<?php if ($cid != 11 && $cid != 14 && $cid != 19) { ?>
	<tr>
		<td align="right" valign="top" class="header">Hitch:</td>
		<td class="normal"><?php echo $hitch; ?></td>
	</tr>
<?php } ?>

<?php if ($cid == 14) { ?>
	<tr>
		<td align="right" valign="top" class="header">Trailer Included:</td>
		<td class="normal"><?php echo $trailer; ?></td>
	</tr>
	<tr>
		<td align="right" valign="top" class="header">Fish Finder:</td>
		<td class="normal"><?php echo $fish_finder; ?></td>
	</tr>
	<tr>
		<td align="right" valign="top" class="header">Depth Finder:</td>
		<td class="normal"><?php echo $depth_finder; ?></td>
	</tr>
<?php } ?>
<?php if ($cid == 19) { ?>
	<tr>
		<td align="right" valign="top" class="header">Slide Out:</td>
		<td class="normal"><?php echo $slide_out; ?></td>
	</tr>
<?php } ?>
	<tr>
		<td align="right" valign="top" class="header">Air Conditioning:</td>
		<td class="normal"><?php echo $ac_yn; ?></td>
	</tr>

    <tr>
		<td align="right" class="header" valign="top">Description:</td>
		<td class="normal"><textarea name="long_desc" rows="10" cols="50" wrap="virtual"><?php echo $long_desc; ?></textarea></td>
    </tr>
	   <tr>
		<td align="right" class="header" valign="top">Condition:</td>
		<td class="normal"><textarea name="condition" rows="10" cols="50" wrap="virtual"><?php echo $condition; ?></textarea></td>
    </tr>
<?php	
?>
	<tr>
		<td colspan="2" align="center" class="header" valign="top"><hr></td>
	</tr>
		
	<tr>
		<td align="right" class="header" valign="top"></td>
	</tr>
	
	<tr>
		<td colspan="2" align="center" class="big" valign="top"><b>Item Location</b></td>
	</tr>

	<tr>
		<td align="right" class="header">City:</td>
		<td class="normal"><?php echo $city; ?></td>
    </tr>
	
	<tr>
		<td align="right" class="header">State:&nbsp;</td>
		<td class="normal"><?php echo $state; ?></td>
    </tr>
	
    <tr>
		<td align="right" class="header">Zip:</td>
		<td class="normal"><?php echo $zip; ?></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="header" valign="top"><hr></td>
	</tr>

	<tr>
		<td align="right" class="header" valign="top">Accepted Payment Methods:</td>
		<td class="normal"><?php echo $payment_method; ?></td>
    </tr>	
	<tr>
		<td colspan="2" align="center" class="header" valign="top"><hr></td>
	</tr>
	<tr>
		<td align="right" class="header" valign="top">Comments:</td>
		<td class="normal"><textarea name="comments" rows="2" cols="50" wrap="virtual"><?php echo $comments; ?></textarea></td>
    </tr>
</table>

<?php include('../footer.php');
db_disconnect();
?>