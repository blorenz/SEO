<?php

/**
* GDTD Feed * Base class for all feed parsers.  *
* subclasses must define:
*  - const feed_name (name of feed service)
*  - const feed_path (path to files)
*  - function parseData (does the actual data checking using supplied functions)
*
* subclasses might need to override:
*  - protected $sql_dealer_*
*/

abstract class GDTD_Feed
{

   // the database constants
   const db_host = 'localhost';
   const db_name = 'godealertodealer';
   const db_user = 'gdtd';
   const db_pass = 'gdtdJiL';
   const db_type = 'mysql';

   // file paths
   const image_path = '/home/gdtd/public_html/auction/uploaded';
   const thumb_path = '/home/gdtd/public_html/auction/uploaded/thumbnails';

   // must be writeable
   const logfile = '';

   protected $feed_name = '';

   // --- DEBUG MODE ---
   // disables db writing
   // ------------------
   protected $debug_mode = false;
   // --- DEBUG MODE ---

   // log file pointer
   protected $log_fp = null;

   // database handle
   protected $dbh = null;

   // all the SQL that's going to be used
   protected $sql_dealer_count = "SELECT COUNT(*) FROM dealers WHERE id =
      :dealer_id";
   protected $sql_dealer_info = "SELECT dba, id, city, state, zip,
      payment_method FROM dealers WHERE id = :dealer_id";
   protected $sql_vin_count = "SELECT COUNT(*) FROM vehicles WHERE vin =
      :vin AND dealer_id = :dealer_id";
   protected $sql_make_count = "SELECT COUNT(*) FROM categories WHERE
      parent_id = :category_id AND name = :make";
   protected $sql_make_id = "SELECT id FROM categories WHERE
      parent_id = :category_id AND name = :make";
   protected $sql_model_count = "SELECT COUNT(*) FROM categories WHERE
      parent_id = :category_id AND subparent_id = :make_id AND name = :model";
   protected $sql_model_id = "SELECT id FROM categories WHERE parent_id =
      :category_id AND subparent_id = :make_id AND name = :model";
   protected $sql_insert_data = 'INSERT INTO vehicles
      (dealer_id, year, make, model, series, stock_num, vin, miles,
       engine, fuel_type, engine_size, transmission, long_desc, short_desc,
       city, state, zip,
       payment_method, category_id, subcategory_id1, subcategory_id2,
       interior_color, exterior_color, fed, created, certified, hin, hours, body, length,
       engine_make, horsepower, seating, iboats_id) VALUES
      (:dealer_id, :year, :make, :model, :series, :stock_num, :vin, :miles,
       :engine, :fuel_type, :engine_size, :transmission, :long_desc,
       :short_desc, :city, :state,
       :zip, :payment_method, :category_id, :subcategory_id1, :subcategory_id2,
       :interior_color, :exterior_color, 1, NOW(), :certified, :hin, :hours, :body,
       :length, :engine_make, :horsepower, :seating, :iboats_id)';
   protected $sql_insert_photo = "INSERT INTO photos (vehicle_id,
      modified, created) VALUES (:v_id, NOW(), NOW())";
   protected $sql_count_photos = "SELECT COUNT(*) FROM photos WHERE
      vehicle_id = :vehicle_id";
   protected $sql_dealer_vins = "SELECT id, vin FROM vehicles WHERE dealer_id =
      :dealer_id AND fed = 1 AND status='active'";
   protected $sql_delete_vehicle = "UPDATE vehicles SET status='inactive' WHERE id = :id LIMIT 1";
   protected $sql_auction_count = "SELECT COUNT(*) FROM auctions a
      WHERE a.vehicle_id = :vehicle_id AND a.status = 'open'";
   protected $sql_vehicleid_get = "SELECT id FROM vehicles WHERE dealer_id =
      :dealer_id AND vin = :vin";




   // this is the autodelete email that's sent out of the to-be-deleted
   // vehicle is in an auction -- protected var so that a subclass may
   // override it.
   protected $delete_msg = "This is an automated message from Go DEALER to DEALER.

Your inventory company %feed_name% informs us that you no longer have the following vehicle:

Vehicle:    %yearmakemodel%
Vin:        %Vin%

However we cannot remove the vehicle from our site because it is currently in an active auction.

If you NO LONGER HAVE this vehicle, please pull the auction from our site immediately.  It is a violation of of the User Agreement (Section 4.4, Selling) to to list auctions for vehicles you no longer have available.

