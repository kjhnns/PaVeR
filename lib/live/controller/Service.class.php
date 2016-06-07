<?php

class Service {
	
	private $_stations = null;
	
	private $dates = null;
	
	static private $unique_instance = null;
	
	
	/**
	 * this function adds the date to the station and regards
	 * the timeframes, whether they shall be extended or a new one is needed
	 * 
	 * @param DateTime $start
	 * @param DateTime $end
	 * @param Station $p_station
	 */
	private function addToStation(	DateTime $start, DateTime $end, 
									Station $p_station = null) {
		
		$stations = array();
		if($p_station === null) 
			foreach($this->_stations as $_s)  
			$stations[] = $_s->getId();
		else $stations[] = $p_station->getId();
		
		foreach($stations as $station):
			$day = $start->format("Ymd");
			
			if(array_key_exists($day,$this->dates[$station])):
			foreach($this->dates[$station][$day] as $frameKey => $frame)  {
				// extend existing
				if($this->intersection($start, $end, $frame['s'], $frame['e'])) {
					$this->dates[$station][$day][$frameKey] = 
						array(
								"s" => min($start,$frame['s']),
								"e" => max($end,$frame['e'])
						);
					return true;
				// create new frame
				} else {
					$this->dates[$station][$day][] =
					array(
							"s" => $start,
							"e" => $end
					);
					return true;
				}
			}
			else:
				$this->dates[$station][$day][] =
				array(
						"s" => $start,
						"e" => $end
				);
					return true;
			endif;
		endforeach;
		
	}
	
	/**
	 * this function determines if there exists any intersections within 2 timeframes
	 * 
	 * @param DateTime $s1
	 * @param DateTime $e1
	 * @param DateTime $s2
	 * @param DateTime $e2
	 * @return boolean
	 */
	private function intersection( 	DateTime $s1, DateTime $e1, 
										DateTime $s2, DateTime $e2) {
		if($s1 <= $s2) return ($e1 >= $s2);
		if($s2 <= $s1) return ($e2 >= $s1);
		if($s1 == $s2 || $e1 == $e2) return true;
		return false;
	}

	/**
	 * compares the timeframes with the exception
	 * if there is an intersection the timeframes get adjusted
	 * @param DateTime $day
	 * @param DateTime $exStart
	 * @param DateTime $exEnd
	 * @param unknown $station
	 * @return boolean
	 */
	private function cmpSubstractException(	DateTime $day, DateTime $exStart, 
											DateTime $exEnd, $station) {
		$day = $day->format("Ymd");
		if(!array_key_exists($day,$this->dates[$station])) return true;
		
		foreach($this->dates[$station][$day] as $fKey => $frame):
			if($exStart <= $frame['s'] && $exEnd >= $frame['e']) {
				unset($this->dates[$station][$day][$fKey]);
				if(count($this->dates[$station][$day]) <= 0)
					unset($this->dates[$station][$day]);
			}
			elseif($this->intersection($exStart, $exEnd, $frame['s'], $frame['e'])) {
				if($exStart >= $frame['s'] && $exEnd <= $frame['e']) {
					$newKey = count($this->dates[$station][$day]);
					$this->dates[$station][$day][$fKey]["s"] = $frame['s'];
					$this->dates[$station][$day][$fKey]["e"] = new DateTime($frame['s']->format("Y-m-d")." ".
						$exStart->format("H:i") );
					$this->dates[$station][$day][$newKey]["s"] = new DateTime($frame['s']->format("Y-m-d")." ".
						$exEnd->format("H:i") );
					$this->dates[$station][$day][$newKey]["e"] = $frame['e'];
				} elseif($exStart < $frame['s']) {
				$this->dates[$station][$day][$fKey]["s"] = new DateTime($frame['s']->format("Y-m-d")." ".
						max($exEnd,$frame['s'])->format("H:i") );
				} else {
				$this->dates[$station][$day][$fKey]["e"] = new DateTime($frame['s']->format("Y-m-d")." ".
						min($exStart,$frame['e'])->format("H:i") );
				}
			}
		endforeach;
	}
	
