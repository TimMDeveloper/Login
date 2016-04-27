<?php
/**
 * TimDev Login System
 * @author Tim M. <tim@timdev.nu>
 * @version 2.0
 * @copyright Copyright (c) 2016, Tim M. 
 */ 

if(!session_start()) {
	session_start();
}

/**
 * Including config file.
 */ 
require_once "config.php";
require_once "includes.php";

/**
* Try to create a new PDO connection
*/
try {
	$db = new PDO('mysql:dbname='.$config['database']['database'].';host=' . $config['database']['host'], $config['database']['username'], $config['database']['password']);
}
catch(PDOexception $e) {
	echo 'Couldn\'t connect to the mysql server with details: <br />' . $e->getMessage(), 'Database connection error';
}

$error = "";
if(isset($_GET['p']))
{
	$page = $_GET['p'];	
	if($page)
	{
		$fileExists = $_SERVER['DOCUMENT_ROOT'] . '/pages/'.$page.".php";
		if(file_exists($fileExists))
		{
			include("pages/".$page.".php");
		} 
		else 
		{
			 include("pages/404.php"); 
		}
	} 
	else 
	{
		include("pages/index.php");
	}
} 
else 
{
	include("pages/index.php");
}