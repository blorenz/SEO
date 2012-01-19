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

include('../../../include/db.php');

$page_title = 'Edit Item';

if (empty($id) || $id <= 0) {
        header('Location: index.php');
        exit;
} 

$make          = trim($make);
$model         = trim($model);
$year          = trim($year);
$vin           = trim($vin);
$hin           = trim($hin);
$miles		   = trim($miles);
$hours		   = trim($hours);
$short_desc    = trim($short_desc);
$long_desc     = trim($long_desc);
$comments      = trim($comments);
$city          = trim($city);
$zip           = trim($zip);
$stock_num     = trim($stock_num);
$series        = trim($series);
$body          = trim($body);
$engine        = trim($engine);
$transmission  = trim($transmission);
$trans_other   = trim($trans_other);
$interior_color= trim($interior_color);
$exterior_color= trim($exterior_color);
$warranty      = trim($warranty);
$title         = trim($title);
$title_status  = trim($title_status);
$certified     = trim($certified);
$fuel_type	   = trim($fuel_type);
$drive_train   = trim($drive_train);
$engine_size   = trim($engine_size);
$wheel_size    = trim($wheel_size);
$payment_method= trim($payment_method);
$horsepower	   = trim($horsepower);
$trailer	   = trim($trailer);
$length		   = trim($length);
$seating	   = trim($seating);
$boat_use	   = trim($boat_use);
$errors        = '';

db_connect();

$has_bid = 'no';
$status = 'closed';
$r = db_do("SELECT id, status, current_bid, reserve_price FROM auctions WHERE vehicle_id=$id ORDER BY created DESC, status DESC LIMIT 1");
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

$result = db_do("SELECT status FROM vehicles WHERE id='$id'");
if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}
list($status) = db_row($result);
db_free($result);

