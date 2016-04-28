<?php
/**
 * Includes file
 * 
 * TimDev Login System
 * @author Tim M. <tim@timdev.nu>
 * @version 2.0
 * @copyright Copyright (c) 2016, Tim M. 
 */ 

require_once "functions.php";
require_once "classes/User.php";

if (User::loggedIn())
{
	$user = new User($_SESSION['id']);
}