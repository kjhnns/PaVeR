<?php

/**
 * Controller for cronjobs
 *
 * @author Johannes
 *
 */
class Cronjob {
	/**
	 * stores the database handler
	 * @var Db
	 */
	private static $_db = null;


	private $transitions;
	
	private $dismissedTrans;

	
	/**
	 * starts cronjobs once every minute
	 * @return boolean
	 */
	static function doCron() {
		$lc = new DateTime(Preferences::value("lastCron"));
		$now = new DateTime();
		
		$diff = $now->diff($lc, true);
		if($diff->i >= 1) return true;
		return false;
	}
	
	/**
	 * cronjobs procedure
	 * lock and unlock safety
	 */
	static function jobs() {
		if(self::doCron()):
		
		while(!Db::lock());

		Reminder::cron();
		
		$ctrl = new Cronjob();
		$ctrl->checkBookings();
		$ctrl->cancelPending();
		$ctrl->unattended();
		
		while(!Db::unlock());
		
		Preferences::set('lastCron', date("H:i:s"));
		_debug("CRON JOBS DONE!");
		endif;
	}
	
	/**
	 * initiates database connection
	 * & getting the relevant table
	 */
	function __construct() {
		if(self::$_db == null)
			self::$_db = new Db();

		$this->transitions = new Stack();
		$this->dismissedTrans = new Stack();
	}
	
	/**
	 * checks whether a booking is servable
	 * @return Ambigous <boolean, mixed>
	 */
	function checkBookings() {
		// Load Transitions Pool
		$this->initTransitions();
		
		$sim = false;
		while(!$sim) {
			$ts = clone $this->transitions;
			$ts->reverse();
			
			// New Simulation
			$rs = new ReservationSimulator();
			while($_res = $ts->pop())
				$rs->addTransition($_res);
			$sim = $rs->simulate();
			
			// pop the last transition on failure recheck bookings
			if(!$sim) $this->dismissedTrans->push($this->transitions->pop());
		}
		
		return $this->finish();
		

		while($o = $this->dismissedTrans->pop())
			_debug($o->getId());
			
	}
	
	/**
	 * @deprecated
	 * quick check
	 * @return Ambigous <Ambigous, boolean, mixed>
	 */
	static function quickCheck() {
		$c = new Cronjob();
		return $c->checkBookings();
	}
	
	/**
	 * set the remaining Transitions to queued status
	 */
	private function finish() {
		$res = true;
		while($res = $this->transitions->pop()) 
			$res->queued();
		while($res = $this->dismissedTrans->pop()) 
			if($res->getStatus() == 'queued') {
				$res->prefered();
				$res = false;
			}
		
		return $res;
	}
	
	/**
	 * init relevant Transitions for reservations simulator
	 */
	private function initTransitions() {
		
		
		self::$_db->saveQry("SELECT ID FROM `#_reservations` ".
				"WHERE (`status` = 'queued' OR `status` = 'pending' OR `status` = 'prefered') ".
				"AND ? <= `startTime` AND `startTime` <= ? ". 
				"ORDER BY FIELD(`status`, 'queued','prefered','pending') , `ID` DESC",
				date("Y-m-d H:i"), Calendar::startAccept());
		
		
		while($res = self::$_db->fetch_assoc()) 
			$this->transitions->push(Reservation::load($res['ID']));
		
		// TagesEnde - BuchungsAcceptZeit ist kleiner als Aktueller Zeitblock
		if(Calendar::calculateTomorrow()) {
			$opening = Calendar::opening(date('Y-m-d', strtotime("tomorrow")));
			self::$_db->saveQry("SELECT ID FROM `#_reservations` ".
					"WHERE (`status` = 'queued' OR `status` = 'pending' OR `status` = 'prefered') ".
					"AND ? <= `startTime` AND `startTime` <= ? ". 
					"ORDER BY FIELD(`status`, 'queued','prefered','pending') , `ID` DESC",
					$opening->format("Y-m-d H:i"), 
					Calendar::startAccept($opening->format("Y-m-d H:i")));
			
			
			while($res = self::$_db->fetch_assoc())
				$this->transitions->push(Reservation::load($res['ID']));
			
		}
			
	}
	
	/**
	 * dismiss the unattended reservations
	 */
	function unattended() {
		self::$_db->saveQry("SELECT `ID` FROM `#_reservations` ".
				"WHERE (`status` = 'queued') ".
				"AND `startTime` <= ?",
				Calendar::unattended());
		
		while($res = self::$_db->fetch_assoc())
			Reservation::load($res['ID'])->unattended();
	}
	
	/**
	 * cancel pending reservations that werent served
	 */
	function cancelPending() {
		self::$_db->saveQry("SELECT `ID` FROM `#_reservations` ".
				"WHERE (`status` = 'pending' OR `status` = 'prefered') ".
				"AND ? >= `startTime` ",
				Calendar::startCancel());
		

		while($res = self::$_db->fetch_assoc())
			Reservation::load($res['ID'])->failed();
		
		
		// TagesEnde - BuchungsCancelZeit ist kleiner als Aktueller Zeitblock
		if(Calendar::calculateTomorrow()) {
			$opening = Calendar::opening(date('Y-m-d', strtotime("tomorrow")));
			self::$_db->saveQry("SELECT * FROM `#_reservations` ".
					"WHERE (`status` = 'pending' OR `status` = 'prefered') ".
					"AND ? <= `startTime` AND `startTime` <= ? ",
					$opening->format("Y-m-d H:i"), 
					Calendar::startCancel($opening));
			
			while($res = self::$_db->fetch_assoc())
				Reservation::load($res['ID'])->failed();
		}
		
	}
}
?>