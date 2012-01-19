<?php

include 'gdtd_feed.class.php';

class GDTD_Feed_DS extends GDTD_Feed
{

   protected $feed_name = 'Dealer Specialties'; 
   const logfile = '/sites/production/feeds/logs/ds';

   // redefine the dealer count and info queries to support the Vinstickers Map
   protected $sql_dealer_count = "SELECT COUNT(*) FROM feed_dealers fd 
      WHERE fd.ds = :dealer_id";
   protected $sql_dealer_info = "SELECT dba, d.id, city, state, zip, payment_method
      FROM dealers d, feed_dealers fd WHERE fd.ds = :dealer_id AND 
      d.id = fd.dealer_id";
   
   
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
      $this->dealer_id = trim($data[0]);  // will be overwritten by getDealerData()
      $this->certified = $data[15];
      $this->year = $data[4];
      $this->make = ucfirst(strtolower($data[5]));
      $this->model = $data[6];
      $this->series = $data[8];
      $this->stock_num = $data[2];
      $this->vin = $data[3];
      $this->miles = $data[14];
      $this->engine_size = $data[12];
      $this->transmission = $data[13];
      $this->ext_color = $data[9];
      $this->int_color = $data[10];
      $this->short_desc = "$data[4] $data[5] $data[6]";
      $this->long_desc = $data[17];


      if ($data[1] == 'NEW') {
         $this->new = true;
      } else {
         $this->new = false;
      }

      // check the color values to see if they match our values
      $this->setInteriorColor($this->int_color);
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

      $desert_kia_id = 1837;
      $speedway_id = 1862;
      $wetmore_id = 1864;
      $oracle_id = 1844;
      $green_valley_id = 1857;

      if ($this->dealer_id == $desert_kia_id) {

         // FOR KIA: break out based on store code
         if (strtolower(substr($this->stock_num,0,1)) == 'k') {
            $this->dealer_id = $desert_kia_id;
         }

         if (strtolower(substr($this->stock_num,-1)) == 'a') {
            $this->dealer_id = $speedway_id;
         }
         
         if (strtolower(substr($this->stock_num,-1)) == 'b') {
            $this->dealer_id = $wetmore_id;
         }
         
         if (strtolower(substr($this->stock_num,-1)) == 'c') {
            $this->dealer_id = $oracle_id;
         }
         
         if (strtolower(substr($this->stock_num,-1)) == 'd') {
            $this->dealer_id = $green_valley_id;
         }
         
      }

      if (!isset($this->array_dealer_vins[$this->dealer_id])) {
         $this->array_dealer_vins[$this->dealer_id] = null;
      }
      $this->array_dealer_vins[$this->dealer_id][] = $this->vin;
      

      if (!isset($this->dealer_breakdown[$this->dealer_dba])) {
         $this->dealer_breakdown[$this->dealer_dba] = 0;
      }

      if (!in_array($this->dealer_id, $this->array_dealer_ids)) {
         $this->array_dealer_ids[] = $this->dealer_id;
      }
      
      // if the dealer has the vin, it's the end of the line
      // we might add new photos, we might not, but This Is The End
      if ($this->dealerHasVin()) {
         $this->output("Skipped - Dealer Has This Vin - ");
         $this->skipped['vin_found']++;
         if (true) {
            $v_id = $this->hasPhotos();
            if ($v_id !== true) {
               $photo_array = array();
               
               $first = substr($this->vin, -4, 2);
               $second = substr($this->vin, -2);

               $url = "http://imgs.getauto.com/imgs/ag/ga/$first/$second/a/{$this->vin}-a.jpg";




               $photo_array[] = $url;
               
               
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
      

      // if we don't know this manufacturer, it's the EOL
      if (!$this->getMakeID()) {
         $this->skipped['no_make']++;
         $this->output("Skipped - We don't know the make $this->make\n");
         return;
      }

      // tell the parser engine to get the Model ID
      $this->getModelID();

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

      $photo_array = array();

      $first = substr($this->vin, -4, 2);
      $second = substr($this->vin, -2);

      $url = "http://imgs.getauto.com/imgs/ag/ga/$first/$second/a/{$this->vin}-a.jpg";


      $photo_array[] = $url;
               

      if ($this->addPhotos($photo_array)) {
         $this->added['with_photos']++;
         $this->output("Photos added.\n");
      } else {
         $this->added['no_photos']++;
         $this->output("No photos.");
      }

      return;
   }


}
