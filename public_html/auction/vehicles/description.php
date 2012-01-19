<?php

include_once('../../../include/session.php');
include_once('../../../include/db.php');

if (!has_priv('vehicles', $privs)) {
	header('Location: ../menu.php');
	exit;
}
$page_title = 'Add Wholesale Item Description';
$help_page = "chp6_create.php";



extract(defineVars("id", "cid", "subcid1", "subcid2", "make", "model", "year", "vin", "hin",
"miles", "hours", "hours_unknown", "short_desc", "long_desc", "comments", "city", "state", "zip",
"stock_num", "series", "body", "engine", "transmission", "trans_other", "interior_color",
"exterior_color", "warranty", "title", "title_status", "certified", "fuel_type", "drive_train",
"engine_size", "engine_make", "wheel_size", "pmt_method", "horsepower", "trailer", "length",
"seating", "boat_use", "seats",  "security_system", "gps", "hitch", "ac_yn", "fish_finder",
 "depth_finder", "trailer_type", "trailer_material", "trailer_brakes", "trailer_spare", "stereo",
 "bags", "sleep_no", "trailer_axle", "trailer_year", "hand_warmers", "studded", "cover", "am_exhaust",
 "sno_trailer", "axels", "maxload"));



$errors        = '';

db_connect();

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

if ($cid != 11 AND $cid != 12 AND $cid !=17 AND $cid != 2075 && $subcid1 != 2071 && $cid != 2481 && $subcid1 != 2820) {
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

if ($cid != 14 && $cid != 11 && $cid != 19 && $cid != 2075 && $cid != 2567) {
	if (empty($miles) && $miles!='0')
		$errors .= '<li>You must specify the number of miles on this item.</li>';
}

if ($cid == 14 || $cid == 11 || $cid == 2075 || $cid == 2567) {
	if ($hours_unknown == 'yes' && $hours > 0)
		$errors .= '<li>You must correctly specify the number of hours on this item.</li>';
}

if ($cid == 14 || $cid == 11 || $cid == 2567) {
	if ($hours_unknown != 'yes' && $hours == '')
		$errors .= '<li>You must correctly specify the number of hours on this item or select <i>Unknown hours</i>.</li>';
}

if($cid == 2075) {
   if($hours_unknown != 'yes' && $hours == '' && $miles == '') {
      $errors .= '<li>You must specify either the miles or the hours, or select <i>Unkonwn</i>';
   }
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

if($cid != 2075) {
	if (empty($title))
		$errors .= '<li>You must specify the title of this item.</li>';
}

if ($cid != 19) {
	if (empty($fuel_type))
		$errors .= '<li>You must specify the type of fuel for this item.</li>';
}

if ($cid == 13 || $cid == 15 || $cid == 16 || $cid == 17 || $cid == 18 || $cid == 2567) {
	if (empty($drive_train))
		$errors .= '<li>You must specify the drive train for this item.</li>';
}

	if (count($pmt_method) == 0)
		$errors .= '<li>You must accept one type of payment.</li>';

	if (empty($errors)) {

	$payment_method = implode(",", $pmt_method);
	$miles	= RemoveNonNumericChar($miles);
	$hours	= RemoveNonNumericChar($hours);

	db_do("INSERT INTO vehicles SET dealer_id='$dealer_id', " .
		    "category_id='$cid', subcategory_id1='$subcid1', subcategory_id2='$subcid2', make='$make', model='$model', " .
		    "year='$year', vin='$vin', hin='$hin', hours='$hours', hours_unknown='$hours_unknown', miles='$miles', " .
		    "short_desc='$short_desc', long_desc='$long_desc', comments='$comments', " .
		    "city='$city', state='$state', zip='$zip', " .
		    "modified=NOW(), created=NOW(), status='active', " .
			"stock_num='$stock_num', series='$series', " .
			"body='$body', engine='$engine', engine_make='$engine_make', transmission='$transmission', "  .
			"seats='$seats', interior_color='$interior_color', exterior_color='$exterior_color', "  .
			"warranty='$warranty', title='$title', title_status='$title_status', "  .
			"certified='$certified', fuel_type='$fuel_type', drive_train='$drive_train', engine_size='$engine_size', " .
			"wheel_size='$wheel_size', payment_method='$payment_method', horsepower='$horsepower', trailer='$trailer', " .
			"length='$length', seating='$seating', boat_use='$boat_use', gps='$gps', security_system='$security_system', " .
			"fish_finder='$fish_finder', depth_finder='$depth_finder', hitch='$hitch', ac_yn='$ac_yn', sleep_no='$sleep_no',
			trailer_spare='$trailer_spare', trailer_brakes='$trailer_brakes', trailer_material='$trailer_material',
			trailer_axle='$trailer_axle', trailer_type='$trailer_type', trailer_year='$trailer_year',
			stereo='$stereo', bags='$bags', hand_warmers='$hand_warmers', studded='$studded',
         cover_inc='$cover', am_exhaust='$am_exhaust', sno_trailer='$sno_trailer', axels='$axels', maxload='$maxload'");

		$vid = db_insert_id();
		header("Location: condition.php?vid=$vid");
		exit;
	}
}

$make          = stripslashes($make);
$model         = stripslashes($model);
$year          = stripslashes($year);
$vin           = stripslashes($vin);
$miles		   = stripslashes($miles);
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
$hours		   = stripslashes($hours);
$fuel_type	   = stripslashes($fuel_type);
$drive_train   = stripslashes($drive_train);
$engine_size   = stripslashes($engine_size);
$wheel_size    = stripslashes($wheel_size);
if(!empty($payment_method)) $payment_method= stripslashes($payment_method);
$horsepower	   = stripslashes($horsepower);
$trailer	   = stripslashes($trailer);
$length		   = stripslashes($length);
$seating	   = stripslashes($seating);
$boat_use	   = stripslashes($boat_use);

if (empty($city) && empty($state) && empty($zip)) {
	$result = db_do("SELECT city, state, zip FROM dealers WHERE id='$dealer_id'");
	list($city, $state, $zip) = db_row($result);
}

	$result = db_do("SELECT payment_method FROM dealers WHERE id='$dealer_id'");
	list($payment_method) = db_row($result);

$pmt_method = explode(',', $payment_method);

$photo_id = '';

include('../header.php');
?>

  <br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p>
<?php
include('_form_desc.php');
include('../footer.php');
db_disconnect();
?>
