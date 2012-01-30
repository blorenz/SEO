<?php

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();
extract(defineVars( "q", "page_title", "no_menu"));    // Added by RJM 1/4/10


if($_GET['vid'] == '' || !isset($_GET['vid'])) {
   header('Location: ../index.php');
   die;
} else {
	$vid = $_GET['vid'];
}

$sql = "SELECT COUNT(*) AS num FROM request_auction WHERE vehicle_id = $vid";
$res = db_do($sql);
list($num) = db_row($res);
if($num < 1) {
   header('Location: ../index.php');
   die;
}

$page_title = "Auction Requested";

$sql = "SELECT photo_id, vin, hin, CONCAT(year, ' ', make, ' ', model) AS type, short_desc, dealer_id FROM vehicles WHERE id = $vid";
$res = db_do($sql);

if(db_num_rows($res) < 1) {
   header('Location: ../index.php');
   die;
}

$data = mysql_fetch_assoc($res);

if($data['dealer_id'] != $_SESSION['dealer_id']) {
   header('Location: ../index.php');
   die;
}

$in = ($data['vin'] == '') ? $data['hin'] : $data['vin'];

if(empty($data['photo_id'])) {
   $result = db_do("SELECT id FROM photos WHERE vehicle_id='$vid' " .
   "ORDER BY id LIMIT 1");

   if (db_num_rows($result) == 1)
   list($photo) = db_row($result);

   db_free($result);

   $src = "../uploaded/$photo.jpg";
} else {
   $src = "../uploaded/$data[photo_id].jpg";
}

include('../header.php');
?>

<div style="text-align: center">

<h3>Auction Requested</h3>

<p>An auction has been requested for the following vehicle:</p>

<?php if(file_exists($src)) { ?>

<img src="<?php echo $src ?>" />

<?php } ?>

<div class="iecenter">
<table style="width: 60%; margin: auto;">
   <tr>
      <th colspan="2"><?php echo $data['type']?></th>
   </tr>
   <tr>
      <th>Vin / Hin</th>
      <td><?php echo $in?></td>
   </tr>
   <tr>
      <th>Description</th>
      <td><?php echo $data['short_desc']?></td>
   </tr>
</table>
</div>

<p>If this item is available, please list it for auction by clicking the button below.</p>
<p>If this item is no longer available, please delete it from your inventory.</p>
<p>Alternatively, if you do not plan to auction this item, click the "Dismiss Request"
button below, which will alert the requesting user that you're not auctioning the item at
this time.  <strong>If you have multiple requests for this item, you will dismiss them
all.</strong></p>

<a href="http://<?php echo $_SERVER['SERVER_NAME']?>/auction/auctions/add.php?vid=<?php echo $vid ?>" class="link_button">Create Auction</a>
<a href="http://<?php echo $_SERVER['SERVER_NAME']?>/auction/vehicles/remove.php?id=<?php echo $vid ?>" class="link_button">Remove Item</a>
<a href="http://<?php echo $_SERVER['SERVER_NAME']?>/auction/vehicles/refuse_request.php?vid=<?php echo $vid ?>" class="link_button">Dismiss Requests</a>

</div>
<?php include('../footer.php');
db_disconnect();
?>
