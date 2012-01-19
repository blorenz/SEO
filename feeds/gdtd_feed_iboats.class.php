<?php

include 'gdtd_feed.class.php';

class GDTD_Feed_Iboats extends GDTD_Feed
{

   protected $feed_name = 'iBoats'; 
   const logfile = '/sites/production/feeds/logs/iboats';

   // redefine the dealer count and info queries to support the Vinstickers Map
   protected $sql_dealer_count = "SELECT COUNT(*) FROM feed_dealers fd 
      WHERE fd.iboats = :dealer_id";
   protected $sql_dealer_info = "SELECT dba, d.id, city, state, zip, payment_method
      FROM dealers d, feed_dealers fd WHERE fd.iboats = :dealer_id AND 
      d.id = fd.dealer_id";


   protected $iboats_id;

   protected $sql_iboats_categories = "SELECT c.id, c.parent_id, c.subparent_id FROM categories c, categories_iboats ci WHERE ci.iboats_id = :iboats_id AND c.id = ci.categories_id AND c.parent_id != 0 AND c.subparent_id != 0";

   protected $sql_dealer_has_iboat = "SELECT COUNT(*) FROM vehicles 
      WHERE dealer_id = :dealer_id AND iboats_id = :iboats_id";

   protected $sql_get_itemid = "SELECT id FROM vehicles WHERE dealer_id = 
      :dealer_id AND iboats_id = :iboats_id";

   protected $sql_dealer_vins = "SELECT id, iboats_id AS vin FROM vehicles WHERE dealer_id = :dealer_id AND fed = '1'";
   
   protected $query_iboats_categories;
   protected $query_dealer_has_iboat;
   protected $query_get_itemid;


   public function __construct($debug_mode = false)
   {
      parent::__construct();
      
      $this->query_iboats_categories = $this->dbh->prepare($this->sql_iboats_categories);
      $this->query_dealer_has_iboat = $this->dbh->prepare($this->sql_dealer_has_iboat);
      $this->query_get_itemid = $this->dbh->prepare($this->sql_get_itemid);
   }
   
   public function getIboatsCategories($id)
   {
      $this->query_iboats_categories->bindParam(':iboats_id', $id, PDO::PARAM_INT);
      $this->query_iboats_categories->execute();

      $res = $this->query_iboats_categories->fetch(PDO::FETCH_ASSOC);
      $this->category_id = $res['parent_id'];   // first level
      $this->make_id = $res['subparent_id'];    // second level
      $this->model_id = $res['id'];             // third level

      if ($this->category_id == null || $this->make_id == null || $this->model_id == null) {
         return false;
      }
      
      return true;
   }


