
<?php

$PHP_SELF = $_SERVER['PHP_SELF'];

include("../../../include/db.php");

if(!empty($_REQUEST['dealer_id']))
	$dealer_id = $_REQUEST['dealer_id'];
else
	$dealer_id = "";


if(!empty($_REQUEST['cid']))
	$cid = $_REQUEST['cid'];
else
	$cid = "";

if(!empty($_REQUEST['subcid1']))
		$subcid1 = $_REQUEST['subcid1'];
	else
		$subcid1 = "";

if(!empty($_REQUEST['subcid2']))
		$subcid2 = $_REQUEST['subcid2'];
	else
		$subcid2 = "";




if(!empty($_REQUEST['in']))
	$in = $_REQUEST['in'];
else
	$in = "";

if(!empty($_REQUEST['did']))
	$did = $_REQUEST['did'];
else
	$did = "";

if(!empty($_REQUEST['vid']))
	$vid = $_REQUEST['vid'];
else
	$vid = "";





if(!empty($_REQUEST['z']))
	$z = $_REQUEST['z'];
else
	$z = "";

if(!empty($_REQUEST['short_desc']))
	$short_desc = $_REQUEST['short_desc'];
else
	$short_desc = "";

if(!empty($_REQUEST['engine_m']))
	$engine_m = $_REQUEST['engine_m'];
else
	$engine_m = "";


if(!empty($_REQUEST['engine_t']))
	$engine_t = $_REQUEST['engine_t'];
else
	$engine_t = "";


if(!empty($_REQUEST['transmission_m']))
	$transmission_m = $_REQUEST['transmission_m'];
else
	$transmission_m = "";


if(!empty($_REQUEST['transmission_t']))
	$transmission_t = $_REQUEST['transmission_t'];
else
	$transmission_t = "";


if(!empty($_REQUEST['exhaust_m']))
	$exhaust_m = $_REQUEST['exhaust_m'];
else
	$exhaust_m = "";


if(!empty($_REQUEST['exhaust_t']))
	$exhaust_t = $_REQUEST['exhaust_t'];
else
	$exhaust_t = "";


if(!empty($_REQUEST['tires_m']))
	$tires_m = $_REQUEST['tires_m'];
else
	$tires_m = "";

if(!empty($_REQUEST['tires_t']))
	$tires_t = $_REQUEST['tires_t'];
else
	$tires_t = "";

if(!empty($_REQUEST['brakes_m']))
	$brakes_m = $_REQUEST['brakes_m'];
else
	$brakes_m = "";


if(!empty($_REQUEST['brakes_t']))
	$brakes_t = $_REQUEST['brakes_t'];
else
	$brakes_t = "";


if(!empty($_REQUEST['steering_m']))
	$steering_m = $_REQUEST['steering_m'];
else
	$steering_m = "";


if(!empty($_REQUEST['ac_m']))
	$ac_m = $_REQUEST['ac_m'];
else
	$ac_m = "";


if(!empty($_REQUEST['ac_t']))
	$ac_t = $_REQUEST['ac_t'];
else
	$ac_t = "";


if(!empty($_REQUEST['front_seats_i']))
	$front_seats_i = $_REQUEST['front_seats_i'];
else
	$front_seats_i = "";


if(!empty($_REQUEST['front_seats_t']))
	$front_seats_t = $_REQUEST['front_seats_t'];
else
	$front_seats_t = "";


if(!empty($_REQUEST['carpet_i']))
	$carpet_i = $_REQUEST['carpet_i'];
else
	$carpet_i = "";


if(!empty($_REQUEST['carpet_t']))
	$carpet_t = $_REQUEST['carpet_t'];
else
	$carpet_t = "";


if(!empty($_REQUEST['headliner_i']))
	$headliner_i = $_REQUEST['headliner_i'];
else
	$headliner_i = "";


if(!empty($_REQUEST['headliner_t']))
	$headliner_t = $_REQUEST['headliner_t'];
else
	$headliner_t = "";

