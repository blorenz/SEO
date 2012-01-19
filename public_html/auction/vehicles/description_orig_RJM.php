<?php

include_once('../../../include/session.php');
include_once('../../../include/db.php');

if (!has_priv('vehicles', $privs)) {
	header('Location: ../menu.php');
	exit;
}
$page_title = 'Add Wholesale Item Description';
$help_page = "chp6_create.php";



extract(defineVars("make", "model", "year"));
        //   I temp commented out these 3 vars for testing.    RJM




if(isset($_REQUEST['id']))
	$id				= $_REQUEST['id'];
else
	$id				= "";
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

/*          if(isset($_REQUEST['make']))
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
	$year          = "";       */


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
	$hours_unknown	= RemoveNonNumericChar($_REQUEST['hours_unknown']);
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
if(isset($_REQUEST['engine_make']))
	$engine_make   = trim($_REQUEST['engine_make']);
else
	$engine_make          = "";
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
