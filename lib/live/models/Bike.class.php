<?php
class Bike extends Model {
	
	private $id;
	
	private $station = null;

	private $battery;
	
	private $status;
	
	private $type;
	
	private $user = null;
	
	private $booking = null;
	
	static private $_bikes = null;

	/**
	 * Constructor using Bike ID
	 * @param int $id ID
	 * @throws Exception
	 */
	function __construct($id) {
		parent::__construct();
		self::$_bikes[$id] = $this;
		
		$res = $this->fetchData($id);
		if(!$res) throw new Exception('Empty Result');
		$this->id = $res['ID'];

		$this->station = !empty($res['station'])?Station::load((int)$res['station']):
							$this->station = null;

		$this->booking = !empty($res['booking'])?Booking::load((int)$res['booking']):
							$this->booking = null;
		$this->user = !empty($res['user'])?User::load((int)$res['user']):
							$this->user = null;
		
		$this->battery = $res['battery'];
		$this->status = $res['status'];
		$this->type = $res['type'];
	}
	
	static function statusToString($s) {
		switch($s) {
			case '5':	return "5 - Sehr Gut";
			case '4':	return "4 - Gut";
			case '3':	return "3 - Gebraucht";
			case '2':	return "2 - Mängel";
			case '1':	return "1 - Wartung nötig";
			case '0':	return "Wird gewartet";
		}
	}
	
	function getType() {
		switch($this->type) {
			case 'smart':	return 'Smart E-Bike';
			case 'ktm':		return 'KTM e-Style';
			case 'grace':	return 'Grace MX';
		}
	}
	
	/**
	 * loading a bike from database
	 * @param unknown $id
	 * @return Ambigous <multitype:, Bike>
	 */
	static function load($id) {
		if(self::$_bikes === null) self::$_bikes = array();
		
		if(!array_key_exists($id, self::$_bikes))
			new Bike($id);
		
		return self::$_bikes[$id];
	}
	
	/**
	 * association with booking
	 * @param Booking $book
	 * @return boolean
	 */
	function _book(Booking $book) {
		if($this->getDefect()) return false;
		if($this->booking !== null) return false;
		if($this->user !== null) return false;
		if($this->station === null) return false;
		$this->booking = $book;
		$this->station = null;
		
		$db = $this->getDb();
		return 	$db->saveQry("UPDATE `#_bikes` SET ".
				"`user` = ?, `booking` = ?, `station` = NULL ".
				"WHERE `ID` = ?",
				$book->getUser()->getId(),
				$book->getId(),
				$this->id);
	}
	
	/**
	 * returning bike to given endstation
	 * 
	 * @param Station $station
	 * @return boolean
	 */
	function _return(Station $station) {
		if($this->user === null) return false;
		if($this->station !== null) return false;
		$this->user = null;
		$this->station = $station;

		$db = $this->getDb();
		return 	$db->saveQry("UPDATE `#_bikes` SET ".
				"`user` = NULL, `booking` = NULL, `station` = ? ".
				"WHERE `ID` = ?",
				$station->getId(),
				$this->id);
	}
	
	/**
	 * Bike available for booking
	 * @return boolean
	 */
	function isAvailable() {
		return ($this->station !== null && 
				$this->user === null && $this->booking === null
				&& !$this->getDefect());
	}

	/**
	 * Bike ID
	 */
	function getId() {
		return $this->id;
	}
	
	function getName() {
		return "#".$this->id." ".$this->getType();
	}
	
	/**
	 * bike defect?
	 * @return boolean
	 */
	function getDefect() {
		return ($this->status == 0);
	}
	
	/**
	 * current station
	 * @return Ambigous <NULL, Station, unknown>
	 */
	function getStation() {
		return $this->station;
	}
	
	/**
	 * current booking
	 * @return Ambigous <NULL, Booking, multitype:>
	 */
	function getBooking() {
		return $this->booking;
	}
	
	function getUser() {
		return $this->user;
	}
	
	/**
	 * battery life
	 */
	function getBattery() {
		return $this->battery;
	}
	
	/**
	 * status 
	 */
	function getStatus() {
		return $this->status;
	}
	
	function setStatus($status) {
		$db = $this->getDb();
		$db->saveQry("UPDATE `#_bikes` SET `status` = ? WHERE `ID` = ?", $status, $this->id);
	}
	
	function setBattery($bat) {
		$db = $this->getDb();
		$db->saveQry("UPDATE `#_bikes` SET `battery` = ? WHERE `ID` = ?", $bat, $this->id);
	}
	
	public function __toString() {
		return "[BIKE ".$this->id." ]";
	}
}
?>