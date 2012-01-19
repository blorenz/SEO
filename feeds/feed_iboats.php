#!/usr/local/bin/php
<?php

error_reporting(E_ALL);

include 'gdtd_feed_iboats.class.php';

define('FEED_PATH', '/sites/production/feeds/iboats');

$feed = new GDTD_Feed_Iboats();

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

      while (($line = fgetcsv($fp, null, '|')) !== false) {

         // looks like iboats doesn't do a header line on their CSV files
         // so don't skip the first line.
         /*
         if ($first_line) {
            $first_line = false;
            continue;
         }
         */

         $feed->parseData($line);
      }
   }

   $dir->next();
}

foreach ($feed->array_dealer_ids as $did) {
   $feed->autoDelete($did);
}

echo "Deleted $feed->auction_reqs_deleted Auction Requests\n";

$feed->sendEmail();
