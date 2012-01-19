<?php
     

function notify_requesters($v_id, $from_feed = null) 
{     

   if ($from_feed === true) {
      require_once '../include/db.php';
      db_connect();
   }
   
   $jc_vehicle_removed_msg = "This is an automatic message from Go DEALER to DEALER.  You have requested an auction for the following vehicle:

Vehicle ID:       %id%
Item:             %item%
VIN/HIN:          %in%

which has since been removed from the system and is unavailable for auction.

Thank you, 
Go DEALER to DEALER

Please do not respond to this message.  This is a system email address that is not able to process incoming email.  Please direct any questions to your Account Executive.";

   
   $d_query = db_do("SELECT dealer_id FROM request_auction WHERE vehicle_id = '$v_id'");
   $v_query = db_do("SELECT CONCAT(year, ' ', make, ' ', model) AS type, vin, hin FROM vehicles WHERE id = $v_id");
   
   $data = mysql_fetch_assoc($v_query);
   
   $in = ($data['vin'] == '') ? $data['hin'] : $data['vin'];
   
   while($dealer = mysql_fetch_assoc($d_query)) {
   
      $results = db_do("select email FROM users u, request_auction ra WHERE u.id = ra.user_id AND ra.vehicle_id = '$v_id'");
      
      $to_list = implode(', ', mysql_fetch_assoc($results));
      
      $jc_vehicle_removed_msg = str_replace('%id%', $v_id, $jc_vehicle_removed_msg);
      $jc_vehicle_removed_msg = str_replace('%in%', $in, $jc_vehicle_removed_msg);
      $jc_vehicle_removed_msg = str_replace('%item%', $data['type'], $jc_vehicle_removed_msg);
      
      $m_sent = mail($to_list, "Requested Item Has Been Removed", $jc_vehicle_removed_msg, GDTD_FROM);
         
      db_do("DELETE FROM request_auction WHERE vehicle_id = $v_id AND dealer_id = $dealer[dealer_id]");
      
      db_do("DELETE FROM alerts WHERE title='Auction Request' and vehicle_id='$v_id'");
   }

   if ($from_feed === true) {
      db_disconnect();
   }

}

function notify_refusal($v_id, $from_feed = null) 
{      

   if ($from_feed === true) {
      require_once '../include/db.php';
      db_connect();
   }

      $jc_request_refused_msg = "This is an automatic message from Go DEALER to DEALER.  You had requested an auction for the following vehicle:

Vehicle ID:       %id%
Item:             %item%
VIN/HIN:          %in%

The auction request has been refused -- the listing dealer does not want to create an auction at this time.  

Thank you,
Go DEALER to DEALER

Please to don't respond to this message.  This is a non-monitored email account.  Please direct any questions to your Accout Executive.";

   
   $d_query = db_do("SELECT dealer_id FROM request_auction WHERE vehicle_id = '$v_id'");
   $v_query = db_do("SELECT CONCAT(year, ' ', make, ' ', model) AS type, vin, hin FROM vehicles WHERE id = $v_id");
   
   $data = mysql_fetch_assoc($v_query);
   
   $in = ($data['vin'] == '') ? $data['hin'] : $data['vin'];
   
   while($dealer = mysql_fetch_assoc($d_query)) {
   
      $results = db_do("select email FROM users u, request_auction ra WHERE u.id = ra.user_id AND ra.vehicle_id = '$v_id'");
      
      $to_list = implode(', ', mysql_fetch_assoc($results));
      

      $jc_request_refused_msg = str_replace('%id%', $v_id, $jc_request_refused_msg);
      $jc_request_refused_msg = str_replace('%in%', $in, $jc_request_refused_msg);
      $jc_request_refused_msg = str_replace('%item%', $data['type'], $jc_request_refused_msg);
      
      $m_sent = mail($to_list, "Auction Request Refused", $jc_request_refused_msg, GDTD_FROM);
         
      db_do("DELETE FROM request_auction WHERE vehicle_id = $v_id AND dealer_id = $dealer[dealer_id]");
      
      db_do("DELETE FROM alerts WHERE title='Auction Request' and vehicle_id='$v_id'");
   }

   if ($from_feed === true) {
      db_disconnect();
   }
}


