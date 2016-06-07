<?php
/** 
 * Accessory Model
 * @author joh
 *
 */
class Accessorie extends Model {

	static private $_access = null;
	
	static private $_categories = null;
	
	private $title;
	private $id;
	private $attr1;
	private $attr2;
	private $attr3;
	private $attr4;
	private $attr5;
	private $station;
	private $bike;
	private $booking;
	private $category;
	private $avail;

	
	/**
	 * get category by id
	 * @param unknown $id
	 * @return Ambigous <multitype:, multitype:unknown Ambigous <NULL, unknown> Ambigous <> >
	 */
	static function getCat($id) {
		self::loadCategories();
		$id = intval($id);
		return self::$_categories[$id];
	}
	
	/**
	 * get all categories
	 * @return Ambigous <multitype:, multitype:unknown Ambigous <NULL, unknown> Ambigous <> >
	 */
	static function getCats() {
		self::loadCategories();
		return self::$_categories;
	}
	
	/**
	 * get accessory by cat and Station
	 * @param unknown $cat
	 * @param Station $station
	 * @return multitype:Ambigous <multitype:, Accessorie>
	 */
	static function getAccess($cat, Station $station) {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_accessories` WHERE `cat` = ? AND `station` = ? AND `del` = '0'",
				$cat, $station->getId());
		$ret = array();
		while($row = $db->fetch_assoc()) 
			if(self::load($row['ID'])->isAvail())
			$ret[] = self::load($row['ID']);
		return $ret;
	}
	
	/**
	 * construct with accessory ID
	 * @param unknown $id
	 * @throws Exception
	 */
	function __construct($id) {
		parent::__construct();
		
		if(self::$_categories == null) 
			self::loadCategories();
		
		self::$_access[$id] = $this;
		
		$res = $this->fetchData($id);
		if(!$res) throw new Exception('Empty Result');

		$this->id = $res['ID'];
		$this->title = $res['title'];
		$this->category = self::$_categories[intval($res['cat'])];
		$this->attr1 = empty($res['attr1'])?null:$res['attr1'];
		$this->attr2 = empty($res['attr2'])?null:$res['attr2'];
		$this->attr3 = empty($res['attr3'])?null:$res['attr3'];
		$this->attr4 = empty($res['attr4'])?null:$res['attr4'];
		$this->attr5 = empty($res['attr5'])?null:$res['attr5'];
		$this->station = empty($res['station'])?null:Station::load($res['station']);
		$this->booking = empty($res['booking'])?null:Booking::load($res['booking']);
		$this->bike = empty($res['bike'])?null:Bike::load($res['bike']);
		$this->avail = $res['avail']=='1'? true: false;
		
	}
	
	/**
	 * load all categories into static variable
	 */
	static function loadCategories() {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_cat_accessories`");
		self::$_categories = array();
		while($row = $db->fetch_assoc()) 
			self::$_categories[$row['ID']] = array(
						"ID" => $row['ID'],
						"title" => $row['title'],
						"limit" => $row['limit'],
						"attr1" => empty($row['attr1'])?null:$row['attr1'],
						"attr2" => empty($row['attr2'])?null:$row['attr2'],
						"attr3" => empty($row['attr3'])?null:$row['attr3'],
						"attr4" => empty($row['attr4'])?null:$row['attr4'],
						"attr5" => empty($row['attr5'])?null:$row['attr5']
					);
	}


	/**
	 * load Accesory by ID
	 * @param unknown $id
	 * @return Ambigous <Accessorie, multitype:>
	 */
	static function load($id) {
		if(self::$_access === null) self::$_access = array();
	
		if(!array_key_exists($id, self::$_access))
			new Accessorie($id);
	
		return self::$_access[$id];
	}
	
	/**
	 * booking an accessory
	 * @param Booking $book
	 * @throws Exception
	 */
	function _book(Booking $book) {
		if($this->getStation() === null)
			throw new Exception("already rent");
		if(!$this->avail)
			throw new Exception("broken or lost");
		
	
		$db = new Db();
		$db->saveQry("UPDATE `#_accessories` SET `station` = NULL, `booking` = ? WHERE `ID` = ? ",
				$book->getId(), $this->id);
		$db->saveQry("INSERT INTO `#_booked_accessories` (`booking`, `accessory`, `broke`) ".
				"VALUES (?,?,?)", $book->getId(), $this->getId(), '0');
	}
	
