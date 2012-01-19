<?php
/**
 * Encapsulates the DM functions
 * 
 * $Id$
 * 
 * @author Kaneda
 * @package GDTD
 */

class gdtd_DM
{   

	/**
    * The real name of the DM
    * @access private
    */
	private $realname = '';

   /**
	 * An array with AE information for this DM
	 * @access private
	 */
	private $aes = array();
	
	/**
	 * A PDO database handle
	 * @access private
	 */
	private $dbh = null;
	
	/**
	 * The DM's DMID
	 * @access private
	 */
	private $id = '';
	
	
	/**
	 * Create a new instance.
	 * 
	 * @param int $id the DMID of the DM
	 * @param resource $dbh A reference to a valid PDO instantiation (optiona.
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
			dms WHERE user_id = '$this->user_id'");
		
		$this->dm_id = $res->fetchColumn();
		
		if ($this->dm_id < 1) {
			throw new Exception("No DM with that user id!");
		}
	}
	
	/**
	 * Need the DM's real name?  
	 * Does Rudimentary Caching, too!
	 * 
	 * @global int Increments $queries
	 * @return string DM's name
	 */
	public function getRealName() 
	{
		if ($this->realname != '') return $this->realname;
		
		$res = $this->dbh->query("SELECT CONCAT(first_name, ' ', last_name) FROM 
			users u, dms dm 
			WHERE dm.id = '$this->id' AND u.id = dm.user_id");
		
		$GLOBALS['queries']++;
		
		return $res->fetchColumn();
	}
	
	/**
	 * Grab specific information about the DM
	 * 
	 * @global int Increments $queries\
	 * @return map of information
	 */
	public function getDMInfo()
	{
	   $sql = "SELECT u.id, u.first_name, u.last_name
			u.city, u.state, u.zip, u.email, u.address1, u.address2
			u.phone FROM users u, dms dm WHERE dm.id = :id AND u.id = dm.user_id";
	   
		$stmt = $this->dbh->prepare($sql);
	   $stmt->bindParam(':id', $this->id);
	   
	   $stmt->execute();
	   
	   if ($stmt->errorCode() != PDO::ERR_NONE) {
	      $err = $stmt->errorInfo();
	      throw new Exception($err[2]);
	   }
	   
	   return $stmt->fetchAll();
	}
	
	/**
	 * Get number of active auctions for all AEs
	 *
	 * @param bool Only get auctions that have met reserve
	 * @param bool Only get auctions ending in 24 hours or less
	 * @global int increments $queries 
	 * @return int Number of active auctions
	 */
	public function getActiveAuctions($sold = false, $endingSoon = false) 
	{
	   $GLOBALS['queries']++;
	   $sql = "SELECT COUNT(a.id) FROM auctions a, dealers d, aes ae, dms dm
              WHERE a.dealer_id = d.id AND d.ae_id = ae.id AND ae.dm_id =
			     '$this->dm_id' AND a.status = 'active'";
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
	 * Get the number of Items that this DM has dominion over
	 * 
	 * @param string Status (optional, defaults to active)
	 * @return int Number of items
	 * @global increments $queries
	 */
	public function getNumItems($status = 'active')
	{
	   $GLOBALS['queries']++;
	   
	   $sql = "SELECT COUNT(DISTINCT v.id) FROM vehicles v, dealers d, aes ae, dms dm
	  	WHERE v.status = :status AND v.dealer_id = d.id AND d.ae_id = ae.id
		AND ae.dm_id = '$this->dm_id'";
	   
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
	   
	   $sql = "SELECT COUNT(DISTINCT a.id) FROM alerts a, users u, dealers d, aes ae,
              dms dm
				  WHERE a.title IS NULL and a.offer_value > 0 AND a.status =
              'pending' AND a.to_user = u.id AND u.dealer_id = d.id AND 
              d.ae_id = ae.id AND ae.dm_id = '$this->dm_id'";
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
		$sql = "SELECT COUNT(DISTINCT ra.id) FROM request_auction ra, dealers d,
				  aes ae, dms dm, rms rm, vehicles v
              WHERE ra.vehicle_id = v.id AND v.dealer_id = d.id AND d.ae_id = 
				  ae.id AND ae.dm_id = '$this->dm_id'";
		
		$query = $this->dbh->query($sql);
		$numRequests = $query->fetchColumn();
		return $numRequests;
	}

	public function getPercentage()
	{
	   $GLOBALS['queries']++;
	   
	   $sql = "SELECT percentage FROM dms WHERE id = '$this->dm_id'";
	   $res = $this->dbh->query($sql);
	   
	   if ($this->dbh->errorCode() != PDO::ERR_NONE) {
	      $err = $this->dbh->errorInfo();
	      throw new Exception($err[2]);
	   }
	   
	   return $res->fetchColumn();
	}
	
	public function getBidsByMonth($month = '')
	{
	   $GLOBALS['queries']++;
	   
	   if (empty($month)) {
	      $month = date('Y-m');
	   }
	   
	   $sql = "SELECT COUNT(DISTINCT b.id) FROM bids b, dealers d, aes ae, dms dm
		WHERE b.created LIKE '$month%' AND b.dealer_id = d.id AND d.ae_id = ae.id 
		AND ae.dm_id = '$this->dm_id'";
	   
	   $res = $this->dbh->query($sql);
	   
	   return $res->fetchColumn();
	}
	
	public function getAuctionsByMonth($month = '', $status = '', $sold = false)
	{
	   $GLOBALS['queries']++;
	   
	   if (empty($month)) {
	      $month = date('Y-m');
	   }
	   
	   $sql = "SELECT COUNT(DISTINCT a.id) FROM auctions a, dealers d, aes ae, 
		dms dm
		WHERE a.created LIKE '$month%' AND a.dealer_id = d.id AND d.ae_id = ae.id 
		AND ae.dm_id = '$this->dm_id'";
	   
	   if (!empty($status)) {
	      $sql .= " AND a.status = '$status'";
	   }
	   
	   if ($sold) {
	      $sql .= " AND a.chaching = 1";
	   }
	   
	   $res = $this->dbh->query($sql);
	   
	   if ($this->dbh->errorCode() != PDO::ERR_NONE) {
	      $err = $this->dbh->errorInfo();
	      throw new Exception($err[2]);
	   }
	   
	   return $res->fetchColumn();
	}
	
	public function getBoughtByMonth($month = '')
	{
	   $GLOBALS['queries']++;
	   
	   if (empty($month)) {
	      $month = date('Y-m');
	   }
	   
	   $sql = "SELECT COUNT(DISTINCT a.id) FROM auctions a, dealers d, aes ae, dms dm, bids b
		WHERE b.created LIKE '$month%' AND b.dealer_id = d.id AND d.ae_id = ae.id 
		AND ae.dm_id = '$this->dm_id' AND a.winning_bid = b.id AND a.chaching = 1
		AND a.status = 'closed'";
	   
	   $res = $this->dbh->query($sql);
	   
	   if ($this->dbh->errorCode() != PDO::ERR_NONE) {
	      $err = $this->dbh->errorInfo();
	      throw new Exception($err[2]);
	   }
	   
	   return $res->fetchColumn();
	}
	
	public function getChargesByMonth($month = '', $paid = false, $type = '')
	{
	   $GLOBALS['queries']++;
	   
	   if (empty($month)) {
	      $month = date('Y-m');
	   }
	   
	   $sql = "SELECT DISTINCT SUM(c.fee) FROM charges c, dealers d, aes ae, dms dm
		WHERE c.created LIKE '$month%' AND c.dealer_id = d.id AND d.ae_id = ae.id 
		AND ae.dm_id = '$this->dm_id'";
	   
	   if ($paid) {
	      $sql .= " AND c.status = 'closed'";
	   }
	   
	   if (!empty($type)) {
	      $sql .= " AND fee_type = '$type'";
	   }
	   
	   $sql .= " GROUP BY dm.id";
	   
	   $res = $this->dbh->query($sql);
	   
	   if ($this->dbh->errorCode() != PDO::ERR_NONE) {
	      $err = $this->dbh->errorInfo();
	      throw new Exception($err[2]);
	   }
	   
	   $charges = $res->fetchColumn();
	   
	   if(empty($charges)) {
	      return 0;
	   } else {
	      return $charges;
	   }
	}

	/**
	 * Get number of dealers for this DM
	 *
	 * @param string $status The status (optional, defaults to active)
	 * @return int Number of dealers matching $status 
	 */
	public function getNumDealers($status = 'active')
	{
	   $sql = "SELECT COUNT(DISTINCT d.id) FROM dealers d, aes ae, dms dm, rms rm
		WHERE d.status = :status AND d.ae_id = ae.id AND ae.dm_id = :id";
	   
	   $stmt = $this->dbh->prepare($sql);
	   $stmt->bindParam(':id', $this->dm_id);
	   $stmt->bindParam(':status', $status);
	   $stmt->execute();
	   
	   if ($stmt->errorCode() != PDO::ERR_NONE) {
	      $err = $this->errorInfo();
	      throw new Exception($err[2]);
	   }
	   
	   return $stmt->fetchColumn();
	}
}
?>
