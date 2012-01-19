<?php
     
include_once('../../../include/db.php');
db_connect();

$tz = date('O');

$new_auction_msg = "This is an automatic message from Go DEALER to DEALER.  An auction has been created for an item you requested!

Title:      %Title%
Start Time: %StartTime% $tz

You can view the auction details here:

http://$_SERVER[SERVER_NAME]/auction/auction.php?id=%AuctionID%

Thank you, 
Go DEALER to DEALER

Please do not respond to this message.  This is a system email address that is not able to process incoming email.  Please direct any questions to your Account Executive.";

function notify_requesters($a_id, $title, $v_id, $start_time) 
{      
   global $new_auction_msg;
   
   $d_query = db_do("SELECT dealer_id FROM request_auction WHERE vehicle_id = '$v_id'");
   
   while($dealer = mysql_fetch_assoc($d_query)) {
   
      $results = db_do("select email FROM users u, dealers d WHERE d.id = $dealer[dealer_id] AND u.dealer_id = d.id AND u.privs LIKE '%buy%'");
      
      $to_list = implode(', ', mysql_fetch_assoc($results));

      $new_auction_msg = str_replace('%Title%', $title, $new_auction_msg);
      $new_auction_msg = str_replace('%StartTime%', $start_time, $new_auction_msg);
      $new_auction_msg = str_replace('%AuctionID%', $a_id, $new_auction_msg);
      
      $m_sent = mail($to_list, "Requested Auction Has Been Created", $new_auction_msg, GDTD_FROM);
         
      db_do("DELETE FROM request_auction WHERE vehicle_id = $v_id AND dealer_id = $dealer[dealer_id]");
      
      db_do("DELETE FROM alerts WHERE title='Auction Request' and vehicle_id='$v_id'");
   }
}