if (isset($submit)) {
	if (empty($short_desc))
		$errors .= '<li>You must specify an auction name.</li>';

	if (empty($make))
		$errors .= '<li>You must specify a manufacturer.</li>';

	if (empty($model))
		$errors .= '<li>You must specify a model.</li>';

	if (empty($year))
		$errors .= '<li>You must specify a year.</li>';

	if (empty($city))
		$errors .= '<li>You must supply a city.</li>';

	if (empty($zip))
		$errors .= '<li>You must supply a zipcode.</li>';

	if (empty($long_desc))
		$errors .= '<li>You must describe this item.</li>';
			
if ($cid != 14) {
	if (empty($vin))
		$errors .= '<li>You must specify a VIN.</li>';
}

if ($cid == 14) {
	if (empty($hin))
		$errors .= '<li>You must specify a HIN.</li>';
}

if ($cid != 11 AND $cid != 12 AND $cid !=17) {
	if (empty($body))
		$errors .= '<li>You must specify the body type.</li>';
}

if ($cid < 18) {
	if (empty($engine))
		$errors .= '<li>You must specify the engine of this item.</li>';
}

if ($cid == 14) {
	if (empty($engine_make))
		$errors .= '<li>You must specify the engine make of this item.</li>';
}

if ($cid != 14 && $cid != 11 && $cid != 19) {			
	if (empty($transmission)) {
		 if(empty($trans_other)) {
		 		 $errors .= '<li>You must specify the transmission of this item.</li>';
		}
	}else {
				if ( $transmission == 'other' ){
			 		 if( empty($trans_other) ) {
			 		 		 $errors .= '<li>You must specify the other transmission of this item.</li>';
			 		 }
				}
	}
}

	
	if (($transmission == 'other')) 
	 		 $transmission = $trans_other;

if ($cid != 14 && $cid != 11 && $cid != 19) {
	if (empty($miles) && $miles!='0')
		$errors .= '<li>You must specify the number of miles on this item.</li>';
}

if ($cid == 14 || $cid == 11) {
	if (empty($hours) && $hours!='0' && (!$if_hour_unknown))
		$errors .= '<li>You must specify the number of hours on this item.</li>';
}

if ($cid == 14) {
	if (empty($boat_use))
		$errors .= '<li>You must specify the use of this item.</li>';
}

if ($cid == 14) {
	if (empty($length))
		$errors .= '<li>You must specify the length of this item.</li>';
}

if ($cid != 19 && $cid != 14) {
	if (empty($seats))
		$errors .= '<li>You must specify the type of seats in this item.</li>';
}

	if (empty($exterior_color))
		$errors .= '<li>You must specify the exterior color of this item.</li>';
		   
	if (empty($title))
		$errors .= '<li>You must specify the title of this item.</li>';		
			
if ($cid != 19) {
	if (empty($fuel_type))
		$errors .= '<li>You must specify the type of fuel for this item.</li>';
}	

if ($cid == 14) {
	if (empty($drive_train))
		$errors .= '<li>You must specify the drive train for this item.</li>';
}	

	if (count($pmt_method) == 0)
		$errors .= '<li>You must accept one type of payment.</li>';	
		

	if (empty($errors)) {
	
		if (!isset($pmt_method))
			$pmt_method = array();
		else
			$payment_method = implode(",", $pmt_method);
	
		db_do("UPDATE vehicles SET make='$make', model='$model', year='$year', vin='$vin', hin='$hin', hours='$hours', 
				miles='$miles', short_desc='$short_desc', long_desc='$long_desc', comments='$comments', city='$city', 
				state='$state', zip='$zip', modified=NOW(), status='active', stock_num='$stock_num', series='$series', 
				body='$body', engine='$engine', engine_make='$engine_make', transmission='$transmission', seats='$seats', 
				interior_color='$interior_color', exterior_color='$exterior_color', warranty='$warranty', title='$title', 
				title_status='$title_status', certified='$certified', fuel_type='$fuel_type', drive_train='$drive_train', 
				engine_size='$engine_size', wheel_size='$wheel_size', payment_method='$payment_method', horsepower='$horsepower', 
				trailer='$trailer', length='$length', seating='$seating', boat_use='$boat_use', gps='$gps', 
				security_system='$security_system', fish_finder='$fish_finder', depth_finder='$depth_finder', 
				hitch='$hitch', slide_out='$slide_out', ac_yn='$ac_yn', sleep_no='$sleep_no' WHERE id='$id'");

		db_disconnect();
		
		header("Location: condition.php?vid=$id");
		exit;
	}
}
else {
	$result = db_do("SELECT dealer_id, category_id, subcategory_id1, subcategory_id2, " . 
						"make, model, year, vin, hin, hours, miles, short_desc, long_desc, comments, " . 
						"city, state, zip, stock_num, series, body, " . 
						"engine, engine_make, transmission, seats, interior_color, exterior_color, " . 
						"warranty, title, title_status, certified, fuel_type, drive_train, engine_size, wheel_size, " . 
						"payment_method, horsepower, trailer, length, seating, boat_use, " . 
						"gps, security_system, fish_finder, depth_finder, hitch,
						slide_out, ac_yn, sleep_no FROM vehicles WHERE id='$id'");

	list($dealer_id, $cid, $subcid1, $subcid2, 
			$make, $model, $year, $vin, $hin, $hours, $miles, $short_desc, $long_desc, $comments, 
			$city, $state, $zip, $stock_num, $series, $body, 
			$engine, $engine_make, $transmission, $seats, $interior_color, $exterior_color, 
			$warranty, $title, $title_status, $certified, $fuel_type, $drive_train, $engine_size, $wheel_size, 
			$payment_method, $horsepower, $trailer, $length, $seating, $boat_use, 
			$gps, $security_system, $fish_finder, $depth_finder, $hitch, $slide_out, $ac_yn, $sleep_no) = db_row($result);

	$pmt_method = explode(',', $payment_method);
	db_free($result);
}

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

include('../header.php');
?>
  <br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php
include('_form_desc.php');
include('../footer.php');
db_disconnect();
?>