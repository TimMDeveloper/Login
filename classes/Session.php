<?php
/**
 * Session Class
 * 
 * TimDev Login System
 * @author Tim M. <tim@timdev.nu>
 * @version 2.0
 * @copyright Copyright (c) 2016, Tim M. 
 */ 

class Session {
	public static function input($user_id = null)
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
	public static function delete($)
}