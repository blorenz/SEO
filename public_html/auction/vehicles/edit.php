<?php

/**
* $Id: edit.php 571 2006-09-26 13:52:54Z kaneda $
*/

include('../../../include/session.php');
include('../../../include/db.php');
extract(defineVars( "q",  "no_menu",    // Added by RJM 1/4/10
"id", "cid", "subcid1", "subcid2", "", "make", "model", "year", "vin", "hin",    //JJM 1/20/2010
"miles", "hours", "hours_unknown", "short_desc", "long_desc", "comments", "city", "state", "zip",
"stock_num", "series", "body", "engine", "transmission", "trans_other", "interior_color",
"exterior_color", "warranty", "title", "title_status", "certified", "fuel_type", "drive_train",
"engine_size", "engine_make", "wheel_size", "pmt_method", "horsepower", "trailer", "length",
"seating", "boat_use", "seats",  "security_system", "gps", "hitch", "ac_yn", "fish_finder",
 "depth_finder", "trailer_type", "trailer_material", "trailer_brakes", "trailer_spare", "stereo",
 "bags", "sleep_no", "trailer_axle", "trailer_year", "hand_warmers", "studded", "cover", "am_exhaust",
 "sno_trailer", "axels", "maxload"));



if (!has_priv('vehicles', $privs)) {
	header('Location: ../menu.php');
	exit;
}

$page_title = 'Edit Item';
$help_page = "chp6.php";

if(isset($_REQUEST['id']))
	$id = $_REQUEST['id'];

if (empty($id) || $id <= 0) {
        header('Location: index.php');
        exit;
}

if(isset($_REQUEST['cid']))
	$cid			= $_REQUEST['cid'];
else
	$cid			= "";
if(isset($_REQUEST['subcid1']))
	$subcid1		= $_REQUEST['subcid1'];
else
	$subcid1		= "";
if(isset($_REQUEST['subcid2']))
	$subcid2		= $_REQUEST['subcid2'];
else
	$subcid2		= "";

if(isset($_REQUEST['make']))
	$make          = trim($_REQUEST['make']);
else
	$make          = "";
if(isset($_REQUEST['model']))
	$model         = trim($_REQUEST['model']);
else
	$model          = "";
if(isset($_REQUEST['year']))
	$year          = trim($_REQUEST['year']);
else
	$year          = "";
if(isset($_REQUEST['vin']))
	$vin           = trim($_REQUEST['vin']);
else
	$vin          = "";
if(isset($_REQUEST['hin']))
	$hin           = trim($_REQUEST['hin']);
else
	$hin          = "";
if(isset($_REQUEST['miles']))
	$miles		   = RemoveNonNumericChar($_REQUEST['miles']);
else
	$miles          = "";
if(isset($_REQUEST['hours']))
	$hours		   = RemoveNonNumericChar($_REQUEST['hours']);
else
	$hours          = "";
if(isset($_REQUEST['hours_unknown']))
	$hours_unknown	= $_REQUEST['hours_unknown'];  //JJM 1/20/2010 This line used the RemoveNonNumericChar() function, but that is bad, cause hours_unknown is either yes or blank
else
	$hours_unknown	= "";
if(isset($_REQUEST['short_desc']))
	$short_desc    = trim($_REQUEST['short_desc']);
else
	$short_desc          = "";
if(isset($_REQUEST['long_desc']))
	$long_desc     = trim($_REQUEST['long_desc']);
else
	$long_desc          = "";
if(isset($_REQUEST['comments']))
	$comments      = trim($_REQUEST['comments']);
else
	$comments          = "";
if(isset($_REQUEST['city']))
	$city          = trim($_REQUEST['city']);
else
	$city          = "";
if(isset($_REQUEST['state']))
	$state          = trim($_REQUEST['state']);
else
	$state          = "";
if(isset($_REQUEST['zip']))
	$zip           = trim($_REQUEST['zip']);
else
	$zip          = "";
if(isset($_REQUEST['stock_num']))
	$stock_num     = trim($_REQUEST['stock_num']);
else
	$stock_num          = "";
if(isset($_REQUEST['series']))
	$series        = trim($_REQUEST['series']);
else
	$series          = "";
if(isset($_REQUEST['body']))
	$body          = trim($_REQUEST['body']);
else
	$body          = "";
if(isset($_REQUEST['engine']))
	$engine        = trim($_REQUEST['engine']);
else
	$engine          = "";
if(isset($_REQUEST['engine_make']))
	$engine_make   = trim($_REQUEST['engine_make']);
