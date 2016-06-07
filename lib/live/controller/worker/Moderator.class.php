<?php
/**
 * Service for Moderators
 */
class Moderator {
	/**
	 * stores the database handler
	 * @var Db
	 */
	private static $_db = null;
	
	/**
	 * get station
	 */
	function getStation() {
		return $this->station;
	}

	/**
	 * initiates database connection
	 * & getting the relevant table
	 */
	function __construct() {
		if(self::$_db == null)
			self::$_db = new Db(); 
		$this->station = User::workerGetStation()->getId();
	}
	
	function getStationName() {
		return User::workerGetStation()->getTitle();
	}
	
	/**
	 * get bikes of the current station
	 * @return Ambigous <mixed, string>
	 */
	static function getBikes() {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_bikes` WHERE `station` = ?", User::workerGetStation()->getId());
		while($r = $db->fetch_assoc()) $res[] = $r;
		return $res;
	}
	
	/**
	 * get available bikes
	 * @return Ambigous <boolean, unknown>
	 */
	static function bikesAvail() {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_bikes` WHERE `station` = ?", User::workerGetStation()->getId());
		$res = false;
		while($r = $db->fetch_assoc()) 
			$res = Bike::load($r['ID'])->getDefect()?
												$res: true;
		
		return $res;
	}
	
	/**
	 * cancel reservation
	 * @param unknown $id
	 * @return boolean
	 */
	function cancelReservation($id) {
		self::$_db->saveQry("UPDATE `#_reservations` SET `status` = 'canceled', `canceled` = NOW() WHERE `ID` = ?",
				$id);
		return (self::$_db->affected() >= 1);
	}
	
	/**
	 * forced to cancel use case
	 * @param unknown $uid
	 * @param unknown $rid
	 * @return boolean
	 */
	function forcedToCancel($uid, $rid) {	
		return User::load($uid)->getBooking()->forcedToCancel(Reservation::load($rid));
		
	}

	/**
	 * get all reservations of the current station
	 * @return unknown
	 */
	function getReservations() {
		//caching missin
		self::$_db->saveQry("SELECT * FROM `#_reservations` WHERE ".
				"`startTime` >= ? AND `startstation` = ? AND (`status` = 'queued' ".
				"OR `status` = 'pending' OR `status` = 'prefered') ORDER BY `startTime` ASC",
				date("Y-m-d"), User::workerGetStation()->getId());
		while($r = self::$_db->fetch_assoc()) $res[] = $r;
		return $res;
	}


	/**
	 * get active bookings
	 * @return Ambigous <mixed, string>
	 */
	function getActiveBookings() {
		//caching missin
		self::$_db->saveQry("SELECT *,b.`startTime` as `startTime` FROM `#_bookings` b ".
				 "LEFT JOIN `#_reservations` r ON b.`ID` = r.`booking` ".
				"WHERE b.`endStation` IS NULL");
		while($r = self::$_db->fetch_assoc()) $res[] = $r;
		return $res;
	}

	/**
	 * end booking
	 * @param unknown $uid
	 * @param unknown $comment
	 * @param unknown $bat
	 * @param unknown $stat
	 * @param unknown $access
	 */
	static function endBooking($uid, $comment, $bat, $stat, $access) {
		while(!Db::lock());

		Report::endBooking(User::load(),User::load($uid),$comment, $bat, $stat);
		User::load($uid)->getBooking()->complete(User::workerGetStation(), false, User::load());

		foreach($access['ok'] as $ac) $ac->_return(User::workerGetStation(), true);
		foreach($access['broke'] as $ac) $ac->_return(User::workerGetStation(), false);
		while(!Db::unlock());
	}
	
	/** 
	 * crash use case
	 * @param unknown $uid
	 * @param unknown $comment
	 * @param unknown $access
	 */
	static function crash($uid, $comment, $access) {
		while(!Db::lock());

		Report::crash(User::load(), User::load($uid), $comment);
		User::load($uid)->getBooking()->complete(User::workerGetStation(), true, User::load());

		foreach($access['ok'] as $ac) $ac->_return(User::workerGetStation(), true);
		foreach($access['broke'] as $ac) $ac->_return(User::workerGetStation(), false);
		
		while(!Db::unlock());
	}
	
	/** 
	 * start booking
	 * @param unknown $rID
	 * @param unknown $bID
	 * @param unknown $access
	 * @return Ambigous <boolean, number>
	 */
	static function startBooking($rID, $bID, $access) {
		while(!Db::lock());
		
		$tmp = new Booking(Reservation::load($rID), Bike::load($bID), User::load());
		$_tmp = $tmp->create();
		try {
			foreach($access as $ac) $ac->_book(Booking::load($_tmp));
		} catch(Exception $e) {
			_debug($e->getMessage());
			_debug($e->getTraceAsString());
		}
		
		
		Report::startBooking(	User::load(), Reservation::load($rID)->getUser(), Bike::load($bID), $_tmp);
		

		while(!Db::unlock());
		
		return $_tmp;
	}
}