<?php
/**
 * class for sessions
 * 
 * @author joh
 *
 */
class Session {
	/**
	 * gets a session variable
	 * 
	 * @param unknown_type $val
	 */
	public static function get($val) {
		return 	empty($_SESSION[$val])?
				false:$_SESSION[$val];
	}
	/**
	 *	sets a session variable
	 */
	public static function set($key, $val) {
		$_SESSION[$key] = $val;
	}
	
	/**
	 * gets a session integer variable
	 *
	 * @param unknown_type $val
	 */
	public static function getInt($val) {
		return intval($_SESSION[$val]);
	}
	
	/**
	 * destroys a session
	 *
	 * @param unknown_type $val
	 */
	public static function destroy() {
		session_destroy();
	}
}
?>