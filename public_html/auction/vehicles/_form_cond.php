<?php

/*
include_once("$DOCUMENT_ROOT/../../include/defineVars.php");    // RJM added for checking the variables.  12.29.09
extract(defineVars("cid", "subcid1"));
*/


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

if (isset($e))
	$errors = "You must enter the condition of the item before creating an auction!!!";

?>
  </p>
<!-- JJM 1/22/2010  This section is being commented out, because it is duplicate HTML
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <input type="hidden" name="vid" value="<?php echo $vid; ?>" />
   <input type="hidden" name="did" value="<?php echo $did; ?>" />
   <input type="hidden" name="dealer_id" value="<?php echo $dealer_id; ?>" />
-->

<?php	if (!empty($errors)) { ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
		<td class="error">The following errors occurred:<br /><ul><?php echo $errors; ?></ul></td>
   </tr>
  </table>
<?php } ?>
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <input type="hidden" name="vid" value="<?php echo $vid; ?>" />
   <input type="hidden" name="did" value="<?php echo $did; ?>" />
   <input type="hidden" name="dealer_id" value="<?php echo $dealer_id; ?>" />
   <table align="center" border="0" cellspacing="0" cellpadding="2">
      	<tr>
			<td align="center" class="error" valign="top">NOTE: The items marked with an asterisk ( * ) are REQUIRED!</td>
		</tr>
       <tr>
		<td align="center" class="normal"><br><b>Category: </b>
     	<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
     	<input type="hidden" name="subcid1" value="<?php echo $subcid1; ?>" />
     	<input type="hidden" name="subcid2" value="<?php echo $subcid2; ?>" />
        <?php
				echo "$z";
			if (isset($y) AND $subcid1 > 1)
			{
				echo " : $y ";
				if (isset ($x) AND $subcid2 > 1)
				echo " : $x";
			}?><br><br>
	</td>
    </tr>
	<tr>
		<td align="center" class="normal"><b>Auction Title: </b><?php echo $short_desc; ?></td>
    </tr>
  </table><br>
   <table align="center" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td align="center" bgcolor="#00cc00"><font color="#FFFFFF"><b>&nbsp;Excellent&nbsp;</b></font></td>
			<td align="center" bgcolor="#0000cc"><font color="#FFFFFF"><b>&nbsp;Good&nbsp;</b></font></td>
			<td align="center" bgcolor="#ffff00"><b>&nbsp;Average&nbsp;</b></font></td>
			<td align="center" bgcolor="#cc0000"><font color="#FFFFFF"><b>&nbsp;Poor&nbsp;</b></font></td>
			<td align="center" bgcolor="#cccccc"><b>&nbsp;Not Applicable&nbsp;</b></font></td>
		</tr>
  </table><p><p>
	<table align="center" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td width="100"><b>Mechanics</b></font></td>
			<td align="center" bgcolor="#00cc00"><font color="#FFFFFF"><b>E</b></font></td>
			<td align="center" bgcolor="#0000cc"><font color="#FFFFFF"><b>G</b></font></td>
			<td align="center" bgcolor="#ffff00"><b>A</b></font></td>
			<td align="center" bgcolor="#cc0000"><font color="#FFFFFF"><b>P</b></font></td>
			<td align="center" bgcolor="#cccccc"><b>X</b></font></td>
			<td align="center">&nbsp;Comments (225 max)</td>
		</tr>


