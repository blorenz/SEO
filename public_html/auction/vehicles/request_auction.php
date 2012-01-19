<?php
include('../../../include/session.php');
include('../../../include/db.php');
include('../../../include/back2search.php');
db_connect();

$page_title = "Request Auction";

if($_POST['submit'] == 'Request Auction') {

if(!is_numeric($_POST['vid']) || $_POST['vid'] == '') {
      header('Location: index.php');
      die;
   }

   $results = db_do("select year, make, model, short_desc, stock_num, vin, hin FROM vehicles WHERE id = '$_POST[vid]'");
   $data = mysql_fetch_assoc($results);

   if($data['stock_num'] == '') $data['stock_num'] == 'N/A';
   if($data['vin'] == '') {
      $in = $data['hin'];
   } else {
      $in = $data['vin'];
   }
   $results = db_do("select email FROM users u, dealers d, vehicles v WHERE v.id = $_POST[vid] AND v.dealer_id = d.id AND u.dealer_id = d.id AND u.privs LIKE '%sell%'");

   $to_list = implode(', ', mysql_fetch_assoc($results));

   $msg = "Another member has expressed interest in an item you have listed, but is not currently in an active auction.

   Stock Num: $data[stock_num]
   Year:      $data[year]
   Make:      $data[make]
   Model:     $data[model]
   VIN/HIN:   $in

   Click the following link to view options for this item:

   http://$_SERVER[SERVER_NAME]/auction/vehicles/auction_requested.php?vid=$_POST[vid]

   Remember, another member is eagerly awaiting this item!

   Thanks,
   Go DEALER to DEALER

   This is an automated message from Go DEALER to DEALER.  Please do not respond to this message.  This is a system email address that is not able to process incoming email.  Please direct any questions to your Account Executive.";

   mail($to_list, "Auction Request", $msg, GDTD_FROM);

   /* record that the dealer requested the auction */
   $req_sql = "INSERT INTO request_auction(dealer_id, vehicle_id, user_id, created) VALUES('$_SESSION[dealer_id]', '$_POST[vid]', '$_SESSION[userid]', now())";
   db_do($req_sql);

   $results = db_do("select u.id FROM users u, dealers d, vehicles v WHERE v.id = $_POST[vid] AND v.dealer_id = d.id AND u.dealer_id = d.id AND u.privs LIKE '%sell%'");

   while($data = mysql_fetch_assoc($results)) {
      // don't set a from_user value to maintain anonymity
      db_do("INSERT INTO alerts(to_user, title, description, vehicle_id)
      VALUES('$data[id]', 'Auction Request', 'Another member has requested you put vehicle id $_POST[vid] up for auction!<br /><a href=\"http://$_SERVER[SERVER_NAME]/auction/auctions/add.php?vid=$_POST[vid]\">Click here to add the auction.</a>', '$_POST[vid]')");
   }

   include('../header.php');
   ?>
   <h3 align="center">Request Successful</h3>

   <p>The dealer has been sent an email and an alert requesting that the item be put into auction.  When the auction is created, you will be notified via email that the auction is pending, and when the auction will start.</p>

   <?php back2search(); ?>
   <a href="/auction/index.php">Click here to return to the auctions page.</a>


   <?php
   include('../footer.php');
   die;
}



/* No id, send 'em home */
if($_GET['vid'] == '' || !isset($_GET['vid']) || !is_numeric($_GET['vid'])) {
   header('Location: ../index.php');
   die;
}

include('../header.php');

/* don't let them re-request the auction! */
$res = db_do("SELECT COUNT(*) FROM request_auction WHERE vehicle_id = $_GET[vid] AND dealer_id = $_SESSION[dealer_id]");
list($rows) = db_row($res);
if($rows > 0) {
   ?>
   <h3>You have already requested an auction for this vehicle</h3>
   <?php
   include('../footer.php');
   die;
}

$results = db_do("SElECT id, CONCAT(year, ' ', make, ' ', model) AS type FROM vehicles WHERE id = '$_GET[vid]'");

$row = db_row($results);

?>

<h3>Request Auction</h3>
<h4><?php echo $row['type'] ?></h4>

<p>You are about to request an auction for this vehicle.  This will alert the selling dealer that there is interest in this vehicle via email.  The email will be sent from our system, none of your identifiable information is disclosed.  When the auction is about ready to become active, the system will send you an email to let you know.  </p>

<p>If this is satisfactory, click the button below.  Otherwise, navigate away from this page.</p>

<form action="<?php echo $_SERVER['php_self'] ?>" method="post">
<p style="text-align: center">
   <input type="submit" name="submit" value="Request Auction" style="font-size: 120%;" />
</p>
<input type="hidden" name="vid" value="<?php echo $_GET['vid'] ?>" />
</form>

<?php
include '../footer.php';
?>
