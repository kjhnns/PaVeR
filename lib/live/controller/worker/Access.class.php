<?php
/**
 * accessories controller
 * 
 * @author joh
 *
 */
class Access {
	
	/**
	 * gets Accessories by Categorie ID
	 * 
	 * @param unknown $id Category
	 * @return multitype:Ambigous <multitype:, Accessorie>
	 */
	static function getAccess($id) {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_accessories` WHERE `cat` = ? AND `del` = '0'", $id);
	
		$res = array();
		while($r = $db->fetch_assoc()) $res[] = Accessorie::load($r['ID']);
	
		return $res;
	
	}
	
	/**
	 * get Accessories from a specific station and specific Category
	 * @param unknown $id
	 * @param Station $s
	 * @return multitype:Ambigous <multitype:, Accessorie>
	 */
	static function getStationAccess($id, Station $s) {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_accessories` WHERE `cat` = ? AND `station` = ? AND `del` = '0'", $id, $s->getId());
	
		$res = array();
		while($r = $db->fetch_assoc()) $res[] = Accessorie::load($r['ID']);
	
		return $res;
		
	}
	
	/**
	 * Select all Bikes
	 * @return multitype:Ambigous <Ambigous, multitype:, Bike>
	 */
	static function bikes() {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_bikes` ORDER BY `ID` DESC");
		
		$res = array();
		while($r = $db->fetch_assoc()) $res[] = Bike::load($r['ID']);
		
		return $res;
	}

	/**
	 * get accesories categories
	 * @return multitype:Ambigous <mixed, string>
	 */
	static function getCats() {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_cat_accessories` ORDER BY `title` DESC");
	
		$res = array();
		while($r = $db->fetch_assoc()) $res[] = $r;
	
		return $res;
	}
	
	/**
	 * delete accesory category
	 * @param unknown $id
	 * @return boolean
	 */
	static function delCat($id) {
		$db = new Db();
		$db->saveQry("SELECT COUNT(*) AS `NR` FROM `#_accessories` WHERE `cat` = ?  AND `del` = '0'", $id);
		$nr = $db->fetch_assoc();
		if($nr['NR'] > 0) return false;
		$db->saveQry("DELETE FROM `#_cat_accessories` WHERE `ID` = ?", $id);
		return true;
	}
	
	/**
	 * delete Accessory
	 * @param unknown $id
	 * @return boolean
	 */
	static function delAccess($id) {
		$db = new Db();
		$db->saveQry("UPDATE `#_accessories` SET `del` = '1' WHERE `ID` = ?", $id);
		return true;
	}

	/**
	 * add Categoy
	 * @param unknown $title Category Title
	 * @param unknown $limit limit
	 * @param unknown $a1 optional Attribute
	 * @param unknown $a2 optional Attribute
	 * @param unknown $a3 optional Attribute
	 * @param unknown $a4 optional Attribute
	 * @param unknown $a5 optional Attribute
	 * @return boolean
	 */
	static function addCat($title, $limit, $a1, $a2, $a3, $a4, $a5) {
		if((int)$limit <= 0) return false;
		if(empty($title) || empty($limit)) return false;
	
		$db = new Db();
			return $db->saveQry(	"INSERT INTO `#_cat_accessories` ".
					"(`title`, `limit`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`) ".
					"VALUES (?,?".
					(empty($a1)?",NULL":",'".$db->_esc($a1)."'").
					(empty($a2)?",NULL":",'".$db->_esc($a2)."'").
					(empty($a3)?",NULL":",'".$db->_esc($a3)."'").
					(empty($a4)?",NULL":",'".$db->_esc($a4)."'").
					(empty($a5)?",NULL":",'".$db->_esc($a5)."'").
					")",
					$title, (int)$limit
			);
	}

