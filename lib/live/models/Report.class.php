<?php
class Report extends Model {

	private $id;
	
	private $service = null;
	
	private $subject;
	
	private $bike;
	
	private $user = null;
	
	private $comment = null;
	
	private $battery = null;

	private $status = null;
	
	private $booking = null;
	
	private $timestamp = null;
	

	function __construct($id = null) {
		parent::__construct();
		
		if($id !== null ):
		
			$res = $this->fetchData($id);
			$this->_setData($res);
		
		endif;
	}
	
	function _setData($res) {
		$this->id =		 	$res['ID'];
		$this->service = 	!empty($res['service']) ? 	User::load($res['service']) : null;
		$this->subject = 	$res['subject'];
		$this->bike = 		!empty($res['bike']) ? 		Bike::load($res['bike']) : null;
		$this->user = 		!empty($res['user']) ? 		User::load($res['user']) : null;
		$this->comment = 	!empty($res['comment']) ? 	$res['comment']: null;
		$this->battery = 	!empty($res['battery']) ? 	$res['battery']: null;
		$this->status = 	!empty($res['status']) ? 	$res['status']: null;
		$this->booking = 	!empty($res['booking']) ? 	Booking::load($res['booking']): null;
		$this->timestamp = 	!empty($res['timestamp']) ? $res['timestamp']: null;
		$this->station = 	!empty($res['station']) ? 	Station::load($res['station']): null;
	}

	function validate() {
		return $this->getStatus() > 0;
	}

	function getId() {
		return $this->id;
	}
	
	function getTime() {
		return $this->timestamp;
	}

	function getService() {
		return $this->service;
	}

	function getUser() {
		return $this->user;
	}

	function getSubject() {
		return $this->subject;
	}
	
	function getBike() {
		return $this->bike;
	}

	function getCom() {
		return html($this->comment);
	}

	function getBattery() {
		return $this->battery;
	}

	function getStatus() {
		return $this->status;
	}
	
	function getStation() {
		return $this->station;
	}
	
	function getBooking() {
		return $this->booking;
	}
	
	static function subToString($sub) {
		switch($sub) {
			case 'start': return 'Entliehen';
			case 'end': return 'Rückgabe';
			case 'changed': return 'Geändert';
			case 'report': return 'Meldung';
			case 'canceled': return 'Storniert';
			case 'login': return 'Angemeldet';
			case 'logout': return 'Abgemeldet';
			case 'crash': return 'Unfall';
		}
	}
	
	static function getBikeReports($bid) {
		$db =new Db();
		$db->saveQry("SELECT * FROM `#_reports` WHERE `bike` = ? ORDER BY `timestamp` DESC LIMIT 0,30",$bid);
		while($r = $db->fetch_assoc()) {
			$tmp = new Report(null);
			$tmp->_setData($r);
			$res[] = $tmp;
		}
		return $res;
	}
	
	static function getWorkerSessions($wid) {
		$db =new Db();
		$db->saveQry("SELECT * FROM `#_reports` WHERE `service` = ? ORDER BY `timestamp` DESC LIMIT 0,20",$wid);
		while($r = $db->fetch_assoc()) {
			$tmp = new Report(null);
			$tmp->_setData($r);
			$res[] = $tmp;
		}
		return $res;
	}
	
	static function getUserReports($bid) {
		$db =new Db();
		$db->saveQry("SELECT * FROM `#_reports` WHERE `user` = ? ORDER BY `timestamp` DESC LIMIT 0,30",$bid);
		while($r = $db->fetch_assoc()) {
			$tmp = new Report(null);
			$tmp->_setData($r);
			$res[] = $tmp;
		}
		return $res;
	}
	
	static function userReport(User $user, $comment) {
		$db =new Db();
		return $db->saveQry("INSERT INTO `#_reports` ".
				"(`subject`, `bike`, `user`, `comment`,`booking`) VALUES ".
				"('report',?,?,?,?)",
				 $user->getBike()->getId(), $user->getId(), $comment, $user->getBooking()->getId());
	}
	
	static function login(Station $station, User $service) {
		$db = new Db();
		$db->saveQry("INSERT INTO `#_reports` (`service`, `subject`,`station`) VALUES (?,?,?)",
				$service->getId(), 'login', $station->getId());
		
	}
	
	static function logout(Station $station, User $service) {
		$db = new Db();
		$db->saveQry("INSERT INTO `#_reports` (`service`, `subject`,`station`) VALUES (?,?,?)",
				$service->getId(), 'logout', $station->getId());
		
	}
	
	static function startBooking(User $service, User $user, Bike $bike, $booking) {
		$db =new Db();
		return $db->saveQry("INSERT INTO `#_reports` ".
				"(`service`, `subject`, `bike`, `user`, `battery`, `status`, `booking`) VALUES ".
				"(?,?,?,?,?,?,?)",
				$service->getId(), 'start', $bike->getId(), $user->getId(), 
				$bike->getBattery(),$bike->getStatus(), $booking);
	}
	
	static function endBooking(User $service, User $user, $comment, $bat, $status) {
		$db =new Db();
		$user->getBike()->setBattery($bat);
		$user->getBike()->setStatus($status);
		return $db->saveQry("INSERT INTO `#_reports` ".
				"(`service`, `subject`, `bike`, `user`, `comment`, `battery`, `status`, `booking`) VALUES ".
				"(?,?,?,?,?,?,?,?)",
				$service->getId(), 'end', $user->getBike()->getId(), 
				$user->getId(), $comment, $bat, $status, $user->getBooking()->getId());
	}
	
	static function bike(Bike $bike, $bat, $stat) {
		$db =new Db();
		$bike->setBattery($bat);
		$bike->setStatus($stat);
		return $db->saveQry("INSERT INTO `#_reports` ".
				"(`service`, `subject`, `bike`, `battery`, `status`) VALUES ".
				"(?,'changed',?,?,?)",
				User::load()->getId(), $bike->getId(), $bat, $stat);
	}
	
	static function crash( User $service, User $user, $comment) {
		$db =new Db();
		$user->getBike()->setBattery(0);
		$user->getBike()->setStatus(0);
		return $db->saveQry("INSERT INTO `#_reports` ".
				"(`service`, `subject`, `bike`, `user`, `comment`,`booking`) VALUES ".
				"(?,'crash',?,?,?,?)",
				$service->getId(), $user->getBike()->getId(), $user->getId(), $comment, $user->getBooking()->getId());
	}
}
?>