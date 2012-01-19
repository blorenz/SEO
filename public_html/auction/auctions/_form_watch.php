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
# $srp: godealertodealer.com/htdocs/auction/auctions/_form.php,v 1.19 2004/04/19 16:15:09 steve Exp $
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

?>
<?php	if (!empty($errors)) { ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
   <tr>
    <td class="error">The following errors occurred:<br /><ul><?php echo $errors; ?></ul></td>
   </tr>
  </table><br />
<?php } ?>
  <form action="<?php echo $PHP_SELF; ?>" method="post">
   <input type="hidden" name="id" value="<?php echo $id; ?>" />
   <input type="hidden" name="vid" value="<?php echo $vid; ?>" />
   <input type="hidden" name="aid" value="<?php echo $aid; ?>" />
   <input type="hidden" name="title" value="<?php echo $title; ?>" />
   <input type="hidden" name="photo" value="<?php echo $photo; ?>" />
   <table align="center" border="0" cellspacing="0" cellpadding="2">
    <tr class="big">
     <td align="right" class="header">Auction Title:</td>
     <td><b><?php echo $title; ?></b></td>
    </tr>
<?php if (!empty($photo) && file_exists("../uploaded/$photo.jpg")) {
	$image = "<img src=\"../uploaded/$photo.jpg\">";

	$result = db_do("SELECT caption FROM photos WHERE id='$photo'");
	list($caption) = db_row($result);
	db_free($result);
} else
	$image = '&nbsp;';
?>
	<tr>
		<td align="center" class="normal" colspan="2">
		<?php echo $image; ?><br /><?php echo $caption; ?></td>
	</tr>
    <tr>
		<td align="right" class="header">Category:</td><td class="normal">
     	<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
     	<input type="hidden" name="subcid1" value="<?php echo $subcid1; ?>" />
     	<input type="hidden" name="subcid2" value="<?php echo $subcid2; ?>" />
		<input type="hidden" name="tleft" value="<?php echo $tleft; ?>" />
     	<?php
     		echo "$z";
		if (isset($y) AND $subcid1 > 1)
		{
			echo " : $y ";
			if (isset ($x) AND $subcid2 > 1)
			echo " : $x";
		}
		?>
		</td>
    </tr>
	<tr>
     <td align="right" class="header" valign="top">Auction Ends In:</td>
     <td class="normal"><input type="hidden" name="timeleft" value="<?php echo $timeleft; ?>" /><?php echo $timeleft; ?></td>
    </tr>
	<tr>
     <td align="right" class="header" valign="top">Auction Ends At:</td>
     <td class="normal"><input type="hidden" name="ends" value="<?php echo $ends; ?>" /><?php echo $ends; ?></td>
    </tr>
    <tr>
     <td align="right" class="header">Email Reminder:</td>
     <td class="normal">
      <select name="starts_month">
       <option value="01" <?php if ($starts_month == '01') echo 'selected'; ?>>January</option>
       <option value="02" <?php if ($starts_month == '02') echo 'selected'; ?>>February</option>
       <option value="03" <?php if ($starts_month == '03') echo 'selected'; ?>>March</option>
       <option value="04" <?php if ($starts_month == '04') echo 'selected'; ?>>April</option>
       <option value="05" <?php if ($starts_month == '05') echo 'selected'; ?>>May</option>
       <option value="06" <?php if ($starts_month == '06') echo 'selected'; ?>>June</option>
       <option value="07" <?php if ($starts_month == '07') echo 'selected'; ?>>July</option>
       <option value="08" <?php if ($starts_month == '08') echo 'selected'; ?>>August</option>
       <option value="09" <?php if ($starts_month == '09') echo 'selected'; ?>>September</option>
       <option value="10" <?php if ($starts_month == '10') echo 'selected'; ?>>October</option>
       <option value="11" <?php if ($starts_month == '11') echo 'selected'; ?>>November</option>
       <option value="12" <?php if ($starts_month == '12') echo 'selected'; ?>>December</option>
      </select>
      <select name="starts_day">
       <option value="01" <?php if ($starts_day == '01') echo 'selected'; ?>>1</option>
       <option value="02" <?php if ($starts_day == '02') echo 'selected'; ?>>2</option>
       <option value="03" <?php if ($starts_day == '03') echo 'selected'; ?>>3</option>
       <option value="04" <?php if ($starts_day == '04') echo 'selected'; ?>>4</option>
       <option value="05" <?php if ($starts_day == '05') echo 'selected'; ?>>5</option>
       <option value="06" <?php if ($starts_day == '06') echo 'selected'; ?>>6</option>
       <option value="07" <?php if ($starts_day == '07') echo 'selected'; ?>>7</option>
       <option value="08" <?php if ($starts_day == '08') echo 'selected'; ?>>8</option>
       <option value="09" <?php if ($starts_day == '09') echo 'selected'; ?>>9</option>
       <option value="10" <?php if ($starts_day == '10') echo 'selected'; ?>>10</option>
       <option value="11" <?php if ($starts_day == '11') echo 'selected'; ?>>11</option>
       <option value="12" <?php if ($starts_day == '12') echo 'selected'; ?>>12</option>
       <option value="13" <?php if ($starts_day == '13') echo 'selected'; ?>>13</option>
       <option value="14" <?php if ($starts_day == '14') echo 'selected'; ?>>14</option>
       <option value="15" <?php if ($starts_day == '15') echo 'selected'; ?>>15</option>
       <option value="16" <?php if ($starts_day == '16') echo 'selected'; ?>>16</option>
       <option value="17" <?php if ($starts_day == '17') echo 'selected'; ?>>17</option>
       <option value="18" <?php if ($starts_day == '18') echo 'selected'; ?>>18</option>
       <option value="19" <?php if ($starts_day == '19') echo 'selected'; ?>>19</option>
       <option value="20" <?php if ($starts_day == '20') echo 'selected'; ?>>20</option>
       <option value="21" <?php if ($starts_day == '21') echo 'selected'; ?>>21</option>
       <option value="22" <?php if ($starts_day == '22') echo 'selected'; ?>>22</option>
       <option value="23" <?php if ($starts_day == '23') echo 'selected'; ?>>23</option>
       <option value="24" <?php if ($starts_day == '24') echo 'selected'; ?>>24</option>
       <option value="25" <?php if ($starts_day == '25') echo 'selected'; ?>>25</option>
       <option value="26" <?php if ($starts_day == '26') echo 'selected'; ?>>26</option>
       <option value="27" <?php if ($starts_day == '27') echo 'selected'; ?>>27</option>
       <option value="28" <?php if ($starts_day == '28') echo 'selected'; ?>>28</option>
       <option value="29" <?php if ($starts_day == '29') echo 'selected'; ?>>29</option>
       <option value="30" <?php if ($starts_day == '30') echo 'selected'; ?>>30</option>
       <option value="31" <?php if ($starts_day == '31') echo 'selected'; ?>>31</option>
      </select>
      <select name="starts_year">