If you STILL HAVE this vehicle, then feel free to ignore this message, and contact %feed_name% to determine why the vehicle is no longer being advertised as available.

Thank you,
Go DEALER to DEALER.

Note: This is an automated email address, please to do not responod.";



   // all the colors that are valid on the site.
   protected $colors = array('beige', 'black', 'blue', 'brown', 'burgundy',
         'champagne', 'charcoal', 'cream', 'dark green', 'gold', 'green',
         'grey', 'light green', 'maroon', 'multi-color', 'offwhite', 'orange',
         'other', 'pink', 'purple', 'red', 'silver', 'tan', 'turquoise',
         'unavailable', 'white', 'yellow');

   // prepared queries
   protected $query_dealer_count;
   protected $query_dealer_info;
   protected $query_vin_count;
   protected $query_make_count;
   protected $query_make_id;
   protected $query_model_count;
   protected $query_model_id;
   protected $query_insert_data;
   protected $query_insert_photo;
   protected $query_count_photos;
   protected $query_dealer_vins;
   protected $query_delete_vehicle;
   protected $query_auction_count; protected $query_vehicleid_get;


   // data from the database (nondealer)
   protected $category_id = null;
   protected $category = "Passenger Vehicles";
   protected $make_id;
   protected $model_id;

   // data from the feed file
   protected $year;
   protected $make;
   protected $model;
   protected $series;
   protected $stock_num;
   protected $vin;
   protected $miles;
   protected $engine = '';
   protected $engine_size;
   protected $transmission;
   protected $short_desc;
   protected $long_desc;
   protected $int_color;
   protected $ext_color;
   protected $new = false;
   protected $certified = 'No';
   protected $fuel_type = '';
   protected $hin;
   protected $hours = '';
   protected $body = '';
   protected $length;
   protected $engine_make;
   protected $horsepower;
   protected $seating;
   protected $iboats_id = '';

   // data from the Dealers table
   protected $dealer_dba;
   protected $dealer_id;
   protected $dealer_city;
   protected $dealer_state;
   protected $dealer_zip;
   protected $dealer_payment_method;

   // the Vehicle ID (the last auto_increment on the vehicles table)
   protected $last_insert_id;


   // everything below is public -- individual scripts should increment
   // these values as necessary for tracking purposes.
   public $dealer_breakdown = array();
   public $dealer_removed = array();

   public $added = array(
         "with_photos" => 0,
         "no_photos" => 0
         );

   public $skipped = array(
         "vin_found" => 0,
         "too_new" => 0,
         "no_dealer" => 0,
         "no_make" => 0,
         "with_photos" => 0
        );

   // special value - not an increment, but a multidimensional array
   // $this->array_dealer_vins['dealer_id'][] = $vin
   // $this->array_dealer_ids[] = $dealer_id;
   // see the autoDelete function
   public $array_dealer_vins = array();
   public $array_dealer_ids = array();
   public $auction_reqs_deleted = 0;


   /**
    * constructor
    * sets up the db connection, opens a log file,
    * prepares all the queries.
    *
    * might throw Exception (can't open logfile)
    * or PDOException (can't open database)
    */
   public function __construct($set_debug = false)
   {

      if ($set_debug) {
         $this->debug_mode = true;
      }

      $this->openLogFile();

      $dsn = self::db_type . ':host=' . self::db_host . ';dbname=' .
         self::db_name;

      $this->dbh = new PDO($dsn, self::db_user, self::db_pass);
      $this->dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

      $cat_id_results = $this->dbh->query("SELECT id FROM categories WHERE
            parent_id = 0 AND subparent_id = 0 AND name = '$this->category'");
      list($this->category_id) = $cat_id_results->fetch();

      $this->query_dealer_count = $this->dbh->prepare($this->sql_dealer_count);
      $this->query_dealer_info = $this->dbh->prepare($this->sql_dealer_info);
      $this->query_vin_count = $this->dbh->prepare($this->sql_vin_count);
      $this->query_make_count = $this->dbh->prepare($this->sql_make_count);
      $this->query_make_id = $this->dbh->prepare($this->sql_make_id);
      $this->query_model_count = $this->dbh->prepare($this->sql_model_count);
      $this->query_model_id = $this->dbh->prepare($this->sql_model_id);
      $this->query_insert_data = $this->dbh->prepare($this->sql_insert_data);
      $this->query_insert_photo = $this->dbh->prepare($this->sql_insert_photo);
      $this->query_count_photos = $this->dbh->prepare($this->sql_count_photos);
      $this->query_dealer_vins = $this->dbh->prepare($this->sql_dealer_vins);
      $this->query_delete_vehicle =
         $this->dbh->prepare($this->sql_delete_vehicle);
      $this->query_auction_count =
         $this->dbh->prepare($this->sql_auction_count);
      $this->query_vehicleid_get =
         $this->dbh->prepare($this->sql_vehicleid_get);

      $this->output("Run started on: " . date('m/d/Y') . '(' . date(DATE_COOKIE) . ')');
   }


   // parseData should take an array of information and assign it
   // to the proper class members, and do all of the logic --
   // checking values, inserting data, inserting photos, running the
   // autodelete, etc.
   abstract public function parseData($data);

   // openLogFile needs to be defined in the subclass
   abstract public function openLogFile();

   /**
   * getDealerData
   *
   * grabs dealer data from the database, populates the
   * proper class methods
   *
   * returns false if we don't have the dealer, true if we have.
   */
   public function getDealerData()
   {
      $this->query_dealer_count->bindParam(':dealer_id', $this->dealer_id, PDO::PARAM_STR);
      $this->query_dealer_count->execute();
      if ($this->query_dealer_count->fetchColumn() != 1) {
         return false;
      }

      $this->query_dealer_info->bindParam(':dealer_id', $this->dealer_id);
      $this->query_dealer_info->execute();

      list($this->dealer_dba, $this->dealer_id, $this->dealer_city, $this->dealer_state,
            $this->dealer_zip, $this->dealer_payment_method) =
         $this->query_dealer_info->fetch();

      return true;
   }


   /**
   * dealerHasVIn
   * checks the dealer for that Vin.
   * if he has the vin, return false.
   * if he doesn't, return true
   */
   public function dealerHasVin()
   {
      $this->query_vin_count->bindParam(':dealer_id', $this->dealer_id);
      $this->query_vin_count->bindParam(':vin', $this->vin);
      $this->query_vin_count->execute();

      if ($this->query_vin_count->fetchColumn() < 1) {
         return false;
      } else {
         return true;
      }
   }

   /**
   * hasPhotos
   * checks the item for photos.
   * returns the current vehicle.id if we have any photos, false if
   * there are no photos for this car..
   */
   public function hasPhotos()
   {
      $this->query_vehicleid_get->bindParam(':vin', $this->vin);
      $this->query_vehicleid_get->bindParam(':dealer_id', $this->dealer_id);
      $this->query_vehicleid_get->execute();
      $vehicle_id = $this->query_vehicleid_get->fetchColumn();

      $this->query_count_photos->bindParam(':vehicle_id', $vehicle_id);
      $this->query_count_photos->execute();
      if ($this->query_count_photos->fetchColumn() > 0) {
         return true;
      } else {
         return $vehicle_id;
      }
   }

   /**
   * checkTooNew
   * checks to see if the current class members define a vehilce
   * that is "too new" (made in a recent year and flagged as new)
   *
   * may be useless if the feed doesn't specify used vs. new
   */
   public function checkTooNew()
   {
      if ($this->year >= date('Y') && $this->new == true) {
         return true;
      } else {
         return false;
      }
   }

   /**
   * addPhotos
   * rolls through the array of photo urls passed to it
   * and gets the photos via curl.  Resizes them and slaps
   * them in the right place.
   *
   * will throw an exception if it can't open the temporary image file.
   */
   public function addPhotos($photo_array, $v_id = null)
   {
      if (!empty($v_id)) {
         $vehicle_id = $v_id;
      } else {
         $vehicle_id = $this->last_insert_id;
      }

      if (empty($photo_array)) return false;

      $ch = curl_init();
      $i = 0;

      $added = false;
      foreach ($photo_array as $url) {
         $img_fp = @fopen('/home/gdtd/feeds/temp_images/' . $i, 'w');

         $url = trim($url);
         $url = str_replace(' ', '%20', $url);

	 //Debug
	 //print "\nImage URL: ".$url."\n";

         if (!is_resource($img_fp)) {
            throw new Exception("Cannot open the temporary image file.");
         }

         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_FILE, $img_fp);
         curl_exec($ch);

         if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '404') {
            echo '!';
            continue;
         }

         // print error if cURL fails
         if (curl_error($ch) != '') {
            echo '-error-';
            continue;
         }


         fclose($img_fp);

         $this->query_insert_photo->bindParam(':v_id', $vehicle_id);

         $this->query_insert_photo->execute();

         if ($this->query_insert_photo->errorCode() != PDO::ERR_NONE) {
            $arr = $this->query_insert_photo->errorInfo();
            throw new Exception("Error in photo query: $arr[2]");
         }

         $photo_id = $this->dbh->lastInsertId();


         $processThumb = '/usr/bin/convert -geometry 65x48 /home/gdtd/feeds/temp_images/' .
                $i . ' ' . self::thumb_path . '/' . $photo_id . '.jpg';

         $processImage ='/usr/bin/convert -geometry 500x400 /home/gdtd/feeds/temp_images/' .
                $i . ' ' . self::image_path . '/' . $photo_id . '.jpg';


         system($processThumb);

         system($processImage);


         $i++;
         $this->output('.');
         $added = true;
      }

      system('rm -f /home/gdtd/feeds/temp_images/*');

      return $added;
   }

   /**
   * getMakeID
   * searches the database for a category ID that matches a given
   * manufacturer.  Places the id in the proper class method.
   *
   * f this fails, it returns false.  Usually this will mean we don't
   * add anything.
   */
   public function getMakeID()
   {
      $this->make_id = null;

      $this->query_make_count->bindParam(':category_id', $this->category_id);
      $this->query_make_count->bindParam(':make', $this->make);
      $this->query_make_count->execute();

      if ($this->query_make_count->fetchColumn() == 1) {
         $this->query_make_id->bindParam(':category_id', $this->category_id);
         $this->query_make_id->bindParam(':make', $this->make);
         $this->query_make_id->execute();

         $this->make_id = $this->query_make_id->fetchColumn();

         return true;
      } else {
         return false;
      }
   }


   /**
   * getModelID
   * searches the database for a catgeory id that matches a given
   * model.  Assigns it to the proper class method.
   *
   * unlike the make id, if we don't find a model id we'll usually add
   * the item anyway -- the model id will default to 0
   */
   public function getModelID()
   {
      $this->model_id = null;

      $this->query_model_count->bindParam(':category_id', $this->category_id);
      $this->query_model_count->bindParam(':make_id', $this->make_id);
      $this->query_model_count->bindParam(':model', $this->model);
      $this->query_model_count->execute();

      if ($this->query_model_count->fetchColumn() == 1) {

         $this->query_model_id->bindParam(':category_id', $this->category_id);
         $this->query_model_id->bindParam(':make_id', $this->make_id);
         $this->query_model_id->bindParam(':model', $this->model);
         $this->query_model_id->execute();
         $this->model_id = $this->query_model_id->fetchColumn();

         return true;

      } else {
         $this->model_id = 0;
         return false;
      }
   }

   /**
   * setInteriorColor
   * checks the given color against the approved list,
   * and assigns a proper value to the int_color class var.
   * returns true if the color made it in, false if we default out.
   */
   public function setInteriorColor($in_color)
   {
      if (in_array($in_color, $this->colors)) {
         $this->interior_color = $in_color;
         return true;
      } else {
         $this->interior_color = "other";
         return false;
      }
   }
   /*
   * setExteriorColor
   * checks the given color against the approved list,
   * and assigns a proper value to the ext_color class var.
   * returns true if the color made it in, false if we default out.
   */
   public function setExteriorColor($in_color)
   {
      if (in_array($in_color, $this->colors)) {
         $this->exterior_color = $in_color;
         return true;
      } else {
         $this->exterior_color = "other";
         return false;
      }
   }


   /**
   * insertVehicleData
   * binds the parameters to the prepared query and shoots the vehicle
   * data to the database.
   *
   * doesn't return anything -- this may be a Bad Thing,
   * but it *does* add the new vehicle id to the last_vehicle_id class var.
   */
   public function insertVehicleData()
   {
      $this->query_insert_data->bindParam(':dealer_id', $this->dealer_id);
      $this->query_insert_data->bindParam(':year', $this->year);
      $this->query_insert_data->bindParam(':make', $this->make);
      $this->query_insert_data->bindParam(':model', $this->model);
      $this->query_insert_data->bindParam(':series', $this->series);
      $this->query_insert_data->bindParam(':stock_num', $this->stock_num);
      $this->query_insert_data->bindParam(':vin', $this->vin);
      $this->query_insert_data->bindParam(':miles', $this->miles);
      $this->query_insert_data->bindParam(':engine_size', $this->engine_size);
      $this->query_insert_data->bindParam(':fuel_type', $this->fuel_type);
      $this->query_insert_data->bindParam(':engine', $this->engine);
      $this->query_insert_data->bindParam(':transmission', $this->transmission);
      $this->query_insert_data->bindParam(':long_desc', $this->long_desc);
      $this->query_insert_data->bindParam(':short_desc', $this->short_desc);
      $this->query_insert_data->bindParam(':city', $this->dealer_city);
      $this->query_insert_data->bindParam(':state', $this->dealer_state);
      $this->query_insert_data->bindParam(':zip', $this->dealer_zip);
      $this->query_insert_data->bindParam(':payment_method',
            $this->dealer_payment_method);
      $this->query_insert_data->bindParam(':category_id', $this->category_id);
      $this->query_insert_data->bindParam(':subcategory_id1', $this->make_id);
      $this->query_insert_data->bindParam(':subcategory_id2', $this->model_id);
      $this->query_insert_data->bindParam(':interior_color', $this->int_color);
      $this->query_insert_data->bindParam(':exterior_color', $this->ext_color);
      $this->query_insert_data->bindParam(':certified', $this->certified);
      $this->query_insert_data->bindParam(':hin', $this->hin);
      $this->query_insert_data->bindParam(':hours', $this->hours);
      $this->query_insert_data->bindParam(':body', $this->body);
      $this->query_insert_data->bindParam(':length', $this->length);
      $this->query_insert_data->bindParam(':engine_make', $this->engine_make);
      $this->query_insert_data->bindParam(':horsepower', $this->horsepower);
      $this->query_insert_data->bindParam(':seating', $this->seating);
      $this->query_insert_data->bindParam(':iboats_id', $this->iboats_id);


      if (!$this->debug_mode) {
         $this->query_insert_data->execute();

         if ($this->query_insert_data->errorCode() != PDO::ERR_NONE) {
            $err = $this->query_insert_data->errorInfo();
            throw new Exception($err[2]);
         }

         $this->last_insert_id = $this->dbh->lastInsertId();
      }

   }

   /**
   * send_email
   * runs through the public class members and shoots off a summary
   * email to the proper staff members that reports on what just happened.
   */
   public function sendEmail()
   {
      $msg = "The %feed_name% feed parser just finished its scheduled run!

We added %new% vehicles to the site:
   Of those: %with_photos% had photos and %without_photos% did not.";

   if (array_sum($this->skipped) > 0) {
      $msg .= "\n\nWe skipped over %skipped% vehicles:
%reasons%";
   }

   $msg .= "\n\nHere's the breakdown by dealer:

%breakdown%

%removed_breakdown%

Thanks,

GDTD Automated %feed_name% parser.";

      $subject = "$this->feed_name Parser Summary";

      $to = "lbungard@godealertodealer.com, lamar@informustech.com";

      $bcc = "lamar@informustech.com";

      $headers = "From: feeds@godealertodealer.com";

      $reasons = '';

      if ($this->skipped['no_dealer'] > 0) {
         $reasons .= "- {$this->skipped['no_dealer']} because we couldn't find the" .
            " dealer.\n";
      }

      if ($this->skipped['no_make'] > 0) {
         $reasons .= "- {$this->skipped['no_make']} because we don't know that " .
            "manufacturer.\n";
      }

      if ($this->skipped['vin_found'] > 0) {
         $reasons .= "- {$this->skipped['vin_found']} because the dealers had that " .
            "vin already. ({$this->skipped['with_photos']} had new photos.)\n";
      }

      if ($this->skipped['too_new'] > 0) {
         $reasons .= "- {$this->skipped['too_new']} because the vehicle was too " .
            "new.\n";
      }

      $breakdown = '';
      foreach ($this->dealer_breakdown as $dba => $num) {
         $breakdown .= "$dba:\t$num new vehicles.\n";
      }

      $removed_breakdown = '';
      foreach ($this->dealer_removed as $dba => $num) {
         $removed_breakdown .= "$dba:\t$num removed.\n";
      }

      if ($this->auction_reqs_deleted > 0) {
         $removed_breakdown .= "\n\n Also, we busted $this->auction_reqs_deleted " .
            "invalid Auction Requests.\n";
      }

      $msg = str_replace('%feed_name%', $this->feed_name, $msg);
      $msg = str_replace('%new%', array_sum($this->added), $msg);
      $msg = str_replace('%with_photos%', $this->added['with_photos'], $msg);
      $msg = str_replace('%without_photos%', $this->added['no_photos'], $msg);
      $msg = str_replace('%skipped%', array_sum($this->skipped), $msg);
      $msg = str_replace('%reasons%', $reasons, $msg);
      $msg = str_replace('%breakdown%', $breakdown, $msg);
      $msg = str_replace('%removed_breakdown%', $removed_breakdown, $msg);

      mail($to, $subject, $msg, $headers);
   }

   /**
   * output
   * takes a string and outputs it to the client.
   * it *also* writes it to the log file for later examination.
   */
   public function output($in_string)
   {
      $linestart = (strpos($in_string, "\n") === false) ? date('[Ymd g:i:s] ') : '';
      fwrite($this->log_fp, $linestart . $in_string);
      print $in_string;
   }


   /**
   * autoDelete
   * compares a list of vins in the file to a list of vins on the site
   * any vins that appear on the site but not in the file are removed.
   * if there's currently an active auction, we email the dealer a notice.
   */
   public function autoDelete($dealer_id)
   {
      $headers = "From: info@godealertodealer.com";
      $subject = "Inventory Conflict Alert";

      $this->query_dealer_vins->bindParam(':dealer_id', $dealer_id);
      $this->query_dealer_vins->execute();
      $current_vins = $this->query_dealer_vins->fetchAll(PDO::FETCH_ASSOC);

      foreach ($current_vins as $row) {

         $this->output("Vin $row[vin]: ");

         if (!in_array($row['vin'], $this->array_dealer_vins[$dealer_id])) {

            // the vehicle is in the DB but not in the Feed
            $this->query_auction_count->bindParam(':vehicle_id', $row['id'], PDO::PARAM_INT);
            $this->query_auction_count->execute();

            if ($this->query_auction_count->fetchColumn() == 0) {

               foreach ($this->dbh->query("SELECT dba FROM dealers
                        WHERE id = $dealer_id") as $dba_row) {
                  $dba = $dba_row['dba'];
               }

               if (!isset($this->dealer_removed[$dba])) {
                  $this->dealer_removed[$dba] = 0;
               }

               $this->dealer_removed[$dba]++;


               $this->output("Not in feed, deleting!\n");

               $this->deleteAuctionRequests($row['id']);

               $this->query_delete_vehicle->bindParam(':id', $row['id'], PDO::PARAM_INT);
               $this->query_delete_vehicle->execute();

            } else {

               $this->output("Not in feed, in auction!\n");

               $sql = "SELECT year, make, model FROM
                        vehicles WHERE id = '$row[id]'";

               foreach ($this->dbh->query($sql) as $row1) {
                  $type = "$row1[year] $row1[make] $row1[model]";
               }

               foreach ($this->dbh->query("SELECT poc_email FROM dealers
                        WHERE id = $dealer_id") as $row2) {
                  $email = $row2['poc_email'];
               }

               $msg = str_replace('%yearmakemodel%', $type, $this->delete_msg);
               $msg = str_replace('%Vin%', $row['vin'], $msg);
               $msg = str_replace('%feed_name%', $this->feed_name, $msg);

               mail($email, $subject, $msg, $headers);
            }
         } else {
            $this->output("In feed, keeping.\n");
         }
      }

   }

   /**
   * deleteAuctionRequests
   *
   * deletes auction requests that no longer have a vehicle behind them
   */
   public function deleteAuctionRequests($vehicle_id)
   {

      $count = $this->dbh->query("SELECT COUNT(*) FROM request_auction WHERE
            vehicle_id = '$vehicle_id'");

      if ($count->fetchColumn() > 0) {

         // going to include the file we normally use for deleteing these
         // the second param to notify_refusal indicates we're a feed
         include_once '/sites/live/htdocs/auction/vehicles/_requests.php';
         notify_requesters($vehicle_id, true);

         $this->auction_reqs_deleted++;
      }

   }

} // the point of no return