else
	$engine_make          = "";
if(isset($_REQUEST['transmission']))
	$transmission  = trim($_REQUEST['transmission']);
else
	$transmission          = "";
if(isset($_REQUEST['trans_other']))
	$trans_other   = trim($_REQUEST['trans_other']);
else
	$trans_other          = "";
if(isset($_REQUEST['interior_color']))
	$interior_color= trim($_REQUEST['interior_color']);
else
	$interior_color          = "";
if(isset($_REQUEST['exterior_color']))
	$exterior_color= trim($_REQUEST['exterior_color']);
else
	$exterior_color          = "";
if(isset($_REQUEST['warranty']))
	$warranty      = trim($_REQUEST['warranty']);
else
	$warranty          = "";
if(isset($_REQUEST['title']))
	$title         = trim($_REQUEST['title']);
else
	$title          = "";
if(isset($_REQUEST['title_status']))
	$title_status  = trim($_REQUEST['title_status']);
else
	$title_status          = "";
if(isset($_REQUEST['certified']))
	$certified     = trim($_REQUEST['certified']);
else
	$certified          = "";
if(isset($_REQUEST['fuel_type']))
	$fuel_type	   = trim($_REQUEST['fuel_type']);
else
	$fuel_type          = "";
if(isset($_REQUEST['drive_train']))
	$drive_train   = trim($_REQUEST['drive_train']);
else
	$drive_train          = "";
if(isset($_REQUEST['engine_size']))
	$engine_size   = trim($_REQUEST['engine_size']);
else
	$engine_size          = "";
if(isset($_REQUEST['wheel_size']))
	$wheel_size    = trim($_REQUEST['wheel_size']);
else
	$wheel_size          = "";
if(isset($_REQUEST['pmt_method']))
	$pmt_method= $_REQUEST['pmt_method'];
else
	$pmt_method          = array();
if(isset($_REQUEST['horsepower']))
	$horsepower	   = trim($_REQUEST['horsepower']);
else
	$horsepower          = "";
if(isset($_REQUEST['trailer']))
	$trailer	   = trim($_REQUEST['trailer']);
else
	$trailer          = "";
if(isset($_REQUEST['length']))
	$length		   = trim($_REQUEST['length']);
else
	$length          = "";
if(isset($_REQUEST['seating']))
	$seating	   = trim($_REQUEST['seating']);
else
	$seating          = "";
if(isset($_REQUEST['boat_use']))
	$boat_use		   = trim($_REQUEST['boat_use']);
else
	$boat_use          = "";
if(isset($_REQUEST['seats']))
	$seats		   = trim($_REQUEST['seats']);
else
	$seats          = "";
if(isset($_REQUEST['security_system']))
	$security_system	= trim($_REQUEST['security_system']);
else
	$security_system    = "";
if(isset($_REQUEST['gps']))
	$gps				= trim($_REQUEST['gps']);
else
	$gps				= "";
if(isset($_REQUEST['hitch']))
	$hitch		 	    = trim($_REQUEST['hitch']);
else
	$hitch              = "";
if(isset($_REQUEST['ac_yn']))
	$ac_yn		 	    = trim($_REQUEST['ac_yn']);
else
	$ac_yn              = "";
if(isset($_REQUEST['fish_finder']))
	$fish_finder		= trim($_REQUEST['fish_finder']);
else
	$fish_finder        = "";
if(isset($_REQUEST['depth_finder']))
	$depth_finder		= trim($_REQUEST['depth_finder']);
else
	$depth_finder       = "";
if(isset($_REQUEST['trailer_type']))
	$trailer_type		= trim($_REQUEST['trailer_type']);
else
	$trailer_type      	= "";
if(isset($_REQUEST['trailer_material']))
	$trailer_material	= trim($_REQUEST['trailer_material']);
else
	$trailer_material   = "";
if(isset($_REQUEST['trailer_brakes']))
	$trailer_brakes		= trim($_REQUEST['trailer_brakes']);
else
	$trailer_brakes     = "";
if(isset($_REQUEST['trailer_spare']))
	$trailer_spare		= trim($_REQUEST['trailer_spare']);
else
	$trailer_spare      = "";
if(isset($_REQUEST['stereo']))
	$stereo		 	    = trim($_REQUEST['stereo']);
else
	$stereo             = "";
if(isset($_REQUEST['bags']))
	$bags		 	    = trim($_REQUEST['bags']);
else
	$bags               = "";