	/**
	 * edit Category
	 * @param unknown $id
	 * @param unknown $title
	 * @param unknown $a1
	 * @param unknown $a2
	 * @param unknown $a3
	 * @param unknown $a4
	 * @param unknown $a5
	 * @return boolean
	 */
	static function editCat($id, $title, $a1, $a2, $a3, $a4, $a5) {
		if(empty($title) || empty($id)) return false;
	
		$db = new Db();
			return $db->saveQry(	"UPDATE `#_cat_accessories` SET ".
					"`title` = ?, ".
					"`attr1` = ".(empty($a1)?"NULL":"'".$db->_esc($a1)."'").", ".
					"`attr2` = ".(empty($a2)?"NULL":"'".$db->_esc($a2)."'").", ".
					"`attr3` = ".(empty($a3)?"NULL":"'".$db->_esc($a3)."'").", ".
					"`attr4` = ".(empty($a4)?"NULL":"'".$db->_esc($a4)."'").", ".
					"`attr5` = ".(empty($a5)?"NULL":"'".$db->_esc($a5)."'")." ".
					"WHERE `ID` = ?",
					$title, $id
			);
	}
	
	/**
	 * add Accesory
	 * @param unknown $title
	 * @param unknown $cat
	 * @param unknown $bike
	 * @param unknown $station
	 * @param unknown $a1
	 * @param unknown $a2
	 * @param unknown $a3
	 * @param unknown $a4
	 * @param unknown $a5
	 * @return boolean
	 */
	static function addAccess($title,$cat,$bike,$station,
						$a1, $a2, $a3, $a4, $a5 ) {
		if(empty($title)) return false;
		
		$db = new Db();
		$cat = Accessorie::getCat($cat);
		$station = Station::load($station);
		
		if($bike == null) {
			return $db->saveQry(	"INSERT INTO `#_accessories` ".
						"(`title`, `cat`, `bike`, `station`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `creator`) ".
						"VALUES (?,?,NULL,?,".
				($a1== null?'NULL':"'".$db->_esc($a1)."'").",".
				($a2== null?'NULL':"'".$db->_esc($a2)."'").",".
				($a3== null?'NULL':"'".$db->_esc($a3)."'").",".
				($a4== null?'NULL':"'".$db->_esc($a4)."'").",".
				($a5== null?'NULL':"'".$db->_esc($a5)."'").",?)",
					$title, $cat['ID'], $station->getId(),  User::load()->getId()
				);
		}
		$bike = Bike::load($bike);
		return $db->saveQry(	"INSERT INTO `#_accessories` ".
					"(`title`, `cat`, `bike`, `station`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `creator`) ".
					"VALUES (?,?,?,?,".
				($a1== null?'NULL':"'".$db->_esc($a1)."'").",".
				($a2== null?'NULL':"'".$db->_esc($a2)."'").",".
				($a3== null?'NULL':"'".$db->_esc($a3)."'").",".
				($a4== null?'NULL':"'".$db->_esc($a4)."'").",".
				($a5== null?'NULL':"'".$db->_esc($a5)."'").",?)",
				$title, $cat['ID'], $bike->getId(), $station->getId(), User::load()->getId()
			);
		
	}
	
	/**
	 * edit Accesory
	 * @param unknown $title
	 * @param unknown $id
	 * @param unknown $bike
	 * @param unknown $station
	 * @param unknown $a1
	 * @param unknown $a2
	 * @param unknown $a3
	 * @param unknown $a4
	 * @param unknown $a5
	 * @return boolean
	 */
	static function editAccess($title,$id,$bike,$station,
						$a1, $a2, $a3, $a4, $a5 ) {
		if(empty($title)) return false;
		
		$db = new Db();
		$station = Station::load($station);
		
		if($bike !== null) $bike = Bike::load($bike);
		
			return $db->saveQry(	"UPDATE `#_accessories` SET ".
						"`title` = ?, ".
						"`station` = ?, ".
						"`bike` = ".($bike==null?'NULL':"'".$bike->getId()."'").", ".
						"`attr1` = ".($a1== null?'NULL':"'".$db->_esc($a1)."'").",".
						"`attr2` = ".($a2== null?'NULL':"'".$db->_esc($a2)."'").",".
						"`attr3` = ".($a3== null?'NULL':"'".$db->_esc($a3)."'").",".
						"`attr4` = ".($a4== null?'NULL':"'".$db->_esc($a4)."'").",".
						"`attr5` = ".($a5== null?'NULL':"'".$db->_esc($a5)."'").
						" WHERE `ID` = ?",
					$title, $station->getId(), $id
				);
			
	}
	
	
}
?>