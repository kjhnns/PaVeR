<?php
/**
 * Token, represents a Bike
 * @author joh
 *
 */
class Token {
	/**
	 * bike id
	 * @var unknown
	 */
	private $id;
	
	/**
	 * construct
	 * @param unknown $id
	 */
	function __construct($id) {
		$this->id = $id;
	}

	/**
	 * to String
	 * @return string
	 */
	public function __toString() {
		return "(".$this->id.")";
	}
	
	/**
	 * returns the bike id
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
}

?>