if(isset($_REQUEST['sleep_no']))
	$sleep_no		 	= trim($_REQUEST['sleep_no']);
else
	$sleep_no           = "";
if(isset($_REQUEST['trailer_axle']))
	$trailer_axle		= trim($_REQUEST['trailer_axle']);
else
	$trailer_axle       = "";
if(isset($_REQUEST['trailer_year']))
	$trailer_year		= trim($_REQUEST['trailer_year']);
else
	$trailer_year       = "";
if(isset($_REQUEST['hand_warmers']))
	$hand_warmers		= trim($_REQUEST['hand_warmers']);
else
	$hand_warmers       = "";
if(isset($_REQUEST['studded']))
	$studded		 	= trim($_REQUEST['studded']);
else
	$studded            = "";
if(isset($_REQUEST['cover']))
	$cover		 	    = trim($_REQUEST['cover']);
else
	$cover              = "";
if(isset($_REQUEST['am_exhaust']))
	$am_exhaust		 	= trim($_REQUEST['am_exhaust']);
else
	$am_exhaust         = "";
if(isset($_REQUEST['sno_trailer']))
	$sno_trailer		= trim($_REQUEST['sno_trailer']);
else
	$sno_trailer        = "";
if(isset($_REQUEST['axels']))
	$axels		 	    = trim($_REQUEST['axels']);
else
	$axels              = "";
if(isset($_REQUEST['maxload']))
	$maxload		 	= trim($_REQUEST['maxload']);
else
	$maxload            = "";

$errors        = '';

db_connect();

$has_bid = 'no';
$status = 'closed';
$r = db_do("SELECT id, status, current_bid, reserve_price FROM auctions WHERE vehicle_id=$id ORDER BY created DESC, status DESC LIMIT 1");
if (db_num_rows($r) > 0) {
	list($aid, $status, $current_bid, $reserve_price) = db_row($r);
	if ($status == 'open')
		if ($current_bid >= $reserve_price && $reserve_price > 0) {
			$has_bid = 'yes';
			header('Location: index.php');
			exit;
		}
}
db_free($r);

$result = db_do("SELECT status FROM vehicles WHERE dealer_id='$dealer_id' AND id='$id'");
if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}
list($status) = db_row($result);
db_free($result);

