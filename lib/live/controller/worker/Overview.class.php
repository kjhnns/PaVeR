<?php
/**
 * overview controller
 * @author joh
 *
 */
class Overview {
	
	/**
	 * get user reservations by user id
	 * @param string $uid
	 * @return Ambigous <Reservation, multitype:>
	 */
	static function getReservations($uid = null) {
		$_db = new Db();
		if($uid !== null) $_db->saveQry("SELECT ID FROM `#_reservations` ".
				"WHERE `user` = ? ORDER BY `ID` DESC", $uid);
		else $_db->saveQry("SELECT ID FROM `#_reservations` ORDER BY `ID` DESC");
		
		while($res=$_db->fetch_assoc())
			$ret[] = Reservation::load($res['ID']);
		return $ret;
	}
	

	/**
	 * get reservation by reservation id
	 * @param unknown $id
	 * @return Ambigous <Reservation, multitype:>
	 */
	static function getReservation($id) {
		$_db = new Db();
		$_db->saveQry("SELECT ID FROM `#_reservations` ".
				"WHERE `ID` = ?", $id);
		$r = $_db->fetch_assoc(); $res[] = Reservation::load($r['ID']);
		return $res;
	}
}
?>