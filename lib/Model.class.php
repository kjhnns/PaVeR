<?php
/**
 * Model database Handler
 * @author Johannes
 *
 */
class Model {
	/**
	 * stores the database handler
	 * @var Db
	 */
	protected $_db = null;
	
	/**
	 * Model table
	 * @var unknown_type
	 */
	private $_table;
	
	/**
	 * initiates database connection
	 * & getting the relevant table
	 */
	function __construct() {
		if($this->_db == null);
			$this->_db = new Db();
		$this->_table = $this->_db->_esc(strtolower(get_class($this))."s");
	}
	
	/**
	 * returns table
	 * @param unknown_type $id
	 * @return Ambigous <mixed, string>
	 */
	protected function fetchData($id) {
		$this->_db->saveQry("SELECT * FROM `#_".$this->_table."` WHERE `ID` = ?", $id);
		if($this->_db->emptyResult()) return false;
		return $this->_db->fetch_assoc();
	}
	
	/**
	 * returns the Database Handler
	 * @return Db
	 */
	protected function getDb() {
		return $this->_db;
	}
}
?>