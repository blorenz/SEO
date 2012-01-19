#!/usr/local/bin/php
<?php

error_reporting(E_ALL);

include 'gdtd_feed_ds.class.php';

define('FEED_PATH', '/sites/production/feeds/ds');


$dir = new DirectoryIterator(FEED_PATH);
while ($dir->valid()) {
   if (!$dir->isDot()) {
      if(!$dir->isFile()) {
         print 'Skipping non-regular file: ' . $dir->getFilename() . "\n";
         $dir->next();
         continue;
      }

      $fp = @fopen(FEED_PATH . '/'. $dir->getFilename(), 'r');
      
      if (!is_resource($fp)) die("Cannot open file: " . $dir->getFilename());

      $first_line = true;

      $dbh = new PDO('mysql:/host=localhost;dbname=godealertodealer', 'gdtd', 'gdtdlord610');
      $dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
      
      while (($line = fgetcsv($fp, null, chr(9))) !== false) {

         if ($first_line) {
            $first_line = false;
            continue;
         }

         // delete the vehcile if it's not in auction
         $sql = "SELECT id FROM vehicles WHERE vin = '$line[3]' AND fed=1";

         $res = $dbh->query($sql);

         $id = $res->fetchColumn();

         if(!empty($id)) {
            echo "Vin $line[3] in system (v-$id)...";

            
            $sql = "SELECT COUNT(id) FROM auctions
               WHERE vehicle_id = '$id'
               AND status='open'";


            $res = $dbh->query($sql);

            if ($dbh->errorCode() != PDO::ERR_NONE) {
               $err = $dbh->errorInfo();
               throw new Exception($err[2]);
            }

            if ($res->fetchColumn() > 0) {
               echo "in auction.\n";
            } else {
               // delete
               $sql = "DELETE FROM vehicles WHERE id = '$id' LIMIT 1";
               $dbh->query($sql);
               echo "DELETED!\n";
            }
         } else {
            echo "Vin $line[3] not in system.\n";
         }

      }
   }

   $dir->next();
}

