

<?php

 if(!empty($_REQUEST['z']))
	$z = $_REQUEST['z'];
else
	$z = "";
?>




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
# $srp: godealertodealer.com/htdocs/auction/vehicles/add.php,v 1.11 2003/02/24 17:13:39 steve Exp $
#

include('../../../include/session.php');
include('../../../include/db.php');

$page_title = 'Add an Item';
$help_page = "chp6_create.php";

db_connect();


include('../header.php');
?>
  <br>
<p align="center" class="big"><b><?php echo $page_title; ?></b></p><br>
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
echo "<p><table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\"><tr><td class=\"normal\"><b>CATEGORY:</b> $z";
if (isset($y))
{
	echo " >> $y ";
	if (isset ($x))
		echo " >> $x";
}
echo "</td></tr></table>";

### DROP DOWN TABLE 1

	echo "<p><table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\"><tr><td class=\"normal\"><form><select size=\"8\" style=\"width: 250px;\" onChange=\"ChooseMenu('parent',this,0)\">";

		if(isset($cid))
		{
			$result = db_do("SELECT name FROM categories WHERE id=$cid");
			list($b) = db_row($result);
			echo "<option value='?cid=$cid' selected>$b</option>";
			$result = db_do("SELECT id, name FROM categories WHERE parent_id=$cid AND subparent_id='0' ORDER BY name");
			if (db_num_rows($result) <= 0)
			{	$subcid1 = 1; $subcid2 = 1; }
		}

		if(!isset($cid))
			echo "<option selected value='?cid=1'>Choose One</option>";

		$result = db_do("SELECT id, name FROM categories WHERE parent_id='0' ORDER BY name");
		while (list($a, $b) = db_row($result))
			echo "<option value='?cid=$a'>$b</option>";

	echo "</select></form></td>";


	### DROP DOWN TABLE 2

	if ($subcid1 == 1)
		echo "<tr><td class=\"normal\"><form>
				<select size=\"8\" style=\"width: 250px; background-color: #999999\">
					<option>&nbsp;&nbsp;&nbsp;*** Finished ***</option></select></form></td>";
	else
	{
		echo "<td class=\"normal\"><form><select size=\"8\" style=\"width: 250px;\" onChange=\"ChooseMenu('parent',this,0)\">";

		if(isset($subcid1))
			{
				$result = db_do("SELECT name FROM categories WHERE id=$subcid1");
				list($b) = db_row($result);
					echo "<option value='?cid=$cid&subcid1=$subcid1' selected>$b</option>";

				$result = db_do("SELECT id, name FROM categories WHERE subparent_id=$subcid1 ORDER BY name");
				if (db_num_rows($result) <= 0)
					$subcid2 = 1;
			}

			if(isset($cid))
			{
				if(!isset($subcid1))
						echo "<option selected value='?cid=1'>Choose One</option>";

				$result = db_do("SELECT id, name FROM categories WHERE parent_id=$cid AND subparent_id='0' ORDER BY name");
				while (list($a, $b) = db_row($result))
					echo "<option value='?cid=$cid&subcid1=$a'>$b</option>";
			}

		echo "</select></form></td></tr>";

	### DROP DOWN TABLE 3

	if ($subcid2 == 1)
		echo "<tr><td class=\"normal\"><form>
				<select size=\"8\" style=\"width: 250px; background-color: #999999\">
					<option>&nbsp;&nbsp;&nbsp;*** Finished ***</option></select></form></td>";
	else
		echo "<tr><td class=\"normal\"><form><select size=\"8\" style=\"width: 250px;\" onChange=\"ChooseMenu('parent',this,0)\">";

		if($subcid2!=1)
		{

			if(isset($subcid2))
				{
					$result = db_do("SELECT name FROM categories WHERE id=$subcid2");
					list($b) = db_row($result);
					echo "<option value='?cid=$cid&subcid1=$subcid1&subcid2=$subcid2' selected>$b</option>";
				}

				if($subcid1>1)
				{
					if(!isset($subcid2))
							echo "<option selected value='?cid=1'>Choose One</option>";

					$result = db_do("SELECT id, name FROM categories WHERE subparent_id=$subcid1 ORDER BY name");
					while (list($a, $b) = db_row($result))
						echo "<option value='?cid=$cid&subcid1=$subcid1&subcid2=$a'>$b</option>";
				}
		}

	echo "</select></form></td>";

	### DROP DOWN TABLE 4

	if (isset($subcid2))
		echo "<td class=\"normal\"><form><select size=\"8\" style=\"width: 250px; background-color: #999999\">
				<option>&nbsp;&nbsp;&nbsp;*** Finished ***</option></select></form></td></tr>";
	else
		echo "<td class=\"normal\"><form><select size=\"8\" style=\"width: 250px;\"></select></form></td></tr>";
}

db_free($result);
?>
</table>

<?php

if (isset($subcid2))
{ ?>
	<p><form method="post" action="description.php">
			<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
			<input type="hidden" name="subcid1" value="<?php echo $subcid1; ?>" />
			<input type="hidden" name="subcid2" value="<?php echo $subcid2; ?>" />
			<p align="center"><input type="submit" value="Continue >>>" name="submit_step_1">
		</form>
<?php
}
include('../footer.php');
db_disconnect();
?>