if(!empty($_REQUEST['dash_i']))
	$dash_i = $_REQUEST['dash_i'];
else
	$dash_i = "";


if(!empty($_REQUEST['dash_t']))
	$dash_t = $_REQUEST['dash_t'];
else
	$dash_t = "";


if(!empty($_REQUEST['electronics_i']))
	$electronics_i = $_REQUEST['electronics_i'];
else
	$electronics_i = "";


if(!empty($_REQUEST['electronics_t']))
	$electronics_t = $_REQUEST['electronics_t'];
else
	$electronics_t = "";


if(!empty($_REQUEST['paint_e']))
	$paint_e = $_REQUEST['paint_e'];
else
	$paint_e = "";


if(!empty($_REQUEST['paint_t']))
	$paint_t = $_REQUEST['paint_t'];
else
	$paint_t = "";


if(!empty($_REQUEST['hood_e']))
	$hood_e = $_REQUEST['hood_e'];
else
	$hood_e = "";


if(!empty($_REQUEST['hood_t']))
	$hood_t = $_REQUEST['hood_t'];
else
	$hood_t = "";


if(!empty($_REQUEST['r_f_fender_e']))
	$r_f_fender_e = $_REQUEST['r_f_fender_e'];
else
	$r_f_fender_e = "";


if(!empty($_REQUEST['r_f_fender_t']))
	$r_f_fender_t = $_REQUEST['r_f_fender_t'];
else
	$r_f_fender_t = "";


if(!empty($_REQUEST['l_f_fender_e']))
	$l_f_fender_e = $_REQUEST['l_f_fender_e'];
else
	$l_f_fender_e = "";


if(!empty($_REQUEST['l_f_fender_t']))
	$l_f_fender_t = $_REQUEST['l_f_fender_t'];
else
	$l_f_fender_t = "";


if(!empty($_REQUEST['r_door_e']))
	$r_door_e = $_REQUEST['r_door_e'];
else
	$r_door_e = "";


if(!empty($_REQUEST['r_door_t']))
	$r_door_t = $_REQUEST['r_door_t'];
else
	$r_door_t = "";


if(!empty($_REQUEST['l_door_e']))
	$l_door_e = $_REQUEST['l_door_e'];
else
	$l_door_e = "";


if(!empty($_REQUEST['l_door_t']))
	$l_door_t = $_REQUEST['l_door_t'];
else
	$l_door_t = "";


if(!empty($_REQUEST['r_rear_e']))
	$r_rear_e = $_REQUEST['r_rear_e'];
else
	$r_rear_e = "";


if(!empty($_REQUEST['r_rear_t']))
	$r_rear_t = $_REQUEST['r_rear_t'];
else
	$r_rear_t = "";


if(!empty($_REQUEST['l_rear_e']))
	$l_rear_e = $_REQUEST['l_rear_e'];
else
	$l_rear_e = "";


if(!empty($_REQUEST['l_rear_t']))
	$l_rear_t = $_REQUEST['l_rear_t'];
else
	$l_rear_t = "";


if(!empty($_REQUEST['trunk_e']))
	$trunk_e = $_REQUEST['trunk_e'];
else
	$trunk_e = "";


if(!empty($_REQUEST['trunk_t']))
	$trunk_t = $_REQUEST['trunk_t'];
else
	$trunk_t = "";


if(!empty($_REQUEST['f_bumper_e']))
	$f_bumper_e = $_REQUEST['f_bumper_e'];
else
	$f_bumper_e = "";


if(!empty($_REQUEST['f_bumper_t']))
	$f_bumper_t = $_REQUEST['f_bumper_t'];
else
	$f_bumper_t = "";


if(!empty($_REQUEST['r_bumper_e']))
	$r_bumper_e = $_REQUEST['r_bumper_e'];
else
	$r_bumper_e = "";

if(!empty($_REQUEST['r_bumper_t']))
	$r_bumper_t = $_REQUEST['r_bumper_t'];
else
	$r_bumper_t = "";

if(!empty($_REQUEST['grille_e']))
	$grille_e = $_REQUEST['grille_e'];
