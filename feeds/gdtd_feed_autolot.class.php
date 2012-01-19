<?php

include 'gdtd_feed.class.php';

class GDTD_Feed_Autolot extends GDTD_Feed
{

   protected $feed_name = 'Autolot'; 
   const logfile = '/sites/production/feeds/logs/autolot_incoming';

   // redefine the dealer count and info queries to support the Vinstickers Map
   protected $sql_dealer_count = "SELECT COUNT(*) FROM feed_dealers fd 
      WHERE fd.autolot = :dealer_id";
   protected $sql_dealer_info = "SELECT dba, d.id, city, state, zip, payment_method
      FROM dealers d, feed_dealers fd WHERE fd.autolot = :dealer_id AND 
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
      $this->dealer_id = $data[0];  // will be overwritten by getDealerData()
      $this->year = $data[4];
      $this->make = $data[5];
      $this->model = $data[6];
      $this->series = $data[7];
      $this->stock_num = $data[1];
      $this->vin = $data[2];
      $this->miles = $data[12];
      $this->engine_size = $data[8];
      $this->transmission = $data[8];
      $this->ext_color = $data[11];
      $this->int_color = $data[12];
      $this->short_desc = "$data[4] $data[5] $data[6]";
      $this->long_desc = $data[14];

      if ($data[1] == 'new') {
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
         if (!empty($data[16])) {
            $v_id = $this->hasPhotos();
            if ($v_id !== true) {
               $photo_array = explode(',', $data[16]);
               if ($this->addPhotos($photo_array, $v_id)) {
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

      $photo_array = null;
      $photo_array = explode(',', $data[16]);
      
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
