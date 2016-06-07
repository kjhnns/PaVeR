<?php

/**
 * Controller for bookings
 *
 * @author Johannes
 *
 */
class Reserve {
	/**
	 * stores the database handler
	 * @var Db
	 */
	private static $_db = null;

	/**
	 * initiates database connection
	 * & getting the relevant table
	 */
	function __construct() {
		if(self::$_db == null)
			self::$_db = new Db();
	}
	
	/**
	 * returns all the stations
	 * @return Ambigous <NULL, mixed, string>
	 */
	function getStations() {
		$result = Cache::get("stations");
		if($result === null) {
			self::$_db->saveQry("SELECT * FROM `#_stations`");
			while($res = self::$_db->fetch_assoc())
				$result[$res['ID']] = $res;
			Cache::set("stations", $result);
		}
		return $result;
	}
	
	/**
	 * throws an exception if the start and endtime are not valid
	 * 
	 * @param DateTime $st
	 * @param DateTime $et
	 * @param Station $ss
	 * @param Station $es
	 * @throws Exception
	 */
	function validateTime(DateTime $st, DateTime $et, 
			Station $ss, Station $es) {
		$now = new DateTime();
		$now->modify("-2 minutes");
		
		if($now > $st) throw new Exception(Preferences::value("exceptionStartTime"));
		
		if($st >= $et) throw new Exception(Preferences::value("exceptionEndTime"));
		
		$dif = totalMinutes($st->diff($et));
		if($dif < Preferences::value("minlen")) 
			throw new Exception(Preferences::value("exlentoshort"));


		$dif_now_start = totalMinutes($now->diff($st))/60/24;
		if($dif_now_start > Preferences::value("maxprebooktime") && Preferences::value("maxprebooktimebool"))
			throw new Exception(Preferences::value("exmaxprebooktime"));
		
		if(Preferences::value("maxlenactive"))
		if($dif > Preferences::value("maxlen")) 
			throw new Exception(Preferences::value("exlenmax"));

		if(!Service::check($st, $ss))
			throw new Exception(Preferences::value("exstclosed"));
		
		if(!Service::check($et, $es))
			throw new Exception(Preferences::value("exetclosed"));
	}
	
	/**
	 * adhoc booking
	 * 
	 * @param User $customer
	 * @param Station $es
	 * @param DateTime $et
	 * @throws Exception
	 */
	static function saveAdhoc($mail, Station $es, DateTime $et) {
		$customer = User::search($mail);
		if($customer === false) 
			throw new Exception(Preferences::value("exnotfoundcust"));
		
		$ctrl = new Reserve();
		
		if($customer->getBooking() !== null) 
			throw new Exception();
		
		$st = new DateTime();
		$ss = User::workerGetStation();
		
		if($st >= $et) throw new Exception(Preferences::value("exceptionEndTime"));
		
		$dif = totalMinutes($st->diff($et));
		if($dif < Preferences::value("minlen")) 
			throw new Exception(Preferences::value("exlentoshort"));
		

		if(!Rights::hasRight("adhoc")) {
			if(Preferences::value("maxlenactive"))
				if($dif > Preferences::value("maxlen"))
				throw new Exception(Preferences::value("exlenmax"));
			
			if(!Service::check($st, $ss))
				throw new Exception(Preferences::value("exstclosed"));
	
			if(!Service::check($et, $es))
				throw new Exception(Preferences::value("exetclosed"));
		}
		
		
		$inst = new Reservation($customer,
				$ss, $es,
				$st->format("Y-m-d H:i"), $et->format("Y-m-d H:i"), "prefered");
		

		if($ctrl->intersections($inst, $customer))
			throw new Exception(Preferences::value("exintersection"));
		

		if($res = $inst->save()) {
			Message::saveSuccess($res);
			Preferences::set('lastCron', date("H:i:s", time()-240));
			
			require(LIVECTRL.'Reminder.class.php');
			
			Cronjob::jobs();
			
			return $res;
		}
		
		return false;
	}
	
	/**
	 * checks for intersections
	 * @param Reservation $res
	 * @return boolean
	 */
	function intersections(Reservation $res, User $user = null) {
		if($user == null) $user = User::load();
		$_reservations = Reservation::getUserReservations($user);
		
		$isec = false;
		foreach($_reservations as $_res)  
			$isec = $isec || $res->intersecs($_res);
		
		return $isec;
	}
	
	
	/**
	 * quick save booking
	 * @param unknown $ss
	 * @param unknown $es
	 * @param DateTime $st
	 * @param DateTime $et
	 * @return boolean
	 */
	function save(Station $ss, Station $es, DateTime $st, DateTime $et) {
		$this->validateTime($st, $et, $ss, $es);
		
		
		// Status
		$status = 	Preferences::value("prefereqbooks") && 
					(totalMinutes($st->diff($et)) <= Preferences::value('qbooksdiff'))? 
					"prefered": "pending";
		

		$inst = new Reservation(User::load(),
				$ss, $es,
				$st->format("Y-m-d H:i"), $et->format("Y-m-d H:i"), $status);
		
		if($this->intersections($inst))
			throw new Exception(Preferences::value("exintersection"));
		

		if($res = $inst->save()) {
			Message::saveSuccess($res);
			Preferences::set('lastCron', date("H:i:s", time()-240));
			return $res;
		}
		
		return false;
	}
}
?>