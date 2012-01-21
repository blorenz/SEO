<?php

$page_title = "Invoices";
$help_page = "chp7.php#Chp7_Unsettledfees";
include('../../../include/session.php');
include('../../../include/db.php');
db_connect();
include('../header.php');
include('_links_months.php');
?>

<style type="text/css" media="print">
#header_top, #header_search, #header_cpanel, #header_nav, #header_test,.noprint {
   display: none;
}

.print {
   width: 100%;
   display: block;
}
</style>

<?php
if(!isset($_GET['month']) || $_GET['month'] == '' || !is_numeric($_GET['month'])) {
   $month = date('m');
} else {
   $month = $_GET['month'];
}

if(!isset($_GET['year']) || $_GET['year'] == '' || !is_numeric($_GET['year'])) {
   $year = date('Y');
} else {
   $year = $_GET['year'];
}

$page = "$_SERVER[SCRIPT_NAME]?year=$year&month=$month";
$header = (isset($_GET['unsettled'])) ? "Invoice: Unsettled Fees" : "Invoice: All Fees";
?>

<p align="center" class="normal noprint">[ <a href="<?php echo $page?>">All Fees</a> | <a href="<?php echo $page . '&unsettled'?>">Unsettled Fees</a> ]</p>

<div class="invoice_months noprint">
<?php 
$i = 1;
$past_12 = prev_months();
echo '| ';
foreach($past_12 as $months) {
   $i = $i++;
   if($months['m'] == $month && $months['y'] == $year) {
      echo "$months[M] $months[y]";
   } else {
      echo "<a href=\"$_SERVER[PHP_SELF]?month=$months[m]&year=$months[y]\">$months[M] $months[y]</a>";
   }
   
   if($i < (count($past_12)-1)) { echo ' | '; }
}

?>
</div>

<?php 
 $query = "SELECT c.id, date_format(c.created,'%M %e %Y') AS createdate, a.title, c.auction_id, c.user_id, c.fee_type, c.status, c.fee, u.username
 FROM charges c
 LEFT OUTER JOIN auctions a on a.id = c.auction_id
 LEFT OUTER JOIN users u on c.user_id = u.id
 WHERE c.dealer_id = '$_SESSION[dealer_id]'
 AND c.created LIKE '$year-$month%'";

    
if(isset($_GET['unsettled'])) $query .= " AND c.status = 'open'";
      
$results = db_do($query);

?>

<h3 style="text-align: center"><?php echo $header ?></h3>

<?php
if(mysql_num_rows($results) < 1) {
   echo '<h4 style="text-align: center;">No fees charged during this month.</h4>';
   include('../footer.php');
   die;
}
?>
   
<div class="tablewrapper">
<table class="invoice">
<tr>
   <th>Date</th>
   <th>Reference No.</th>
   <th>Username</th>
   <th>Auction ID</th>
   <th>Auction Title</th>
   <th>Type</th>
   <th>Status</th>
   <th>Amount</th>
</tr>

<?php

$total = 0;
$i = true;
setlocale(LC_MONETARY, 'en_US');
while($data = mysql_fetch_assoc($results)) {
   $total += $data['fee'];

   $class = ($i) ? ' class="altrow"' : '';
   
   echo "<tr$class>";
   echo "<td$class>" . date('m/d/Y', strtotime($data['createdate'])) . '</td>';
   echo "<td$class>" . date('Ymd', strtotime($data['createdate'])) . '-' . $data['id'] . '</td>';
   echo "<td$class>$data[username]</td>";
   echo "<td$class>$data[auction_id]</td>";
   echo "<td$class>$data[title]</td>";
   echo "<td$class>$data[fee_type]</td>";
   echo "<td$class>" . (($data['status'] == 'open') ? 'unpaid' : 'paid') . '</td>';
   echo "<td$class style=\"text-align: right\">" . money_format('%n', $data['fee']) . '</td>';
   echo '</tr>';

   $i = !$i;
}

echo '<tr>';
echo '<th colspan="7" style="text-align: right;">Total:</th>';
echo '<th style="text-align: right;">' . money_format('%n', $total) . '</th>';
echo '</tr>';
echo '</table>';
echo '</div>';

include('../footer.php');
?>