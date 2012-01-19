<?php
/**
 * Class RM
 * Abstracts away the RM queries and stores them in a central location
 * TODO: Refactor code.  I know there's a few extraneous methods and members.
 * TODO: Add rudimentary caching of DM information, which is unlikely to change between runs
 * 
 * @package gdtd
 * @author Kaneda
 * 
 * $Id$
 */
class gdtd_RM
{
   /**
    * The real name of the RM
    * @access private
    */
	private $realname = '';
	
	/**
	 * An array with DM information for this RM
	 * @access private
	 */
	private $dms = array();
	
	/**
	 * A PDO database handle
	 * @access private
	 */
	private $dbh = null;
	
	/**
	 * The RM's user id
	 * @access private
	 */
	private $rm_id = '';
	
	/**
	 * The RM's user ID
	 * @access private 
	 */
	private $user_id = '';
	
	/**
	 * Create a new instance.
	 * 
	 * @param int $id the userid of the RM
	 * @param resource $dbh A reference to a valid PDO instantiation.
	 */
	public function __construct($id, &$dbh = null) 
	{
		if ($dbh != null) {
			$this->dbh = $dbh;
		} else {
			$this->dbh = new PDO('mysql:dbhost=localhost;dbname='.DB_NAME,
				DB_USER, DB_PASS);
		}
		
		$this->user_id = $id;
		
		$res = $this->dbh->query("SELECT id FROM 
			rms WHERE user_id = '$this->user_id'");
		
		$this->rm_id = $res->fetchColumn();
		
		if ($this->rm_id < 1) {
			throw new Exception("No RM with that user id ($this->user_id, $this->rm_id)!");
		}
		
	}
	
	/**
	 * Need the RM's real name?  
	 * Does Rudimentary Caching, too!
	 * 
	 * @global int Increments $queries
	 * @return string RM's name
	 */
	public function getRealName() 
	{
		if ($this->realname != '') return $this->realname;
		
		$res = $this->dbh->query("SELECT CONCAT(first_name, ' ', last_name) FROM 
			users WHERE id = '$this->user_id'");
		
		$GLOBALS['queries']++;
		
		return $res->fetchColumn();
	}
	
	/**
	 * Get the name of the Corp the RM represents.
	 *
	 * @return string The corporate name
	 */
	public function getCorpName() 
	{
	   $sql = "SELECT corp_name FROM rms WHERE id = '$this->rm_id'";
	   $res = $this->dbh->query($sql);
	   
	   return $res->fetchColumn();
	}
	
	public function getRMInfo()
	{
	   $sql = "SELECT u.password, rm.corp_name, u.first_name, u.last_name, u.address1,
		u.address2, u.city, u.state, u.zip, u.email, u.phone, u.fax
		FROM rms rm, users u
		WHERE rm.id = '$this->rm_id' AND u.id = rm.user_id";
	   
	   $res = $this->dbh->query($sql);
	   
	   if ($this->dbh->errorCode() != PDO::ERR_NONE) {
	      $err = $this->dbh->errorInfo();
	      throw new Exception($err[2]);
	   }
	   
	   $dms = $res->fetchAll(PDO::FETCH_ASSOC);
	   return $dms;
	   
	}
	
	/**
	 * Get information on the DMs below an RM.
	 * 
	 * @global int Increments $queries
	 * @return array Multidimensional array of DM data.
	 */
	public function getDMInfo() 
	{
	   if (!empty($this->dms)) return $this->dms;
	   
	   $sql = "SELECT u.id AS user_id, 
			CONCAT(u.first_name, ' ', u.last_name) AS name, 
			CONCAT(u.address1, ' ', u.address2, ' ', u.city, ' ', u.state, ' ', 
			u.zip) as address,
			u.phone,
			u.username, u.password, dm.id AS dm_id, COUNT(ae.id) as ae_count
			FROM users u, dms dm, aes ae
			WHERE dm.rm_id = '$this->rm_id' 
			AND dm.user_id = u.id
			AND ae.dm_id = dm.id
			GROUP BY dm.id";
			
	   $res = $this->dbh->query($sql);
	   $GLOBALS['queries']++;
	   
	   if ($this->dbh->errorCode() != PDO::ERR_NONE) {
	      $err = $this->dbh->errorInfo();
	      throw new Exception($err[2]);
	   }
	   
	   $this->dms = $res->fetchAll();
	   return $this->dms;
	}

	/**
	 * Get number of active auctions for all DMs
	 *
	 * @param bool Only get auctions that have met reserve
	 * @param bool Only get auctions ending in 24 hours or less
	 * @global int increments $queries 
	 * @return int Number of active auctions
	 */
	public function getActiveAuctions($sold = false, $endingSoon = false) 
	{
	   $GLOBALS['queries']++;
	   $sql = "SELECT COUNT(a.id) FROM auctions a, dealers d, aes ae, dms dm, 
				  rms rm
              WHERE a.dealer_id = d.id AND d.ae_id = ae.id 
				  AND ae.dm_id = dm.id
				  AND dm.rm_id = rm.id
				  AND rm.id = '$this->rm_id' AND a.status = 'active'";
	   if ($sold) {
	      $sql .= " AND a.current_bid > a.reserve_price";
	   }
	   
	   if ($endingSoon) {
	      $sql .= " AND a.ends >= DATE_ADD(a.ends, INTERVAL +1 DAY)";
	   }
	   
	   $query = $this->dbh->query($sql);
	   $numActiveAuctions = $query->fetchColumn();
	   return $numActiveAuctions;
	   
	}
	
	/**
	 * Get the number of Items that this RM has dominion over
	 * 
	 * @param string Status (optional, defaults to active)
	 * @return int Number of items
	 * @global increments $queries
	 */
	public function getNumItems($status = 'active')
	{
	   $GLOBALS['queries']++;
	   
	   $sql = "SELECT COUNT(v.id) FROM vehicles v, dealers d, aes ae, dms dm,
		rms rm WHERE v.status = :status AND v.dealer_id = d.id AND d.ae_id = ae.id
		AND ae.dm_id = dm.id AND dm.rm_id = '$this->rm_id'";
	   
	   $stmt = $this->dbh->prepare($sql);
	   $stmt->bindParam(':status', $status);
	   $stmt->execute();
	   
		if ($stmt->errorCode() != PDO::ERR_NONE) {
	      $err = $this->dbh->errorInfo();
	    	throw new Exception($err[2]);
	   }
	   
	   return $stmt->fetchColumn();
	}
	
	/**
	 * Grabs the number of Make Offers
	 * 
	 * @param bool Only count offers that have been pending for a day
	 * @return int Number of offers
	 * @global int Increments $queries
	 */
	public function getMakeOffers($urgent = false) 
	{
	   $GLOBALS['queries']++;
	   
	   $sql = "SELECT COUNT(a.id) FROM alerts a, users u, dealers d, aes ae,
              dms dm, rms rm 
				  WHERE a.title IS NULL and a.offer_value > 0 AND a.status =
              'pending' AND a.to_user = u.id AND u.dealer_id = d.id AND 
              d.ae_id = ae.id AND ae.dm_id = dm.id AND dm.rm_id = 
				  '$this->rm_id'";
	   if ($urgent) {
	      $sql .= " AND a.modified >= DATE_ADD(a.modified, INTERVAL +1 DAY)";
	   }
	   
	   $query = $this->dbh->query($sql);
	   $numMakeOffers = $query->fetchColumn();
	   return $numMakeOffers;
	}
	
	/**
	 * Grabs the number of Auction Requests
	 * 
	 * @return int Number of requests
	 * @global int Increments $queries
	 */
	public function getAuctionRequests() 
	{
	   $GLOBALS['queries']++;
		$sql = "SELECT COUNT(ra.id) FROM request_auction ra, dealers d,
				  aes ae, dms dm, rms rm, vehicles v
              WHERE ra.vehicle_id = v.id AND v.dealer_id = d.id AND d.ae_id = 
				  ae.id AND ae.dm_id = dm.id AND dm.rm_id = '$this->rm_id'";
		
		$query = $this->dbh->query($sql);
		$numRequests = $query->fetchColumn();
		return $numRequests;
	}
	
	/**
	 * Grab number of alerts to this RM
	 * 
	 * @return int Number of alerts
	 * @global int increments $queries
	 */
	public function getNumAlerts() 
	{
	   $GLOBALS['queries']++;
	   
	   $sql = "SELECT COUNT(*) FROM alerts WHERE to_user = '$this->user_id'";
	   $res = $this->dbh->query($sql);
	   return $res->fetchColumn();
	}
	
	/**
	 * grab array of alert information
	 * 
	 * @return array (id, from_user, title, auction_id, offer_value, modified)
	 * @global int increments $queries
	 */
	public function getAlerts()
	{
	   $GLOBALS['queries']++;
	   $sql = "SELECT alerts.id, from_user, CONCAT(first_name, ' ', last_name) as from_name,
				  title, auction_id, offer_value, alerts.modified
              FROM alerts, users WHERE to_user = '$this->user_id' AND from_user = users.id";
	   $res = $this->dbh->query($sql);
	   return $res->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Gets the list of DMs: ids and names
	 * Good for generating lists
	 * 
	 * @return array DMs, IDs
	 * @global int Increments $queries
	 */
	public function getDMs() 
	{
	   $sql = "SELECT u.id, CONCAT(u.first_name, ' ', u.last_name) AS name	
			FROM dms dm, users u WHERE u.id = dm.user_id AND dm.rm_id = 
		  	'$this->rm_id'";
	   $res = $this->dbh->query($sql);
	   return $res->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * Send a message to one or all DMs
	 *
	 * @param mixed $to string 'allDMs' or specific DM id
	 * @param string $title The subject
	 * @param string $message the Message
	 * @return bool True or false
	 */
	public function sendMessage($to, $title, $message) 
	{
	   $sql = "INSERT INTO alerts (to_user, from_user, title, description)
			VALUES(:to, '$this->user_id', '$title', '$message')";
	   $stmt = $this->dbh->prepare($sql);
	   
	   if (is_numeric($to)) {
	      $stmt->bindParam(':to', $to);
	      $stmt->execute();
	   	
	   	if ($stmt->errorCode() != PDO::ERR_NONE) {
	      	$err = $this->dbh->errorInfo();
	    	   throw new Exception($err[2]);
	   	}
	   	
	   	return true;
	   }
	   
	   if ($to == 'allDMs') {
	      foreach ($this->getDMs() as $dm) {
	         $stmt->bindParam(':to', $dm['id']);
	         $stmt->execute();
	     		if ($stmt->errorCode() != PDO::ERR_NONE) {
	      		$err = $this->dbh->errorInfo();
	    	   	throw new Exception($err[2]);
	   		}
	      }
	   	return true;
	   }
	}

	/**
	 * Delete RM messages
	 *
	 * @param array $ids An array of alert IDs to delete
	 * @return bool True on success
	 */
	public function deleteMessages($ids)
	{
	   $sql = "DELETE FROM alerts WHERE id = :id";
	   $stmt = $this->dbh->prepare($sql);
	   
	   foreach ($ids as $id) {
	      $stmt->bindParam(':id', $id);
	      $stmt->execute();
	   	
	      if ($stmt->errorCode() != PDO::ERR_NONE) {
	      	$err = $stmt->errorInfo();
	      	throw new Exception($err[2]);
	  		}
	   }
	   
	   return true;
	}
	
	/**
	 * Update DM Percentages
	 * Updates all percentages, as we currently do not flag changed vs. nonchanged percentages.
	 *
	 * @param array $ids Array of DM IDs
	 * @param array $pers Array of DM Percentages, synchs with $ids
	 * @return bool True on success
	 */
	public function updateDMPercentages($ids, $pers)
	{
	   $sql = "UPDATE dms SET percentage = :per WHERE id = :id";
	   $stmt = $this->dbh->prepare($sql);
	   
	   for($i = 0; $i < count($ids); $i++) {
	      $stmt->bindParam(':id', $ids[$i]);
	      $stmt->bindParam(':per', $pers[$i]);
	      $stmt->execute();
	   	
	      if ($stmt->errorCode() != PDO::ERR_NONE) {
	      	$err = $stmt->errorInfo();
	      	throw new Exception($err[2]);
	  		}
	   }
	   
	   return true;
	}
	
	/**
	 * Gets the contents of an alert
	 *
	 * @param int $id The id of the alert
	 * @return array Contains title, desc, and name of sender
	 */
	public function getMessage($id)
	{
	   $sql = "SELECT a.title, a.description u.first_name, u.last_name
		FROM alerts a, users u WHERE a.id = :id AND u.id = a.from_user";

	   $stmt = $this->dbh->prepare($sql);
	   $stmt->bindParam(':id', $id);
	   $stmt->execute();
		
	   if ($stmt->errorCode() != PDO::ERR_NONE) {
	   	$err = $stmt->errorInfo();
	      throw new Exception($err[2]);
	  	}
	  	
	  	return $stmt->fetchAll(PDO::FETCH_ASSOC);
	   
	}

	/**
	 * Get number of dealers for this RM
	 *
	 * @param string $status The status (optional, defaults to active)
	 * @return int Number of dealers matching $status 
	 */
	public function getNumDealers($status = 'active')
	{
	   $sql = "SELECT COUNT(d.id) FROM dealers d, aes ae, dms dm, rms rm
		WHERE d.status = ':status' AND d.ae_id = ae.id AND ae.dm_id = dm.id
		AND dm.rm_id = ':rm_id'";
	   
	   $stmt = $this->dbh->prepare($sql);
	   $stmt->bindParam(':id', $this->rm_id);
	   $stmt->bindParam(':status', $status);
	   $stmt->execute();
	   
	   if ($stmt->errorCode() != PDO::ERR_NONE) {
	      $err = $this->errorInfo();
	      throw new Exception($err[2]);
	   }
	   
	   return $stmt->fetchColumn();
	}

	/**
	 * Changes the RMs password
	 * Verifies the existing password and drops in the new one
	 * Entering the password twice is required by a higher layer
	 *
	 * @param string $oldpass The current password
	 * @param string $newpass The password to change to
	 * @return true on success, throws exception on failure
	 */
	public function changePassword($oldpass, $newpass)
	{
	   $sql = "UPDATE users SET password = :newpass WHERE id = :id AND password = :oldpass";
	   $stmt = $this->dbh->prepare($sql);
	   $stmt->bindParam(':newpass', $newpass);
		$stmt->bindParam(':oldpass', $oldpass);
	   $stmt->bindParam(':id', $this->user_id);
	   $stmt->execute();
	   
	   if ($stmt->errorCode() != PDO::ERR_NONE) {
	      $err = $stmt->errorInfo();
	      throw new Exception($err[2]);
	   }
	   
	   return true;
	}
	
	public function updateProfile($corp_name, $fname, $lname, $add1, $add2, $city, $state, $zip, $email, $phone, $fax) 
	{
	   $sql = "UPDATE rms SET corp_name = :corp_name WHERE id = :id";
	   $stmt = $this->dbh->prepare($sql);
	   $stmt->bindParam(':corp_name', $corp_name);
	   $stmt->bindParam(':id', $this->rm_id);
	   
	   $sql2 = "UPDATE users SET first_name = :fname, last_name = :lname, address1 = :add1, address2 = :add2,
			city = :city, state = :state, zip = :zip, email = :email, phone = :phone, fax = :fax WHERE id = :id";
	   $stmt2 = $this->dbh->prepare($sql2);
	   $stmt2->bindParam(':fname', $fname);
	   $stmt2->bindParam(':lname', $lname);
	   $stmt2->bindParam(':add1', $add1);
	   $stmt2->bindParam(':add2', $add2);
	   $stmt2->bindParam(':city', $city);
	   $stmt2->bindParam(':state', $state);
	   $stmt2->bindParam(':zip', $zip);
	   $stmt2->bindParam(':email', $email);
	   $stmt2->bindParam(':phone', $phone);
	   $stmt2->bindParam(':fax', $fax);
	   $stmt2->bindParam(':id', $this->user_id);
	   
		$stmt->execute();
		$stmt2->execute();
		
		if ($stmt->errorCode() != PDO::ERR_NONE) {
		   $err = $stmt->errorInfo();
		   throw new Exception($err[2]);
		}
		
		if ($stmt2->errorCode() != PDO::ERR_NONE) {
	   	$err = $stmt2->errorInfo();
	   	throw new Exception($err[2]); 
		}
		
		return true;
	}
}
?>
