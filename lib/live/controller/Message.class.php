<?php
/**
 * Service for customer messages
 */
class Message {
	
	private $title;
	private $message;
	private $user;

	/**
	 * initiates database connection
	 * & getting the relevant table
	 */
	function __construct($title, $message, User $user) {
		$this->user = $user;
		$this->message = $message;
		$this->title = $title;
	}
	
	private function send() {
		$db = new Db();
		
		
		$header = 	'Content-type: text/html; charset=utf-8' . "\r\n".
					'From: '. Preferences::value('mailFrom') . "\r\n" .
    				'Reply-To: '. Preferences::value('mailFrom') . "\r\n" ;
		
		$this->message = 	"<html>".
							"<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />".
							"<title>".Preferences::value('pageTitle')."</title></head>".
							"<body style=\"font-family: 'Verdana'; font-size: 14px;\">".
							$this->message.
							"</body></html>";
		
		
		$res = mail($this->user->getMail(), $this->title, $this->message, $header);
		
		$db->saveQry("INSERT INTO `#_messages` (`user`,`title`,`text`, `result`) VALUES (?,?,?,?)",
				$this->user->getId(),$this->title, $this->message,$res);
		return $res;
	}
	
	/**
	 * msg worker created
	 * @param User $u
	 * @param unknown $pw
	 * @return boolean
	 */
	static function workerCreated(User $u, $pw) {
		$title = 	Preferences::value("mTiWcreated");
		$message =  Preferences::value("mTxWcreated");
		

		$message = sprintf($message,
				$pw);
		
		$m = new Message($title, $message, $u);
		return $m->send();
	}
	
	/**
	 * msg customer created
	 * @param User $u
	 * @param unknown $pw
	 * @return boolean
	 */
	static function customerCreated(User $u, $pw) {
		$title = 	Preferences::value("mTiCcreated");
		$message =  Preferences::value("mTxCcreated");
		

		$message = sprintf($message,
				$pw);
		
		$m = new Message($title, $message, $u);
		return $m->send();
	}
	
	/**
	 * msg password changed
	 * @param User $u
	 * @param unknown $pw
	 * @return boolean
	 */
	static function pwChanged(User $u, $pw) {
		$title = 	Preferences::value("mTiPwReset");
		$message =  Preferences::value("mTxPwReset");
		
		
		$message = sprintf($message,
				$pw);
		
		$m = new Message($title, $message, $u);
		return $m->send();
	}
	
	/**
	 * msg reservation saved
	 * @param Reservation $res
	 * @return boolean
	 */
	static function saveSuccess(Reservation $res) {
		// reservation saved
		$title = 	Preferences::value("mTitlersave");
		$message =  Preferences::value("mTxtrsave");
		
		$message = sprintf($message, 
				$res->getId(), 
				date("d.m.Y H:i", strtotime($res->getStartTime())),
				date("d.m.Y H:i", strtotime($res->getEndTime())),
				$res->getStart()->getTitle(),
				$res->getEnd()->getTitle());
		
		$m = new Message($title, $message, $res->getUser());
		return $m->send();
	}

	/**
	 * msg for reminder for booking start
	 * @param Reservation $res
	 * @return boolean
	 */
	static function startReminder(Reservation $res) {
		$title = 	Preferences::value("mTiSRem");
		$message =  Preferences::value("mTxSRem");
	
		$message = sprintf($message,
				$res->getId(),
				date("d.m.Y H:i", strtotime($res->getStartTime())),
				date("d.m.Y H:i", strtotime($res->getEndTime())),
				$res->getStart()->getTitle(),
				$res->getEnd()->getTitle());
	
		$m = new Message($title, $message, $res->getUser());
		return $m->send();
	
	}
	
	/**
	 * msg for reminder for booking end
	 * @param Reservation $res
	 * @return boolean
	 */
	static function endReminder(Reservation $res) {
		$title = 	Preferences::value("mTiERem");
		$message =  Preferences::value("mTxERem");
		
		$message = sprintf($message, 
				$res->getId(), 
				date("d.m.Y H:i", strtotime($res->getStartTime())),
				date("d.m.Y H:i", strtotime($res->getEndTime())),
				$res->getStart()->getTitle(),
				$res->getEnd()->getTitle());
		
		$m = new Message($title, $message, $res->getUser());
		return $m->send();
		
	}
	
	static function canceled(Reservation $res) {
		// reservation got canceled
		$title = 	Preferences::value("mTitleCanceled");
		$message =  Preferences::value("mTxtCanceled");
		
		$message = sprintf($message, 
				$res->getId(), 
				date("d.m.Y H:i", strtotime($res->getStartTime())),
				date("d.m.Y H:i", strtotime($res->getEndTime())),
				$res->getStart()->getTitle(),
				$res->getEnd()->getTitle());
		
		$m = new Message($title, $message, $res->getUser());
		return $m->send();
	}
	
	/**
	 * msg for unattended reservations
	 * @param Reservation $res
	 * @return boolean
	 */
	static function unattended(Reservation $res) {
		// reservation got canceled
		$title = 	Preferences::value("mTitleunattended");
		$message =  Preferences::value("mTxtunattended");
		
		$message = sprintf($message, 
				$res->getId(), 
				date("d.m.Y H:i", strtotime($res->getStartTime())),
				date("d.m.Y H:i", strtotime($res->getEndTime())),
				$res->getStart()->getTitle(),
				$res->getEnd()->getTitle());
		
		$m = new Message($title, $message, $res->getUser());
		return $m->send();
	}
	
	/**
	 * msg for reservations that couldnt be served
	 * @param Reservation $res
	 * @return boolean
	 */
	static function failed(Reservation $res) {
		// booking failed
		$title = 	Preferences::value("mTitleFailed");
		$message =  Preferences::value("mTxtFailed");
		

		$message = sprintf($message,
				$res->getId(),
				date("d.m.Y H:i", strtotime($res->getStartTime())),
				date("d.m.Y H:i", strtotime($res->getEndTime())),
				$res->getStart()->getTitle(),
				$res->getEnd()->getTitle());
		
		$m = new Message($title, $message, $res->getUser());
		return $m->send();
	}
	
	/**
	 * msg if a reservation gets back to queued status
	 * @param Reservation $res
	 * @return boolean
	 */
	static function queued(Reservation $res) {
		// reservation got queued
		$title = 	Preferences::value("mTitleQueued");
		$message =  Preferences::value("mTxtQueued");
		

		$message = sprintf($message,
				$res->getId(),
				date("d.m.Y H:i", strtotime($res->getStartTime())),
				date("d.m.Y H:i", strtotime($res->getEndTime())),
				$res->getStart()->getTitle(),
				$res->getEnd()->getTitle());
		
		$m = new Message($title, $message, $res->getUser());
		return $m->send();
	}
	
	/**
	 * msg for reservation gets prefered status
	 * @param Reservation $res
	 * @return boolean
	 */
	static function prefered(Reservation $res) {
		$title = 	Preferences::value("mTitlePrefered");
		$message =  Preferences::value("mTxtPrefered");
		

		$message = sprintf($message,
				$res->getId(),
				date("d.m.Y H:i", strtotime($res->getStartTime())),
				date("d.m.Y H:i", strtotime($res->getEndTime())),
				$res->getStart()->getTitle(),
				$res->getEnd()->getTitle());
		
		$m = new Message($title, $message, $res->getUser());
		return $m->send();
	}
}