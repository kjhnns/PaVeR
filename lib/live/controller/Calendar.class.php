<?php
/**
 * calendar controller
 * @author joh
 *
 */
class Calendar {
	
	private $cal = null;
	
	private $year = null;
	
	/**
	 * construct for calendar by year
	 * @param string $year
	 */
	function __construct($year = false) {
		if($year == false || $year <= 2011 || year >= 4000) $year = date("Y");
		$this->year = $year;
		$s = new DateTime(date("Y-m-d",
				strtotime('first day of January', strtotime($year."-01-01"))));
		$e = new DateTime(date("Y-m-d",
				strtotime('last day of December', strtotime($year."-01-01"))));
		$i = new DateInterval("P1D");
		$this->cal = new DatePeriod($s, $i, $e);
	}

	/**
	 * get open timesframes
	 * @return multitype:Ambigous <mixed, string>
	 */
	static function getOpen() {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_cal_open` ORDER BY `ID` DESC");
	
		$res = array();
		while($r = $db->fetch_assoc()) $res[] = $r;
	
		return $res;
	}
	
	/**
	 * get closed timeframes
	 * @return multitype:Ambigous <mixed, string>
	 */
	static function getClose() {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_cal_closed` ORDER BY `ID` DESC");
		
		$res = array();
		while($r = $db->fetch_assoc()) $res[] = $r;
		
		return $res;
	}
	
	/**
	 * save open timeframe
	 * @param unknown $st
	 * @param unknown $et
	 * @param unknown $dd
	 * @param unknown $ed
	 * @param unknown $p
	 * @param unknown $d
	 * @param unknown $station
	 * @return boolean
	 */
	static function saveOpen($st, $et,$dd, $ed, $p, $d, $station) {
		$db = new Db();
		
		$dd = date("Y-m-d", strtotime($dd));
		
		$ed = date("Y-m-d", strtotime($ed));
		
		if($station == 'null')
			$station = false;
		else
			$station = Station::load($station)->getId();
		
		if($p == 'null')
		$r = $db->saveQry("INSERT INTO `#_cal_open` (`stime`, `etime`, `date`, `station`) VALUES (?,?,?,".($station===false?'NULL':"'".$station."'").")",
				$st, $et, $dd);
		else
		$r = $db->saveQry("INSERT INTO `#_cal_open` (`stime`, `etime`, `date`, `enddate`, `period`, `duration`, `station`) VALUES (?,?,?,?,?,?,".($station===false?'NULL':"'".$station."'").")",
				$st, $et, $dd, $ed, $p, $d);
		
		return $r;
	}
	
	/**
	 * delete open timeframe
	 * @param unknown $id
	 * @return boolean
	 */
	static function delOpen($id) {
		$db = new Db();
		
		$veto = false;
		$service = new Service($id);
		foreach(Reservation::upcoming() as $res) 
			$veto = $service->checkReservation($res)? true: $veto;
		
		if($veto) return false;
		return $db->saveQry("DELETE FROM `#_cal_open` WHERE `ID` = ?", $id);
	}
	
	/**
	 * delete closed timeframe by ID
	 * @param unknown $id
	 */
	static function delClose($id) {
		$db = new Db();
		$db->saveQry("DELETE FROM `#_cal_closed` WHERE `ID` = ?", $id);
	}
	
	/**
	 * save closed timeframe
	 * @param unknown $s
	 * @param unknown $e
	 * @param unknown $t
	 * @param unknown $station
	 * @return boolean
	 */
	static function saveClosed($s, $e, $t, $station) {
		$db = new Db();

		$start = new DateTime($s);
		$end = new DateTime($e);
		
		

		if($station == 'null')
			$station = false;
		else
			$station = Station::load($station);
		
		
		$veto = false;
		foreach(Reservation::upcoming() as $res) 
			$veto = Service::checkReservationInFrame($start, $end, $res, ($station?$station:null))?
					true: $veto;
		
		if($veto) return false;

		return $db->saveQry("INSERT INTO `#_cal_closed` (`start`, `end`, `title`, `station`) VALUES (?,?,?,".($station===false?'NULL':"'".$station->getId()."'").")",
				$start->format("Y-m-d H:i"), $end->format("Y-m-d H:i"), $t);
	}
	
	/**
	 * is the given Date String Today?
	 * @param unknown $d
	 * @return boolean
	 */
	static function today($d) {
		$a = new DateTime($d);
		$b = new DateTime();
		
		return ($a->format("Ymd") == $b->format("Ymd"));
	}
	
	/**
	 * get instance year
	 * @return Ambigous <string, string>
	 */
	function getYear() {
		return $this->year;
	}
	
	/**
	 * get calendar days
	 * @return unknown
	 */
	function days() {
		return clone $cal;
	}
	
	/**
	 * returns a calendar matrix
	 * @return multitype:
	 */
	function getMatrix() {
		$ret = array();
		foreach($this->cal as $day) {
			$w = $day->format("w");
			$w = ($w <= 0?7:$w);
			$ret[$day->format("m")][$day->format("W")][$w] = $day->format("d");
		}
		
		return $ret;
	}
	
	/**
	 * months string
	 * @param unknown $num
	 * @return Ambigous <string>
	 */
	static function month($num) {
		$map = array(
				1 => "Januar",
				"Februar",
				"März",
				"April",
				"Mai",
				"Juni",
				"Juli",
				"August",
				"September",
				"Oktober",
				"November",
				"Dezember"
				);
		
		return $map[(int)$num];
	}
	
	/**
	 * returns the start accept date time for bookings
	 */
	static function startAccept($date = false) {
		if($date == false) $start_accept = new DateTime(date("Y-m-d H:i"));
		else
		$start_accept = new DateTime($date);
		$start_accept->modify("+".Preferences::value("startAccept")." minutes");
		
		return $start_accept->format("Y-m-d H:i");
	}
	
	/**
	 * returns the time minus the unattended time for sql select
	 */
	static function unattended() {
		$now =  new DateTime(date("Y-m-d H:i"));
		$now->modify("-".Preferences::value("unattended")." minutes");
		return $now->format("Y-m-d H:i");
	}
	
	/**
	 * returns the start cancel date time for bookings
	 */
	static function startCancel($date = false) {
		if($date == false) $start_cancel = new DateTime(date("Y-m-d H:i"));
		else
		$start_cancel = $date;
		$start_cancel->modify("+".BOOKING_STARTCANCEL." minutes");
		
		return $start_cancel->format("Y-m-d H:i");
	}
	
	/**
	 * true when the calculations for tomorrow shall start
	 * @return boolean
	 */
	static function calculateTomorrow() {
		$tom = Service::checkDay("tomorrow");
		$close = Service::checkDay("today")?
					Service::end("today"):
					new DateTime(date("Y-m-d")." 19:00:00");
		$dt = new DateTime(date("Y-m-d H:i"));
		
		// fang 30 minuten vor start mit den berechnungen an
		$dt->modify("-30 minutes");
		
		return ($tom && $dt >= $close);
	}
	
	
	/**
	 * returns the opening hour for the given day
	 * @param string $date
	 */
	static function opening($date = false) {
		return Service::start($date);
	}
}

?>