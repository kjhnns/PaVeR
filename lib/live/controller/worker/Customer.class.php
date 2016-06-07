<?php
/**
 * Customer controller
 * @author joh
 *
 */
class Customer {
	/**
	 * get all customers
	 * @return Ambigous <boolean, multitype:, User>
	 */
	static function get() {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_users` WHERE `worker` = 0 ORDER BY `surname`");
		while($r = $db->fetch_assoc()) $res[] = User::load($r['ID']);
		return $res;
	}
	
	/**
	 * edit customer
	 * @param unknown $user
	 * @param unknown $start
	 * @param unknown $end
	 * @param unknown $phone
	 * @param unknown $manr
	 * @param unknown $surname
	 * @param unknown $name
	 * @param unknown $mail
	 * @param unknown $birth
	 * @param unknown $major
	 * @param unknown $street
	 * @param unknown $zip
	 * @param unknown $home
	 * @return boolean
	 */
	static function edit($user, $start, $end, $phone, $manr, $surname, $name, $mail,
				$birth, $major, $street, $zip, $home) {
		if(!Rights::hasRight("customers")) return false;
		if(User::load($user)->isWorker()) return false;

		if(empty($name) || empty($mail)) return false;
		$start = new DateTime($start);
		$end = new DateTime($end);
		
		$birth = new DateTime($birth);
		
		$db = new Db();
		$db->saveQry(	"UPDATE `#_users` SET `start` = ?, `end` = ?, `phone` = ?, ".
						"`name` = ?, `surname` = ?, `email` = ?, `matrikel` = ?, ".
						"`birth` = ?, `major` = ?, `street` = ?, `zip` = ?, `home` = ? WHERE `ID` = ? AND `worker` = '0'",
						$start->format("Y-m-d H:i"),
						$end->format("Y-m-d H:i"),
						$phone,
						$name,
						$surname,
						$mail,
						$manr,
						$birth->format("Y-m-d"),
						$major,
						$street,
						$zip,
						$home,
						User::load($user)->getId()
					);
	}
	
	/**
	 * create customer
	 * 
	 * @param unknown $start
	 * @param unknown $end
	 * @param unknown $phone
	 * @param unknown $matrikel
	 * @param unknown $surname
	 * @param unknown $name
	 * @param unknown $mail
	 * @param unknown $birth
	 * @param unknown $major
	 * @param unknown $street
	 * @param unknown $zip
	 * @param unknown $home
	 * @return boolean|number
	 */
	static function create($start, $end, $phone, $matrikel, $surname, $name, $mail,
			$birth, $major, $street, $zip, $home) {
		if(!Rights::hasRight("customers")) return false;
		
		if(empty($name) || empty($mail) || empty($surname) || empty($matrikel)) return false;

		
		$db = new Db();
		$pw = rand(111111,999999);
		
		
		$start = new DateTime($start);
		$end = new DateTime($end);
		
		$birth = new DateTime($birth);
		
		$db->saveQry("SELECT ID FROM `#_users` WHERE `email` = ? LIMIT 1", $mail);
		$_mc = $db->fetch_assoc();
		if(intval($_mc['ID']) > 0) return false;
		
		$db->saveQry("INSERT INTO `#_users` (`start`, `end`, `matrikel`,`phone`, `surname`, `name`, ".
				"`email`, `birth`, `major`, `street`, `zip`, `home`, `password`, `worker`, `creator`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
				$start->format("Y-m-d H:i"),
				$end->format("Y-m-d H:i"),
				$matrikel,
				$phone,
				$surname,
				$name,
				$mail,
				$birth->format("Y-m-d"),
				$major,
				$street,
				$zip,
				$home,
				password($pw),
				0,
				User::load()->getId()
		);
		
		$return = $db->insertID();
		
		
		Message::customerCreated(User::load($return), $pw);
		return $return;
	}
	
	/**
	 * reset customer password
	 * @param unknown $id
	 * @return boolean
	 */
	static function resetPw($id) {
		if(!Rights::hasRight("customers")) return false;

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
	
	
	
}
?>