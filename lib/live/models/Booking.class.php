<?php
class Booking extends Model {
	
	private $id = null;
	
	private $bike = null;
	
	private $user = null;
	
	private $gStart = null;
	
	private $gEnd = null;
	
	private $tStart;
	
	private $tEnd;
	
	private $reservation = null;
	
	static private $_bookings = null;

	private $sService;
	
	private $eService;
	
	private $forcedtocancel;
	
	/**
	 * Construct for bookings
	 * @param User $user
	 * @param Bike $bike
	 * @param Station $gStart
	 */
	function __construct(Reservation $res =null, Bike $bike = null, User $service = null) {
		parent::__construct();
		
		if($res !== null && $bike !== null ) {
			$this->reservation = $res;
			$this->user = $res->getUser();
			$this->bike = $bike;
			$this->gStart = $this->bike->getStation();
			$this->sService = $service;
		}
	}
	
	function getAccess() {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_booked_accessories` WHERE `booking` = ?", $this->id);
		$ret = array();
		while($row = $db->fetch_assoc())
			$ret[] = Accessorie::load($row['accessory']);
		return $ret;
	}
	
	function gotLost(Accessorie $ac) {
		$db = new Db();
		$db->saveQry("SELECT `broke` FROM `#_booked_accessories` WHERE `booking` = ? ".
				"AND `accessory` = ?", $this->id,$ac->getId());
		$res = $db->fetch_assoc();
		return $res['broke'] == '1';
		
	}
	
	function validAccess() {
		$db = new Db();
		$db->saveQry("SELECT `broke` FROM `#_booked_accessories` WHERE `booking` = ? ",$this->id);
		$ret = true;
		while($res = $db->fetch_assoc())
			$ret = $res['broke'] == '1'?false: $ret;
		return $ret;
	}
	
	static function load($id) {
		if(self::$_bookings === null) self::$_bookings = array();
		
		if(!array_key_exists($id, self::$_bookings)) {
			$b = new Booking();
			$b->loadData($id);
		}
		
		return self::$_bookings[$id];
	}	
	
	function loadData($id) {
		$res = $this->fetchData($id);
		if(!$res) throw new Exception('Empty Result');
		
		$this->user = 	!empty($res['user'])?User::load((int)$res['user']):
						$this->user = null;
		$this->bike = 	!empty($res['bike'])?Bike::load((int)$res['bike']):
						$this->bike = null;
		$this->reservation = 	!empty($res['reservation'])?Reservation::load((int)$res['reservation']):
						$this->reservation = null;
		$this->gStart = !empty($res['startStation'])?Station::load((int)$res['startStation']):
						$this->gStart = null;
		$this->gEnd = 	!empty($res['endStation'])?Station::load((int)$res['endStation']):
						$this->gEnd = null;
		$this->forcedtocancel = !empty($res['forcedtocancel'])?
						Reservation::load((int)$res['forcedtocancel']):
						$this->forcedtocancel = null;
		$this->sService = 	!empty($res['sService'])?User::load((int)$res['sService']):
						$this->sService = null;
		$this->eService = 	!empty($res['eService'])?User::load((int)$res['eService']):
						$this->eService = null;
		
		$this->id = (int)$res['ID'];
		$this->tStart = $res['startTime'];
		$this->tEnd = $res['endTime'];

		self::$_bookings[$id] = $this;
	}
	
	function create() {
		if($this->id === null && $this->user !== null && 
				$this->bike !== null && $this->gStart !== null && 
				$this->sService !== null){
			if(!$this->bike->isAvailable()) 
				throw new Exception("Bike not available");
			$db = $this->getDb();
			$db->saveQry("INSERT INTO `#_bookings` ".
					"(`user`, `bike`, `startTime`, `startStation`, `reservation`, `sService`) VALUES (?,?,NOW(),?,?,?)",
					$this->user->getId(),
					$this->bike->getId(),
					$this->gStart->getId(),
					$this->reservation->getId(),
					$this->sService->getId());
			$this->id = $db->insertID();
			
			$this->bike->_book($this);
			$this->user->_book($this);
			$this->reservation->_book($this);
			$this->gStart->_book($this->bike);
			
			$this->loadData($this->id);
			return $this->id;
		} 
		return false;
	}
	
	function forcedToCancel(Reservation $res) {
		if($this->forcedtocancel !== null) return false;

		$db = $this->getDb();
		$db->saveQry("UPDATE `#_bookings` ".
				"SET `forcedtocancel` = ? ".
				"WHERE `ID` = ?",
				$res->getId(),
				$this->id);
		
		return $res->forcedtocancel($this);
	}
	
	function getReports() {
		$db = $this->getDb();
		$db->saveQry("SELECT * FROM `#_reports` WHERE `booking` = ?", $this->getId());
		while($row = $db->fetch_assoc())  {
			$tmp = new Report();
			$tmp->_setData($row);
			$res[] = $tmp;
			$tmp = null;
		}
		return $res;
	}
	
	function complete(Station $gEnd = null, $crash = false, User $eService = null) {
		if($this->gEnd == null && $this->id !== null && $gEnd !== null 
				&& $eService !== null && $this->eService === null) {
			$this->gEnd = $gEnd;
			$this->eService = $eService;

			$db = $this->getDb();
			$db->saveQry("UPDATE `#_bookings` ".
					"SET `endTime` = NOW(), `endStation` = ?, `eService` = ? ".
					"WHERE `ID` = ?",
					$this->gEnd->getId(),
					$eService->getId(),
					$this->id);	
			

			$this->bike->_return($gEnd);
			$this->user->_return();
			$this->reservation->_return($crash);
			$this->gStart->_return($this->bike);
			
			return true;
		}
		return false;
	} 

	public function __toString() {
		if($this->gEnd)
		return "[BOOKING: user ".$this->user.", bike ".$this->bike.", start ".$this->gStart.", end ".$this->gEnd." ]";	
		if($this->user)
		return "[BOOKING: user ".$this->user.", bike ".$this->bike.", start ".$this->gStart." ]";
		return "[Booking]";
	}
	
	function inProgress() {
		return $this->getEnd() === null;
	}
	
	function getForcedToCancel() {
		return $this->forcedtocancel;
	}
	
	function statement() {
		$s = "";
		if($this->getForcedToCancel()) $s.= '- Absage von Buchung Nr. '.$this->getForcedToCancel()->getId().
		' wurde erzwungen Benutzer '.$this->getForcedToCancel()->getUser()->getHtml().
		' betroffen.<br>';
		
		if(!$this->timeValidate()) $s.= "- Die Abgabezeit wurde überschritten!<br>";

		if($this->getEnd()){
		$endstationplan = $this->getReservation()->getEnd()->getId();
		$endstationist = $this->getEnd()->getId();
		
		if($endstationist != $endstationplan) $s.= "- Rückgabe an falscher Station.";
		
		}
		return $s;
	}
	
	function validate() {
		if($this->inProgress()) return true;
		if($this->forcedtocancel !== null) return false;
		
		
		$endstationplan = $this->getReservation()->getEnd()->getId();
		$endstationist = $this->getEnd()->getId();
		
		
		
		return $this->timeValidate() && $endstationist == $endstationplan;
		
	}
	
	
	private function timeValidate() {
		$splan = new DateTime($this->getReservation()->getStartTime());
		$seplan = new DateTime($this->getReservation()->getStartTime());
		$seplan->modify("+".Preferences::value("unattended")." minutes");
		$eplan = new DateTime($this->getReservation()->getEndTime());
		
		$sist = new DateTime($this->getTStart());
		$eist = new DateTime($this->getTEnd());
		
		return ($splan <= $sist && $sist <= $seplan &&
				$eist <= $eplan);
	}
	
	function getTStart() {
		return $this->tStart;
	}
	
	function getTEnd() {
		return $this->tEnd;
	}
	
	function getReservation() {
		return $this->reservation;
	}
	
	function getStart() {
		return $this->gStart;
	}
	
	function getEnd() {
		return $this->gEnd;
	}
	
	function getEService() {
		return $this->eService;
	}
	
	function getSService() {
		return $this->sService;
	}
	
	function getHtml() {
		$rid = $this->getReservation()->getId();
		return 	"<a href=\"./_overview.php?do=detail&rid=".$rid.
				"\">Buchung #".$rid."</a>";
	}
	
	function getUser() {
		return $this->user;
	}
	
	function getBike() {
		return $this->bike;
	}
	
	function getId() {
		return $this->id;
	}
}
?>