<?php

include('../../include/session.php');
include('../../include/db.php');
db_connect();

$no_menu = 1;
$page_title = "DM Reports";
$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

?>
<html>
 <head>
  <title><?=$page_title?></title>
  <link rel="stylesheet" type="text/css" href="../site.css" title="site" />
  
<script language="JavaScript" type="text/JavaScript">
function ChooseMenu(targ,selObj,restore){
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;}
</script>

 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr valign="top">
	
		<!-- Left Column -->
		<td bgcolor="#EEEEEE" width="20%">
		<?php #include('_alerts.php'); ?>
		</td>
		
		<!-- Middle Column -->
		<td align="center" valign="top" width="60%">
			<table class="header" align="center" border="0" cellpadding="2" cellspacing="4">
		
<?php
	echo "<tr>
			<td class=\"header\" align=\"right\">Account Executive:</td><td class=\"normal\">
				<form method=\"post\">
					<select onChange=\"ChooseMenu('parent',this,0)\">";
	
		if(isset($ae_id) && $ae_id!=0)
		{
			$result = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM aes WHERE id='$ae_id'");
			list($aename) = db_row($result);
			echo "<option value='?ae_id=$aeid&did=0' selected>$aename</option>";
		}
		
		echo "<option value='?'>Choose an AE</option>";
		
			$result = db_do("SELECT id, CONCAT(first_name, ' ', last_name) FROM aes WHERE dm_id='$dm_id' and status='active' ORDER BY last_name");
			while (list($aeid, $aename) = db_row($result))
				echo "<option value='?ae_id=$aeid&did=0'>$aename</option>";
			
		echo "		</select>
				</form>
			</td>
		</tr>";
			
	### DROP DOWN TABLE 3

	echo "<tr>
			<td class=\"header\" align=\"right\">Dealership:</td><td class=\"normal\">
				<form method=\"post\">
					<select onChange=\"ChooseMenu('parent',this,0)\">";

		if(isset($did) && $did!=0)
		{
			$result = db_do("SELECT name FROM dealers WHERE id='$did'");
			list($dealer_name) = db_row($result);
			echo "<option value='?ae_id=$ae_id&did=$did' selected>$dealer_name</option>";
		}
		
		echo "<option value='?ae_id=$aeid&did=0'>(Not Required)</option>";
		
		if(isset($ae_id))
		{
			$result = db_do("SELECT id, name FROM dealers WHERE ae_id='$ae_id' ORDER BY name");
			while (list($dealer_id, $dealername) = db_row($result))
				echo "<option value='?ae_id=$ae_id&did=$dealer_id'>$dealername</option>";
		}


	echo "			</select>
				</form>
			</td>
		</tr>";
?>
		</table>
<?php

if (isset($ae_id)) { ?>
		<form method="post" action="reports.php">
			<input type="hidden" name="ae_id" value="<?php echo $ae_id; ?>" />
			<input type="hidden" name="did" value="<?php echo $did; ?>" />
			<p align="center"><input type="submit" value="Submit" name="submit">
		</form>
<?php } ?>
</td>

		
		<!-- Right Column -->
		<td width="20%" valign="top" bgcolor="#EEEEEE">		
			<table border="0" cellpadding="3" cellspacing="0" width="100%">
				<tr>
					<td align="center" bgcolor="#000066"><font color="#FFFFFF" size="-1"><b>Internal News</b></font></td>
				</tr>
			</table>
		</td>
		
	</tr>
</table>

<?php
db_disconnect();
include('footer.php');
?>