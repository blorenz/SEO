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

	if (empty($comments))
		$errors .= '<li>You must complete the Report Comments.</li>';
		
	if (empty($poc_1_name))
		$errors .= '<li>You must supply at least one Point of Contact.</li>';
		
		if (empty($errors)) {
			
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
			
			if (!empty($poc_1_cell_1) || !empty($poc_1_cell_2) || !empty($poc_1_cell_3)) 
				$poc_1_cell = $poc_1_cell_1."-".$poc_1_cell_2."-".$poc_1_cell_3;
			
			if (!empty($poc_2_cell_1) || !empty($poc_2_cell_2) || !empty($poc_2_cell_3))
				$poc_2_cell = $poc_2_cell_1."-".$poc_2_cell_2."-".$poc_2_cell_3;
			
			if (!empty($poc_3_cell_1) || !empty($poc_3_cell_2) || !empty($poc_3_cell_3))
				$poc_3_cell = $poc_3_cell_1."-".$poc_3_cell_2."-".$poc_3_cell_3;
	
			$meeting = $yearn.$monthn.$dayn.$hourn."0000";
			
			$result_dealer = db_do("SELECT name, CONCAT(address1, ' ', address2), phone, city, state, zip FROM dealers WHERE id='$did'");
			list ($name, $address, $phone, $city, $state, $zip) = db_row($result_dealer);
			
			db_do("INSERT INTO dmreports SET ae_id='$ae_id', comments='$comments', 
			name='$name', address='$address', city='$city', state='$state', zip='$zip', phone='$phone', 
			poc_1_name='$poc_1_name', poc_1_title='$poc_1_title', poc_1_direct='$poc_1_direct', poc_1_cell='$poc_1_cell', poc_1_email='$poc_1_email', 
			poc_2_name='$poc_2_name', poc_2_title='$poc_2_title', poc_2_direct='$poc_2_direct', poc_2_cell='$poc_2_cell', poc_2_email='$poc_2_email', 
			poc_3_name='$poc_3_name', poc_3_title='$poc_3_title', poc_3_direct='$poc_3_direct', poc_3_cell='$poc_3_cell', poc_3_email='$poc_3_email', 
			meeting='$meeting', created=NOW()");
			
			header('Location: report_sent.php');
			exit;

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
		<font color="#CC0000">
			* Note: You have to write a DM Report for 'EACH' of the day's Dealerships.<br>
			In order to write a DM Report, You must have the Dealership saved in your 'Saved Dealers' &amp; <br>
			have at least their Name, Address, City, State, Zip and Phone filled out in the 'Saved Dealers' secton.<br>
			If the Dealership is not 'Saved' or is without Address/Phone, it will not appear in the Drop Down Menu.<br><br>
			<font color="FF0000"><b>*&nbsp; = Required</b></font><br><br>
		</font>
<?php if (!empty($errors)) { ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
		<td class="error">The following errors occurred:<br /><ul><?php echo $errors; ?></ul>&nbsp;</td>
   </tr>
  </table>
<?php } ?>

			<form action="<?php echo $PHP_SELF; ?>" method="post">
				<table align="center" border="0" cellpadding="1" cellspacing="0">
				
<!-- Dealership Information -->
					<tr>
						<td valign="top" align="right" class="small"><font color="FF0000"><b>*&nbsp;</b></font><b>Dealership Name:&nbsp;</b></td>
						<td class="small"><select class="small" name="did">
							<option value="" selected>Choose Dealership</option>
							<?php $result_d = db_do("SELECT id, name, dba FROM dealers 
							WHERE ae_id='$ae_id' and phone!='' and address1!='' and city!='' and state!='' and zip!=''
							ORDER BY name");
								while (list($did, $name, $dba) = db_row($result_d)) { ?>
									<option value="<?=$did?>"><?=$name.", (".$dba.")"?></option>
							<?php } ?>
						</select></td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>


<!-- Comments Report -->
				<tr>
					 <td align="right" class="small"><b>"Tentative" Follow-up on:&nbsp;</b></td>
					 <td class="small">
					  <select name="monthn">
					   <option value="01" <?php if ($month == '01') echo 'selected'; ?>>January</option>
					   <option value="02" <?php if ($month == '02') echo 'selected'; ?>>February</option>
					   <option value="03" <?php if ($month == '03') echo 'selected'; ?>>March</option>
					   <option value="04" <?php if ($month == '04') echo 'selected'; ?>>April</option>
					   <option value="05" <?php if ($month == '05') echo 'selected'; ?>>May</option>
					   <option value="06" <?php if ($month == '06') echo 'selected'; ?>>June</option>
					   <option value="07" <?php if ($month == '07') echo 'selected'; ?>>July</option>
					   <option value="08" <?php if ($month == '08') echo 'selected'; ?>>August</option>
					   <option value="09" <?php if ($month == '09') echo 'selected'; ?>>September</option>
					   <option value="10" <?php if ($month == '10') echo 'selected'; ?>>October</option>
					   <option value="11" <?php if ($month == '11') echo 'selected'; ?>>November</option>
					   <option value="12" <?php if ($month == '12') echo 'selected'; ?>>December</option>
					  </select>
					  <select name="dayn">
					   <option value="01" <?php if ($day == '01') echo 'selected'; ?>>1</option>
					   <option value="02" <?php if ($day == '02') echo 'selected'; ?>>2</option>
					   <option value="03" <?php if ($day == '03') echo 'selected'; ?>>3</option>
					   <option value="04" <?php if ($day == '04') echo 'selected'; ?>>4</option>
					   <option value="05" <?php if ($day == '05') echo 'selected'; ?>>5</option>
					   <option value="06" <?php if ($day == '06') echo 'selected'; ?>>6</option>
					   <option value="07" <?php if ($day == '07') echo 'selected'; ?>>7</option>
					   <option value="08" <?php if ($day == '08') echo 'selected'; ?>>8</option>
					   <option value="09" <?php if ($day == '09') echo 'selected'; ?>>9</option>
					   <option value="10" <?php if ($day == '10') echo 'selected'; ?>>10</option>
					   <option value="11" <?php if ($day == '11') echo 'selected'; ?>>11</option>
					   <option value="12" <?php if ($day == '12') echo 'selected'; ?>>12</option>
					   <option value="13" <?php if ($day == '13') echo 'selected'; ?>>13</option>
					   <option value="14" <?php if ($day == '14') echo 'selected'; ?>>14</option>
					   <option value="15" <?php if ($day == '15') echo 'selected'; ?>>15</option>
					   <option value="16" <?php if ($day == '16') echo 'selected'; ?>>16</option>
					   <option value="17" <?php if ($day == '17') echo 'selected'; ?>>17</option>
					   <option value="18" <?php if ($day == '18') echo 'selected'; ?>>18</option>
					   <option value="19" <?php if ($day == '19') echo 'selected'; ?>>19</option>
					   <option value="20" <?php if ($day == '20') echo 'selected'; ?>>20</option>
					   <option value="21" <?php if ($day == '21') echo 'selected'; ?>>21</option>
					   <option value="22" <?php if ($day == '22') echo 'selected'; ?>>22</option>
					   <option value="23" <?php if ($day == '23') echo 'selected'; ?>>23</option>
					   <option value="24" <?php if ($day == '24') echo 'selected'; ?>>24</option>
					   <option value="25" <?php if ($day == '25') echo 'selected'; ?>>25</option>
					   <option value="26" <?php if ($day == '26') echo 'selected'; ?>>26</option>
					   <option value="27" <?php if ($day == '27') echo 'selected'; ?>>27</option>
					   <option value="28" <?php if ($day == '28') echo 'selected'; ?>>28</option>
					   <option value="29" <?php if ($day == '29') echo 'selected'; ?>>29</option>
					   <option value="30" <?php if ($day == '30') echo 'selected'; ?>>30</option>
					   <option value="31" <?php if ($day == '31') echo 'selected'; ?>>31</option>
					  </select>
					  <select name="yearn">
				<?php
				$foo = date('Y');
				for ($y = $foo; $y <= $foo + 1; $y++) {
				?>
					   <option value="<?php echo $y; ?>" <?php if ($year == $y) echo 'selected'; ?>><?php echo $y; ?></option>
				<?php
				}
				?>
					  </select>
					  <select name="hourn">
					   <option value="7" <?php if ($hour == '07') echo 'selected'; ?>>7:00 AM</option>
					   <option value="8" <?php if ($hour == '08') echo 'selected'; ?>>8:00 AM</option>
					   <option value="9" <?php if ($hour == '09') echo 'selected'; ?>>9:00 AM</option>
					   <option value="10" <?php if ($hour == '10') echo 'selected'; ?>>10:00 AM</option>
					   <option value="11" <?php if ($hour == '11') echo 'selected'; ?>>11:00 AM</option>
					   <option value="12" <?php if ($hour == '12') echo 'selected'; ?>>12:00 PM</option>
					   <option value="13" <?php if ($hour == '13') echo 'selected'; ?>>1:00 PM</option>
					   <option value="14" <?php if ($hour == '14') echo 'selected'; ?>>2:00 PM</option>
					   <option value="15" <?php if ($hour == '15') echo 'selected'; ?>>3:00 PM</option>
					   <option value="16" <?php if ($hour == '16') echo 'selected'; ?>>4:00 PM</option>
					   <option value="17" <?php if ($hour == '17') echo 'selected'; ?>>5:00 PM</option>
					   <option value="18" <?php if ($hour == '18') echo 'selected'; ?>>6:00 PM</option>
					   <option value="19" <?php if ($hour == '19') echo 'selected'; ?>>7:00 PM</option>
					  </select>
					 </td>
				  </tr>
					<tr>
						<td valign="top" align="right" class="header">Comments:&nbsp;</td>
						<td class="small"><textarea name="comments" cols="38" rows="10" wrap="VIRTUAL"><?=$comments?></textarea></td>
					</tr><tr><td colspan="2">&nbsp;</td></tr>

<!-- POC #1 Information -->
					<tr>
						<td valign="top" align="right" class="small"><font color="FF0000"><b>*&nbsp;</b></font><b>POC #1 Name:&nbsp;</b></td>
						<td class="small"><input class="small" name="poc_1_name" size="50" value="<?=$poc_1_name?>"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><b>POC #1 Title:&nbsp;</b></td>
						<td class="small"><input class="small" name="poc_1_title" size="50" value="<?=$poc_1_title?>"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><font color="FF0000"><b>*&nbsp;</b></font><b>POC #1 Direct Phone:&nbsp;</b></td>
						<td class="small">( <input class="small" name="poc_1_direct_1" size="1" value="<?=$poc_1_direct_1?>" maxlength="3"> )
						 <input class="small" name="poc_1_direct_2" size="1" value="<?=$poc_1_direct_2?>" maxlength="3"> -
						 <input class="small" name="poc_1_direct_3" size="1" value="<?=$poc_1_direct_3?>" maxlength="4"> ext
						 <input class="small" name="poc_1_direct_e" size="1" value="<?=$poc_1_direct_e?>"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><b>POC #1 Cell Phone:&nbsp;</b></td>
						<td class="small">( <input class="small" name="poc_1_cell_1" size="1" value="<?=$poc_1_cell_1?>" maxlength="3"> )
						 <input class="small" name="poc_1_cell_2" size="1" value="<?=$poc_1_cell_2?>" maxlength="3"> -
						 <input class="small" name="poc_1_cell_3" size="1" value="<?=$poc_1_cell_3?>" maxlength="4"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><b>POC #1 Email:&nbsp;</b></td>
						<td class="small"><input class="small" name="poc_1_email" size="50" value="<?=$poc_1_email?>"></td>
					</tr><tr><td colspan="2">&nbsp;</td></tr>
					
<!-- POC #2 Information -->
					<tr>
						<td valign="top" align="right" class="small"><b>POC #2 Name:&nbsp;</b></td>
						<td class="small"><input class="small" name="poc_2_name" size="50" value="<?=$poc_2_name?>"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><b>POC #2 Title:&nbsp;</b></td>
						<td class="small"><input class="small" name="poc_2_title" size="50" value="<?=$poc_2_title?>"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><b>POC #2 Direct Phone:&nbsp;</b></td>
						<td class="small">( <input class="small" name="poc_2_direct_1" size="1" value="<?=$poc_2_direct_1?>" maxlength="3"> )
						 <input class="small" name="poc_2_direct_2" size="1" value="<?=$poc_2_direct_2?>" maxlength="3"> -
						 <input class="small" name="poc_2_direct_3" size="1" value="<?=$poc_2_direct_3?>" maxlength="4"> ext
						 <input class="small" name="poc_2_direct_e" size="1" value="<?=$poc_2_direct_e?>"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><b>POC #2 Cell Phone:&nbsp;</b></td>
						<td class="small">( <input class="small" name="poc_2_cell_1" size="1" value="<?=$poc_2_cell_1?>" maxlength="3"> )
						 <input class="small" name="poc_2_cell_2" size="1" value="<?=$poc_2_cell_2?>" maxlength="3"> -
						 <input class="small" name="poc_2_cell_3" size="1" value="<?=$poc_2_cell_3?>" maxlength="4"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><b>POC #2 Email:&nbsp;</b></td>
						<td class="small"><input class="small" name="poc_2_email" size="50" value="<?=$poc_2_email?>"></td>
					</tr><tr><td colspan="2">&nbsp;</td></tr>
						
<!-- POC #3 Information -->
					<tr>
						<td valign="top" align="right" class="small"><b>POC #3 Name:&nbsp;</b></td>
						<td class="small"><input class="small" name="poc_3_name" size="50" value="<?=$poc_3_name?>"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><b>POC #2 Title:&nbsp;</b></td>
						<td class="small"><input class="small" name="poc_3_title" size="50" value="<?=$poc_3_title?>"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><b>POC #3 Direct Phone:&nbsp;</b></td>
						<td class="small">( <input class="small" name="poc_3_direct_1" size="1" value="<?=$poc_3_direct_1?>" maxlength="3"> )
						 <input class="small" name="poc_3_direct_2" size="1" value="<?=$poc_3_direct_2?>" maxlength="3"> -
						 <input class="small" name="poc_3_direct_3" size="1" value="<?=$poc_3_direct_3?>" maxlength="4"> ext
						 <input class="small" name="poc_3_direct_e" size="1" value="<?=$poc_3_direct_e?>"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><b>POC #3 Cell Phone:&nbsp;</b></td>
						<td class="small">( <input class="small" name="poc_3_cell_1" size="1" value="<?=$poc_3_cell_1?>" maxlength="3"> )
						 <input class="small" name="poc_3_cell_2" size="1" value="<?=$poc_3_cell_2?>" maxlength="3"> -
						 <input class="small" name="poc_3_cell_3" size="1" value="<?=$poc_3_cell_3?>" maxlength="4"></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="small"><b>POC #3 Email:&nbsp;</b></td>
						<td class="small"><input class="small" name="poc_3_email" size="50" value="<?=$poc_3_email?>"></td>
					</tr>				
					<tr>
						<td></td>
						<td align="center" valign="top" class="normal"><input type="submit" name="sendreport" value="Send Report" /></td>
					</tr>
				</table>
			</form>
		</td>
		<td width="20%"></td>
	</tr>		
</table>

<?php
db_disconnect();
include('footer.php');
?>