   public function dealerHasIboat()
   {
      $this->query_dealer_has_iboat->bindParam(':dealer_id', $this->dealer_id);
      $this->query_dealer_has_iboat->bindParam(':iboats_id', $this->iboats_id);
      $this->query_dealer_has_iboat->execute();

      $num = $this->query_dealer_has_iboat->fetchColumn();

      if ($num > 0) {
         return true;
      } else {
         return false;
      }
   }
   
   
   /**
   * hasPhotos (overridden from parent)
   * checks the item for photos.
   * returns the current vehicle.id if we have any photos, false if 
   * there are no photos for this car..
   */
   public function hasPhotos() 
   {
      $this->query_get_itemid->bindParam(':iboats_id', $this->iboats_id);
      $this->query_get_itemid->bindParam(':dealer_id', $this->dealer_id);
      $this->query_get_itemid->execute();
      $item_id = $this->query_get_itemid->fetchColumn();
     
      $this->query_count_photos->bindParam(':vehicle_id', $item_id);
      $this->query_count_photos->execute();
      if ($this->query_count_photos->fetchColumn() > 0) {
         return true;
      } else {
         return $item_id;
      }
   
   }  
   
   
   /**
   * autoDelete (overridden from parent)
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
               // removed becuase iboats doesn't feed a vin, and the dealers
               // don't(?) know the iboats ad id.
               // $msg = str_replace('%Vin%', $row['vin'], $msg);
               $msg = str_replace('%feed_name%', $this->feed_name, $msg);

               mail($email, $subject, $msg, $headers);
            }
         } else {
            $this->output("In feed, keeping.\n");
         }
      }

   }


   // have to define the fucntion to open the logfile here
   public function openLogFile()
   {
      $this->log_fp = @fopen(self::logfile, 'a+');
      if (!is_resource($this->log_fp)) {
         throw new Exception("Cannot open logfile: " . self::logfile);
      }
   }

   // parseData is required
   public function parseData($data)
   {
      $this->iboats_id = $data[0];
      $this->dealer_id = $data[1];  // will be overwritten by getDealerData()
      $this->year = $data[9];
      $this->make = $data[10];
      $this->model = $data[11];
      $this->body = $data[12];
      $this->fuel_type = $data[13];
      $this->hin = '';
      $this->length = ($data[15] / 12); // Length is in inches, divide into feet.
      $this->hours = $data[21];
      $this->engine_size = $data[14];
      $this->engine_make = $data[19];
      $this->horsepower = $data[20];
      $this->seating = $data[25];
      $this->ext_color = $data[27];
      $this->short_desc = "$data[9] $data[10] $data[11]";
      $this->long_desc = strip_tags($data[17]);


      $this->miles = '';


      if (!$this->getIboatsCategories($data[7])) {
         $this->output("Unknown Iboat Cat ID ({$data[7]})\n");
         return;
      }

      if ($data[7] == 'New') {
         $this->new = true;
      } else {
         $this->new = false;
      }
      
      // check the color values to see if they match our values
      $this->setExteriorColor($this->ext_color);

      
      // putput the beginning line...
      $this->output("dID $this->dealer_id - $this->year $this->make " .
            "$this->model - Processing: ");

      // if we can't find the dealer, it's the end of the line
      if (!$this->getDealerData()) {
         $this->output("Skipped - Dealer Unknown\n");
         $this->skipped['no_dealer']++;
         return;
      }
      
      if (!isset($this->array_dealer_vins[$this->dealer_id])) {
         $this->array_dealer_vins[$this->dealer_id] = null;
      }
      $this->array_dealer_vins[$this->dealer_id][] = $this->iboats_id;
      

      if (!isset($this->dealer_breakdown[$this->dealer_dba])) {
         $this->dealer_breakdown[$this->dealer_dba] = 0;
      }

      if (!in_array($this->dealer_id, $this->array_dealer_ids)) {
         $this->array_dealer_ids[] = $this->dealer_id;
      }
      
      // if the dealer has the vin, it's the end of the line
      // we might add new photos, we might not, but This Is The End
      if ($this->dealerHasIboat()) {
         $this->output("Skipped - Dealer Has This Vin - ");
         $this->skipped['vin_found']++;
         if (!empty($data[27])) {
            $v_id = $this->hasPhotos();
            if ($v_id !== true) {

               for($i = 27; $i < 47; $i++) {
                  if ($data[$i] != '') {
                     $photo_array[] = $data[$i];
                  }
               }

               $this->addPhotos($photo_array, $v_id);
               $this->skipped['with_photos']++;
               $this->output("New Photos Added\n");
               return;
            } else {
               $this->output("No New Photos\n");
               return;
            }
         } else {
            $this->output("No New Photos\n");
            return;
         }
      }


      // if the vehicle's too new for the system, End Of Line
      if ($this->checkTooNew()) {
         $this->skipped['too_new']++;
         $this->output("Skipped - Vehicle is too new.\n");
         return;
      }
      

      try {
         $this->insertVehicleData();
      } 
      Catch (PDOException $e) {
         $this->output($e->getMessage() . "\n");
         die();
      }
      Catch (Exception $e) {
         $this->output($e->getMessage() . "\n");
         die();
      }
      
      $this->dealer_breakdown[$this->dealer_dba]++;

      $photo_array = null;
      for($i = 27; $i < 47; $i++) {
         if ($data[$i] != '') {
            $photo_array[] = $data[$i];
         }
      }
      
      if ($this->addPhotos($photo_array)) {
         $this->added['with_photos']++;
         $this->output("Photos added.\n");
      } else {
         $this->added['no_photos']++;
         $this->output("No photos.\n");
      }

      return;
   }


}
