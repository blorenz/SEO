<?php

include('../../../include/session.php');
include('../../../include/db.php');
include('_requests.php');
extract(defineVars("vid"));  //JJM 1/13/2010  added, even though a few places correctly use $_GET, there are other locations that have forgotten

db_connect();

if($_GET['vid'] == '' || !isset($_GET['vid'])) {
   header('Location: ../index.php');
   die;
}

$sql = "SELECT COUNT(*) AS num FROM request_auction WHERE vehicle_id = $_GET[vid]";
$res = db_do($sql);
list($num) = db_row($res);
if($num < 1) {
   header('Location: ../index.php');
   die;
}

$page_title = "Request Refused";


// actually do the deed
notify_refusal($_GET['vid']);


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

<h3>Request Refused</h3>

<p>All Auction Requests for this vehicle have been dismissed:</p>

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

<p>All auction requests for this item have been deleted, and the requesting users have been
notified that the request has been denied.  This <strong>does not</strong> mean you cannot
create an auction later -- the item is still in your inventory should you want to auction
it later.</p>

<a href="http://<?php echo $_SERVER['SERVER_NAME']?>/auction/vehicles/">Back to My Items</a>

</div>
<?php include('../footer.php');
db_disconnect();
?>
