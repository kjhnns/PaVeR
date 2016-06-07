<?php
class User extends Model {
	private $id = null;
	
	private $matrikel = null;
	
	private $phone = null;
	
	private $name = null;

	private $bike = null;
	
	private $surname = null;
	
	private $booking = null;
	
	private $password = null;
	
	private $email = null;
	
	private $street = null;
	
	private $home = null;
	
	private $zip = null;
	
	private $major = null;
	
	private $birth = null;

	private $worker = 0;
	
	private $rights = 0;
	
	private $start = null;
	
	private $end = null;
	
	private $created = null;
	
	private $creator = null;
	
	static private $_users = null;
	
	function __construct($id) {
		parent::__construct();
		self::$_users[$id] = $this;
		
		$res = $this->fetchData($id);
		if(!$res) throw new Exception('No User found with that ID!');

		$this->id = 	$res['ID'];
		$this->name =	$res['name'];
		$this->email =	$res['email'];
		$this->phone =	$res['phone'];
		$this->zip =	$res['zip'];
		$this->street =	$res['street'];
		$this->home =	$res['home'];
		$this->major =	$res['major'];
		$this->birth = new DateTime($res['birth']);
		$this->start =  $res['start'];
		$this->creator =	User::load($res['creator']);
		$this->created =  	$res['created'];
		$this->end =  	$res['end'];
		$this->rights =	User::RightsNum2array($res['rights']);
		$this->matrikel =	$res['matrikel'];
		$this->password = $res['password'];
		$this->surname =	$res['surname'];
		$this->worker =	$res['worker']=='1' ? true: false;
		$this->bike = 	!empty($res['bike'])?Bike::load((int)$res['bike']):
						$this->bike = null;
		$this->booking = 	!empty($res['booking'])?Booking::load((int)$res['booking']):
							$this->booking = null;
		
	}
	
	static function search($mail) {
		try {
			$db = new Db();
			$db->saveQry("SELECT `ID` FROM `#_users` WHERE `email` = ? AND `worker` = '0'", $mail);
			$res = $db->fetch_assoc();
			
			if(empty($res['ID'])) return false;
			
			$u = User::load($res['ID']);
			return $u;
		} catch(Exception $e) {
			return false;
		}
		
	}
	
	static function RightsNum2array($p_i) {
		$p_i++; $p_i--;
		$tmp = str_split(str_pad(decbin((int)$p_i), MAX_RIGHT_POS, "0", STR_PAD_LEFT));
		for($i = 0; $i< MAX_RIGHT_POS; $i++) $tmp[$i] = $tmp[$i]=='1'?true:false;
		return $tmp;
	}
	
	static function RightsArray2Num($arr) {
		for($i = 0; $i< MAX_RIGHT_POS; $i++) $arr[$i] = $arr[$i]?1:0;
		return bindec(implode($arr));
	}
	
	function changePw($apw, $pw, $pww) {
		if(password($apw) != $this->password ||$pw != $pww || empty($pw) || strlen($pw) < 6) return false;
		$db = new Db();
		$db->saveQry("UPDATE `#_users` SET `password` = ? WHERE `ID` = ?",
					password($pw),
					$this->id
				);
		return true;
	}
	
	function changeMail($m, $mw) {
		if($m != $mw || !mailCheck($m)) return false;
		$db = new Db();
		$db->saveQry("UPDATE `#_users` SET `email` = ? WHERE `ID` = ?",
					$m,
					$this->id
				);
		$this->email = $m;
		return true;
	}
	
	function validSession() {
		return (password($_SERVER['REMOTE_ADDR'].$this->getId()) ==
				Session::get('sessionkey'));
	}
	
	static function workerSetStation(Station $s = null) {
		if($s == null) { Session::set("station", "-1"); return true; }
		if(Rights::hasStation($s)) {
			Session::set("station", $s->getId());
			return true;
		} return false;
	}

	static function workerGetStation() {
		$s = Session::get('station');
		if((int)$s <= 0) return false;
		try { $s = Station::load(intval($s)); }
		catch(Exception $e) { _debug($e->getTraceAsString()); return false; }
		if(Rights::hasStation($s)) return $s;
		return false;
	}
	
