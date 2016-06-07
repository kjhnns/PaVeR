<?php
/**
 * Transition, represents a reservation
 * @author joh
 *
 */
class Transition {
	
	/**
	 * reservation id
	 * @var unknown
	 */
	private $id;
	
	/**
	 * the start time
	 * @var int
	 */
	private $fireTime;
	
	/**
	 * the end time
	 * @var unknown
	 */
	private $doneTime;
	
	/**
	 * Station a 
	 * @var Place
	 */
	private $stationA;
	
	/**
	 * station b
	 * @var Place
	 */
	private $stationB;
	
	/**
	 * Bike
	 * @var Token
	 */
	private $token = null;

	/**
	 * status variables
	 * @var boolean
	 */
	private $active = false, $failed = false;
	
	/**
	 * simulator
	 * @var unknown
	 */
	private $rSimulator;
	
	/**
	 * live
	 * @var unknown
	 */
	private $live;
	
	/**
	 * construct
	 * @param ReservationSimulator $rS
	 * @param unknown $id
	 * @param Place $a
	 * @param Place $b
	 * @param string $fTime
	 * @param Token $token
	 */
	function __construct(ReservationSimulator $rS, $id, Place $a, Place $b, $fTime = null, $dTime = null, Token $token = null) {
		$this->rSimulator = $rs;
		
		$this->stationA = $a;
		$this->stationB = $b;
		
		$this->id = $id;
		$this->fireTime = new DateTime($fTime);
		$this->doneTime = new DateTime($dTime);
		
		$this->live = false;
		
		// token given, means that the transition is active
		if($token !== null) {
			$this->token = $token;
			$this->failed = false;
			$this->startTime = $ftime;
			$this->active = true;
			$this->live = true;
		}
	}
	
	/**
	 * to string
	 * @return string
	 */
	public function __toString() {
		return "{ ".$this->id.": ".$this->stationA." -> ".$this->stationB." }";
	}
	
	/**
	 * executes the transfer
	 * @param int $time
	 * @return string|NULL result
	 */
	function execute(DateTime $time) {
		// Start of the Transition
		if(($this->fireTime) <= $time && ($this->token===null) && (!$this->failed)) {
			if($this->stationA->isEmpty()) {
				$this->failed = true;
				return TRANSITION_TOKEN_POP_FAILED;
			}
			$this->active = true;
			$this->token = $this->stationA->popToken();
			return TRANSITION_TOKEN_POP_SUCCESS;
		}
		
		// End of the Transition
		if( ($this->doneTime <= $time) 
				&& ($this->token !== null) && ($this->active) && (!$this->failed)) {
			if(!$this->stationB->hasSlot()) return TRANSITION_TOKEN_ADD_FAILED;
			$this->active = false;
			$this->stationB->addToken($this->token);
			return TRANSITION_TOKEN_ADD_SUCCESS;
		}
		
		return null;
	}
	
	/**
	 * returns whether the transition was successfull
	 * @return boolean
	 */
	function successfull() {
		return (!$this->failed && !$this->active);
	}
	
	/**
	 * id
	 * @return unknown
	 */
	function getId() {
		return $this->id;
	}
	
	/**
	 * Token
	 * @return Token
	 */
	function getToken() {
		return $this->token;
	}
	
	/**
	 * station a
	 * @return Place
	 */
	function getStationA() {
		return $this->stationA;
	}
	
	/**
	 * station b
	 * @return Place
	 */
	function getStationB() {
		return $this->stationB;
	}
	
	/**
	 * Time
	 * @return number
	 */
	function getTStart() {
		return $this->fireTime;
	}
	
	/**
	 * Time
	 * @return number
	 */
	function getTEnd() {
		return $this->doneTime;
	}
	
	/**
	 * string result
	 * @return string
	 */
	function result() {
		$ttt = $this->token== null ? "kein Fahrrad vorhanden": $this->token;
		return "{\n".
				"\t ReservierungsNummer:\t ".$this->id." \n".
				"\t Start Zeit:\t\t ".b2Time($this->getTStart())."\n".
				"\t Start Station:\t\t ".Station::load($this->stationA->getId())->getTitle()." \n".
				"\t End Zeit:\t\t ".b2Time($this->getTEnd())."\n".
				"\t End Station:\t\t ".Station::load($this->stationB->getId())->getTitle()." \n".
				"\t Pedelec Nummer:\t\t ".$ttt." \n".
				"\t wird ausgeführt:\t".($this->live?"ja":"nein")."\n".
				"\t => \t ".($this->successfull()?"erfolgreich":"fehlerhaft")."\n".
				"}";
	}
	
}