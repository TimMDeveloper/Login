<?php
/**
 * TimDev Login System
 * @author Tim M. <tim@timdev.nu>
 * @version 2.0
 * @copyright Copyright (c) 2016, Tim M.
 */

if (session_status() == PHP_SESSION_NONE) 
{
    session_start();
}

/**
 * Including config, functions and classes files.
 */
require_once 'config.php';
require_once 'functions.php';
require_once 'classes/User.php';

/**
 * Check of the user logged in is.
 */ 
if (User::loggedIn())
{
	$user = new User($_SESSION['id']);
}

$error = null;
include "content/header.php";
if(isset($_GET['p']))
{
	$page = $_GET['p'];
	$allowedFiles = ['404', 'home', 'index', 'logout', 'register'];
	if($page && in_array($page, $allowedFiles))
	{
		include("pages/$page.php");
	}
	else
	{
		include('pages/index.php');
	}
}
else
{
	include('pages/index.php');
}
include 'content/footer.php';
