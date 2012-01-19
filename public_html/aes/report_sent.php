<?php

$page_title = 'Report To Your DM';
$page_link = 'docs/chp3.php#Chp3_ReportDM';
$no_menu = 1;

include('../../include/session.php');
include('../../include/db.php');
db_connect();

$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

$sent = FALSE;

$result = db_do("SELECT id FROM users WHERE username='$username'");
list($ae_uid) = db_row($result);
$from_user = $ae_uid;

$date = strtotime("-5 hours");
$date_in_five = $date + 604800;

$year = date('Y', $date_in_five);
$month = date('m', $date_in_five);
$day = date('d', $date_in_five);
$hour = date('H', $date_in_five);
	
	
if ($sendreport) {

	if (empty($did))
		$errors .= '<li>You must specify the Dealership.</li>';

	if (empty($phone_1) || empty($phone_2) || empty($phone_3))
		$errors .= '<li>You must copmlete the Dealership Phone Number.</li>';

	if (empty($comments))
		$errors .= '<li>You must copmlete the Report Comments.</li>';
		
	if (empty($poc_1_name))
		$errors .= '<li>You must supply at least one Point of Contact.</li>';
		
		if (empty($errors)) {
		
			$phone = $phone_1."-".$phone_2."-".$phone_3;
			
			if (!empty($poc_1_direct_1) || !empty($poc_1_direct_2) || !empty($poc_1_direct_3)) { 
				$poc_1_direct = $poc_1_direct_1."-".$poc_1_direct_2."-".$poc_1_direct_3;
				if (!empty($poc_1_direct_e))
					$poc_1_direct.= "x".$poc_1_direct_e;
			}
			
			if (!empty($poc_2_direct_1) || !empty($poc_2_direct_2) || !empty($poc_2_direct_3)) { 
				$poc_2_direct = $poc_2_direct_1."-".$poc_2_direct_2."-".$poc_2_direct_3;
				if (!empty($poc_2_direct_e))
					$poc_2_direct.= "x".$poc_2_direct_e;
			}
			
			if (!empty($poc_3_direct_1) || !empty($poc_3_direct_2) || !empty($poc_3_direct_3)) { 
				$poc_3_direct = $poc_3_direct_1."-".$poc_3_direct_2."-".$poc_3_direct_3;
				if (!empty($poc_3_direct_e))
					$poc_3_direct.= "x".$poc_3_direct_e;
			}
	
			$meeting = $month.$day.$year.$hour."0000";
			
			db_do("INSERT INTO dmreports SET ae_id='$ae_id', comments='$comments', 
			did='$did', phone='$phone', fax='$fax', 
			poc_1_name='$poc_1_name', poc_1_title='$poc_1_title', poc_1_direct='$poc_1_direct', poc_1_cell='$poc_1_cell', poc_1_email='$poc_1_email', 
			poc_2_name='$poc_2_name', poc_2_title='$poc_2_title', poc_2_direct='$poc_2_direct', poc_2_cell='$poc_2_cell', poc_2_email='$poc_2_email', 
			poc_3_name='$poc_3_name', poc_3_title='$poc_3_title', poc_3_direct='$poc_3_direct', poc_3_cell='$poc_3_cell', poc_3_email='$poc_3_email', 
			meeting='$meeting', created=NOW()");

	}

} ?>
		<html><head><title>Account Executive: <?= $page_title ?></title>
		<link rel="stylesheet" type="text/css" href="../site.css" title="site" /></head>
		<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"><?php include('header.php'); ?>
		<?php include('_links.php'); ?><p align="center" class="big"><b><?= $page_title ?></b></p>
<table border="0" cellspacing="2" cellpadding="2" width="100%">
	<tr valign="top">
	
		<!-- Left Column -->
		<td bgcolor="#EEEEEE" width="20%">
		<?php #include('_alerts.php'); ?>
		</td>
		<td width="60%" align="center" class="header"><br>
			Report Sent.<br><br>
			
			To Create another report <a href="report.php">click here</a>

			</td>
		<td width="20%"></td>
	</tr>		
</table>

<?php
db_disconnect();
include('footer.php');
?>