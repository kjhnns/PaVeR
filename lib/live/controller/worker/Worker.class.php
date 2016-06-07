<?php
/**
 * worker controller
 * @author joh
 *
 */
class Worker {
	/**
	 * get all workers
	 * @return Ambigous <boolean, multitype:, User>
	 */
	static function getWorker() {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_users` WHERE `worker` = 1 ORDER BY `surname`");
		while($r = $db->fetch_assoc()) $res[] = User::load($r['ID']);
		return $res;
	}
	
	/**
	 * edit worker
	 * @param unknown $user
	 * @param unknown $start
	 * @param unknown $end
	 * @param unknown $phone
	 * @param unknown $surname
	 * @param unknown $name
	 * @param unknown $mail
	 * @return boolean
	 */
	static function edit($user, $start, $end, $phone, $surname, $name, $mail) {
		if(!Rights::hasRight("worker")) return false;
		if(!User::load($user)->isWorker()) return false;

		if(empty($name) || empty($mail)) return false;
		$start = new DateTime($start);
		$end = new DateTime($end);
		
		$db = new Db();
		$db->saveQry(	"UPDATE `#_users` SET `start` = ?, `end` = ?, `phone` = ?, ".
						"`name` = ?, `surname` = ?, `email` = ? WHERE `ID` = ?",
						$start->format("Y-m-d H:i"),
						$end->format("Y-m-d H:i"),
						$phone,
						$name,
						$surname,
						$mail,
						User::load($user)->getId()
					);
	}
	
	/**
	 * create worker
	 * @param unknown $start
	 * @param unknown $end
	 * @param unknown $phone
	 * @param unknown $surname
	 * @param unknown $name
	 * @param unknown $mail
	 * @param unknown $rights
	 * @return boolean
	 */
	static function create($start, $end, $phone, $surname, $name, $mail, $rights) {
		if(!Rights::hasRight("worker")) return false;
		
		if(empty($name) || empty($mail)) return false;
		
		$_rights = array();
		for($i = 0; $i < MAX_RIGHT_POS; $i++) $_rights[$i] = false;
		foreach(Rights::allRights() as $key => $dat) 
			if($rights[$key] == '1') $_rights[$dat['position']] = true;

		$_rights = User::RightsArray2Num($_rights);
		
		$db = new Db();
		$pw = rand(111111,999999);
		
		
		$start = new DateTime($start);
		$end = new DateTime($end);
		
		$db->saveQry("SELECT ID FROM `#_users` WHERE `email` = ? LIMIT 1", $mail);
		$_mc = $db->fetch_assoc();
		if(intval($_mc['ID']) > 0) return false;
		
		$db->saveQry("INSERT INTO `#_users` (`start`, `end`, `rights`,`phone`, `surname`, `name`, ".
				"`email`, `password`, `worker`, `creator`) VALUES (?,?,?,?,?,?,?,?,?,?)",
				$start->format("Y-m-d H:i"),
				$end->format("Y-m-d H:i"),
				$_rights,
				$phone,
				$surname,
				$name,
				$mail,
				password($pw),
				1,
				User::load()->getId()
		);
		
		$return = $db->insertID();
		
		
		Message::workerCreated(User::load($return), $pw);
		return true;
	}
	
	/**
	 * reset password
	 * @param unknown $id
	 * @return boolean
	 */
	static function resetPw($id) {

		if(empty($id)) return false;
		$db = new Db();
		$pw = rand(111111,999999);
		$db->saveQry("UPDATE `#_users` SET `password` = ? WHERE `ID` = ?",
				password($pw),
				User::load($id)->getId()
		);
		
		Message::pwChanged(User::load($id), $pw);
		return true;
	}
	
	/**
	 * change worker rights
	 * @param unknown $rights
	 * @param unknown $stations
	 * @param User $user
	 * @return boolean
	 */
	static function changeRights($rights, $stations, User $user) {
		if(!Rights::hasRight("worker")) return false;
		
		$_rights = array();
		for($i = 0; $i < MAX_RIGHT_POS; $i++) $_rights[$i] = false;
		foreach(Rights::allRights() as $key => $dat)
			if($rights[$key] == '1') $_rights[$dat['position']] = true;
		
		$_rights = User::RightsArray2Num($_rights);
		$db = new Db();
		$db->saveQry("UPDATE `#_users` SET `rights` = ? WHERE `ID` = ?", $_rights, $user->getId());
		
		$db->saveQry("DELETE FROM `#_station_rights` WHERE `user` = ?", $user->getId());
		
		foreach($stations as $s => $bool) { $s = Station::load($s);
			$db->saveQry("INSERT INTO `#_station_rights` (`user`, `station`) VALUES (?,?)", $user->getId(), $s->getId());
		}
	}
	
	
}
?>