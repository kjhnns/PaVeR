<?php
/**
 * Bike controller
 * @author joh
 *
 */
class Bikes {
	/**
	 * get all bikes
	 * @return Ambigous <Ambigous, multitype:, Bike>
	 */
	static function all() {
		$db = new Db();
		$db->saveQry("SELECT `ID` FROM `#_bikes`");
		while($r = $db->fetch_assoc()) $res[] = Bike::load($r['ID']);
		return $res;
	}
	
	/**
	 * get all bikes as html options
	 * @param Station $station
	 * @return string
	 */
	static function options(Station $station) {
		foreach(Station::getAll() as $s)
			$res .= "<option value=\"".$s->getId()."\" ".
			($s->getId() == $station->getId()?'selected': '').">".$s->getTitle()."</option>";
		return $res;
	}
	
}
?>