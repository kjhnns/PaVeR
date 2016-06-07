<?php
/**
 * AGB controller
 * @author joh
 *
 */
class Agb {
	static $curr;
	static $curr_text;
	
	/**
	 * initiates current agb
	 */
	function __construct() {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_agbs` WHERE `ID` = ? LIMIT 1", Preferences::value("agb"));
		$res = $db->fetch_assoc();
		
		self::$curr = Preferences::value("agb");
		self::$curr_text = empty($res['text'])?"NULL":$res['text'];
	}
	
	/**
	 * returns current agb ID
	 */
	static function curr() {
		return self::$curr;
	}	
	
	/**
	 * return agb html
	 * @return string
	 */
	static function text() {
		return self::$curr_text;
	}
	
}
?>