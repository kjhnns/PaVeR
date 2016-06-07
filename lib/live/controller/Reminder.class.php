<?php
/**
 * reminder controller
 * @author joh
 *
 */
class Reminder {
	
	/**
	 * cronjob for the reminders
	 */
	static function cron() {
		self::starter();
		self::ender();
	}
	
	/**
	 * insert start reminder for reservation
	 * @param Reservation $res
	 */
	static function start(Reservation $res) {
		$db =  new Db();
		$db->saveQry("INSERT INTO `#_reminder` (`reservation`, `status`) ".
				"VALUES (?,?)", $res->getId(), 'start');
	}
	
	/**
	 * insert end reminder for reservation
	 * @param Reservation $res
	 */
	static function end(Reservation $res) {
		$db =  new Db();
		$db->saveQry("INSERT INTO `#_reminder` (`reservation`, `status`) ".
				"VALUES (?,?)", $res->getId(), 'end');
	}
	
	/**
	 * start reminder necessary?
	 */
	static function starter() {
		$db = new Db();
		$db->saveQry("SELECT `ID` FROM `#_reservations` ".
				"WHERE `startTime` >= CURDATE() AND SUBTIME(`startTime`, ?) <= NOW() AND `status` = 'queued'", 
				Preferences::value("startreminder"));
		
		while($row = $db->fetch_assoc()) {
			$res = Reservation::load($row['ID']);
			if(!self::startSended($res)) {
				Message::startReminder($res);
				self::start($res);
			}
		}
			
	}
	
	/**
	 * was starter already send?
	 * @param Reservation $res
	 * @return boolean
	 */
	static function startSended(Reservation $res) {
		$db =  new Db();
		$db->saveQry("SELECT COUNT(*) as `set` FROM `#_reminder` WHERE `reservation` = ? AND `status` = 'start'",
				$res->getId());
		$res = $db->fetch_assoc();
	 	return (intval($res['set']) > 0);
	}

	/**
	 * end reminder necessary?
	 */
	static function ender() {
		$db = new Db();
		$db->saveQry("SELECT `ID` FROM `#_reservations` ".
				"WHERE `endTime` >= CURDATE() AND SUBTIME(`endTime`, ?) <= NOW() AND `status` = 'progress'",
				Preferences::value("endreminder"));
	
		while($row = $db->fetch_assoc()) {
			$res = Reservation::load($row['ID']);
			if(!self::endSended($res)) {
				Message::endReminder($res);
				self::end($res);
			}
		}
			
	}
	
	/**
	 * was ender already send?
	 * @param Reservation $res
	 * @return boolean
	 */
	static function endSended(Reservation $res) {
		$db =  new Db();
		$db->saveQry("SELECT COUNT(*) as `set` FROM `#_reminder` ".
				"WHERE `reservation` = ? AND `status` = 'end'",
				$res->getId());
		$res = $db->fetch_assoc();
	 	return (intval($res['set']) > 0);
	}
}

?>