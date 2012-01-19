	<?php

/**
*
* The Advanced Search feature
*
* $Id: advsearch.php 564 2006-09-22 17:50:31Z kaneda $
**/

include('../../include/session.php');
include('../../include/db.php');

extract(defineVars("page_title", "q", "no_menu", "searchid", "cid", "pid", "submit", //JJM 1/17/2010 (removed the old if statments)
"am_exhaust", "ac_yn", "trailer", "brakes", "transmission", "year_end", "year_start",
"boat_use", "state", "seating", "seats", "submit", "security_system", "sid", "cid",
"body", "sleep_no", "fuel_type", "engine", "engine_make", "price_high", "price_low",
"npid", "slide_out", "drive_train", "miles", "hand_warmers", "length", "tonguejack",
"sno_trailer", "type", "depth_finder", "warranty", "horsepower", "certified", "gps",
"fish_finder", "hitch", "interior_color", "exterior_color", "interior_color",
"exterior_color", "interior_color", "title", "title_status", "studded", "hours", "cover"));

db_connect();
$page_title = "Advanced Search";
$help_page = "chp4.php";
include('header.php');
?><head><title><?=$page_title?></title>
</head>
<script type="text/javascript" language="Javascript1.2">
function checkForm(form) {
   var anyChecked = false;
   var errMsg = "Please check at least one type.";
   for (var d = 0, e; e=form[d]; d++) {
      if (e.type == 'checkbox') {
         if (e.checked) {
            anyChecked = true;
         }
      }
   }

   if(!anyChecked) {
      alert(errMsg);
   }

   return anyChecked;
}
</script>


<?php if(!isset($cid) || $cid=='all') { ?>


<br><p class="header" align="center"><br><u>Select the Category to Search</u><br><br>
		<table align="center" border="0" cellspacing="0" cellpadding="0"><?php
		$result = db_do("SELECT id, name FROM categories WHERE parent_id='0' AND subparent_id='0' AND deleted = 0");
		while (list($cid, $name) = db_row($result)) { ?>
			<tr>
				<td align="left" class="header"><li><a href="advsearch.php?cid=<?=$cid?>"><?=$name?></a>&nbsp;&nbsp;</td>
				<td align="center" class="header"><a href="advsearch.php?cid=<?=$cid?>&searchid=all">ALL</a></li></td>
			</tr>
		<?php } ?>
		</table>
<?php } ?>

<?php if(isset($cid) && $cid!='all' && !isset($pid) && $searchid!='all') { $pid = array(); ?>
		<p class="header" align="center"><u>Select All that Apply</u><br>
		<table align="center" border="0" cellspacing="5" cellpadding="5">
		<form action="<?= $PHP_SELF; ?>" method="POST" name="pidform"
      onsubmit="javascript: return checkForm(this);">
      <input type="hidden" name="cid" value="<?=$cid?>">
		<tr><td valign="top" align="left" class="normal" width="175"><?php
      $sql = "SELECT c.id, c.name, COUNT(*) as num FROM vehicles v, categories c, dealers d
              WHERE v.category_id = $cid AND v.status = 'active'
              AND v.subcategory_id1 = c.id
              AND v.dealer_id = d.id
              AND d.status = 'active'
              GROUP BY c.name";
      $res = db_do($sql);
      $count = 0;
      while($datum = mysql_fetch_assoc($res)) {
            ?>

				<input type="checkbox" name="pid[]" value="<?=$datum['id']?>"><?=$datum['name']?>
				<?php if ($datum['num'] > 0) echo " <i><b>($datum[num])</b></i>";  ?><br>
				<?php $count++;
				if ($count%19==0) { ?>
					</td><td valign="top" align="left" class="normal" width="175">
				<?php } ?>
		<?php } ?>
		</td></tr><tr><td align="center" colspan="99"><input type="submit" name="submit" value="Continue >>>" /></td></tr></form></table>
<?php } ?>

