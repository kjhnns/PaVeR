<?php
/**
 * Controller for the Index and Registration parts
 * 
 * @author Johannes
 *
 */
class Index {
	/**
	 * stores the database handler
	 * @var Db
	 */
	private static $_db = null;
	
	
	private $sub_nav = null;

	/**
	 * initiates database connection
	 * & getting the relevant table
	 */
	function __construct() {
		if(self::$_db == null)
			self::$_db = new Db();
	}
	
	
	/**
	 * change customer password
	 * @param unknown $a
	 * @param unknown $pw
	 * @param unknown $pww
	 * @return boolean
	 */
	function changePw($a, $pw, $pww) {
		return User::load()->changePw($a, $pw, $pww);
	}
	
	/**
	 * change customer email
	 * @param unknown $m
	 * @param unknown $mw
	 * @return boolean
	 */
	function changeMail($m, $mw) {
		return User::load()->changeMail($m, $mw);
	}
	
	/**
	 * returns the logged in username
	 */
	function getMap() {
		$map = Cache::get("map");
		$this->sub_nav = Cache::get("map_subnav");
		if($this->sub_nav === null || $map === null) {
			if($this->sub_nav === null)
				$this->sub_nav = array();
			$map = new Map();
			self::$_db->saveQry("SELECT `ID` FROM `#_stations`");
			while($r = self::$_db->fetch_assoc()) {
				$station =Station::load($r['ID']);
				$map->addStation($station, 'a#station_'.$r['ID']);
				array_push(
					$this->sub_nav, 
					array(	'id' => 'station_'.$r['ID'], 
							'title' => $station->getTitle() 	)
				);
			}
		}
		return $map->getHtml();
	} 
	
	/**
	 * returns the subnavigation
	 * @return mixed
	 */
	function getSubNav() {
		if($this->sub_nav === null) return null;
		return array_pop($this->sub_nav);
	}
}