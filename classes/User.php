<?php
/**
 * User Class
 * 
 * TimDev Login System
 * @author Tim M. <tim@timdev.nu>
 * @version 2.0
 * @copyright Copyright (c) 2016, Tim M. 
 */ 

class User {

	/**
	 * @var $fields
	 * @return array
	 */ 
	private $fields = [];

	/**
	 * @param string $id
	 * @return string $value
	 */ 
	public function __construct($id)
	{
		global $db;
		$sql = "SELECT * FROM users WHERE id=:id";

		$query = $db->prepare($sql);
		$query->execute(array(
			":id" => $id
		)); 
		foreach ($query->fetch() as $key => $value) {
			$this->fields[$key] = $value;
		}
	}

	/**
	 * Get user info from the database.
	 * @param string $key
	 * @return string
	 */ 
	public function data($key)
	{
		return isset($this->fields[$key]);
	}
	/**
	 * Check the username
	 * @param string $username
	 * @return mixed. User object|false 
	 */ 
	public static function ByUsername($username)
	{
		global $db;
		$sql = "SELECT * FROM users WHERE username = :username";
		$query = $db->prepare($sql);
		$query->execute(array(
			":username" => $username
		));
		if ($query->rowCount() == 1)
		{
			$getUserId = $query->fetch();
			return new User($getUserId['id']);
		}
		return false;
	}

	/**
	 * Check the password from the user.
	 * @param string $password.
	 * @return bool true|false
	 */ 
	public function login($password)
	{
		return (password_verify($password, $this->fields['password']));
	}

	/**
	 * Check wether the user is logged in or not
	 * @return bool true|false. True: loggedin, false: not loggedin.
	*/
	public static function loggedIn()
	{
		global $db;
		if (isset($_SESSION['id']))
		{
			$sql = 'SELECT * FROM sessions WHERE session_id = :session_id AND ip = :ip';
			var_dump($db);
			$query = $db->prepare($sql);
			$query->execute(array(
				':session_id' => self::$fields['sessions_id'],
				':ip' => self::$fields['ip_last']
			));
			if ($query->rowCount() == 1)
				return true;
			else
				return false;
		}
		return false;
	}

	public function session($user_id = null)
	{
		global $db;
		$session_id = sha1(uniqid(mt_rand(), true));
		$sql = 'INSERT INTO sessions (user_id, session_id, time, ip) VALUES (:user_id, :session_id, :time, :ip)';
		$query = $db->prepare($sql);
		$query->execute(array(
			':user_id' => $user_id,
			':session_id' => $session_id,
			':time' => strtotime("now"),
			':ip' => getIP()
		));
		$sqlUsers = 'UPDATE users SET session_id = :session_id WHERE id = :id';
		$updateQuery = $db->prepare($sqlUsers);
		$updateQuery->execute(array(':id' => $user_id, ':session_id' => $session_id));
	}
}