<?php

$PHP_SELF = $_SERVER['PHP_SELF'];


if(!empty($_REQUEST['dm_id']))
	$dm_id = $_REQUEST['dm_id'];
else
	$dm_id = "";

if(!empty($_REQUEST['ae_id']))
	$ae_id = $_REQUEST['ae_id'];
else
	$ae_id = "";

if(!empty($_REQUEST['dealer_id']))
	$dealer_id = $_REQUEST['dealer_id'];
else
	$dealer_id = "";

if(!empty($_REQUEST['dealer_id']))
	$dealer_id = $_REQUEST['dealer_id'];
else
	$dealer_id = "";



?>



<?php

$page_title = 'Add D2DBucks';

include('../../../include/db.php');
db_connect();

if (isset($submit)) {

	if (empty($amount))
		$errors .= '<li>You must supply the Amount of the Bucks.</li>';

	if (empty($dm_id))
		$errors .= '<li>You must Assign the Bucks to a DM.</li>';

	if (empty($errors)) {

		if(!isset($ae_id))
			$ae_id = 0;

		if(!isset($dealer_id))
			$dealer_id = 0;

		if (!isset($serial_id_end) || $serial_id_end=='')
			$serial_id_end = $serial_id_start;
		$serial_id = $serial_id_start;
		do {
			db_do("INSERT INTO d2dbucks SET serial_id='$serial_id', amount='$amount', dm_id='$dm_id',
					ae_id='$ae_id', dealer_id='$dealer_id', status='open', modified=NOW(), created=modified");
			$serial_id++;
		} while ($serial_id_end >= $serial_id);
		$success = TRUE;

		$dm_id = '';
		$ae_id = '';
		$dealer_id = '';

		empty($dm_id);
		empty($ae_id);
		empty($dealer_id);
	}
}

?>

<html>
	<head>
	<script language="JavaScript" type="text/JavaScript">
	function ChooseMenu(targ,selObj,restore){
	  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	  if (restore) selObj.selectedIndex=0;}
	</script>
		<title>Administration: <?= $page_title ?></title>
		<link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?><br><?php include('_links.php'); ?>
		<table align="center" border="0" cellpadding="10" cellspacing="0">
			<tr>
				<td class="error">
					<?php
							if (isset($success))
								echo "<br>Serial # $serial_id_start - # $serial_id_end has sucessfully been Entered.<br><br>";
							include('_form.php');
					?>
				</td>
			</tr>
		</table>
	</body>
</html>