if (isset($_POST['submit'])) { //JJM had to add isset, to find the form
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

if ($cid != 14 && $cid != 2567) {
	if (empty($vin))
		$errors .= '<li>You must specify a VIN.</li>';
}

if ($cid == 14 || $cid == 2567) {
	if (empty($hin))
		$errors .= '<li>You must specify a HIN.</li>';
}

if ($cid != 11 AND $cid != 12 AND $cid !=17 && $cid != 2075 && $subcid1 != 2071) {
	if (empty($body))
		$errors .= '<li>You must specify the body type.</li>';
}

if ($cid < 18) {
	if (empty($engine))
		$errors .= '<li>You must specify the engine of this item.</li>';
}

if ($cid == 14 || $cid == 2567) {
	if (empty($engine_make))
		$errors .= '<li>You must specify the engine make of this item.</li>';
}

if ($cid != 14 && $cid != 11 && $cid != 19 && $cid != 2567) {
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

if ($cid != 14 && $cid != 11 && $cid != 19 && $cid != 2567) {
	if (empty($miles) && $miles!='0')
		$errors .= '<li>You must specify the number of miles on this item.</li>';
}

if ($cid == 14 || $cid == 11 || $cid == 2567) {
	if ($hours_unknown == 'yes' && $hours > 0)
		$errors .= '<li>You must correctly specify the number of hours on this item.</li>';
}

if ($cid == 14 || $cid == 11 || $cid == 2567) {
	if ($hours_unknown != 'yes' && $hours == '')
		$errors .= '<li>You must correctly specify the number of hours on this item.</li>';
}

if ($cid == 14 || $cid == 2567) {
	if (empty($boat_use))
		$errors .= '<li>You must specify the use of this item.</li>';
}

if ($cid == 14 || $cid == 2567) {
	if (empty($length))
		$errors .= '<li>You must specify the length of this item.</li>';
}

if ($cid != 19 && $cid != 14 && $cid != 2567) {
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

if ($cid == 13 || $cid == 15 || $cid == 16 || $cid == 17 || $cid == 18) {
	if (empty($drive_train))
		$errors .= '<li>You must specify the drive train for this item.</li>';
}

if ($cid == 14 || $cid == 2567) {
	if ((!empty($trailer_spare) || !empty($trailer_brakes) || !empty($trailer_material) || !empty($trailer_axle) ||
		!empty($trailer_type) || !empty($trailer_year)) && $trailer != 'Yes')
		$errors .= '<li>You must check Trailer Include if you want to specify Trailer Information.</li>';
}

	if (count($pmt_method) == 0)
		$errors .= '<li>You must accept one type of payment.</li>';


	if (empty($errors)) {

		if (!isset($pmt_method))
			$pmt_method = array();
		else
			$payment_method = implode(",", $pmt_method);
		$miles	= RemoveNonNumericChar($miles);
		$hours	= RemoveNonNumericChar($hours);

		db_do("UPDATE vehicles SET make='$make', model='$model', year='$year', vin='$vin', hin='$hin', hours='$hours',
				miles='$miles', short_desc='$short_desc', long_desc='$long_desc', comments='$comments', city='$city',
				state='$state', zip='$zip', modified=NOW(), status='active', stock_num='$stock_num', series='$series',
				body='$body', engine='$engine', engine_make='$engine_make', transmission='$transmission', seats='$seats',
				interior_color='$interior_color', exterior_color='$exterior_color', warranty='$warranty', title='$title',
				title_status='$title_status', certified='$certified', fuel_type='$fuel_type', drive_train='$drive_train',
				engine_size='$engine_size', wheel_size='$wheel_size', payment_method='$payment_method', horsepower='$horsepower',
				trailer='$trailer', length='$length', seating='$seating', boat_use='$boat_use', gps='$gps',
				security_system='$security_system', fish_finder='$fish_finder', depth_finder='$depth_finder',
				hitch='$hitch', slide_out='$slide_out', ac_yn='$ac_yn', sleep_no='$sleep_no', hours_unknown='$hours_unknown',
				trailer_spare='$trailer_spare', trailer_brakes='$trailer_brakes', trailer_material='$trailer_material',
				trailer_axle='$trailer_axle', trailer_type='$trailer_type', trailer_year='$trailer_year',
				stereo='$stereo', bags='$bags', axels='$axels', maxload='$maxload'  WHERE id='$id'");

		db_do("UPDATE auctions SET description='$long_desc' WHERE vehicle_id='$id' AND status='open'");

		db_disconnect();

		header("Location: condition.php?vid=$id");
		exit;
	}
}
else {
	$result = db_do("SELECT dealer_id, category_id, subcategory_id1, subcategory_id2, " .
						"make, model, year, vin, hin, hours, miles, short_desc, long_desc, comments, " .
						"city, state, zip, stock_num, series, body, hours_unknown, " .
						"engine, engine_make, transmission, seats, interior_color, exterior_color, " .
						"warranty, title, title_status, certified, fuel_type, drive_train, engine_size, wheel_size, " .
						"payment_method, horsepower, trailer, length, seating, boat_use, " .
						"gps, security_system, fish_finder, depth_finder, hitch, slide_out, ac_yn, sleep_no,
						trailer_spare, trailer_brakes, trailer_material, trailer_axle, trailer_type, trailer_year,
						stereo, bags, axels, maxload FROM vehicles WHERE id='$id'");

	list($dealer_id, $cid, $subcid1, $subcid2,
			$make, $model, $year, $vin, $hin, $hours, $miles, $short_desc, $long_desc, $comments,
			$city, $state, $zip, $stock_num, $series, $body, $hours_unknown,
			$engine, $engine_make, $transmission, $seats, $interior_color, $exterior_color,
			$warranty, $title, $title_status, $certified, $fuel_type, $drive_train, $engine_size, $wheel_size,
			$payment_method, $horsepower, $trailer, $length, $seating, $boat_use,
			$gps, $security_system, $fish_finder, $depth_finder, $hitch, $slide_out, $ac_yn, $sleep_no,
			$trailer_spare, $trailer_brakes, $trailer_material, $trailer_axle, $trailer_type, $trailer_year,
			$stereo, $bags, $axels, $maxload) = db_row($result);

	$pmt_method = explode(',', $payment_method);
	db_free($result);


   // populate payment options if not set.
   if (empty($pmt_method)) {
      $sql = "SELECT payment_method FROM dealers WHERE id = '$dealer_id'";
      $res = db_do($sql);
      list($payment_method) = db_row($res);
      $pmt_method = explode(',', $payment_method);
      db_free($res);
   }
}

$make          = stripslashes($make);
$model         = stripslashes($model);
$year          = stripslashes($year);
$vin           = stripslashes($vin);
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
