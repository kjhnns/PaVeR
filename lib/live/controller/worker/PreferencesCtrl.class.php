<?php
/**
 * preferences controller
 * @author joh
 *
 */
class PreferencesCtrl {
	/**
	 * user has access?
	 * @return boolean
	 */
	static function access() {
		return Rights::hasRight("prefAllg") ||
		Rights::hasRight("prefMail") ||
		Rights::hasRight("prefExc");
	}
	
	/**
	 * save new preferences
	 * @param unknown $values
	 * @param unknown $grp
	 * @return boolean
	 */
	static function save($values, $grp) {
		switch($grp) {
			case '1': if(!Rights::hasRight("prefAllg")) return false;
			case '2': if(!Rights::hasRight("prefMail")) return false;
			case '4': if(!Rights::hasRight("prefExc")) return false;
		}
		$db = new Db();
		
		foreach(Preferences::getGroup($grp) as $k => $v)  {
			if($v['type'] == 'bool') $values[$k] = $values[$k]=='1'?'1':'0';
			$db->saveQry("UPDATE `#_preferences` SET  `".$v['type']."_value` = ? ".
					"WHERE `key` = ?", $values[$k],$k);
		}
		return true;
	}
}

?>