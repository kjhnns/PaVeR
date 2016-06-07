<?php
class Station extends Model {
	/**
	 * id
	 * @var unknown
	 */
	private $id;
	
	/**
	 * title
	 * @var unknown
	 */
	private $title;
	
	/**
	 * longitude
	 * @var unknown
	 */
	private $longitude;
	
	/**
	 * latitude
	 * @var unknown
	 */
	private $latitude;
	
	/**
	 * power
	 * @var unknown
	 */
	private $power;
	
	/**
	 * slots
	 * @var unknown
	 */
	private $slots;
	
	/**
	 * available stack
	 * @var unknown
	 */
	private $available;
	
	/**
	 * reserved stack
	 * @var unknown
	 */
	private $reserved;
	
	/**
	 * Stations array
	 * @var unknown
	 */
	static private $_stations = null;
	
	function __construct($id) {
		parent::__construct();
		self::$_stations[$id] = $this;
		
		$res = $this->fetchData($id);
		if(!$res) throw new Exception('Empty Result');

		$this->id = $res['ID'];
		$this->title = $res['title'];
		$this->longitude = $res['longitude'];
		$this->latitude = $res['latitude'];

		$this->power = ($res['power']=='1'?true:false);
		$this->slots = intval($res['slots']);

		$this->available = new Stack();
		$this->reserved = new Stack();
		
		$this->loadMyBikes();
		
	}
	
	static function load($id) {
		if(self::$_stations === null) self::$_stations = array();
		
		if(!array_key_exists($id, self::$_stations))
			new Station($id);
		
		return self::$_stations[$id];
	}
	
	private function loadMyBikes() {
		$con = $this->getDb();
		$con->saveQry("SELECT * FROM `#_bikes` WHERE `station` = ? ORDER BY `battery` DESC", $this->id);
		while($res = $con->fetch_assoc()) {
			try {
				$bike = Bike::load($res['ID']);
				if($bike->isAvailable()) $this->available->push($bike);
				else $this->reserved->push($bike);
			} catch(Exception $e) {
				_debug($e->getMessage()." bike ".$res['ID']);
			}
		}
	}
	
	function _reserve() {
		$this->loadMyBikes();
		return true;
	}
	
	function availableBikes() {
		return (int)$this->available->size();
	}
	
	function _book(Bike $bike) {
		$k = $this->available->indexOf($bike);
		$this->available->remove($k);
	}
	
	function _return(Bike $bike) {
		$this->available->push($bike);
	}
	
	static function getAll() {
		$db = new Db();
		$db->saveQry("SELECT ID FROM `#_stations`");
		while($r = $db->fetch_assoc()) $res[] =Station::load($r['ID']);
		return $res;
	}
	
	function getTitle() {
		return $this->title;
	}
	
	function getId() {
		return $this->id;
	}
	
	function getLong() {
		return $this->longitude;
	}
	
	function getLat() {
		return $this->latitude;
	}
	
	function getSlots() {
		return $this->slots;
	}
	
	function getPower(){
		return ($this->power == true);
	}
	
	function __toString() {
		return "[STATION: ". $this->title.", ".
				$this->availableBikes()."/".$this->slots." ]";
	}
}

?>