else
	$grille_e = "";

if(!empty($_REQUEST['grille_t']))
	$grille_t = $_REQUEST['grille_t'];
else
	$grille_t = "";

if(!empty($_REQUEST['glass_e']))
	$glass_e = $_REQUEST['glass_e'];
else
	$glass_e = "";

if(!empty($_REQUEST['glass_t']))
	$glass_t = $_REQUEST['glass_t'];
else
	$glass_t = "";

if(!empty($_REQUEST['frame_e']))
	$frame_e = $_REQUEST['frame_e'];
else
	$frame_e = "";


if(!empty($_REQUEST['frame_t']))
	$frame_t = $_REQUEST['frame_t'];
else
	$frame_t = "";


if(!empty($_REQUEST['condition']))
	$condition = $_REQUEST['condition'];
else
	$condition = "";

























if(!empty($_REQUEST['r_f_fender_e']))
	$r_f_fender_e = $_REQUEST['r_f_fender_e'];
else
	$r_f_fender_e = "";

if(!empty($_REQUEST['r_f_fender_t']))
	$r_f_fender_t = $_REQUEST['r_f_fender_t'];
else
	$r_f_fender_t = "";

if(!empty($_REQUEST['l_f_fender_e']))
	$l_f_fender_e = $_REQUEST['l_f_fender_e'];
else
	$l_f_fender_e = "";

if(!empty($_REQUEST['l_f_fender_t']))
	$l_f_fender_t = $_REQUEST['l_f_fender_t'];
else
	$l_f_fender_t = "";




if(!empty($_REQUEST['starboard_e']))
	$starboard_e  = $_REQUEST['starboard_e'];
else
	$starboard_e  = "";

if(!empty($_REQUEST['starboard_t']))
	$starboard_t  = $_REQUEST['starboard_t'];
else
	$starboard_t  = "";

if(!empty($_REQUEST['port_e']))
	$port_e  = $_REQUEST['port_e'];
else
	$port_e  = "";

if(!empty($_REQUEST['port_t']))
	$port_t  = $_REQUEST['port_t'];
else
	$port_t  = "";


if(!empty($_REQUEST['r_door_e']))
	$r_door_e = $_REQUEST['r_door_e'];
else
	$r_door_e = "";


if(!empty($_REQUEST['r_door_t']))
	$r_door_t = $_REQUEST['r_door_t'];
else
	$r_door_t = "";


if(!empty($_REQUEST['l_door_e']))
	$l_door_e = $_REQUEST['l_door_e'];
else
	$l_door_e = "";


if(!empty($_REQUEST['l_door_t']))
	$l_door_t = $_REQUEST['l_door_t'];
else
	$l_door_t = "";


if(!empty($_REQUEST['r_rear_e']))
	$r_rear_e = $_REQUEST['r_rear_e'];
else
	$r_rear_e = "";


if(!empty($_REQUEST['r_rear_t']))
	$r_rear_t = $_REQUEST['r_rear_t'];
else
	$r_rear_t = "";


if(!empty($_REQUEST['l_rear_e']))
	$l_rear_e = $_REQUEST['l_rear_e'];
else
	$l_rear_e = "";


if(!empty($_REQUEST['l_rear_t']))
	$l_rear_t = $_REQUEST['l_rear_t'];
else
	$l_rear_t = "";


if(!empty($_REQUEST['stern_e']))
	$stern_e  = $_REQUEST['stern_e'];
else
	$stern_e  = "";

if(!empty($_REQUEST['stern_t']))
	$stern_t  = $_REQUEST['stern_t'];
else
	$stern_t  = "";

 if(!empty($_REQUEST['bow_e']))
 	$bow_e  = $_REQUEST['bow_e'];
 else
 	$bow_e  = "";


if(!empty($_REQUEST['bow_t']))
	$bow_t  = $_REQUEST['bow_t'];
else
	$bow_t  = "";



if(!empty($_REQUEST['trunk_e']))
	$trunk_e = $_REQUEST['trunk_e'];