	/**
	 * this function shall identify dates where 
	 * exceptions and opening dates collidate
	 * @param DateTime $start
	 * @param DateTime $end
	 * @param Station $station
	 */
	private function substractException(DateTime $start, DateTime $end, Station $p_station = null) {
		$stations = array();
		if($p_station === null) {
			foreach($this->_stations as $_s)
			$stations[] = $_s->getId();
		}else $stations[] = $p_station->getId();
		
		$_period = iterator_to_array(new DatePeriod($start, new DateInterval("P1D"), $end));
		
		foreach($stations as $station) {
		foreach($_period as $day)
			$this->cmpSubstractException($day, $start, $end, $station);
		
		}
		
	}
	
	/**
	 * This function identifies the periods and adds all the dates 
	 * 
	 * @param unknown $start
	 * @param unknown $end
	 * @param unknown $startDate
	 * @param Station $station
	 * @param string $endDate
	 * @param string $period
	 * @param string $duration
	 */
	private function addDate($start, $end,
							 $startDate, Station $station = null, 
							 $endDate = null, 
							 $period = null, $duration = null) {
		
		$_daykey = date("Ymd", strtotime($startDate));
	
		
		
		// initialising all the time frames
		$dates = array();
		if($endDate === null) {
			$__end = new DateTime($startDate." ".$end);
			//$__end->modify("+1 day");
			$this->addToStation(	new DateTime($startDate." ".$start), 
									$__end,
									$station	);
		} else {
			// creating the Interval
			if(empty($period) || empty($duration))
				$_interval = 	new DateInterval("P1D");
			else switch($period) {
				case 'weeks': 	$_interval = new DateInterval("P".	$duration."W"); break;
				case 'months': 	$_interval = new DateInterval("P".	$duration."M"); break;
				case 'years': 	$_interval = new DateInterval("P".	$duration."Y"); break;
				default: 		$_interval = new DateInterval("P".	$duration."D");
			}
			

			$__end = new DateTime($endDate);
			$__end->modify("+1 day");
			$_period = new DatePeriod(	new DateTime($startDate),
										$_interval,
										$__end);
			foreach($_period as $__date) 
				$this->addToStation(	new DateTime($__date->format("Y-m-d")." ".$start),
								 		new DateTime($__date->format("Y-m-d")." ".$end),
								 		$station	);
			
		}
	}
	
	/** 
	 * construct loading all the dates and exceptions
	 */
	function __construct($calOpen = null) {
		
		if($calClose === null && 
				self::$unique_instance !== null) exit;
		
		$db = new Db();

		$this->dates = array();
		foreach($this->_stations = Station::getAll() as $_st) 
			$this->dates[$_st->getId()] = array();
		
		
		// opening dates
		if($calOpen === null) $db->saveQry("SELECT * FROM `#_cal_open` ORDER BY `stime`");
		else $db->saveQry("SELECT * FROM `#_cal_open` WHERE `ID` = ? ORDER BY `stime`", $calOpen);
		
		while($row = $db->fetch_assoc())
			$this->addDate(	$row['stime'], $row['etime'], $row['date'], 
							empty($row['station'])?null:Station::load($row['station']),
							empty($row['enddate'])?null:$row['enddate'],
							$row['period'],
							$row['duration']	);
		
		
		// closing exceptions
		$db->saveQry("SELECT * FROM `#_cal_closed` ORDER BY `start`");
		
		while($row = $db->fetch_assoc()) 
			$this->substractException(	new DateTime($row['start']), 
										new DateTime($row['end']), 
										empty($row['station'])?
											null:Station::load($row['station'])	);
		
		// DEFINETLY NEEDS CACHING HERE!
	}

	/**
	 * initiates an instance
	 * @return Service
	 */
	static function uInstance() {
		if(self::$unique_instance === null)
			self::$unique_instance = new Service();
	
		return self::$unique_instance;
	}
	
	/**
	 * return the frames of the given day
	 * @param Station $st
	 * @return boolean
	 */
	static function frames(Station $st, $day = false) {
		$u = self::uInstance();
		if($day ===  false) $day = date("Ymd"); else
		$day = date("Ymd",strtotime($day));
		
		if(array_key_exists($day, $u->dates[$st->getId()])) 
			return $u->dates[$st->getId()][$day];
		
		return false;
	}
	
	/**
	 * returns the endtime of the given day
	 * @param string $day
	 * @return mixed|boolean
	 */
	static function end($day = false) {
		$u = self::uInstance();
		if($day ===  false) $day = date("Ymd"); else
			$day = date("Ymd",strtotime($day));

		$max = new DateTime("1980-01-01");
		if($s === null) {
			foreach($u->dates as $station)
			if(array_key_exists($day, $station))
			foreach($station[$day] as $frame) 
				$max = max($frame['e'],$max);
			return $max;	
		}

		if(array_key_exists($day, $u->dates[$s->getId()])){
		foreach($u->dates[$s->getId()][$day] as $frame)
			$max = max($frame['e'],$max);

			return $max;
		}
		return false;
	}
	