<?php
$foo = date('Y');
for ($y = $foo - 2; $y <= $foo + 2; $y++) {
?>
       <option value="<?php echo $y; ?>" <?php if ($starts_year == $y) echo 'selected'; ?>><?php echo $y; ?></option>
<?php
}
?>
      </select>
      <select name="starts_hour">
       <option value="0" <?php if ($starts_hour == '0') echo 'selected'; ?>>12:00 AM</option>
       <option value="1" <?php if ($starts_hour == '1') echo 'selected'; ?>>1:00 AM</option>
       <option value="2" <?php if ($starts_hour == '2') echo 'selected'; ?>>2:00 AM</option>
       <option value="3" <?php if ($starts_hour == '3') echo 'selected'; ?>>3:00 AM</option>
       <option value="4" <?php if ($starts_hour == '4') echo 'selected'; ?>>4:00 AM</option>
       <option value="5" <?php if ($starts_hour == '5') echo 'selected'; ?>>5:00 AM</option>
       <option value="6" <?php if ($starts_hour == '6') echo 'selected'; ?>>6:00 AM</option>
       <option value="7" <?php if ($starts_hour == '7') echo 'selected'; ?>>7:00 AM</option>
       <option value="8" <?php if ($starts_hour == '8') echo 'selected'; ?>>8:00 AM</option>
       <option value="9" <?php if ($starts_hour == '9') echo 'selected'; ?>>9:00 AM</option>
       <option value="10" <?php if ($starts_hour == '10') echo 'selected'; ?>>10:00 AM</option>
       <option value="11" <?php if ($starts_hour == '11') echo 'selected'; ?>>11:00 AM</option>
       <option value="12" <?php if ($starts_hour == '12') echo 'selected'; ?>>12:00 PM</option>
       <option value="13" <?php if ($starts_hour == '13') echo 'selected'; ?>>1:00 PM</option>
       <option value="14" <?php if ($starts_hour == '14') echo 'selected'; ?>>2:00 PM</option>
       <option value="15" <?php if ($starts_hour == '15') echo 'selected'; ?>>3:00 PM</option>
       <option value="16" <?php if ($starts_hour == '16') echo 'selected'; ?>>4:00 PM</option>
       <option value="17" <?php if ($starts_hour == '17') echo 'selected'; ?>>5:00 PM</option>
       <option value="18" <?php if ($starts_hour == '18') echo 'selected'; ?>>6:00 PM</option>
       <option value="19" <?php if ($starts_hour == '19') echo 'selected'; ?>>7:00 PM</option>
       <option value="20" <?php if ($starts_hour == '20') echo 'selected'; ?>>8:00 PM</option>
       <option value="21" <?php if ($starts_hour == '21') echo 'selected'; ?>>9:00 PM</option>
       <option value="22" <?php if ($starts_hour == '22') echo 'selected'; ?>>10:00 PM</option>
       <option value="23" <?php if ($starts_hour == '23') echo 'selected'; ?>>11:00 PM</option>
      </select>&nbsp;<?php echo date('T') . ' <i>(GMT' . date('O') . ')</i>'; ?>
     </td>
    </tr>
	<tr><td colspan="2">&nbsp;</td></tr>
    <tr>
     <td>&nbsp;</td>
     <td class="normal"><input type="submit" name="submit" value=" Submit ">
	 <input type="submit" name="exit" value=" Exit "></td>
    </tr>
   </table>
  </form>
