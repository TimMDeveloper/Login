<?php
/**
 * Config file
 * 
 * TimDev Login System
 * @author Tim M. <tim@timdev.nu>
 * @version 2.0
 * @copyright Copyright (c) 2016, Tim M. 
 */ 

 $config = [
 	"database" => [
	 		"host" => "localhost",
	 		"username" => "root",
	 		"password" => "root123",
	 		"database" => "login"
	 ],
	"site_name" => "LoginSystem",
	"url" => "http://localhost:8080/Login" // Url without /
 ];
 
/**
* Try to create a new PDO connection
*/
try {
	$db = new PDO('mysql:dbname='.$config['database']['database'].';host=' . $config['database']['host'], $config['database']['username'], $config['database']['password']);
}
catch(PDOexception $e) {
	echo 'Couldn\'t connect to the mysql server with details: <br />' . $e->getMessage(), 'Database connection error';
}