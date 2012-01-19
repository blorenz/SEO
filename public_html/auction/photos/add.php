<?php

include('../../../include/session.php');

//get our the variables that we need.
extract(defineVars("vid","submit","files","MAX_FILE_SIZE"));

$files = $_FILES['files'];

if (!has_priv('vehicles', $privs)) {
	header('Location: ../menu.php');
	exit;
}

if (empty($vid) || $vid <= 0) {
	header('Location: ../vehicles/index.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$result = db_do("SELECT dealer_id, short_desc FROM vehicles WHERE id='$vid'");
list($did, $title) = db_row($result);
db_free($result);

if ($did != $dealer_id) {
	header('Location: ../vehicles/index.php');
	exit;
}

$prefix		= $_SERVER['DOCUMENT_ROOT'].'auction/uploaded';
$max_file_size 	= 1024 * 1024;
$thumbnail_size	= '144x144';
$preferred_type	= '.jpg';
$allowed_types	= array("image/bmp", "image/gif", "image/jpeg", "image/pjpeg", "image/png");
$uploadErrors = "";

error_log("files = " . var_export($files,1));

if (isset($submit)) {
	$old_mask = umask(007);

	for ($i = 0; $i < count($files); $i++) {
		$filename = $files['name'][$i];

		//JJM 07/07/2010 - added to display errors to users
		if ($files['error'][$i] == '2')
		{
		error_log("Sorry your file named {$files['name'][$i]} exceeded the file limit.  Please resize and upload again.");
			$uploadErrors .= "Sorry your file named {$files['name'][$i]} exceeded the file limit.  Please resize and upload again.<br>";
			continue;
		}

		if ($files['error'][$i] == '4' ||
		    !in_array($files['type'][$i], $allowed_types))
			continue;

		db_do("INSERT INTO photos SET vehicle_id='$vid', " .
		    "modified=NOW(), created=modified");
		$id = db_insert_id();

		list($width, $height) = getImageSize($files['tmp_name'][$i]);

		if ($width > 500 || $height > 400)
			system("convert -geometry 500x400 " . $files['tmp_name'][$i] . " $prefix/$id.jpg");
		else
			system("convert " . $files['tmp_name'][$i] . " $prefix/$id.jpg");

		$orig_img = imagecreatefromjpeg("../uploaded/$id.jpg");
		$width = imagesx($orig_img);
		$height = imagesy($orig_img);
		#$new_width = ($width/$height)*50;
		#$new_height = 50;

		$new_height = ($height/$width)*65;
		$new_width = 65;

		if ($new_height > 100)
			$new_height = 100;

		$new_img = imagecreatetruecolor($new_width,$new_height);
		imagecopyresized($new_img,$orig_img,0,0,0,0,$new_width,$new_height,imagesx($orig_img),imagesy($orig_img));

		imagejpeg($new_img, "../uploaded/thumbnails/$id.jpg");
	}

	if(empty($uploadErrors)) //JJM 07/07/2010 - added to display errors to users
	{
		db_disconnect();
		umask($old_mask);

		header("Location: index.php?vid=$vid");
		exit;
	}
}

$has_bid = 'no';
$status = 'closed';
$r = db_do("SELECT id, status, current_bid, reserve_price FROM auctions WHERE vehicle_id=$vid ORDER BY created DESC, status DESC LIMIT 1");
if (db_num_rows($r) > 0) {
	list($aid, $status, $current_bid, $reserve_price) = db_row($r);
	if ($status == 'open')
		if ($current_bid > 0)
			$has_bid = 'yes';
}
db_free($r);

$result = db_do("SELECT COUNT(*) FROM photos WHERE vehicle_id=$vid");
list($num_photos) = db_row($result);

$help_page = "chp6_activate.php
";

include('../header.php');
?>
  <br>
  <p align="center" class="big"><b>Manage Photos</b></p>
  <p align="center" class="normal">[ <a href="..">Home</a>
<?php if ($has_bid == 'no')
  		echo " | <a href=\"../vehicles/edit.php?id=$vid\">Edit This Item</a>";
	if ($num_photos > 0)
		echo " | <a href=\"index.php?vid=$vid\">This Item's Images</a>";
	if ($status=='open')
		echo " | <a href=\"../auctions/edit_open.php?id=$aid\">Edit This Auction</a>";
	elseif ($status=='pending')
		echo " | <a href=\"../auctions/edit.php?id=$aid\">Edit This Auction</a>";
	else
		echo " | <a href=\"../auctions/add.php?vid=$vid\">Create This Auction</a>";?> ]</p>
<?php if(!empty($uploadErrors))	echo "<p align='center' class='error'>** $uploadErrors **</p>";?>
<p align="center" class="notice">NOTE - Your photos must be less than 900kb each. If your photos are larger than 900kb,<br>
  edit the photos and schrink to 75 or 50% before uploading.</p>
<p align="center" class="notice">No identifiable company information or advertising is permitted in your photos<br />
  or listings.  (Ref: <a href="../../docs/useragreement.htm" target="_blank">User Agreement</a>, Section 4.4)</p>
<p align="center" class="header"><?php echo $title; ?></p>
  <p align="center" class="normal"><span id="StatusLine">Select images to upload for this item.</span></p>
  <form action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data" method="POST">
   <input type="hidden" name="vid" value="<?php echo $vid; ?>" />
   <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>">
   <table align="center" border="0" cellpadding="5" cellspacing="0">
    <tr>
     <td class="header">Image #1:</td>
     <td class="header"><input name="files[]" type="file" size="35"></td>
    </tr>
    <tr>
     <td class="header">Image #2:</td>
     <td class="header"><input name="files[]" type="file" size="35"></td>
    </tr>
    <tr>
     <td class="header">Image #3:</td>
     <td class="header"><input name="files[]" type="file" size="35"></td>
    </tr>
    <tr>
     <td class="header">Image #4:</td>
     <td class="header"><input name="files[]" type="file" size="35"></td>
    </tr>
    <tr>
     <td class="header">Image #5:</td>
     <td class="header"><input name="files[]" type="file" size="35"></td>
    </tr>
    <tr>
     <td align="center" colspan="2"><input onClick="DisplayMessage()" type="submit" name="submit" value=" Upload "></td>
    </tr>
   </table>
  </form>
<?php include('../footer.php');
db_disconnect();
?>
