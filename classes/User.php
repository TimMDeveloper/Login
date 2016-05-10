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
		$query->execute([':id' => $id]);
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
		if(isset($this->fields[$key]) && $key !== 'password')
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
	public static function byUsername($username)
	{
		global $db;
		$query = $db->prepare('SELECT * FROM users WHERE username = :username');
		$query->execute([':username' => $username]);
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
		return password_verify($password, $this->fields['password']);
	}

	/**
	 * Check wether the user is logged in or not
	 * @return bool true|false. True: loggedin, false: not loggedin.
	*/
	public static function loggedIn()
	{
		return isset($_SESSION['id']);
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
	/**
	 * @param string $username
	 * @param string $password
	 * @return array msg
	 */
	public static function register($username, $password)
	{
		global $db, $config;
		$query = $db->prepare('SELECT `username` FROM `users` WHERE `username` = :username');
		$query->execute([':username' => $username]);
		if ($query->rowCount() == 0)
		{
			if (strlen($password) > 5)
			{
				$insertQuery = $db->prepare('
				INSERT INTO
					`users`
				(
					username,
					password,
					ip_reg,
					ip_last
				)
				VALUES
				(
					:username,
					:password,
					:ip_reg,
					:ip_last
				)
				');
				$insertQuery->execute([
					':username' => $username,
					':password' => password_hash($password, PASSWORD_BCRYPT),
					':ip_reg' => getIP(),
					':ip_last' => getIP()
				]);
				return ['msg' => 'U bent succesvol ingelogd.', 'id' => $db->lastInsertId()];
			}
			return ['msg' => 'Uw wachtwoord moet uit minimaal 6 karakters bestaan.'];
		}
		return ['msg' => 'Deze gebruikersnaam is al in gebruik.'];
	}
}
