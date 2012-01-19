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
# $srp: godealertodealer.com/htdocs/auction/vehicles/_form.php,v 1.12 2003/02/24 17:13:39 steve Exp $
#


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

echo $a[1];
?>
  </p>
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <table align="center" border="0" cellspacing="0" cellpadding="2">
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
			}?></td>
    </tr>
	<tr>
		<td align="center" class="normal"><b>Auction Title: </b><?php echo $short_desc; ?></td>
    </tr>
	<tr>
		<td align="center" class="normal"><b>Stock Number: </b><?php echo $stock_num; ?></td>
    </tr>
<?php if($vin != '') { ?>
	<tr>
		<td align="center" class="normal"><b>VIN: </b><?php echo $vin; ?></td>
    </tr>
<?php } else { ?>
	<tr>
		<td align="center" class="normal"><b>HIN: </b><?php echo $hin; ?></td>
    </tr>
<?php } ?>
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
<?php if ($cid != 19) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 12) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 12) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 11) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 11) { ?>
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
			<td width="150"><input type="text" name="r_doors_t" size="20" value="<?php echo $r_door_t; ?>"></td>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 12 && $cid != 11) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 12 && $cid != 11) { ?>
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
<?php if ($cid != 19 && $cid != 15 && $cid != 12) { ?>
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
<?php if ($cid != 19 && $cid != 11) { ?>
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
<?php if ($cid != 11) { ?>
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
<?php } ?>
	</table>

	<hr>
	<table align="center" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td align="right" class="header" valign="top"><font color="red"> * </font>Condition:</td>
			<td class="normal"><i>Detailed description of the item including <br>any interior or exterior damage, mechanical defects, etc.</i><br /><textarea name="condition" rows="10" cols="50" wrap="virtual"><?php echo $condition; ?></textarea></td>
		</tr>
	</table>

