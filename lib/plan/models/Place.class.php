<?php
/**
 * Place class
 * synonym for Station
 * @author joh
 *
 */
class Place extends Stack {
	/**
	 * station id
	 * @var unknown
	 */
	private $id;
	
	/**
	 * slot limit
	 * @var unknown
	 */
	private $limit;
	
	/**
	 * construct
	 * @param unknown $id
	 * @param string $limit
	 */
	function __construct($id, $limit = null) {
		parent::__construct();
		$this->id = $id;
		$this->limit = $limit;
	}
	
	/**
	 * adds a token
	 * @param Token $token
	 */
	function addToken(Token $token) {
		$this->push($token);
	}
	
	/**
	 * pops a token
	 * @return mixed
	 */
	function popToken() {
		return $this->pop();
	}
	
	/**
	 * returns whether there are slots 
	 * @return boolean
	 */
	function hasSlot() {
		if($this->limit === null) return true;
		return ($this->size() < $this->limit);
	}
	
	/**
	 * Station Id
	 * @return int
	 */
	function getId() {
		return $this->id;
	}
	
	/**
	 * to string
	 * @return string
	 */
	public function __toString() {
		return "[".$this->id."]";
	}
}