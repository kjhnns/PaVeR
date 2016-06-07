<?php
class Rights {
	
	static private $unique_instance = null;

	private $data_pos = null;
	private $data_key = null;
	
	private $data_su = null;
	private $data_us = null;
	
	public $missing = false;
	
	/**
	 * construct
	 * @throws Exception
	 */
	function __construct() {
		if(self::$unique_instance !== null) 
			throw new Exception("Rights kann nur einmal initialisiert werden!");
		$db = new Db();
		
		$db->saveQry("SELECT * FROM `#_rights`");
		$data_pos = array();
		$data_key = array();
		while($row = $db->fetch_assoc()) {
			$this->data_pos[$row['position']] = $row;
			$this->data_key[$row['key']] = $row;
		}

		$data_us = array();
		$data_su = array();
		$db->saveQry("SELECT * FROM `#_station_rights`");
		// WHERE `start` <= NOW() AND NOW() <= `end`");
		while($row = $db->fetch_assoc()) {
			$this->data_su[$row['station']][$row['user']] = true;
			$this->data_us[$row['user']][$row['station']] = true;
		}
		
	}
	
	/**
	 * returns all rights
	 * @return Ambigous <mixed, string>
	 */
	static function allRights() {
		$_u = self::uInstance();
		return $_u->data_key;
	}
	
	/**
	 * label for the right
	 * @param unknown $key
	 */
	static function rLabel($key) {

		$_u = self::uInstance();
		return $_u->data_key[$key]['label'];
	}
	
	/**
	 * if user is worker
	 * @param User $u
	 * @return boolean
	 */
	static function isWorker(User $u = null) {
		if($u === null) $u = User::load();
		return $u->isWorker();
	}
	
	/**
	 * returns all the stations a user owns
	 * @param User $u
	 * @return multitype:unknown
	 */
	static function stations(User $u = null) {
		if($u === null) $u = User::load();
		
		$_u = self::uInstance();
		
		$ret = array();

		if(!isset($_u->data_us[$u->getId()])) return null;
		foreach($_u->data_us[$u->getId()] as $station => $bool) 
			$ret[] = $station;
		
		return $ret;
	}
	
	/**
	 * If user has station
	 * @param Station $s
	 * @param User $u
	 * @return boolean
	 */
	static function hasStation(Station $s, User $u = null) {
		if($u === null)$u = User::load();

		$_u = self::uInstance();
		return ($_u->data_su[$s->getId()][$u->getId()] === true);
	}
	
	/**
	 * is user a customer?
	 * @param User $u
	 * @return boolean
	 */
	static function customer(User $u = null) {
		if($u === null) $u = User::load();
		return !$u->isWorker();
	}
	
	/**
	 * get unique instance
	 * @return Preferences
	 */
	static function uInstance() {
		if(self::$unique_instance === null) 
			self::$unique_instance = new Rights();
		
		return self::$unique_instance;
	}
	
	/**
	 * checks whether the user has the given right
	 * @param unknown $right
	 * @param User $u
	 * @return number
	 */
	static function hasRight($right, User $u = null) {
		if($u === null) $u = User::load();

		$_u = self::uInstance();
		$r = $u->getRights();
		return $r[$_u->data_key[$right]['position']];
	}
	
	/**
	 * position to rights?
	 * @param unknown $pos
	 */
	static function pos2rights($pos) {
		$_u = self::uInstance();
		return $_u->data_pos[$pos];
	}
	
	/**
	 * @todo
	 * @return boolean
	 */
	static function missin() {
		$_u = self::uInstance();
		return $_u->missing;
	}
	
}