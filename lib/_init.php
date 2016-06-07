<?php
/*
 * debug internal
 */

define("DEBUG", false);


/*
 * benchmark
 */
function _microTime() {
	list($a,$b) = explode(" ", microtime()); return $a+$b;
}
define("BENCHSTART", _microTime());
define("MEMORYSTART", memory_get_usage());
$GLOBALS['_GLOBAL_QRYS'] = 0;
function _debug($txt) { $GLOBALS['_DEBUG'][] = $txt; }

/*
 * paths
 */
define("RUNID",		md5(_microTime().$_SERVER['REMOTE_ADDR'].rand(0, 99999999)));
define("ROOT", 		"./");
define("LIB",		ROOT."lib/");
define("LIVE",		ROOT."lib/live/");
define("LIVECTRLW",	ROOT."lib/live/controller/worker/");
define("LIVECTRL",	ROOT."lib/live/controller/");
define("LIVEMDL",	ROOT."lib/live/models/");
define("PLAN",		ROOT."lib/plan/");
define("TEMPLATE", 	ROOT."template/");
define("CONFIG",	ROOT."etc/");


// initializing necessary classes
include(LIVECTRLW.	"Moderator.class.php");
include(LIVECTRL.	"Index.class.php");
include(LIVECTRL.	"Agb.class.php");
include(LIVECTRL.	"Map.class.php");
include(LIVECTRL.	"Reserve.class.php");
include(LIVECTRL.	"MyBookings.class.php");
include(LIVECTRL.	"Cronjob.class.php");
include(LIVECTRL.	"Calendar.class.php");
include(LIVECTRL.	"Message.class.php");
include(LIVECTRL.	"Rights.class.php");
include(LIVECTRL.	"Service.class.php");

// for the planing system
function initPlaningSystem() {
	require(PLAN."models/Place.class.php");
	require(PLAN."models/Token.class.php");
	require(PLAN."models/Transition.class.php");
	require(PLAN."ReservationSimulator.class.php");
}

/*
 * init
 */
include(LIB.		"Db.class.php");
include(LIB.		"Model.class.php");
include(LIB.		"Cache.class.php");
include(LIB.		"Session.class.php");
include(LIB.		"Stack.class.php");
include(LIVEMDL.	"User.class.php");
include(LIVEMDL.	"Bike.class.php");
include(LIVEMDL.	"Accessorie.class.php");
include(LIVEMDL.	"Preferences.class.php");
include(LIVEMDL.	"Booking.class.php");
include(LIVEMDL.	"Station.class.php");
include(LIVEMDL.	"Reservation.class.php"); 
include(LIVEMDL.	"Report.class.php");
session_start();
if(!DEBUG) error_reporting(0);
ob_start();
@set_magic_quotes_runtime(0);
date_default_timezone_set('Europe/Berlin');
mt_srand((double)microtime() * 98989);
initPlaningSystem(); 
Preferences::uInstance(); 
new Agb();
function password($str) { return hash("sha512", 
		$str."salty&fish%20urgh!", false); }
function cmplt($a , $b = false) {
	if($b == false) $b = new DateTime(date("Y-m-d H:i:s"));
	$a = new DateTime($a);
	return $a <= $b;
}
function mailCheck($m) {
	return preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*".
				"@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$m);
}
function fdate($d) {
	$dt = new DateTime($d);
	return $dt->format("d.m.Y H:i");
}
function totalMinutes(DateInterval $di) {
	$minutes = $di->days * 24 * 60;
	$minutes += $di->h * 60;
	$minutes += $di->i;
	return $minutes;
}
function html($str) {
	return htmlspecialchars($str);
}

/*
 * preferences
 */
define("MAX_RIGHT_POS", 32);	
define("BOOKING_STARTACCEPT", 		Preferences::value("startAccept")); 
define("BOOKING_STARTCANCEL", 		Preferences::value("startCancel")); 


/* 
 * logout procedure
 */
if(isset($_GET['logout'])) {
	Session::destroy();
	header("location: index.php");
}


/*
 * Session check
 * + choosing Template 
 */
if(!defined("CRONJOB") || CRONJOB !== true) {
	try {
		$user = User::load();
		
	} catch(Exception $e) 
	// bad session
	{ session_destroy(); header("location: index.php"); }
	

	// shutdown function implemented in the template
	function shutdown() { Preferences::set('dbLock', 'null'); _shutdown();  }
	register_shutdown_function("shutdown");

	// template
	if($user && $user->validSession())  {
		if($user->isWorker()) include(TEMPLATE."moderator.php");
		else include(TEMPLATE."loggedIn.php");
	} elseif(defined("GUEST") && GUEST === true) {
		include(TEMPLATE."loggedOut.php");
	} else {
		include(TEMPLATE."login.php");
		exit;
	}
}
?>
