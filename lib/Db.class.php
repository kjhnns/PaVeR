<?php
/**
 * DB Handler Class
 */
class Db {
	static private $lock = null;
 	static private $conn = false;
	var $qryRes = false;
	static private $prefix;
	var $db;
	

	/**
	 * connecting to database
	 */
	function __construct() {
		if(self::$conn === false) {
			require(CONFIG."_database.php");
			self::$conn = @mysql_connect(	$db_conf['host'],
		  									$db_conf['user'],
		  									$db_conf['password'] );
		  	if(!self::$conn) $this->dbError();
			$this->db = $db_conf['database'];
			self::$prefix = $db_conf['prefix'];
			@mysql_select_db($this->db, self::$conn);
			mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', ".
					"character_set_connection = 'utf8', character_set_database = 'utf8', ".
					"character_set_server = 'utf8'", self::$conn) or _debug("ERROR UTF8 CONVERSION");
			unset($db_conf);
			_debug("db + conn");
		}
	}
	
	/**
	 * lock database 
	 * @return boolean
	 */
	static function lock() {
		if(Preferences::dbLock() != 'null') return false;
		Preferences::set("dbLock", RUNID);
		_debug("DB wurde gelocked");
		return true;
	}
	
	/**
	 * database is locked?
	 * @return boolean
	 */
	static function locked() {
		$db = Preferences::dbLock();
		return  $db != 'null' && $db != RUNID;
	}
	
	/**
	 * unlock database
	 * @return boolean
	 */
	static function unlock() {
		if(Preferences::dbLock() != RUNID) return false;
		Preferences::set("dbLock", 'null');
		_debug("DB wurde unlocked");
		return true;
	}
	
	/**
	 * mysql affected rows
	 * @return number
	 */
	function affected() {
		return mysql_affected_rows(self::$conn);
	}

	/**
	 * destruct method
	 */
	function __destruct() {
		//@mysql_close(self::$conn);
	}
	
	
	/**
	 * checks whether result set is empty
	 * @return boolean
	 */
	function emptyResult() {
		return (mysql_num_rows($this->qryRes) <= 0);
	}

	/**
	 * qrys the database
	 *
	 * @param str qry
	 * @return boolean qryResult
	 */
	private function _qry($str) {
		if(substr($str, 0, 6) !== 'SELECT')
		while(self::locked());
		$start =_microTime();
		$this->qryRes = mysql_query($str, self::$conn);
		$bench = _microTime() - $start;
		$GLOBALS['_GLOBAL_QRYS']++;
		
		if(DEBUG) 
			if($this->qryRes)	_debug($str." ### <i>".$bench."ms</i>");
			else _debug("<b>failed - ".$str."</b>");
		
		return $this->qryRes;
	}

	/**
	 * qrys the database preferences Query only
	 * necessary for the lock/unlock procedure
	 *
	 * @param str qry
	 * @return boolean qryResult
	 */
	function prefQry(Preferences $obj, $str) {

		if(get_class($obj) != 'Preferences') return false;
		
		$args = func_get_args();
		$str = str_replace('#_', self::$prefix, $str);
		
		$start =_microTime();
		$this->qryRes = mysql_query($str, self::$conn);
		$bench = _microTime() - $start;
		$GLOBALS['_GLOBAL_QRYS']++;
		
		if(DEBUG) 
			if($this->qryRes)	_debug("PREFQUERY: ".$str." ### <i>".$bench."ms</i>");
			else _debug("<b>failed - ".$str."</b>");
		
		return $this->qryRes;
	}

	/**
	 * sends a save qry
	 * ? replaces parameters
	 *
	 * @param str qry
	 * @return boolean qryResult
	 */
	function saveQry($qry) {
		$args = func_get_args();
		$_qry = str_replace('#_', self::$prefix, $qry);
		$parts = explode("?",$_qry);
		$pos = strlen($parts[0]);
		for($i = 1; $i< count($args);$i++) {
			$arg = "'".$this->_esc($args[$i])."'";
			$_qry=substr_replace($_qry, $arg, $pos, 1);
			$pos+= strlen($arg) + strlen($parts[$i]);
		}
		return $this->_qry($_qry);
	}

	/**
	 * addslashes and escapes the qry
	 *
	 * @param str qry
	 * @return str qry
	 */
	function _esc($str) {
		if(function_exists('mysql_real_escape_string'))
			return(mysql_real_escape_string($str, self::$conn));
		else if(function_exists('mysql_escape_string'))
			return(mysql_escape_string($str));
		else
			return(addslashes($str));
	}

	/**
	 * mysql_fetch_assoc
	 *
	 * @return mixed
	 */
	function fetch_assoc() {
        while ($row = mysql_fetch_assoc($this->qryRes)) {
            foreach($row as $k => $v) $res[stripslashes($k)]=stripslashes($v);
            return $res;
        }
    }

	/**
	 * mysql_insert_id
	 *
	 * @return int ID
	 */
    function insertID() {
		return mysql_insert_id(self::$conn);
    }

	/**
	 * mysql_free_result
	 */
	function free() {
		mysql_free_result($this->qryRes);
	}

	/**
	 * datebase failure
	 */
	function dbError() {
		echo "datenbank fehler";
		exit;
	}
 }
?>