else
	$trunk_e = "";

if(!empty($_REQUEST['trunk_t']))
	$trunk_t = $_REQUEST['trunk_t'];
else
	$trunk_t = "";

if(!empty($_REQUEST['f_bumper_e']))
	$f_bumper_e = $_REQUEST['f_bumper_e'];
else
	$f_bumper_e = "";

if(!empty($_REQUEST['f_bumper_t']))
	$f_bumper_t = $_REQUEST['f_bumper_t'];
else
	$f_bumper_t = "";

if(!empty($_REQUEST['r_bumper_e']))
	$r_bumper_e = $_REQUEST['r_bumper_e'];
else
	$r_bumper_e = "";

if(!empty($_REQUEST['r_bumper_t']))
	$r_bumper_t = $_REQUEST['r_bumper_t'];
else
	$r_bumper_t = "";

if(!empty($_REQUEST['grille_e']))
	$grille_e = $_REQUEST['grille_e'];
else
	$grille_e = "";

if(!empty($_REQUEST['grille_t']))
	$grille_t = $_REQUEST['grille_t'];
else
	$grille_t = "";

if(!empty($_REQUEST['glass_e']))
	$glass_e = $_REQUEST['glass_e'];
else
	$glass_e = "";

if(!empty($_REQUEST['glass_t']))
	$glass_t = $_REQUEST['glass_t'];
else
	$glass_t = "";

if(!empty($_REQUEST['frame_e']))
	$frame_e = $_REQUEST['frame_e'];
else
	$frame_e = "";

if(!empty($_REQUEST['frame_t']))
	$frame_t = $_REQUEST['frame_t'];
else
	$frame_t = "";


if(!empty($_REQUEST['tongue_e']))
	$tongue_e  = $_REQUEST['tongue_e'];
else
	$tongue_e  = "";

if(!empty($_REQUEST['tongue_t']))
	$tongue_t  = $_REQUEST['tongue_t'];
else
	$tongue_t  = "";


if(!empty($_REQUEST['hull_e']))
	$hull_e  = $_REQUEST['hull_e'];
else
	$hull_e  = "";


if(!empty($_REQUEST['hull_t']))
	$hull_t  = $_REQUEST['hull_t'];
else
	$hull_t  = "";

if(!empty($_REQUEST['b_trailer_e']))
	$b_trailer_e   = $_REQUEST['b_trailer_e'];
else
	$b_trailer_e   = "";

if(!empty($_REQUEST['b_trailer_t']))
	$b_trailer_t  = $_REQUEST['b_trailer_t'];
else
	$b_trailer_t  = "";





?>



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

if (isset($e))
	$errors = "You must enter the condition of the item before creating an auction!!!";

?>
  </p>
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <input type="hidden" name="vid" value="<?php echo $vid; ?>" />
   <input type="hidden" name="did" value="<?php echo $did; ?>" />
   <input type="hidden" name="dealer_id" value="<?php echo $dealer_id; ?>" />

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

