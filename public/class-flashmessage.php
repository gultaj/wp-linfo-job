<?php 
/**
* 
*/
class Wp_Job_Flash
{
	public static  $types   = ['danger', 'warning', 'info', 'success'];
	private static $_prefix = "linfo_job_";
	
	public function __construct($type = null, $message = null) {
		if( !session_id() ) session_start();
		if ( !is_null($type) ) {
			if ( !is_null($message) ) {
				$this->setFlash($type, $message);
 			} elseif ( !empty($type) ) {
 				$this->setType($type);
 			}
 		}
	}

	public static function setFlash($type, $message) {
		if( !session_id() ) session_start();
		if ( empty($type) || !in_array($type, self::$types) ) return false;
		if ( is_array($message) ) $message = serialize($message);
		$_SESSION[self::$_prefix . $type] = $message;
	}

	public function getFlash($type) {
		if ( empty($type) || !in_array($type, $this->types) ) return false;
		$key = $this->_prefix . $type;
		$message = isset($_SESSION[$key]) ? $_SESSION[$key] : false;
		unset($_SESSION[$key]);
		return $message;
	}

	public static function getFlashes() {
		$messages = [];
		$keys = array_keys($_SESSION);
		foreach ($keys as $key) {
			if ( $type = str_replace(self::$_prefix,'', $key) ) {
				$messages[$type] = $_SESSION[$key];
				unset($_SESSION[$key]);
			}
		}
		return count($messages) > 0 ? $messages : false;
	}

	public static function hasFlash($type = null) {
		if ( !is_null($type) && in_array($type, self::$types) ) {
			return isset($_SESSION[self::$_prefix.$type]);
		}
		foreach (self::$types as $type) {
			if ( isset($_SESSION[self::$_prefix.$type]) ) return true;
		}
		return false;
	}

	public function clearFlash($type = null) {
		if ( !is_null($type) ) {
			if( !in_array($type, $this->types) ) return false;
			unset($_SESSION[$this->_prefix.$type]);
		} else {
			foreach ($this->types as $type) {
				unset($_SESSION[$this->_prefix.$type]);
			}
		}
	}

	public function setType($type) {
		if ( !empty($type) && !in_array($type, $this->types) ) {
			$this->types[] = $type;
		}
	}
}
 ?>