	static function getCustomers() {
		$db = new Db();
		$db->saveQry("SELECT `ID` FROM `#_users` WHERE `worker` = 0");
		$r = array();
		while($rr = $db->fetch_assoc()) $r[] = self::load($rr['ID']);
		
		return $r;
	}
	
	static function load($id = null) {
		if($id === null)
		if($sess = Session::get('user')) $id = (int)$sess;
		else return false;
		
		if(self::$_users === null) self::$_users = array();
		
		if(!array_key_exists($id, self::$_users))
			new User($id);
		
		return self::$_users[$id];
	}
	
	function getfName() {
		return $this->surname.", ".$this->name;
	}
	
	function getId() {
		return $this->id;
	}
	
	function getMail() {
		return $this->email;
	}
	
	
	
	function getHtml() {
		if($this->isWorker())
			return "<a href=\"_worker.php?wid=".$this->getId()."\" ".
					"data-toggle=\"tooltip\" class=\"text-success\" title=\"Telefonnummer: ".$this->getPhone()."\">".$this->getSurName().", ".$this->getName()."</a>";
				
		
		return "<a href=\"_overview.php?do=show&uid=".$this->getId()."\" ".
				"data-toggle=\"tooltip\" title=\"Matrikel Nummer: ".$this->getMatrikel()."\">".$this->getSurName().", ".$this->getName()."</a>";
	}
	
	function getBirth() {
		return $this->birth;
	}
	
	function getStreet() {
		return $this->street;
	}
	
	function getMajor() {
		return $this->major;
	}
	
	function getZip() {
		return $this->zip;
	}
	
	function getHome() {
		return $this->home;
	}

	function getStart() {
		return $this->start;
	}
	
	function getCreator() {
		return $this->creator;
	}
	
	function getCreated() {
		return new DateTime($this->created);
	}
	
	function getEnd() {
		return $this->end;
	}
	
	function getName() {
		return $this->name;
	}
	
	function getMatrikel() {
		return $this->matrikel;
	}
	
	function getSurName() {
		return $this->surname;
	}
	
	function getPhone() {
		return html($this->phone);
	}
	
	function getBike() {
		return $this->bike;
	}
	
	function isWorker() {
		return $this->worker==true;
	}
	
	function getBooking() {
		return $this->booking;
	}
	
	function getRights() {
		return $this->rights;
	}
	
	static function login($user, $pw) {
		$db = new Db();
		$db->saveQry("SELECT * FROM `#_users` WHERE `email` = ? ".
					"AND ((`start` <= NOW() AND NOW() <= `end`) OR (`start` = NULL AND `end` = NULL)) ", $user);
		$res = $db->fetch_assoc();
		if($user == $res['email'] && password($pw) == $res['password']) {
			Session::set('user', $res['ID']);
			Session::set('sessionkey', password($_SERVER['REMOTE_ADDR'].$res['ID']));
			return true;
		}
		return false;
	}
	
	function changePhone($phone) {
		$db = $this->getDb();
		$db->saveQry("UPDATE `#_users` SET `phone` = ? WHERE `ID` = ?", $phone, $this->id);
	}
	
	public function __toString() {
		return "[USER: ".$this->id." ]";
	}

	function _book(Booking $book) {
		if($this->booking !== null) return false;
		if($this->bike !== null) return false;
		$this->bike = $book->getBike();
		$this->booking = $book;
		
		$db = $this->getDb();
		return 	$db->saveQry("UPDATE `#_users` SET ".
				"`booking` = ?, `bike` = ? ".
				"WHERE `ID` = ?",
				$this->booking->getId(),
				$this->bike->getId(),
				$this->id);
	}
	
	function _reserve(Bike $bike) {
		if($this->bike !== null) return false;
		$this->bike = $bike;
		
		$this->getDb()->saveQry("UPDATE `#_users` SET `bike` = ? WHERE `ID` = ?",
				$this->bike->getId(),
				$this->getId());
		
		return true;
	}
	
	function _return() {
		if($this->booking === null) return false;
		if($this->bike === null) return false;
		$this->bike = null;
		$this->booking = null;
		
		$db = $this->getDb();
		return 	$db->saveQry("UPDATE `#_users` SET ".
				"`booking` = NULL, `bike` = NULL ".
				"WHERE `ID` = ?",
				$this->id);
	}
}
?>