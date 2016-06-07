<?php
class Preferences {
	
	static private $unique_instance = null;
	
	private $data = null;
	
	private $groupData = null;
	
	
	function __construct() {
		if(self::$unique_instance !== null) 
			throw new Exception("Preferences kann nur einmal initialisiert werden!");

		$db = new Db();
		
		$db->prefQry($this, "SELECT * FROM `#_preferences`");

		$this->data = array();
		$this->groupData = array();
		while($row = $db->fetch_assoc()) {
			switch($row['type']) {
				case 'varchar': 	$value = $row['varchar_value'];
								break;
				case 'text': 	$value = $row['text_value'];
								break;
				case 'int': 	$value = (int)$row['int_value'];
								break;
				case 'bool': 	$value = $row['bool_value']=='1'?true:false;
								break;
				case 'datetime': 	$value = new DateTime($row['datetime_value']);
								break;
				case 'time': 	$value = $row['time_value'];
								break;
			} 
			
			$this->groupData[$row['group']][$row['key']] =
			$this->data[$row['key']] = array(
						"label" => $row['label'],
						"group" => $row['group'],
						"desc" => empty($row['desc'])?null:$row['desc'],
						"value" => $value,
						"type" => $row['type'],
						"_id" => $row['ID']
					);
		}
	}
	
	static function set($id, $val) {
		$u = self::uInstance();
		$data = $u->_get($id);
		$db = new Db();
		
		$db->saveQry("UPDATE `#_preferences` SET `".$data['type']."_value` = ? WHERE `key` = ?",
				$val, $id) ?  $u->_set($id, $val): false;
		
	}
	
	static function dbLock() {
		$db = new Db();
		
		$db->prefQry(self::uInstance(), "SELECT * FROM `#_preferences` WHERE `key` = 'dbLock'");
		$r = $db->fetch_assoc();
		return $r['varchar_value'];
	}
	
	static function grpName($id) {
		$a = array(1 => "Allgemein", 2 => "E-Mails", 4 => "Warnungen");
		return $a[(int)$id];
	}
	
	static function uInstance() {
		if(self::$unique_instance == null)
			self::$unique_instance = new Preferences();
		
		
		return self::$unique_instance;
	}
	
	static function getGroup($g) {
		$u = self::uInstance();
		return $u->groupData[$g];
	}
	
	static function get($key) {
		$u = self::uInstance();
		return $u->_get($key);
	}
	
	static function value($key) {
		$u = self::uInstance();
		$v = $u->_get($key);
		return $v['value'];
	}
	
	function _get($key) {
		return $this->data[$key];
	}
	
	function _set($key, $val) {
		$this->data[$key]['value'] = $val;
	}
}

?>