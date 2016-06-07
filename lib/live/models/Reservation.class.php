<?php
class Reservation extends Model{
	
	private $id = null;
	
	private $user = null;
	
	private $booking = null;
	
	private $startstation = null;
	
	private $endstation = null;

	private $startTime = null;
	
	private $endTime = null;

	private $created = null;
	
	private $creator = null;

	private $canceled = null;
	
	private $forcedtocancel = null;
	
	private $status = null;
	
	private static $_reservations = null;
	
	function __construct(User $user = null, 
			Station $start = null, Station $end = null, 
			$startTime = null, $endTime = null, $status = null) {
		parent::__construct();
		if($user !== null) {
			$this->user = $user;
			$this->startstation = $start;
			$this->endstation = $end;
			$this->startTime = $startTime;
			$this->endTime = $endTime;
			$this->status = $status;
		} 
	}
	
	static function getUserReservations(User $u) {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_reservations` WHERE ".
				"(`status` = 'pending' OR `status` = 'queued' OR `status` = 'prefered' OR `status` = 'progress') AND ".
				"(`endTime` >= ? OR `startTime` >= ?) AND `user` = ?", 
				date("Y-m-d H:i"),date("Y-m-d H:i"),$u->getId());
		$ret =array();
		while($row = $db->fetch_assoc()) $ret[] = Reservation::load($row['ID']);
		return $ret;
	}
	
	static function upcoming() {
		$db = new Db();
		$db->saveQry("SELECT `ID` FROM `#_reservations` WHERE (`startTime` >= NOW() OR `endTime` >= NOW()) AND ".
						"(`status` = 'pending' OR `status` = 'prefered' OR `status` = 'queued')");
		$res = array();
		while($row = $db->fetch_assoc()) $res[] = Reservation::load($row['ID']);
		return $res;
	}
	
	static function load($id) {
		if(self::$_reservations === null) self::$_reservations = array();
		
		if(!array_key_exists($id, self::$_reservations)) {
			$tmp = new Reservation();
			$tmp->loadData($id);
		}
		
		return self::$_reservations[$id];
	}
	
	static function statusToString($str) {
		switch($str) {
			case 'prefered': return "Anfrage (bevorzugt)";
			case 'pending': return "Anfrage";
			case 'queued': return "Buchung";
			case 'progress': return "Entliehen";
			case 'succeeded': return "Abgeschlossen";
			case 'failed': return "Abgesagt";
			case 'canceled': return "Abgesagt";
			case 'crash': return "Unfall";
			case 'unattended': return "Nicht angetreten";
			case 'forcedtocancel': return "Abgesagt";
		}
	}
	
	static function statusToString2($str) {
		switch($str) {
			case 'prefered': return "Anfrage (bevorzugt)";
			case 'pending': return "Anfrage";
			case 'queued': return "Buchung";
			case 'progress': return "Entliehen";
			case 'succeeded': return "Abgeschlossen";
			
			// Störfälle
			case 'forcedtocancel': return "Wurde zur Absage gezwungen";
			case 'failed': return "Konnte nicht bedient werden";
			case 'canceled': return "Abgesagt";
			case 'crash': return "Unfall";
			case 'unattended': return "Nicht angetreten";
		}
	}
	
	function validate() {
		if($this->getStatus() == 'unattended')  return false;
		if($this->getStatus() == 'crash')  return false;
		if($this->getStatus()== 'forcedtocancel') return true;
		
		if($this->canceled === null) return true;
		$canceled = new DateTime($this->getCanceled());
		$start = new DateTime($this->getStartTime());
		
		$canceled->modify("+60 minutes"); // 60Minuten vor start Zeit?
		
		return $start >= $canceled;
	}
	
	function loadData($id) {
		self::$_reservations[$id] = $this;
		
		$res = $this->fetchData($id);

		$this->id = (int)$res['ID'];
		$this->status = $res['status'];
		$this->user =
		!empty($res['user'])? User::load((int)$res['user']):
		$this->user = null;
		$this->creator =
		!empty($res['creator'])? User::load((int)$res['creator']): null;
		$this->booking =
		!empty($res['booking'])? Booking::load((int)$res['booking']):
		$this->booking = null;
		$this->startstation =
		!empty($res['startstation'])? Station::load((int)$res['startstation']):
		$this->startstation = null;
		$this->endstation =
		!empty($res['endstation'])? Station::load((int)$res['endstation']):
		$this->endstation = null;
		$this->canceled =
		!empty($res['canceled'])? $res['canceled']:
		$this->canceled = null;
		$this->forcedtocancel =
		!empty($res['forcedtocancel'])? Booking::load($res['forcedtocancel']):
		$this->forcedtocancel = null;

		$this->startTime = $res['startTime'];
		$this->endTime = $res['endTime'];
		$this->created = $res['created'];
	}
	
	function getUser() {
		return $this->user;
	}

	function getCreator() {
		return $this->creator;
	}
	
	function getStart() {
		return $this->startstation;
	}
	
	function getCreated() {
		return $this->created;
	}
	
	function getCanceled() {
		return $this->canceled;
	}
	
	function getEnd() {
		return $this->endstation;
	}
	
	function getStatus() {
		return $this->status;
	}
	
	function getBooking() {
		return $this->booking;
	}

	function getStartTime() {
		return $this->startTime;
	}
	function getEndTime() {
		return $this->endTime;
	}
	
	function getId() {
		return $this->id;
	}
	
	function getForcedToCancel() {
		return $this->forcedtocancel;
	}
	
	function queued() {
		if($this->status == 'queued') return false;
		$db = $this->getDb();
		Message::queued($this);
		return 	$db->saveQry("UPDATE `#_reservations` SET ".
				"`status` = 'queued' ".
				"WHERE `ID` = ?",
				$this->id);
	}
	
	function forcedtocancel(Booking $book) {
		if($this->status == 'forcedtocancel') return false;
		$db = $this->getDb();
		//Message::failed($this);
		return 	$db->saveQry("UPDATE `#_reservations` SET ".
				"`status` = 'forcedtocancel', ".
				"`forcedtocancel` = ?, ".
				"`canceled` = NOW() ".
				"WHERE `ID` = ?",
				$book->getId(),
				$this->id);
	}
	
	/**
	 * returns true if two reservations have an intersection
	 * @param Reservation $res
	 * @return boolean
	 */
	function intersecs(Reservation $res) {
		$s = new DateTime($this->getStartTime());
		$e = new DateTime($this->getEndTime());
		$_s = new DateTime($res->getStartTime());
		$_e = new DateTime($res->getEndTime());
		
		if($s < $_s)
			return $e >= $_s;
		elseif($s > $_s)
			return $_e >= $s;
		
		return true;
	}
	
	function failed() {
		if($this->status == 'failed') return false;
		$db = $this->getDb();
		Message::failed($this);
		return 	$db->saveQry("UPDATE `#_reservations` SET ".
				"`status` = 'failed' ".
				"WHERE `ID` = ?",
				$this->id);
	}
	
	function crashed() {
		if($this->status == 'crash') return false;
		$db = $this->getDb();
		//Message::failed($this);
		return 	$db->saveQry("UPDATE `#_reservations` SET ".
				"`status` = 'crash' ".
				"WHERE `ID` = ?",
				$this->id);
	}
	
	function unattended() {
		if($this->status == 'unattended') return false;
		$db = $this->getDb();
		Message::unattended($this);
		return 	$db->saveQry("UPDATE `#_reservations` SET ".
				"`status` = 'unattended' ".
				"WHERE `ID` = ?",
				$this->id);
	}
	
	function prefered() {
		if($this->status == 'prefered') return false;
		$db = $this->getDb();
		Message::prefered($this);
		return 	$db->saveQry("UPDATE `#_reservations` SET ".
				"`status` = 'prefered' ".
				"WHERE `ID` = ?",
				$this->id);
	}
	
	function _book(Booking $book) {
		if($this->booking !== null) return false;
		$this->booking = $book;
		
		$db = $this->getDb();
		return 	$db->saveQry("UPDATE `#_reservations` SET ".
				"`booking` = ?, `status` = 'progress' ".
				"WHERE `ID` = ?",
				$this->booking->getId(),
				$this->id);
	}
	
	function _return($crash = false) {
		if($this->booking === null) return false;
		
		$db = $this->getDb();
		return 	$db->saveQry("UPDATE `#_reservations` SET ".
				"`status` = ? ".
				"WHERE `ID` = ?",
				$crash?'crash':'succeeded',
				$this->id);
	}
	
	function __toString() {
		return "[RESERVATION user ".$this->user."]";
	}
	
	function save() {
		if($this->id === null && $this->user !== null && $this->startstation !== null
				 && $this->endstation !== null && $this->startTime !== null && $this->endTime !== null){
			
			if(new DateTime($this->startTime) > new DateTime($this->endTime))
				throw new Exception("StartTime is after EndTime");
			
			
			$db = $this->getDb();
			$db->saveQry("INSERT INTO `#_reservations` ".
					"(`user`, `startTime`,`endTime`, `startstation`, `endstation`,`status`, `creator`) VALUES (?,?,?,?,?,?,?)",
					$this->user->getId(),
					$this->startTime,
					$this->endTime,
					$this->startstation->getId(),
					$this->endstation->getId(),
					$this->status, User::load()->getId());
			$this->id = $db->insertID();
				
			$this->loadData($this->id);
			return $this;
		}
		return false;
	}
}