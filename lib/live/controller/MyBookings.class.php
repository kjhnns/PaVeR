<?php

/**
 * Controller for bookings
 *
 * @author Johannes
 *
 */
class MyBookings {
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
	 * get all reservations for customer
	 * @return Ambigous <mixed, string>
	 */
	function getReservations() {
		//caching missin
		self::$_db->saveQry("SELECT * FROM `#_reservations` WHERE `startTime` >= ? AND `user` = ? ORDER BY `ID` DESC", 
				date("Y-m-d"), User::load()->getId());
		while($r = self::$_db->fetch_assoc()) $res[] = $r;
		return $res;
	}
	
	/**
	 * cancel customer reservation
	 * @param unknown $id
	 */
	function cancelReservation($id) {
		self::$_db->saveQry("UPDATE `#_reservations` SET `status` = 'canceled', `canceled`= NOW() WHERE `ID` = ? AND `user` = ?",
				$id, User::load()->getId());
		Message::canceled(Reservation::load($id));
	}
	
	/**
	 * make a customer report
	 * @param unknown $comment
	 */
	function report($comment) {
		Report::userReport(User::load(), $comment);
	}
}
?>