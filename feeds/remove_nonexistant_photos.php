#!/usr/local/bin/php
<?php

/**
* Removes entries from the photos table where the actual file
* is not present on the server.

* By: Jon Canady
* $Id: remove_nonexistant_photos.php 102 2006-05-17 19:25:55Z kaneda $
*/

error_reporting(E_ALL);

define('DB_RDBMS', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'godealertodealer');
define('DB_USER', 'gdtd');
define('DB_PASS', 'gdtdJiL');
define('THUMB_PATH', '/home/gdtd/public_html/auction/uploaded/thumbnails');
define('IMG_PATH', '/home/gdtd/public_html/auction/uploaded');



$dbh = new PDO(DB_RDBMS . ":host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER,
      DB_PASS);

$dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 1);
$kept = 0;
$removed = 0;

$rm_query = $dbh->prepare("DELETE FROM photos WHERE id = :id");

$sql = "SELECT id FROM photos";

foreach ($dbh->query($sql) as $row) {

   $file = '/' . $row['id'] . '.jpg';

   if (!file_exists(THUMB_PATH . $file) ||
       !file_exists(IMG_PATH . $file)) {

     $rm_query->bindParam(':id', $row['id']);
     $rm_query->execute();

     $removed++;

   } else {

      $kept++;

   }
}

print "\n";
print "-----Results-----\n";
print "Kept: $kept\tRemoved:$removed\n\n";