<?php if(isset($_POST['pid']) || $searchid=='all') {
      if($searchid != 'all' && count($_POST['pid']) == 0) {
         header('https://www.godealertodealer.com/auction/advsearch.php');
      }

		if(isset($_POST['pid']))
			$npid = implode(",", $_POST['pid']); ?>
		<form action="search.php" method="POST">
		<input type="hidden" name="cid" value="<?=$cid?>">
		<input type="hidden" name="npid" value="<?=$npid?>">

	<?php if ($searchid!='all') { ?>
		<p class="header" align="center"><br><u><strong>Select All that Apply</strong></u>
		<p class="header" align="center">Selecting options will filter the search results to only<br />
those items that match the selection. Multiple selections<br />
may also be selected per group to display more items.<br />
You may leave the
          options
          unselected resulting<br />
in no filters for that particular   group. <br>
	      <br>
	      <?php if (count($pid) > 4) {
			$new_width = count($pid)*125; ?>
		  <table width="<?=$new_width?>" align="center" border="0" cellspacing="5" cellpadding="5">
		<?php } else { ?>
			<table align="center" border="0" cellspacing="5" cellpadding="5">
		<?php } ?>

		<tr><?php
			for ($i=0;$i<count($pid);$i++) { ?>

				<td valign="top" align="left" class="normal" width="175"><?php
				$ipid = $pid[$i];
				$result = db_do("SELECT name FROM categories WHERE id='$ipid'");
				list($name_top) = db_row($result);
				echo "<u><b>$name_top</b></u><br>";
			$sql = "SELECT c.id, c.name, COUNT(*) as num FROM vehicles v, categories c, dealers d
              WHERE v.subcategory_id1 = $ipid AND v.status = 'active'
              AND v.subcategory_id2 = c.id
              AND c.subparent_id = $ipid
              AND v.dealer_id = d.id
              AND d.status = 'active'
              GROUP BY c.name";
				$result = db_do($sql);
					if (db_num_rows($result) > 0) {
						$count = 0;
						while ($datum  = mysql_fetch_assoc($result)) {
                     ?>
								<input type="checkbox" name="sid[]" value="<?=$datum['id']?>"><?php echo "$datum[name]"; ?>
								<i><b><?="($datum[num])"?></b></i>
								<br />
								<?php $count++;
								if ($count%23==0) { ?>
		  </td><td valign="top" align="left" class="normal" width="175"><br>
								<?php } ?>
				<?php } } ?></td><?php } ?>
		</tr>
</table><?php } ?>

        <table align="center" border="0" cellspacing="10" cellpadding="5">
          <tr>
            <td colspan="4" class="header" align="center" valign="top"><br>
                <u><b>Check the Following that Apply</b></u><br>
          &nbsp;</td>
          </tr>
          <tr>
            <td valign="top" align="right" class="header">Year:</td>
            <td colspan="3" class="normal"><select name="year_start">
                <?php
				for ( $count=1900; $count<2010; $count++ )
					echo "<option value=\"$count\">$count</option>";
			?>
              </select>
      to
      <select name="year_end">
        <?php
				for ( $count=(date('Y')+2); $count>1899; $count-- )
					echo "<option value=\"$count\">$count</option>";
			?>
    </select></td>
          </tr>
		  <tr>
            <td valign="top" align="right" class="header">Price:</td>
            <td colspan="3" class="normal">Between $<input type="text" name="price_low" value="<?php echo $price_low; ?>" size="15" />
				&nbsp;up to&nbsp;$<input type="text" name="price_high" value="<?php echo $price_high; ?>" size="15" />
				<br />
				(NOTE - if  a price range is entered, only items that are in  auction<br />
			  will be displayed. There will be no option to request auction)</td>
          </tr>
          <?php if ($cid != 14 && $cid != 11 && $cid != 19 && $cid != 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Miles:</td>
            <td colspan="3" class="normal">Less Than
                <input type="text" name="miles" value="<?php echo $miles; ?>" size="15" /></td>
          </tr>
          <?php } ?>
          <?php if ($cid == 14 || $cid == 11 || $cid == 2075 || $cid == 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Hours:</td>
            <td colspan="3" class="normal">Less Than
                <input type="text" name="hours" value="<?php echo $hours; ?>" size="15" /></td>
          </tr>
          <?php } ?>
          <?php if ($cid == 13) { ?>
          <tr>
            <td valign="top" align="right" class="header">Body:</td>
            <td valign="top" class="normal">
              <input type="checkbox" name="body[]" value='Bus'>
              Bus<br>
              <input type="checkbox" name="body[]" value='Coupe'>
              Coupe<br>
              <input type="checkbox" name="body[]" value='Hatchback'>
              Hatchback<br>
              <input type="checkbox" name="body[]" value='Sedan'>
              Sedan<br>
            </td>
            <td valign="top" colspan="2" class="normal">
              <input type="checkbox" name="body[]" value='Truck'>
              Truck<br>
              <input type="checkbox" name="body[]" value='Van'>
              Van<br>
              <input type="checkbox" name="body[]" value='Wagon'>
              Wagon<br>
              <input type="checkbox" name="body[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 14 || $cid == 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Hull Material:</td>
            <td valign="top" class="normal">
              <input type="checkbox" name="body[]" value='Fiberglass'>
              Fiberglass<br>
              <input type="checkbox" name="body[]" value='Metal'>
              Metal<br>
              <input type="checkbox" name="body[]" value='Plastic'>
              Plastic<br>
              <input type="checkbox" name="body[]" value='Wood'>
              Wood<br>
            </td>
            <td valign="top" colspan="2" class="normal">
              <input type="checkbox" name="body[]" value='Inflatable'>
              Inflatable<br>
              <input type="checkbox" name="body[]" value='Composite'>
              Composite<br>
              <input type="checkbox" name="body[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 15) { ?>
          <tr>
            <td valign="top" align="right" class="header">Body:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="body[]" value='Off Road'>
              Off Road<br>
              <input type="checkbox" name="body[]" value='Street'>
              Street<br>
              <input type="checkbox" name="body[]" value='Enduro'>
              Enduro<br>
              <input type="checkbox" name="body[]" value='Motocross'>
              Motocross<br>
              <input type="checkbox" name="body[]" value='Dual Sport'>
              Dual Sport<br>
              <input type="checkbox" name="body[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 16) { ?>
          <tr>
            <td valign="top" align="right" class="header">Body:</td>
            <td valign="top" class="normal">
              <input type="checkbox" name="body[]" value='Convertible'>
              Convertible<br>
              <input type="checkbox" name="body[]" value='Coupe'>
              Coupe<br>
              <input type="checkbox" name="body[]" value='Hatchback'>
              Hatchback<br>
              <input type="checkbox" name="body[]" value='Sedan'>
              Sedan<br>
              <input type="checkbox" name="body[]" value='Sport Utility'>
              Sport Utility<br>
            </td>
            <td valign="top" colspan="2" class="normal">
              <input type="checkbox" name="body[]" value='Truck'>
              Truck<br>
              <input type="checkbox" name="body[]" value='Van'>
              Van<br>
              <input type="checkbox" name="body[]" value='Wagon'>
              Wagon<br>
              <input type="checkbox" name="body[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 18) { ?>
          <tr>
            <td valign="top" align="right" class="header">Body:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="body[]" value='Engine'>
              Engine<br>
              <input type="checkbox" name="body[]" value='Towed'>
              Towed<br>
              <input type="checkbox" name="body[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 19) { ?>
          <tr>
            <td valign="top" align="right" class="header">Body:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="body[]" value='Camper'>
              Camper<br>
              <input type="checkbox" name="body[]" value='Flat'>
              Flat<br>
              <input type="checkbox" name="body[]" value='Open'>
              Open<br>
              <input type="checkbox" name="body[]" value='Box'>
              Box<br>
              <input type="checkbox" name="body[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 13 || $cid == 16 || $cid == 17) { ?>
          <tr>
            <td valign="top" align="right" class="header">Engine:</td>
            <td valign="top" class="normal">
              <input type="checkbox" name="engine[]" value='1 Cylinders'>
              1 Cylinder<br>
              <input type="checkbox" name="engine[]" value='2 Cylinders'>
              2 Cylinders<br>
              <input type="checkbox" name="engine[]" value='3 Cylinders'>
              3 Cylinders<br>
              <input type="checkbox" name="engine[]" value='4 Cylinders'>
              4 Cylinders<br>
              <input type="checkbox" name="engine[]" value='5 Cylinders'>
              5 Cylinders<br>
              <input type="checkbox" name="engine[]" value='6 Cylinders'>
              6 Cylinders<br>
              <input type="checkbox" name="engine[]" value='8 Cylinders'>
              8 Cylinders<br>
            </td>
            <td valign="top" colspan="2" class="normal">
              <input type="checkbox" name="engine[]" value='10 Cylinders'>
              10 Cylinders<br>
              <input type="checkbox" name="engine[]" value='12 Cylinders'>
              12 Cylinders<br>
              <input type="checkbox" name="engine[]" value='Rotary'>
              Rotary<br>
              <input type="checkbox" name="engine[]" value='Electric'>
              Electric<br>
              <input type="checkbox" name="engine[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 12 || $cid == 15 || $cid == 2075 || $cid == 2481) { ?>
          <tr>
            <td valign="top" align="right" class="header">Engine:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="engine[]" value='2 Stroke'>
              2 Stroke<br>
              <input type="checkbox" name="engine[]" value='4 Stroke'>
              4 Stroke<br>
              <input type="checkbox" name="engine[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 11) { ?>
          <tr>
            <td valign="top" align="right" class="header">Engine:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="engine[]" value='Prop'>
              Prop<br>
              <input type="checkbox" name="engine[]" value='Jet'>
              Jet<br>
              <input type="checkbox" name="engine[]" value='Glider'>
              Glider<br>
              <input type="checkbox" name="engine[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 14 || $cid == 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Engine Type:</td>
            <td valign="top" class="normal">
              <input type="checkbox" name="engine[]" value='Outboard'>
              Outboard<br>
              <input type="checkbox" name="engine[]" value='Twin Outboard'>
              Twin Outboard<br>
			  <input type="checkbox" name="engine[]" value='Inboard'>
              Inboard<br>
              <input type="checkbox" name="engine[]" value='In-Out'>
              In-Out<br>
              <input type="checkbox" name="engine[]" value='Twin In-Out'>
              Twin In-Out<br>
            </td>
            <td valign="top" colspan="2"class="normal">
              <input type="checkbox" name="engine[]" value='Jet'>
              Jet<br>
              <input type="checkbox" name="engine[]" value='Sail'>
              Sail<br>
			  <input type="checkbox" name="engine[]" value='Stern Drive'>
              Stern Drive<br>
              <input type="checkbox" name="engine[]" value='V-Drive'>
              V-Drive<br>
              <input type="checkbox" name="engine[]" value='Manual'>
              Manual<br>
              <input type="checkbox" name="engine[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 14 || $cid == 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Engine Make:</td>
            <td valign="top" class="normal">
              <input type="checkbox" name="engine_make[]" value='Caterpillar'>
              Caterpillar<br>
              <input type="checkbox" name="engine_make[]" value='Evinrude'>
              Evinrude<br>
              <input type="checkbox" name="engine_make[]" value='Force'>
              Force<br>
              <input type="checkbox" name="engine_make[]" value='Honda'>
              Honda<br>
              <input type="checkbox" name="engine_make[]" value='Johnson'>
              Johnson<br>
              <input type="checkbox" name="engine_make[]" value='Mariner'>
              Mariner<br>
              <input type="checkbox" name="engine_make[]" value='MerCruiser'>
              MerCruiser<br>
              <input type="checkbox" name="engine_make[]" value='Mercury'>
              Mercury<br>
            </td>
            <td valign="top" colspan="2" class="normal">
              <input type="checkbox" name="engine_make[]" value='Minn Kota'>
              Minn Kota<br>
              <input type="checkbox" name="engine_make[]" value='Motor Guide'>
              Motor Guide<br>
              <input type="checkbox" name="engine_make[]" value='Polaris'>
              Polaris<br>
              <input type="checkbox" name="engine_make[]" value='Suzuki'>
              Suzuki<br>
			  <input type="checkbox" name="engine_make[]" value='Volvo Penta'>
              Volvo Penta<br>
              <input type="checkbox" name="engine_make[]" value='Yamaha'>
              Yamaha<br>
              <input type="checkbox" name="engine_make[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid != 19) { ?>
          <tr>
            <td valign="top" align="right" class="header">Fuel Type:</td>
            <td valign="top" class="normal">
              <input type="checkbox" name="fuel_type[]" value='Gas'>
              Gas<br>
              <input type="checkbox" name="fuel_type[]" value='Diesel'>
              Diesel<br>
              <input type="checkbox" name="fuel_type[]" value='Hybrid'>
              Hybrid<br>
              <input type="checkbox" name="fuel_type[]" value='Electric'>
              Electric<br>
              <input type="checkbox" name="fuel_type[]" value='Natural Gas'>
              Natural Gas<br>
            </td>
            <td valign="top" colspan="2" class="normal">
              <input type="checkbox" name="fuel_type[]" value='Aviation'>
              Aviation<br>
              <input type="checkbox" name="fuel_type[]" value='Hydrogen'>
              Hydrogen<br>
              <input type="checkbox" name="fuel_type[]" value='Wind'>
              Wind<br>
              <input type="checkbox" name="fuel_type[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 14 || $cid == 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Drive Train:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="drive_train[]" value='Jet'>
              Jet<br>
              <input type="checkbox" name="drive_train[]" value='Prop'>
              Prop<br>
              <input type="checkbox" name="drive_train[]" value='Sail'>
              Sail<br>
              <input type="checkbox" name="drive_train[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 13 || $cid == 16 || $cid == 17 || $cid == 18) { ?>
          <tr>
            <td valign="top" align="right" class="header">Drive Train:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="drive_train[]" value='Front WD'>
              Front WD<br>
              <input type="checkbox" name="drive_train[]" value='Rear WD'>
              Rear WD<br>
              <input type="checkbox" name="drive_train[]" value='4WD'>
              4WD<br>
              <input type="checkbox" name="drive_train[]" value='All WD'>
              All WD<br>
              <input type="checkbox" name="drive_train[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 15 || $cid == 2481) { ?>
          <tr>
            <td valign="top" align="right" class="header">Drive Train:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="drive_train[]" value='Shaft'>
              Shaft<br>
              <input type="checkbox" name="drive_train[]" value='Belt'>
              Belt<br>
              <input type="checkbox" name="drive_train[]" value='Chain'>
              Chain<br>
              <input type="checkbox" name="drive_train[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid != 14 && $cid != 11 && $cid != 19 && $cid != 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Transmission:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="transmission[]" value='Automatic'>
              Automatic<br>
              <input type="checkbox" name="transmission[]" value='Manual'>
              Manual<br>
              <input type="checkbox" name="transmission[]" value='Semi-Automatic'>
              Semi-Automatic<br>
              <input type="checkbox" name="transmission[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 14 || $cid == 11 || $cid == 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Horsepower:</td>
            <td valign="top" colspan="3" class="normal">At Least
                <input type="text" name="horsepower" value="<?php echo $horsepower; ?>" size="15" /></td>
          </tr>
          <?php } ?>
          <?php if ($cid == 14 || $cid == 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Use:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="boat_use[]" value='Fresh Water'>
              Fresh Water<br>
              <input type="checkbox" name="boat_use[]" value='Salt Water'>
              Salt Water<br>
              <input type="checkbox" name="boat_use[]" value='Both Fresh-Salt Water'>
              Both Fresh-Salt Water<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 14 || $cid == 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Boat Length:</td>
            <td valign="top" colspan="3" class="normal">At Least
                <input type="text" name="length" value="<?php echo $length; ?>" />
                <i> in ft</i></td>
          </tr>
          <?php } ?>
          <?php if ($cid == 14 || $cid == 11 || $cid == 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Max Seating Capacity:</td>
            <td valign="top" colspan="3" class="normal">At Least
                <input type="text" name="seating" value="<?php echo $seating; ?>" /></td>
          </tr>
          <?php } ?>
          <?php if ($cid != 19 && $cid != 14 && $cid != 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Seat Surface:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="seats[]" value='Leather'>Leather<br>
              <input type="checkbox" name="seats[]" value='Cloth'>Cloth<br>
              <input type="checkbox" name="seats[]" value='Vinyl'>Vinyl<br>
              <input type="checkbox" name="seats[]" value='Other'>Other<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid != 12 && $cid != 15 && $cid != 19 && $cid != 2075 && $cid != 2481 && $cid != 2567) { ?>
          <tr>
            <td valign="top" align="right" class="header">Interior Color:</td>
            <td valign="top" class="normal">
              <input type="checkbox" name="interior_color[]" value='Beige'>
              Beige<br>
              <input type="checkbox" name="interior_color[]" value='Black'>
              Black<br>
              <input type="checkbox" name="interior_color[]" value='Blue'>
              Blue<br>
              <input type="checkbox" name="interior_color[]" value='Brown'>
              Brown<br>
              <input type="checkbox" name="interior_color[]" value='Burgundy'>
              Burgundy<br>
              <input type="checkbox" name="interior_color[]" value='Champagne'>
              Champagne<br>
              <input type="checkbox" name="interior_color[]" value='Charcoal'>
              Charcoal<br>
              <input type="checkbox" name="interior_color[]" value='Cream'>
              Cream<br>
              <input type="checkbox" name="interior_color[]" value='Dark Green'>
              Dark Green<br>
            </td>
            <td valign="top" class="normal">
              <input type="checkbox" name="interior_color[]" value='Gold'>
              Gold<br>
              <input type="checkbox" name="interior_color[]" value='Green'>
              Green<br>
              <input type="checkbox" name="interior_color[]" value='Grey'>
              Grey<br>
              <input type="checkbox" name="interior_color[]" value='Light Green'>
              Light Green<br>
              <input type="checkbox" name="interior_color[]" value='Mult-color'>
              Mult-color<br>
              <input type="checkbox" name="interior_color[]" value='Offwhite'>
              Offwhite<br>
              <input type="checkbox" name="interior_color[]" value='Orange'>
              Orange<br>
              <input type="checkbox" name="interior_color[]" value='Other'>
              Other<br>
            </td>
            <td valign="top" class="normal">
              <input type="checkbox" name="interior_color[]" value='Pink'>
              Pink<br>
              <input type="checkbox" name="interior_color[]" value='Purple'>
              Purple<br>
              <input type="checkbox" name="interior_color[]" value='Red'>
              Red<br>
              <input type="checkbox" name="interior_color[]" value='Silver'>
              Silver<br>
              <input type="checkbox" name="interior_color[]" value='Tan'>
              Tan<br>
              <input type="checkbox" name="interior_color[]" value='Turquiose'>
              Turquiose<br>
              <input type="checkbox" name="interior_color[]" value='White'>
              White<br>
              <input type="checkbox" name="interior_color[]" value='Yellow'>
              Yellow<br>
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" align="right" class="header">Exterior Color:</td>
            <td valign="top" class="normal">
              <input type="checkbox" name="exterior_color[]" value='Beige'>
              Beige<br>
              <input type="checkbox" name="exterior_color[]" value='Black'>
              Black<br>
              <input type="checkbox" name="exterior_color[]" value='Blue'>
              Blue<br>
              <input type="checkbox" name="exterior_color[]" value='Brown'>
              Brown<br>
              <input type="checkbox" name="exterior_color[]" value='Burgundy'>
              Burgundy<br>
              <input type="checkbox" name="exterior_color[]" value='Champagne'>
              Champagne<br>
              <input type="checkbox" name="exterior_color[]" value='Charcoal'>
              Charcoal<br>
              <input type="checkbox" name="exterior_color[]" value='Cream'>
              Cream<br>
              <input type="checkbox" name="exterior_color[]" value='Dark Green'>
              Dark Green<br>
            </td>
            <td valign="top" class="normal">
              <input type="checkbox" name="exterior_color[]" value='Gold'>
              Gold<br>
              <input type="checkbox" name="exterior_color[]" value='Green'>
              Green<br>
              <input type="checkbox" name="exterior_color[]" value='Grey'>
              Grey<br>
              <input type="checkbox" name="exterior_color[]" value='Light Green'>
              Light Green<br>
              <input type="checkbox" name="exterior_color[]" value='Mult-color'>
              Mult-color<br>
              <input type="checkbox" name="exterior_color[]" value='Offwhite'>
              Offwhite<br>
              <input type="checkbox" name="exterior_color[]" value='Orange'>
              Orange<br>
              <input type="checkbox" name="exterior_color[]" value='Other'>
              Other<br>
            </td>
            <td valign="top" class="normal">
              <input type="checkbox" name="exterior_color[]" value='Pink'>
              Pink<br>
              <input type="checkbox" name="exterior_color[]" value='Purple'>
              Purple<br>
              <input type="checkbox" name="exterior_color[]" value='Red'>
              Red<br>
              <input type="checkbox" name="exterior_color[]" value='Silver'>
              Silver<br>
              <input type="checkbox" name="exterior_color[]" value='Tan'>
              Tan<br>
              <input type="checkbox" name="exterior_color[]" value='Turquiose'>
              Turquiose<br>
              <input type="checkbox" name="exterior_color[]" value='White'>
              White<br>
              <input type="checkbox" name="exterior_color[]" value='Yellow'>
              Yellow<br>
            </td>
          </tr>
          <?php if ($cid == 19) { ?>
          <tr>
            <td valign="top" align="right" class="header">Hitch:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="hitch[]" value='Class A'>
              Class A<br>
              <input type="checkbox" name="hitch[]" value='Class B'>
              Class B<br>
              <input type="checkbox" name="hitch[]" value='Class C'>
              Class C<br>
            </td>
          </tr>
          <?php } ?>
          <?php if ($cid == 19 && ($npid != 235 && $npid != 236 && $npid != 237 && $npid != 238)) { ?>
          <tr>
            <td valign="top" align="right" class="header">Max Sleeping Capacity:</td>
            <td valign="top" colspan="3" class="normal"> At Least
                <input type="text" name="sleep_no" value="<?php echo $sleep_no; ?>" />
            </td>
          </tr>
          <?php } ?>
          <?php if($cid != 2075) { ?>
          <tr>
            <td valign="top" align="right" class="header">Title:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="title[]" value='New'>
              New<br>
              <input type="checkbox" name="title[]" value='Used'>
              Used<br>
              <input type="checkbox" name="title[]" value='Reconditioned'>
              Reconditioned<br>
            </td>
          </tr>
          <tr>
            <td valign="top" align="right" class="header">Title Status:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" name="title_status[]" value='Clear'>
              Clear<br>
              <input type="checkbox" name="title_status[]" value='Duplicate'>
              Duplicate<br>
              <input type="checkbox" name="title_status[]" value='Flood'>
              Flood<br>
              <input type="checkbox" name="title_status[]" value='Salvage'>
              Salvage<br>
              <input type="checkbox" name="title_status[]" value='Other'>
              Other<br>
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" align="right" class="header">Misc:</td>
            <td valign="top" colspan="3" class="normal"><input type="checkbox" name="warranty" value="Yes" <?php if ($warranty == 'Yes') echo 'checked'; ?>>
              Warranty<br>
              <input type="checkbox" name="certified" value="Yes" <?php if ($certified == 'Yes') echo 'checked'; ?>>
              Certified<br>
              <?php if ($npid != 235 && $npid != 236 && $npid != 237 && $npid != 238) { ?>
              <input type="checkbox" name="security_system" value="Yes" <?php if ($security_system == 'Yes') echo 'checked'; ?>>
              Security System<br>
              <?php } ?>
              <?php if ($cid != 17 && $cid != 19) { ?>
              <input type="checkbox" name="gps" value="Yes" <?php if ($gps == 'Yes') echo 'checked'; ?>>
              GPS/Navigation System<br>
              <?php } ?>
              <?php if ($cid != 11 && $cid != 14 && $cid != 19 && $cid != 2567) { ?>
              <input type="checkbox" name="hitch" value="Yes" <?php if ($hitch == 'Yes') echo 'checked'; ?>>
              Hitch<br>
              <?php } ?>
              <?php if ($cid == 14 || $cid == 2567) { ?>
              <input type="checkbox" name="trailer" value="Yes" <?php if ($trailer == 'Yes') echo 'checked'; ?>>
              Trailer Included<br>
              <input type="checkbox" name="fish_finder" value="Yes" <?php if ($fish_finder == 'Yes') echo 'checked'; ?>>
              Fish Finder<br>
              <input type="checkbox" name="depth_finder" value="Yes" <?php if ($depth_finder == 'Yes') echo 'checked'; ?>>
              Depth Finder<br>
              <?php } ?>
              <?php if ($cid == 19 && ($npid != 235 && $npid != 236 && $npid != 237 && $npid != 238)) { ?>
              <input type="checkbox" name="slide_out" value="Yes" <?php if ($slide_out == 'Yes') echo 'checked'; ?>>
              Slide Out<br>
              <?php } ?>
              <?php if($cid != 2075 && $cid != 2567 && $npid != 235 && $npid != 236 && $npid != 237 && $npid != 238) { ?>
              <input type="checkbox" name="ac_yn" value="Yes" <?php if ($ac_yn == 'Yes') echo 'checked'; ?>>
              Air Conditioning <br>
              <?php } ?>
              <?php if ($npid == 235 || $npid == 236 || $npid == 237 || $npid == 238) { ?>
               <input type="checkbox" name="brakes" value="Yes" <?php if ($brakes == 'Yes') echo 'checked'; ?>>
               Brakes <br>
              <?php } ?>
               <?php if ($npid == 235 || $npid == 236 || $npid == 237 || $npid == 238) { ?>
               <input type="checkbox" name="tonguejack" value="Yes" <?php if ($tonguejack == 'Yes') echo 'checked'; ?>> Tongue Jack <br>
              <?php } ?>


              <?php if($cid == 2075) { ?>
              <input type="checkbox" name="hand_warmers" value="Yes" <?php if($hand_warmers == 'yes') echo 'checked'; ?> />Hand Warmers<br />

              <input type="checkbox" name="studded" value="Yes" <?php if($studded == 'yes') echo 'checked'; ?> />Studded<br />

              <input type="checkbox" name="cover" value="Yes" <?php if($cover == 'yes') echo 'checked'; ?> />Cover Included<br />

              <input type="checkbox" name="am_exhaust" value="Yes" <?php if($am_exhaust == 'yes') echo 'checked'; ?> />Aftermarket Exhaust<br />

         <input type="checkbox" name="sno_trailer" value="Yes" <?php if($sno_trailer == 'yes') echo 'checked'; ?> />Street Trailer<br />
              <?php } ?>
          </tr>
</table>
<table align="center" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="50" class="header" align="center" valign="top">
			<br><br><u>To Refine Your Search Select only the States You Want to Buy From</u>
		</td>
	</tr>
	<tr>
		<td align="center" class="normal"><i>(Otherwise Leave Blank)</i></td>
	</tr>
</table>
<table align="center" border="0" cellspacing="0" cellpadding="0" background="images/usmap.gif">
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value='WA'></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="ND"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="MT"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="MN"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="ME"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="OR"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="SD"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="WI"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="VT"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="ID"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="WY"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="MI"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NY"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NH"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NE"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="IA"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="CT"></td>
		<td><input type="checkbox" name="state[]" value="RI"></td>
		<td><input type="checkbox" name="state[]" value="MA"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NV"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="IL"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="IN"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="OH"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="PA"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NJ"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="UT"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="CO"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="KS"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="MO"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="WV"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="MD"></td>
		<td><input type="checkbox" name="state[]" value="DE"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="CA"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="KY"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="VA"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="TN"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="AZ"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NM"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="OK"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="AR"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NC"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="MS"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="GA"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="SC"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="TX"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="AL"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="AK"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="LA"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="FL"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="HI"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
	</tr>

</table>
<table align="center" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" class="huge"><br>
                <br><input class="huge" type="submit" name="submit" value="Search" /></td>
                <input type="hidden" name="type" value="advanced" />
    </tr>
        </table><br><br>
		</form>


<?php }

include('footer.php'); ?>