	/**
	 * returning an accesory
	 * @param Station $s
	 * @param string $broke
	 * @throws Exception
	 */
	function _return(Station $s, $broke = false) {
		if($this->booking === null)
			throw new Exception("no active booking!");
		
		$avail = $broke===true?"1":"0";
		$broke = $broke===false?"1":"0";
		
		$db = new Db();
		$db->saveQry("UPDATE `#_accessories` SET `station` = ?,`avail` = ?, `booking` = NULL WHERE `ID` = ? ",
				$s->getId(),$avail, $this->id);
		$db->saveQry("UPDATE `#_booked_accessories` SET `broke` = ? WHERE `accessory` = ? AND `booking` = ?",
				$broke, $this->id, $this->getBooking()->getId());
	}
	
	
	function getCheckBox() {
		$atts = array();
		
		if($this->attr1!==null)
		$atts[] = $this->getA1Title().": ".$this->getAttr1();
		if($this->attr2!==null)
		$atts[] = $this->getA2Title().": ".$this->getAttr2();
		if($this->attr3!==null)
		$atts[] = $this->getA3Title().": ".$this->getAttr3();
		if($this->attr4!==null)
		$atts[] = $this->getA4Title().": ".$this->getAttr4();
		if($this->attr5!==null)
		$atts[] = $this->getA5Title().": ".$this->getAttr5();
		
		
		if(count($atts) > 0) $atts = " (".implode(", ",$atts).")";
		else $atts = "";
		
		return 	'<input type="hidden" value="0" name="access['.$this->id.']">'.
				'<label for="access_'.$this->id.'">'.
				'<input id="access_'.$this->id.'" type="checkbox" value="1" name="access['.$this->id.']" /> '.
				$this->title.$atts."</label>";
	}
	
	function getSelOption(Bike $pedelec) {
		$atts = array();
		
		if($this->attr1!==null)
		$atts[] = $this->getA1Title().": ".$this->getAttr1();
		if($this->attr2!==null)
		$atts[] = $this->getA2Title().": ".$this->getAttr2();
		if($this->attr3!==null)
		$atts[] = $this->getA3Title().": ".$this->getAttr3();
		if($this->attr4!==null)
		$atts[] = $this->getA4Title().": ".$this->getAttr4();
		if($this->attr5!==null)
		$atts[] = $this->getA5Title().": ".$this->getAttr5();
		
		
		if(count($atts) > 0) $atts = " (".implode(", ",$atts).")";
		else $atts = "";

		if($this->getBike() === null)
		return "<option value=\"".$this->id."\" ".
				">#".$this->id." ".
				$this->title.
				$atts.
				"</option>";

		if($this->getBike()->getId() == $pedelec->getId())
			return "<option value=\"".$this->id."\" ".
			"selected".
			">#".$this->id." ".
			$this->title.
			$atts.
			"</option>";
		
		return "";
	}
	
	function getBooking() {
		return $this->booking;
	}
	
	function getBrokeBooking() {
		$db = new Db();
		$db->saveQry("SELECT `booking` FROM `#_booked_accessories` WHERE `broke` = '1' ".
				"AND `accessory` = ?", $this->id);
		$res = $db->fetch_assoc();
		return Booking::load($res['booking']);
	}

	function getA1Title() {
		return $this->category['attr1'];
	}
	
	function getA2Title() {
		return $this->category['attr2'];
	}

	function getA3Title() {
		return $this->category['attr3'];
	}

	function getA4Title() {
		return $this->category['attr4'];
	}

	function getA5Title() {
		return $this->category['attr5'];
	}
	
	function getAttr1() {
		return $this->attr1;
	}
	
	function getAttr2() {
		return $this->attr2;
	}

	function getAttr3() {
		return $this->attr3;
	}

	function getAttr4() {
		return $this->attr4;
	}

	function getAttr5() {
		return $this->attr5;
	}
	
	function getCategory() {
		return $this->category;
	}
	
	function getId() {
		return $this->id;
	}
	
	function getTitle() {
		return $this->title;
	}
	
	function getStation() {
		return $this->station;
	}
	
	function getBike() {
		return $this->bike;
	}
	
	function isAvail() {
		return $this->avail;
	}
}

?>