<?php if ($cid != 19) { ?>
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
<?php if ($cid != 14 && $cid != 11 && $cid != 19) { ?>
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
<?php if ($cid != 19) { ?>
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
<?php if ($cid != 14) { ?>
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
<?php if ($cid != 14) { ?>
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
<?php if ($cid != 19) { ?>
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
<?php if ($cid == 14) { ?>
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
<?php if ($cid == 14  || $cid == 18) { ?>
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
<?php if ($cid == 18) { ?>
		<tr>
			<td width="100">plumbing</td>
			<td><input type="radio" name="plumbing_m" value="Excellent" <?php if ($plumbing_m == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="plumbing_m" value="Good" <?php if ($plumbing_m == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="plumbing_m" value="Average" <?php if ($plumbing_m == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="plumbing_m" value="Poor" <?php if ($plumbing_m == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="plumbing_m" value="Not Rated" <?php if ($plumbing_m == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="plumbing_t" size="20" value="<?php echo $plumbing_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid == 18) { ?>
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
<?php if ($cid != 12 && $cid != 19) { ?>
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
<?php if ($cid == 18) { ?>
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
<?php if ($cid != 19) { ?>
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
<?php if ($cid != 19 && $cid != 14) { ?>
		<tr>
			<td width="100">Front Seats</td>
			<td><input type="radio" name="front_seats_i" value="Excellent" <?php if ($front_seats_i == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_seats_i" value="Good" <?php if ($front_seats_i == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_seats_i" value="Average" <?php if ($front_seats_i == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_seats_i" value="Poor" <?php if ($front_seats_i == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="front_seats_i" value="Not Rated" <?php if ($front_seats_i == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="front_seats_t" size="20" value="<?php echo $front_seats_t; ?>"></td>
		</tr>
<?php } ?>
<?php if ($cid != 19 && $cid != 14 && $cid != 15 && $cid != 12) { ?>
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
<?php if ($cid == 14) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 12) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 14 && $cid != 12) { ?>
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
<?php if ($cid != 19) { ?>
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
<?php if ($cid != 19) { ?>
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
<?php if ($cid == 18) { ?>
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
<?php if ($cid == 18) { ?>
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
<?php if ($cid == 18) { ?>
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
<?php } ?>
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
<?php if ($cid != 19 && $cid != 14 && $cid != 15 && $cid != 12) { ?>
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
<?php if ($cid == 18) { ?>
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
<?php if ($cid == 18) { ?>
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
<?php if ($cid == 18) { ?>
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
<?php if ($cid != 19 && $cid != 14 && $cid != 15 && $cid != 11) { ?>
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
<?php if ($cid != 19 && $cid != 14 && $cid != 15 && $cid != 11) { ?>
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
<?php if ($cid == 14) { ?>
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
<?php if ($cid == 14) { ?>
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
<?php if ($cid == 19) { ?>
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
<?php if ($cid == 19) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 14 && $cid != 12) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 14 && $cid != 12) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 14 && $cid != 12 && $cid != 11) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 14 && $cid != 12 && $cid != 11) { ?>
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
<?php if ($cid == 14) { ?>
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
<?php if ($cid == 14) { ?>
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
<?php if ($cid != 19 && $cid != 18 && $cid != 14 && $cid != 15 && $cid != 12) { ?>
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
<?php if ($cid != 19  && $cid != 18 && $cid != 14 && $cid != 11) { ?>
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
<?php if ($cid != 11 && $cid != 18 && $cid != 14) { ?>
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
<?php if ($cid != 19 && $cid != 14) { ?>
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
		<tr>
			<td width="100">Glass</td>
			<td><input type="radio" name="glass_e" value="Excellent" <?php if ($glass_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="glass_e" value="Good" <?php if ($glass_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="glass_e" value="Average" <?php if ($glass_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="glass_e" value="Poor" <?php if ($glass_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="glass_e" value="Not Rated" <?php if ($glass_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="100"><input type="text" name="glass_t" size="20" value="<?php echo $glass_t; ?>"></td>
		</tr>
		<tr>
			<td width="100">Frame</td>
			<td><input type="radio" name="frame_e" value="Excellent" <?php if ($frame_e == 'Excellent') echo 'checked'; ?>></td>
			<td><input type="radio" name="frame_e" value="Good" <?php if ($frame_e == 'Good') echo 'checked'; ?>></td>
			<td><input type="radio" name="frame_e" value="Average" <?php if ($frame_e == 'Average') echo 'checked'; ?>></td>
			<td><input type="radio" name="frame_e" value="Poor" <?php if ($frame_e == 'Poor') echo 'checked'; ?>></td>
			<td><input type="radio" name="frame_e" value="Not Rated" <?php if ($frame_e == 'Not Rated') echo 'checked'; ?>></td>
			<td width="150"><input type="text" name="frame_t" size="20" value="<?php echo $frame_t; ?>"></td>
		</tr>
<?php if ($cid == 19) { ?>
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
<?php if ($cid == 14) { ?>
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

