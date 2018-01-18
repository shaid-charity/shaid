<?php
define( "APP_ROOT", realpath( dirname( __FILE__ ) ).'/../');

require_once 'autoload.php';
require_once APP_ROOT . 'vendor/autoload.php';// Autoloads the packages installed via Composer that we use
require_once 'db.php' // Require Dmyro's db.php

// If someone tries to load this file directly, then deny access
// The IN_APP constant is defined in settings.php
if (!defined('IN_APP')) {
	die('You cannot access this file directly');
}

/*
// May not be needed due to Dmytro's db.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Databse constants that will be defined throughout the application
define('DB_HOST', 'localhost');
define('DB_PORT', '8889');
define('DB_NAME', 'gp');
define('DB_USER', 'root');
define('DB_PASS', 'root');

// Create a connection to the DB

try {
	$db = new PDO("mysql:host=" . DB_HOST . ";dbport=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
	echo 'Error from config.php: <br />';
	echo $e->getMessage();
}*/

// Settings for sending emails via SwiftMailer
define('EMAIL_ADDRESS', 'matthew.accounts@gmx.com');
define('EMAIL_NAME', 'Matthew Watson');
define('EMAIL_PASSWORD', 'AbCd@0123');
define('EMAIL_SERVER', 'mail.gmx.com');
define('EMAIL_PORT', 587);