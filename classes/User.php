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
	 * @var array $fields The array with the model's data
	 */ 
	private $fields = [];

	/**
	 * @param string $id
	 * @return string $value
	 */ 
	public function __construct($id)
	{
		global $db;
		$query = $db->prepare('SELECT * FROM users WHERE id=:id');
		$query->execute(array(":id" => $id));
		if ($query->rowCount() == 1)
		{ 
			foreach ($query->fetch() as $key => $value) {
				$this->fields[$key] = $value;
			}
		}
	}

	/**
	 * Get user info from the database.
	 * @param string $key
	 * @return string
	 */ 
	public function data($key)
	{
		if(isset($this->fields[$key])) 
		{
			return $this->fields[$key];
		}
		return false;
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
		if (isset($_SESSION['id']))
		{
			return true;
		}
		return false;
	}

	/**
	 * Delete current session id. The user will be logout.
	 */ 
	public function logout()
	{
		global $config;
		if (isset($_SESSION['id']))
		{
			unset($_SESSION['id']);
		}
		header("Location: {$config['url']}");
	}
}