	/**
	 * returns the starttime of the given day
	 * @param string $day
	 * @return mixed|boolean
	 */
	static function start($day = false) {
		$u = self::uInstance();
		if($day ===  false) $day = date("Ymd"); else
			$day = date("Ymd",strtotime($day));

		$max = new DateTime("3000-12-31");
		if($s === null) {
			foreach($u->dates as $station)
			if(array_key_exists($day, $station))
			foreach($station[$day] as $frame) 
				$max = min($frame['s'],$max);
			return $max;	
		}

		if(array_key_exists($day, $u->dates[$s->getId()])) {
		foreach($u->dates[$s->getId()][$day] as $frame)
			$max = min($frame['s'],$max);
		return $max;
		}
		return false;
	}
	
	/**
	 * checks whether the given day has timeframes
	 * @param unknown $d
	 * @return boolean
	 */
	static function checkDay($d, Station $s = null) {
		$u = self::uInstance();
		$day = date("Ymd",strtotime($d));
		if($s === null) {
			foreach($u->dates as $stations) 
			if(array_key_exists($day,$stations)) return true;
			return false;
		}

		return (array_key_exists($day, $u->dates[$s->getId()]));
	}
	
	/**
	 * checks whether the service is open at that moment
	 * @param DateTime $d
	 * @return boolean
	 */
	static function check(DateTime $d, Station $station) {
		$u = self::uInstance();
		if(!array_key_exists($d->format("Ymd"), $u->dates[$station->getId()])) return false;
		
		foreach($u->dates[$station->getId()][$d->format("Ymd")] as $fKey => $frame) 
			if($frame['s'] <= $d && $d <= $frame['e']) return true;
		
		return false;
	}
	
	/**
	 * checks whether the service is open at that moment
	 * @param DateTime $d
	 * @param Station $station
	 * @return boolean
	 */
	function _check(DateTime $d, Station $station) {
		$u = $this;
		if(!array_key_exists($d->format("Ymd"), $u->dates[$station->getId()])) return false;
		
		foreach($u->dates[$station->getId()][$d->format("Ymd")] as $fKey => $frame) 
			if($frame['s'] <= $d && $d <= $frame['e']) return true;
		
		return false;
	}
	
	
	/**
	 * checks whether the reservation is within the given service instance
	 * @param Reservation $res
	 * @return boolean
	 */
	function checkReservation(Reservation $res) {
		$sT = new DateTime($res->getStartTime());
		$sS = $res->getStart()->getId();
		if(array_key_exists($sT->format("Ymd"), $this->dates[$sS]))
			foreach($this->dates[$sS][$sT->format("Ymd")] as $fKey => $frame)
				if($frame['s'] <= $sT && $sT <= $frame['e']) return true;
		
		$eT = new DateTime($res->getEndTime());
		$eS = $res->getEnd()->getId();
		if(array_key_exists($eT->format("Ymd"), $this->dates[$eS]))
			foreach($this->dates[$eS][$eT->format("Ymd")] as $fKey => $frame)
				if($frame['s'] <= $eT && $eT <= $frame['e']) return true;
		
		return false;
	}
	
	/**
	 * Checks whether the given Reservation is within the start and end DateTimes
	 * important too check when you add an new closed frame for the calendar
	 *  
	 * @param DateTime $start
	 * @param DateTime $end
	 * @param Reservation $res
	 * @param Station $s
	 * @return boolean
	 */
	static function checkReservationInFrame(DateTime $start, DateTime $end, Reservation $res, Station $s = null) {
		$sT = new DateTime($res->getStartTime());
		$eT = new DateTime($res->getEndTime());
		
		if($s === null) 
			return 	($start <= $sT && $sT <= $end) ||
					($start <= $eT && $eT <= $end);

		if($res->getStart()->getId() == $s->getId() && 
				($start <= $sT && $sT <= $end)) return true;

		if($res->getEnd()->getId() == $s->getId() && 
				($start <= $eT && $eT <= $end)) return true;

		_debug("");
		return false;
	}
	
}

?>