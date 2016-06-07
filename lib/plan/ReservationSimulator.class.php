<?php
// internals
define("TRANSITION_TOKEN_ADD_SUCCESS", 1);
define("TRANSITION_TOKEN_ADD_FAILED", -1);
define("TRANSITION_TOKEN_POP_SUCCESS", 2);
define("TRANSITION_TOKEN_POP_FAILED", -2);

/**
 * Simulator Class
 * @author joh
 *
 */
class ReservationSimulator {
	
	/**
	 * stores the transitions
	 * @var unknown
	 */
	private $transitions = array();
	
	/**
	 * stores the places
	 * @var unknown
	 */
	private $places = array();
	
	/**
	 * stores the bikes
	 * @var unknown
	 */
	private $bikes = array();
	
	/** 
	 * construct
	 */
	function __construct() {
		$this->initiate();
	}
	
	/**
	 * adds a Transition to the Simulation
	 * @param Transition $trans
	 */
	private function _addTransition(Transition $trans) {
		array_push($this->transitions, $trans);
		_debug("added Transition ".$trans);
	}
	
	/**
	 * Add an Reservation to the Transitions
	 * @param Reservation $res
	 */
	function addTransition(Reservation $res) {
		$this->_addTransition(new Transition(
				$this,
				$res->getId(),
				$this->places[$res->getStart()->getId()],
				$this->places[$res->getEnd()->getId()],
				$res->getStartTime(),
				$res->getEndTime()
		));
	}
	
	/**
	 * whether the bike is occupied at the moment
	 * @param unknown $res
	 */
	private function occupiedBike($res) {
		$idb = new Db();
		
		$this->bikes[$res['ID']] = new Token($res['ID']);
		$idb->saveQry("SELECT *,`#_reservations`.`startTime` AS ".
				"`sTime`,`#_reservations`.`endTime` AS `eTime` FROM `#_reservations` ".
				"LEFT JOIN `#_bookings` ON `#_bookings`.`ID` = `#_reservations`.`booking` ".
				"WHERE `status` = 'progress' ".
				"AND `#_reservations`.`startTime` >= ? AND `bike` = ? ORDER BY `#_reservations`.`ID` DESC LIMIT 1",
				date("Y-m-d"), $res['ID']);
		$r = $idb->fetch_assoc();
		$this->_addTransition(new Transition(
				$this,
				$r['ID'],
				$this->places[$r['startstation']],
				$this->places[$r['endstation']],
				$r['sTime'],
				$r['eTime'],
				$this->bikes[$r['bike']]
		));

		_debug("in Progress: ".$r['ID']);
		_debug("bike occupied: ".$res['ID']);
	}
	
	/**
	 * loads the Stations and Bikes
	 */
	private function initiate() {
		$db = new Db();
		
		// Stationen
		$db->saveQry("SELECT * FROM `#_stations`");
		while($res = $db->fetch_assoc())
			$this->places[$res['ID']] = new Place($res['ID']);
		_debug("--> loaded stations");
		
		// Raeder
		$db->saveQry("SELECT * FROM `#_bikes` WHERE `status` > 0");
		while($res = $db->fetch_assoc()) {
			// associate with Bike Station
			if(!empty($res['station']) && 
					array_key_exists($res['station'],$this->places)){
				$this->bikes[$res['ID']] = new Token($res['ID']);
				$this->places[$res['station']]->addToken($this->bikes[$res['ID']]); 
				
				
			// whether the bike is booked and not defect
			} elseif($res['status'] != '0' && !empty($res['booking']))
				$this->occupiedBike($res);
			
			
			// else Bike is Defect!
			else;
		}
		_debug("--> loaded bikes");
		$this->allowInit = true;
	}
	
	
	/**
	 * @deprecated
	 * 
	 * Transition init
	 * @return boolean
	 */
	function initTransitions() {
		if(!$this->allowInit) return false;
		$db = new Db();
		
		
		
		// QUEUED Reservations 
		// where StartBlock is Bigger then current
		// and Date equals the current
		$db->saveQry("SELECT * FROM `#_reservations` ".
				"WHERE (`status` = 'queued' OR `status` = 'pending' OR `status` = 'prefered') ".
				"AND `startTime` >= ? ".
				"ORDER BY `ID` DESC",
				date("Y-m-d H:i:s"));
		
		
		while($res = $db->fetch_assoc()) 
			$this->addTransition(new Transition(
							$this,
							$res['ID'],
							$this->places[$res['startstation']],
							$this->places[$res['endstation']],
							$res['startTime'],
							$res['endTime']
			));
		
		_debug("--> loaded queued");
		$this->allowInit = false;
		return true;
	}
	
	/**
	 * starts the simulation and returns the result
	 * @return boolean
	 */
	function simulate() {
		$result = true;
		
		// Sorting by Firetime to get a sorted process
		uasort($this->transitions, array($this, 'sortByFireTime'));
		
		$end = new DateTime(date("d.m.Y"));
		$end->modify("+1 days");
		for(	$itime = new DateTime(date("d.m.Y")); 
				$itime <= $end; $itime->modify("+1 minutes"))
			
		foreach($this->transitions as $trans) {
			$_result = $trans->execute($itime);
			
			// on fail! state the simulation failed
			if(	$_result == TRANSITION_TOKEN_POP_FAILED || 
				$_result == TRANSITION_TOKEN_ADD_FAILED )
				$result = false;
			
			// on success do nothing...
			if(	$_result == TRANSITION_TOKEN_POP_SUCCESS ||
				$_result == TRANSITION_TOKEN_ADD_SUCCESS );
		} 
		
		if(DEBUG) {  _debug("SIM: ".($result?"erfolg":"fehler")); }
		return $result;
	}
	
	/**
	 * Sorted by Fire Time
	 */
	function sortByFireTime(Transition $a, Transition $b) {
		if ($a->getTStart() == $b->getTStart()) {
			return 0;
		}
		return ($a->getTStart() < $b->getTStart()) ? -1 : 1;
	}
	
	/**
	 * transition status
	 */
	function listStatus() {
		foreach($this->transitions as $trans) {
			echo $trans->result()."\n\n";
		}
	}
}