<?php if ($cid != 19 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Engine</td>
			<td><input type="radio" name="engine_m" value="Excellent" <?php if ($engine_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="engine_m" value="Good" <?php if ($engine_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="engine_m" value="Average" <?php if ($engine_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="engine_m" value="Poor" <?php if ($engine_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="engine_m" value="Not Rated" <?php if ($engine_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="engine_t" size="20" value="<?php echo $engine_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 14 && $cid != 11 && $cid != 19 && $cid != 2567 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Transmission</td>
			<td><input type="radio" name="transmission_m" value="Excellent" <?php if ($transmission_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="transmission_m" value="Good" <?php if ($transmission_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="transmission_m" value="Average" <?php if ($transmission_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="transmission_m" value="Poor" <?php if ($transmission_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="transmission_m" value="Not Rated" <?php if ($transmission_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="transmission_t" size="20" value="<?php echo $transmission_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Exhaust System</td>
			<td><input type="radio" name="exhaust_m" value="Excellent" <?php if ($exhaust_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="exhaust_m" value="Good" <?php if ($exhaust_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="exhaust_m" value="Average" <?php if ($exhaust_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="exhaust_m" value="Poor" <?php if ($exhaust_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="exhaust_m" value="Not Rated" <?php if ($exhaust_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="exhaust_t" size="20" value="<?php echo $exhaust_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 14 && $cid != 2075 && $cid != 2567 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Tires</td>
			<td><input type="radio" name="tires_m" value="Excellent" <?php if ($tires_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="tires_m" value="Good" <?php if ($tires_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="tires_m" value="Average" <?php if ($tires_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="tires_m" value="Poor" <?php if ($tires_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="tires_m" value="Not Rated" <?php if ($tires_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="tires_t" size="20" value="<?php echo $tires_t; ?>"></td>
		</tr>
<?php } ?>

<?php if($cid == 2075) { ?>
      <tr>
         <td width="100">Warebars / Carbides</td>
         <td><input type="radio" name="warebars_e" value="Excellent" <?php if ($warebars_e == 'Excellent') echo 'checked'; ?>></td>
         <td><input type="radio" name="warebars_e" value="Good" <?php if ($warebars_e == 'Good') echo 'checked'; ?>></td>
         <td><input type="radio" name="warebars_e" value="Average" <?php if ($warebars_e == 'Average') echo 'checked'; ?>></td>
         <td><input type="radio" name="warebars_e" value="Poor" <?php if ($warebars_e == 'Poor') echo 'checked'; ?>></td>
         <td><input type="radio" name="warebars_e" value="Not Rated" <?php if ($warebars_e == 'Not Rated') echo 'checked'; ?>></td>
         <td width="150"><input type="text" name="warebars_t" size="20" value="<?php echo $warebars_t; ?>"></td>
      </tr>
<?php } ?>

<?php if ($cid != 14 && $cid != 2567 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Brakes</td>
			<td><input type="radio" name="brakes_m" value="Excellent" <?php if ($brakes_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="brakes_m" value="Good" <?php if ($brakes_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="brakes_m" value="Average" <?php if ($brakes_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="brakes_m" value="Poor" <?php if ($brakes_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="brakes_m" value="Not Rated" <?php if ($brakes_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="brakes_t" size="20" value="<?php echo $brakes_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 15 && $cid != 2481 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Steering</td>
			<td><input type="radio" name="steering_m" value="Excellent" <?php if ($steering_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="steering_m" value="Good" <?php if ($steering_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="steering_m" value="Average" <?php if ($steering_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="steering_m" value="Poor" <?php if ($steering_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="steering_m" value="Not Rated" <?php if ($steering_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="steering_t" size="20" value="<?php echo $steering_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567) { ?>
		<tr>
			<td width="100">Prop</td>
			<td><input type="radio" name="prop_m" value="Excellent" <?php if ($prop_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="prop_m" value="Good" <?php if ($prop_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="prop_m" value="Average" <?php if ($prop_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="prop_m" value="Poor" <?php if ($prop_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="prop_m" value="Not Rated" <?php if ($prop_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="prop_t" size="20" value="<?php echo $prop_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 14  || $cid == 18 || $cid == 2567 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Gauges</td>
			<td><input type="radio" name="gauges_m" value="Excellent" <?php if ($gauges_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="gauges_m" value="Good" <?php if ($gauges_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="gauges_m" value="Average" <?php if ($gauges_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="gauges_m" value="Poor" <?php if ($gauges_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="gauges_m" value="Not Rated" <?php if ($gauges_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="gauges_t" size="20" value="<?php echo $gauges_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Plumbing</td>
			<td><input type="radio" name="plumbing_m" value="Excellent" <?php if ($plumbing_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="plumbing_m" value="Good" <?php if ($plumbing_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="plumbing_m" value="Average" <?php if ($plumbing_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="plumbing_m" value="Poor" <?php if ($plumbing_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="plumbing_m" value="Not Rated" <?php if ($plumbing_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="plumbing_t" size="20" value="<?php echo $plumbing_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Generator</td>
			<td><input type="radio" name="generator_m" value="Excellent" <?php if ($generator_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="generator_m" value="Good" <?php if ($generator_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="generator_m" value="Average" <?php if ($generator_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="generator_m" value="Poor" <?php if ($generator_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="generator_m" value="Not Rated" <?php if ($generator_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="generator_t" size="20" value="<?php echo $generator_t; ?>"></td>
		</tr>
<?php } ?>
<?php if (($cid != 12 && $cid != 19 && $cid != 15 && $cid != 2075 && $cid != 2481 && $cid != 2567) || ($subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820)  ) { ?>
		<tr>
			<td width="100">A / C</td>
			<td><input type="radio" name="ac_m" value="Excellent" <?php if ($ac_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="ac_m" value="Good" <?php if ($ac_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="ac_m" value="Average" <?php if ($ac_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="ac_m" value="Poor" <?php if ($ac_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="ac_m" value="Not Rated" <?php if ($ac_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="ac_t" size="20" value="<?php echo $ac_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 15 && $cid == 2481) { ?>
		<tr>
			<td width="100">Primary Drive</td>
			<td><input type="radio" name="primary_drive_m" value="Excellent" <?php if ($primary_drive_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="primary_drive_m" value="Good" <?php if ($primary_drive_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="primary_drive_m" value="Average" <?php if ($primary_drive_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="primary_drive_m" value="Poor" <?php if ($primary_drive_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="primary_drive_m" value="Not Rated" <?php if ($primary_drive_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="primary_drive_t" size="20" value="<?php echo $primary_drive_t; ?>"></td>
		</tr>

		<tr>
			<td width="100">Wheels</td>
			<td><input type="radio" name="wheels_m" value="Excellent" <?php if ($wheels_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="wheels_m" value="Good" <?php if ($wheels_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="wheels_m" value="Average" <?php if ($wheels_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="wheels_m" value="Poor" <?php if ($wheels_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="wheels_m" value="Not Rated" <?php if ($wheels_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="wheels_t" size="20" value="<?php echo $wheels_t; ?>"></td>
		</tr>
		<tr>
			<td width="100">Stereo &amp; Speakers</td>
			<td><input type="radio" name="stereo_speakers_m" value="Excellent" <?php if ($stereo_speakers_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="stereo_speakers_m" value="Good" <?php if ($stereo_speakers_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="stereo_speakers_m" value="Average" <?php if ($stereo_speakers_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="stereo_speakers_m" value="Poor" <?php if ($stereo_speakers_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="stereo_speakers_m" value="Not Rated" <?php if ($stereo_speakers_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="stereo_speakers_t" size="20" value="<?php echo $stereo_speakers_t; ?>"></td>
		</tr>
		<tr>
			<td width="100">Suspension</td>
			<td><input type="radio" name="suspension_m" value="Excellent" <?php if ($suspension_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="suspension_m" value="Good" <?php if ($suspension_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="suspension_m" value="Average" <?php if ($suspension_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="suspension_m" value="Poor" <?php if ($suspension_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="suspension_m" value="Not Rated" <?php if ($suspension_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="suspension_t" size="20" value="<?php echo $suspension_t; ?>"></td>
		</tr>
		<tr>
			<td width="100">Instrument Panel</td>
			<td><input type="radio" name="instrument_panel_m" value="Excellent" <?php if ($instrument_panel_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="instrument_panel_m" value="Good" <?php if ($instrument_panel_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="instrument_panel_m" value="Average" <?php if ($instrument_panel_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="instrument_panel_m" value="Poor" <?php if ($instrument_panel_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="instrument_panel_m" value="Not Rated" <?php if ($instrument_panel_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="instrument_panel_t" size="20" value="<?php echo $instrument_panel_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">HVAC</td>
			<td><input type="radio" name="hvac_m" value="Excellent" <?php if ($hvac_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="hvac_m" value="Good" <?php if ($hvac_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="hvac_m" value="Average" <?php if ($hvac_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="hvac_m" value="Poor" <?php if ($hvac_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="hvac_m" value="Not Rated" <?php if ($hvac_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="hvac_t" size="20" value="<?php echo $hvac_t; ?>"></td>
		</tr>
<?php } ?>
	</table>
	<hr>
	<table align="center" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td width="100"><b>Interior</b></font></td>
			<td align="center" bgcolor="#00cc00"><font color="#FFFFFF"><b>E</b></font></td>
			<td align="center" bgcolor="#0000cc"><font color="#FFFFFF"><b>G</b></font></td>
			<td align="center" bgcolor="#ffff00"><b>A</b></font></td>
			<td align="center" bgcolor="#cc0000"><font color="#FFFFFF"><b>P</b></font></td>
			<td align="center" bgcolor="#cccccc"><b>X</b></font></td>
			<td align="center">&nbsp;Comments (225 max)</td>
		</tr>
<?php if ($cid != 19 && $cid != 14 && $cid != 15 && $cid != 2481 && $cid != 2567 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100"><?php if($cid != 2075) { ?>Front<?php } ?> Seats</td>
			<td><input type="radio" name="front_seats_i" value="Excellent" <?php if ($front_seats_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_seats_i" value="Good" <?php if ($front_seats_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_seats_i" value="Average" <?php if ($front_seats_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_seats_i" value="Poor" <?php if ($front_seats_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_seats_i" value="Not Rated" <?php if ($front_seats_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="front_seats_t" size="20" value="<?php echo $front_seats_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 14 && $cid != 15 && $cid != 12 && $cid != 2075 && $cid != 2481 && $cid != 2567) { ?>
		<tr>
			<td width="100">Rear Seats</td>
			<td><input type="radio" name="rear_seats_i" value="Excellent" <?php if ($rear_seats_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="rear_seats_i" value="Good" <?php if ($rear_seats_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="rear_seats_i" value="Average" <?php if ($rear_seats_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="rear_seats_i" value="Poor" <?php if ($rear_seats_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="rear_seats_i" value="Not Rated" <?php if ($rear_seats_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="rear_seats_t" size="20" value="<?php echo $rear_seats_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 15 || $cid == 2481 || $cid == 2567) { ?>
		<tr>
			<td width="100">Seats</td>
			<td><input type="radio" name="a_seats_i" value="Excellent" <?php if ($a_seats_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="a_seats_i" value="Good" <?php if ($a_seats_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="a_seats_i" value="Average" <?php if ($a_seats_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="a_seats_i" value="Poor" <?php if ($a_seats_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="a_seats_i" value="Not Rated" <?php if ($a_seats_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="a_seats_t" size="20" value="<?php echo $a_seats_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Floor</td>
			<td><input type="radio" name="a_floor_i" value="Excellent" <?php if ($a_floor_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="a_floor_i" value="Good" <?php if ($a_floor_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="a_floor_i" value="Average" <?php if ($a_floor_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="a_floor_i" value="Poor" <?php if ($a_floor_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="a_floor_i" value="Not Rated" <?php if ($a_floor_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="a_floor_t" size="20" value="<?php echo $a_floor_t; ?>"></td>
		</tr>
<?php } ?>
<?php if (($cid != 19 && $cid != 15 && $cid != 12 && $cid != 2075 && $cid != 2481 && $cid != 2567) || ($subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820)) { ?>
		<tr>
			<td width="100">Carpet</td>
			<td><input type="radio" name="carpet_i" value="Excellent" <?php if ($carpet_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="carpet_i" value="Good" <?php if ($carpet_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="carpet_i" value="Average" <?php if ($carpet_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="carpet_i" value="Poor" <?php if ($carpet_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="carpet_i" value="Not Rated" <?php if ($carpet_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="carpet_t" size="20" value="<?php echo $carpet_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 15 && $cid != 14 && $cid != 12 && $cid != 2075 && $cid != 2481 && $cid != 2567 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Headliner</td>
			<td><input type="radio" name="headliner_i" value="Excellent" <?php if ($headliner_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="headliner_i" value="Good" <?php if ($headliner_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="headliner_i" value="Average" <?php if ($headliner_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="headliner_i" value="Poor" <?php if ($headliner_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="headliner_i" value="Not Rated" <?php if ($headliner_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="headliner_t" size="20" value="<?php echo $headliner_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Dash</td>
			<td><input type="radio" name="dash_i" value="Excellent" <?php if ($dash_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="dash_i" value="Good" <?php if ($dash_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="dash_i" value="Average" <?php if ($dash_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="dash_i" value="Poor" <?php if ($dash_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="dash_i" value="Not Rated" <?php if ($dash_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="dash_t" size="20" value="<?php echo $dash_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Electronics</td>
			<td><input type="radio" name="electronics_i" value="Excellent" <?php if ($electronics_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="electronics_i" value="Good" <?php if ($electronics_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="electronics_i" value="Average" <?php if ($electronics_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="electronics_i" value="Poor" <?php if ($electronics_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="electronics_i" value="Not Rated" <?php if ($electronics_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="electronics_t" size="20" value="<?php echo $electronics_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Kitchen</td>
			<td><input type="radio" name="kitchen_i" value="Excellent" <?php if ($kitchen_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="kitchen_i" value="Good" <?php if ($kitchen_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="kitchen_i" value="Average" <?php if ($kitchen_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="kitchen_i" value="Poor" <?php if ($kitchen_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="kitchen_i" value="Not Rated" <?php if ($kitchen_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="kitchen_t" size="20" value="<?php echo $kitchen_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Bathroom</td>
			<td><input type="radio" name="bathroom_i" value="Excellent" <?php if ($bathroom_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="bathroom_i" value="Good" <?php if ($bathroom_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="bathroom_i" value="Average" <?php if ($bathroom_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="bathroom_i" value="Poor" <?php if ($bathroom_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="bathroom_i" value="Not Rated" <?php if ($bathroom_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="bathroom_t" size="20" value="<?php echo $bathroom_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Furniture</td>
			<td><input type="radio" name="furniture_i" value="Excellent" <?php if ($furniture_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="furniture_i" value="Good" <?php if ($furniture_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="furniture_i" value="Average" <?php if ($furniture_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="furniture_i" value="Poor" <?php if ($furniture_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="furniture_i" value="Not Rated" <?php if ($furniture_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="furniture_t" size="20" value="<?php echo $furniture_t; ?>"></td>
		</tr>
<?php } ?>

	</table>
	<hr>
	<table align="center" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td width="100"><b>Exterior</b></font></td>
			<td align="center" bgcolor="#00cc00"><font color="#FFFFFF"><b>E</b></font></td>
			<td align="center" bgcolor="#0000cc"><font color="#FFFFFF"><b>G</b></font></td>
			<td align="center" bgcolor="#ffff00"><b>A</b></font></td>
			<td align="center" bgcolor="#cc0000"><font color="#FFFFFF"><b>P</b></font></td>
			<td align="center" bgcolor="#cccccc"><b>X</b></font></td>
			<td align="center">&nbsp;Comments (225 max)</td>
		</tr>
		<tr>
			<td width="100">Paint</td>
			<td><input type="radio" name="paint_e" value="Excellent" <?php if ($paint_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="paint_e" value="Good" <?php if ($paint_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="paint_e" value="Average" <?php if ($paint_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="paint_e" value="Poor" <?php if ($paint_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="paint_e" value="Not Rated" <?php if ($paint_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="paint_t" size="20" value="<?php echo $paint_t; ?>"></td>
		</tr>
<?php if ($cid != 19 && $cid != 14 && $cid != 15 && $cid != 12 && $cid != 2075 && $cid != 2481 && $cid != 2567) { ?>
		<tr>
			<td width="100">Hood</td>
			<td><input type="radio" name="hood_e" value="Excellent" <?php if ($hood_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="hood_e" value="Good" <?php if ($hood_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="hood_e" value="Average" <?php if ($hood_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="hood_e" value="Poor" <?php if ($hood_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="hood_e" value="Not Rated" <?php if ($hood_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="hood_t" size="20" value="<?php echo $hood_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Roof</td>
			<td><input type="radio" name="roof_e" value="Excellent" <?php if ($roof_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="roof_e" value="Good" <?php if ($roof_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="roof_e" value="Average" <?php if ($roof_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="roof_e" value="Poor" <?php if ($roof_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="roof_e" value="Not Rated" <?php if ($roof_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="roof_t" size="20" value="<?php echo $roof_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18 || ($cid == 19 && ($subcid1 == 235 || $subcid1 == 236 || $subcid1 == 237 || $subcid1 == 238 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820))) { ?>
		<tr>
			<td width="100">Front</td>
			<td><input type="radio" name="front_e" value="Excellent" <?php if ($front_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_e" value="Good" <?php if ($front_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_e" value="Average" <?php if ($front_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_e" value="Poor" <?php if ($front_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_e" value="Not Rated" <?php if ($front_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="front_t" size="20" value="<?php echo $front_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18 || ($cid == 19 && ($subcid1 == 235 || $subcid1 == 236 || $subcid1 == 237 || $subcid1 == 238 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820))) { ?>
		<tr>
			<td width="100">Right</td>
			<td><input type="radio" name="right_e" value="Excellent" <?php if ($right_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="right_e" value="Good" <?php if ($right_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="right_e" value="Average" <?php if ($right_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="right_e" value="Poor" <?php if ($right_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="right_e" value="Not Rated" <?php if ($right_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="right_t" size="20" value="<?php echo $right_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18 || ($cid == 19 && ($subcid1 == 235 || $subcid1 == 236 || $subcid1 == 237 || $subcid1 == 238 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820))) { ?>
		<tr>
			<td width="100">Left</td>
			<td><input type="radio" name="left_e" value="Excellent" <?php if ($left_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="left_e" value="Good" <?php if ($left_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="left_e" value="Average" <?php if ($left_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="left_e" value="Poor" <?php if ($left_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="left_e" value="Not Rated" <?php if ($left_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="left_t" size="20" value="<?php echo $left_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18 || ($cid == 19 && ($subcid1 == 235 || $subcid1 == 236 || $subcid1 == 237 || $subcid1 == 238 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820))) { ?>
		<tr>
			<td width="100">Rear</td>
			<td><input type="radio" name="rear_e" value="Excellent" <?php if ($rear_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="rear_e" value="Good" <?php if ($rear_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="rear_e" value="Average" <?php if ($rear_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="rear_e" value="Poor" <?php if ($rear_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="rear_e" value="Not Rated" <?php if ($rear_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="rear_t" size="20" value="<?php echo $rear_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 14 && $cid != 15 && $cid != 11 && $cid != 2075 && $cid != 2481 && $cid != 2567) { ?>
		<tr>
			<td width="100">R Front Fender</td>
			<td><input type="radio" name="r_f_fender_e" value="Excellent" <?php if ($r_f_fender_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_f_fender_e" value="Good" <?php if ($r_f_fender_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_f_fender_e" value="Average" <?php if ($r_f_fender_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_f_fender_e" value="Poor" <?php if ($r_f_fender_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_f_fender_e" value="Not Rated" <?php if ($r_f_fender_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="r_f_fender_t" size="20" value="<?php echo $r_f_fender_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 14 && $cid != 15 && $cid != 11 && $cid != 2075 && $cid != 2481 && $cid != 2567) { ?>
		<tr>
			<td width="100">L Front Fender</td>
			<td><input type="radio" name="l_f_fender_e" value="Excellent" <?php if ($l_f_fender_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_f_fender_e" value="Good" <?php if ($l_f_fender_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_f_fender_e" value="Average" <?php if ($l_f_fender_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_f_fender_e" value="Poor" <?php if ($l_f_fender_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_f_fender_e" value="Not Rated" <?php if ($l_f_fender_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="l_f_fender_t" size="20" value="<?php echo $l_f_fender_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567) { ?>
		<tr>
			<td width="100">Starboard</td>
			<td><input type="radio" name="starboard_e" value="Excellent" <?php if ($starboard_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="starboard_e" value="Good" <?php if ($starboard_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="starboard_e" value="Average" <?php if ($starboard_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="starboard_e" value="Poor" <?php if ($starboard_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="starboard_e" value="Not Rated" <?php if ($starboard_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="starboard_t" size="20" value="<?php echo $starboard_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567) { ?>
		<tr>
			<td width="100">Port</td>
			<td><input type="radio" name="port_e" value="Excellent" <?php if ($port_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="port_e" value="Good" <?php if ($port_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="port_e" value="Average" <?php if ($port_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="port_e" value="Poor" <?php if ($port_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="port_e" value="Not Rated" <?php if ($port_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="port_t" size="20" value="<?php echo $port_t; ?>"></td>
		</tr>
<?php } ?>
<?php if (($cid == 19 && $subcid1 != 235 && $subcid1 != 236 && $subcid1 != 237 && $subcid1 != 238 && $subcid1 != 234 && $subcid1 != 239 && $subcid1 != 2820) || $cid == 15 || $cid == 2481) { ?>
		<tr>
			<td width="100">F Fender</td>
			<td><input type="radio" name="f_fender_e" value="Excellent" <?php if ($f_fender_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="f_fender_e" value="Good" <?php if ($f_fender_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="f_fender_e" value="Average" <?php if ($f_fender_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="f_fender_e" value="Poor" <?php if ($f_fender_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="f_fender_e" value="Not Rated" <?php if ($f_fender_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="f_fender_t" size="20" value="<?php echo $f_fender_t; ?>"></td>
		</tr>
<?php } ?>
<?php if (($cid == 19 && $subcid1 != 235 && $subcid1 != 236 && $subcid1 != 237 && $subcid1 != 238 && $subcid1 != 234 && $subcid1 != 239 && $subcid1 != 2820) || $cid == 15 || $cid == 2481) { ?>
		<tr>
			<td width="100">R Fender</td>
			<td><input type="radio" name="r_fender_e" value="Excellent" <?php if ($r_fender_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_fender_e" value="Good" <?php if ($r_fender_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_fender_e" value="Average" <?php if ($r_fender_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_fender_e" value="Poor" <?php if ($r_fender_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_fender_e" value="Not Rated" <?php if ($r_fender_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="r_fender_t" size="20" value="<?php echo $r_fender_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 15 && $cid != 14 && $cid != 12 && $cid != 2075 && $cid != 2481 && $cid != 2567 || $subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">R Doors</td>
			<td><input type="radio" name="r_door_e" value="Excellent" <?php if ($r_door_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_door_e" value="Good" <?php if ($r_door_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_door_e" value="Average" <?php if ($r_door_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_door_e" value="Poor" <?php if ($r_door_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_door_e" value="Not Rated" <?php if ($r_door_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="r_door_t" size="20" value="<?php echo $r_door_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 15 && $cid != 14 && $cid != 12 && $cid != 2075 && $cid != 2481 && $cid != 2567) { ?>
		<tr>
			<td width="100">L Doors</td>
			<td><input type="radio" name="l_door_e" value="Excellent" <?php if ($l_door_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_door_e" value="Good" <?php if ($l_door_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_door_e" value="Average" <?php if ($l_door_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_door_e" value="Poor" <?php if ($l_door_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_door_e" value="Not Rated" <?php if ($l_door_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="100"><input type="text" name="l_door_t" size="20" value="<?php echo $l_door_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 15 && $cid != 14 && $cid != 12 && $cid != 11 && $cid != 2075 && $cid != 2567) { ?>
		<tr>
			<td width="100">R Rear 1/4</td>
			<td><input type="radio" name="r_rear_e" value="Excellent" <?php if ($r_rear_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_rear_e" value="Good" <?php if ($r_rear_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_rear_e" value="Average" <?php if ($r_rear_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_rear_e" value="Poor" <?php if ($r_rear_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_rear_e" value="Not Rated" <?php if ($r_rear_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="r_rear_t" size="20" value="<?php echo $r_rear_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 15 && $cid != 14 && $cid != 12 && $cid != 11 && $cid != 2075 && $cid != 2481 && $cid != 2567) { ?>
		<tr>
			<td width="100">L Rear 1/4</td>
			<td><input type="radio" name="l_rear_e" value="Excellent" <?php if ($l_rear_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_rear_e" value="Good" <?php if ($l_rear_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_rear_e" value="Average" <?php if ($l_rear_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_rear_e" value="Poor" <?php if ($l_rear_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="l_rear_e" value="Not Rated" <?php if ($l_rear_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="l_rear_t" size="20" value="<?php echo $l_rear_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567) { ?>
		<tr>
			<td width="100">Stern</td>
			<td><input type="radio" name="stern_e" value="Excellent" <?php if ($stern_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="stern_e" value="Good" <?php if ($stern_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="stern_e" value="Average" <?php if ($stern_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="stern_e" value="Poor" <?php if ($stern_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="stern_e" value="Not Rated" <?php if ($stern_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="100"><input type="text" name="stern_t" size="20" value="<?php echo $stern_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 14 || $cid == 2567) { ?>
		<tr>
			<td width="100">Bow</td>
			<td><input type="radio" name="bow_e" value="Excellent" <?php if ($bow_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="bow_e" value="Good" <?php if ($bow_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="bow_e" value="Average" <?php if ($bow_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="bow_e" value="Poor" <?php if ($bow_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="bow_e" value="Not Rated" <?php if ($bow_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="bow_t" size="20" value="<?php echo $bow_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 18 && $cid != 14 && $cid != 15 && $cid != 12 && $cid != 2075 && $cid != 2481 && $cid != 2567) { ?>
		<tr>
			<td width="100">Trunk Lid</td>
			<td><input type="radio" name="trunk_e" value="Excellent" <?php if ($trunk_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="trunk_e" value="Good" <?php if ($trunk_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="trunk_e" value="Average" <?php if ($trunk_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="trunk_e" value="Poor" <?php if ($trunk_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="trunk_e" value="Not Rated" <?php if ($trunk_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="100"><input type="text" name="trunk_t" size="20" value="<?php echo $trunk_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19  && $cid != 18 && $cid != 14 && $cid != 15 && $cid != 11 && $cid != 2075 && $cid != 2481 && $cid != 2567) { ?>
		<tr>
			<td width="100">F Bumper</td>
			<td><input type="radio" name="f_bumper_e" value="Excellent" <?php if ($f_bumper_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="f_bumper_e" value="Good" <?php if ($f_bumper_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="f_bumper_e" value="Average" <?php if ($f_bumper_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="f_bumper_e" value="Poor" <?php if ($f_bumper_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="f_bumper_e" value="Not Rated" <?php if ($f_bumper_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="f_bumper_t" size="20" value="<?php echo $f_bumper_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 11 && $cid != 19 && $cid != 14 && $cid != 15 && $cid != 2075 && $cid != 2481 && $cid != 2567) { ?>
		<tr>
			<td width="100">R Bumper</td>
			<td><input type="radio" name="r_bumper_e" value="Excellent" <?php if ($r_bumper_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_bumper_e" value="Good" <?php if ($r_bumper_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_bumper_e" value="Average" <?php if ($r_bumper_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_bumper_e" value="Poor" <?php if ($r_bumper_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="r_bumper_e" value="Not Rated" <?php if ($r_bumper_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="r_bumper_t" size="20" value="<?php echo $r_bumper_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 14 && $cid != 15 && $cid != 2075 && $cid != 2481 && $cid != 2567 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Grille</td>
			<td><input type="radio" name="grille_e" value="Excellent" <?php if ($grille_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="grille_e" value="Good" <?php if ($grille_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="grille_e" value="Average" <?php if ($grille_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="grille_e" value="Poor" <?php if ($grille_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="grille_e" value="Not Rated" <?php if ($grille_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="grille_t" size="20" value="<?php echo $grille_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($subcid1 == 234 || $subcid1 == 239 || $subcid1 == 2820) : ?>
		<tr>
			<td width="100">Glass</td>
			<td><input type="radio" name="glass_e" value="Excellent" <?php if ($glass_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="glass_e" value="Good" <?php if ($glass_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="glass_e" value="Average" <?php if ($glass_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="glass_e" value="Poor" <?php if ($glass_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="glass_e" value="Not Rated" <?php if ($glass_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="100"><input type="text" name="glass_t" size="20" value="<?php echo $glass_t; ?>"></td>
		</tr>
<?php endif; ?>

<?php if($cid != 2075 || $subcid1 == 2820) { ?>
		<tr>
			<td width="100">Frame</td>
			<td><input type="radio" name="frame_e" value="Excellent" <?php if ($frame_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="frame_e" value="Good" <?php if ($frame_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="frame_e" value="Average" <?php if ($frame_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="frame_e" value="Poor" <?php if ($frame_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="frame_e" value="Not Rated" <?php if ($frame_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="frame_t" size="20" value="<?php echo $frame_t; ?>"></td>
		</tr>
<?php } ?>

<?php if($cid == 2075) { ?>
      <tr>
         <td width="100">Hood</td>
         <td><input type="radio" name="hood_e" value="Excellent" <?php if ($glass_e == 'Excellent') echo 'checked'; ?>></td>
         <td><input type="radio" name="hood_e" value="Good" <?php if ($glass_e == 'Good') echo 'checked'; ?>></td>
         <td><input type="radio" name="hood_e" value="Average" <?php if ($glass_e == 'Average') echo 'checked'; ?>></td>
         <td><input type="radio" name="hood_e" value="Poor" <?php if ($glass_e == 'Poor') echo 'checked'; ?>></td>
         <td><input type="radio" name="hood_e" value="Not Rated" <?php if ($glass_e == 'Not Rated') echo 'checked'; ?>></td>
         <td width="100"><input type="text" name="hood_t" size="20" value="<?php echo $glass_t; ?>"></td>
      </tr>

      <tr>
         <td width="100">Bellypan</td>
         <td><input type="radio" name="bellypan_e" value="Excellent" <?php if ($glass_e == 'Excellent') echo 'checked'; ?>></td>
         <td><input type="radio" name="bellypan_e" value="Good" <?php if ($glass_e == 'Good') echo 'checked'; ?>></td>
         <td><input type="radio" name="bellypan_e" value="Average" <?php if ($glass_e == 'Average') echo 'checked'; ?>></td>
         <td><input type="radio" name="bellypan_e" value="Poor" <?php if ($glass_e == 'Poor') echo 'checked'; ?>></td>
         <td><input type="radio" name="bellypan_e" value="Not Rated" <?php if ($glass_e == 'Not Rated') echo 'checked'; ?>></td>
         <td width="100"><input type="text" name="bellypan_t" size="20" value="<?php echo $glass_t; ?>"></td>
      </tr>

      <tr>
         <td width="100">Tunnell</td>
         <td><input type="radio" name="tunnell_e" value="Excellent" <?php if ($glass_e == 'Excellent') echo 'checked'; ?>></td>
         <td><input type="radio" name="tunnell_e" value="Good" <?php if ($glass_e == 'Good') echo 'checked'; ?>></td>
         <td><input type="radio" name="tunnell_e" value="Average" <?php if ($glass_e == 'Average') echo 'checked'; ?>></td>
         <td><input type="radio" name="tunnell_e" value="Poor" <?php if ($glass_e == 'Poor') echo 'checked'; ?>></td>
         <td><input type="radio" name="tunnell_e" value="Not Rated" <?php if ($glass_e == 'Not Rated') echo 'checked'; ?>></td>
         <td width="100"><input type="text" name="tunnell_t" size="20" value="<?php echo $glass_t; ?>"></td>
      </tr>

      <tr>
         <td width="100">Skis</td>
         <td><input type="radio" name="skis_e" value="Excellent" <?php if ($glass_e == 'Excellent') echo 'checked'; ?>></td>
         <td><input type="radio" name="skis_e" value="Good" <?php if ($glass_e == 'Good') echo 'checked'; ?>></td>
         <td><input type="radio" name="skis_e" value="Average" <?php if ($glass_e == 'Average') echo 'checked'; ?>></td>
         <td><input type="radio" name="skis_e" value="Poor" <?php if ($glass_e == 'Poor') echo 'checked'; ?>></td>
         <td><input type="radio" name="skis_e" value="Not Rated" <?php if ($glass_e == 'Not Rated') echo 'checked'; ?>></td>
         <td width="100"><input type="text" name="skis_t" size="20" value="<?php echo $glass_t; ?>"></td>
      </tr>


      <tr>
         <td width="100">Track</td>
         <td><input type="radio" name="track_e" value="Excellent" <?php if ($glass_e == 'Excellent') echo 'checked'; ?>></td>
         <td><input type="radio" name="track_e" value="Good" <?php if ($glass_e == 'Good') echo 'checked'; ?>></td>
         <td><input type="radio" name="track_e" value="Average" <?php if ($glass_e == 'Average') echo 'checked'; ?>></td>
         <td><input type="radio" name="track_e" value="Poor" <?php if ($glass_e == 'Poor') echo 'checked'; ?>></td>
         <td><input type="radio" name="track_e" value="Not Rated" <?php if ($glass_e == 'Not Rated') echo 'checked'; ?>></td>
         <td width="100"><input type="text" name="track_t" size="20" value="<?php echo $glass_t; ?>"></td>
      </tr>

      <tr>
         <td width="100">Glass</td>
         <td><input type="radio" name="glass_e" value="Excellent" <?php if ($glass_e == 'Excellent') echo 'checked'; ?>></td>
         <td><input type="radio" name="glass_e" value="Good" <?php if ($glass_e == 'Good') echo 'checked'; ?>></td>
         <td><input type="radio" name="glass_e" value="Average" <?php if ($glass_e == 'Average') echo 'checked'; ?>></td>
         <td><input type="radio" name="glass_e" value="Poor" <?php if ($glass_e == 'Poor') echo 'checked'; ?>></td>
         <td><input type="radio" name="glass_e" value="Not Rated" <?php if ($glass_e == 'Not Rated') echo 'checked'; ?>></td>
         <td width="100"><input type="text" name="glass_t" size="20" value="<?php echo $glass_t; ?>"></td>
      </tr>
<?php } ?>

<?php if ($cid == 19 && $subcid1 != 2820) { ?>
		<tr>
			<td width="100">Tongue</td>
			<td><input type="radio" name="tongue_e" value="Excellent" <?php if ($tongue_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="tongue_e" value="Good" <?php if ($tongue_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="tongue_e" value="Average" <?php if ($tongue_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="tongue_e" value="Poor" <?php if ($tongue_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="tongue_e" value="Not Rated" <?php if ($tongue_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="tongue_t" value="<?php echo $tongue_t; ?>" size="20"></td>
		</tr>
<?php } ?>
<?php if (($subcid1 == 235 || $subcid1 == 236 || $subcid1 == 237 || $subcid1 == 238 || $subcid1 == 234 || $subcid1 == 239)) { ?>
		<tr>
			<td width="100">Tongue Jack</td>
			<td><input type="radio" name="tonguejack_e" value="Excellent" <?php if ($tongue_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="tonguejack_e" value="Good" <?php if ($tongue_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="tonguejack_e" value="Average" <?php if ($tongue_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="tonguejack_e" value="Poor" <?php if ($tongue_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="tonguejack_e" value="Not Rated" <?php if ($tongue_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="tonguejack_t" value="<?php echo $tongue_t; ?>" size="20"></td>
		</tr>
<?php } ?>

<?php if ($cid == 14 || $cid == 2567) { ?>
		<tr>
			<td width="100">Hull</td>
			<td><input type="radio" name="hull_e" value="Excellent" <?php if ($hull_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="hull_e" value="Good" <?php if ($hull_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="hull_e" value="Average" <?php if ($hull_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="hull_e" value="Poor" <?php if ($hull_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="hull_e" value="Not Rated" <?php if ($hull_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="hull_t" value="<?php echo $hull_t; ?>" size="20"></td>
		</tr>
		<tr>
			<td width="100">Trailer</td>
			<td><input type="radio" name="b_trailer_e" value="Excellent" <?php if ($b_trailer_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="b_trailer_e" value="Good" <?php if ($b_trailer_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="b_trailer_e" value="Average" <?php if ($b_trailer_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="b_trailer_e" value="Poor" <?php if ($b_trailer_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="b_trailer_e" value="Not Rated" <?php if ($b_trailer_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="b_trailer_t" value="<?php echo $b_trailer_t; ?>" size="20"></td>
		</tr>
<?php } ?>
<?php if ($cid == 15 || $cid == 2481) { ?>
		<tr>
			<td width="100">Bags</td>
			<td><input type="radio" name="bags_cond_e" value="Excellent" <?php if ($bags_cond_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="bags_cond_e" value="Good" <?php if ($bags_cond_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="bags_cond_e" value="Average" <?php if ($bags_cond_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="bags_cond_e" value="Poor" <?php if ($bags_cond_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="bags_cond_e" value="Not Rated" <?php if ($bags_cond_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="bags_cond_t" value="<?php echo $bags_cond_t; ?>" size="20"></td>
		</tr>
		<tr>
			<td width="100">Radiator</td>
			<td><input type="radio" name="radiator_e" value="Excellent" <?php if ($radiator_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="radiator_e" value="Good" <?php if ($radiator_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="radiator_e" value="Average" <?php if ($radiator_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="radiator_e" value="Poor" <?php if ($radiator_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="radiator_e" value="Not Rated" <?php if ($radiator_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="radiator_t" value="<?php echo $radiator_t; ?>" size="20"></td>
		</tr>
		<tr>
			<td width="100">Windscreen</td>
			<td><input type="radio" name="windscreen_e" value="Excellent" <?php if ($windscreen_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="windscreen_e" value="Good" <?php if ($windscreen_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="windscreen_e" value="Average" <?php if ($windscreen_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="windscreen_e" value="Poor" <?php if ($windscreen_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="windscreen_e" value="Not Rated" <?php if ($windscreen_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="windscreen_t" value="<?php echo $windscreen_t; ?>" size="20"></td>
		</tr>
<?php } ?>
	</table>

	<hr>
	<table align="center" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td align="right" class="header" valign="top"><font color="red"> * </font>Condition:</td>
			<td class="normal"><i>Detailed description of the item including <br>any interior or exterior damage, mechanical defects, etc.</i><br /><textarea name="condition" rows="10" cols="50" wrap="virtual"><?php echo $condition; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="2" >&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="header"><i><font color="red">If you have photos to add or update, select Yes. If Yes is selected,
												 <br>the image uploader page will be shown after clicking Submit. </font></i></td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="header">Photos: <input type="radio" name="add_photo" value="yes" checked>Yes <input type="radio" name="add_photo" value="no">No</td>
		</tr>
		<tr>
			<td colspan="2" >&nbsp;</td>
		</tr>
		<tr>
		 <td colspan="2" align="center" class="normal"><input type="submit" name="submit" value="Submit" /></td>
		</tr>
	</table>

  </form> <!-- JJM 1/22/2010 Added the form here, because it was missing, poor HTML coding -->
