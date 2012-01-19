<?php
$PHP_SELF = $_SERVER['PHP_SELF'];

include('../../../include/db.php');
extract(defineVars("id","cid","make","model","year","vin","hin","miles","hours","short_desc","long_desc","comments",
					"city","zip","stock_num","series","body","engine","transmission","trans_other","interior_color",
					"exterior_color","warranty","title","title_status","certified","fuel_type","drive_train",
					"engine_size","wheel_size","payment_method","horsepower","trailer","length","seating","boat_use",
					"pmt_method","seats","state","engine_make","gps","security_system","fish_finder","depth_finder",
					"hitch","slide_out","ac_yn","sleep_no")); //JJM 9/11/2010

$page_title = 'Edit Item';


if (empty($id) || $id <= 0) {
        header('Location: index.php');
        exit;
}

$errors        = '';

db_connect();

$has_bid = 'no';
$status = 'closed';
$r = db_do("SELECT id, status, current_bid, reserve_price FROM auctions WHERE vehicle_id=$id ORDER BY created DESC, status DESC LIMIT 1");
if (db_num_rows($r) > 0) {
	list($aid, $status, $current_bid, $reserve_price) = db_row($r);

}
db_free($r);

$result = db_do("SELECT status FROM vehicles WHERE id='$id'");
if (db_num_rows($result) <= 0) {
	header('Location: index.php');
	exit;
}
list($status) = db_row($result);
db_free($result);

if (isset($_POST['submit'])) {

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

if(!empty($_POST['submit']) && $_POST['submit'] == 'save') {
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

		header("Location: index.php");
		exit;
}




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
//if(!empty($trans_other))
//	$trans_other   = stripslashes($trans_other);
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
  <title>Administration: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
  <br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php
include('_form_desc.php');
db_disconnect();
?>
