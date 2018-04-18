<?php
// This is Matthew's DB file.
// TODO: Set up everything to use one DB connection

define( "APP_ROOT", realpath(dirname( __FILE__ ) ) . "/../");

require_once "autoload.php";
require_once APP_ROOT . "vendor/autoload.php";// Autoloads the packages installed via Composer that we use
require_once "db.php"; // Require Dmyro's db.php

// If someone tries to load this file directly, then deny access
// The IN_APP constant is defined in settings.php
if (!defined("IN_APP")) {
	die("You cannot access this file directly");
}

// Databse constants that will be defined throughout the application
// TODO: We are opening two connections to the DB so that both my code and Dmytro's will work.
// This needs fixing ASAP
define("DB_HOST", "localhost");
define("DB_PORT", "3306");
define("DB_NAME", "gp_new");
define("DB_USER", "root");
define("DB_PASS", "root");

// Create a connection to the DB

try {
	$db = new PDO("mysql:host=" . DB_HOST . ";dbport=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
	echo "Error from config.php: <br />";
	echo $e->getMessage();
}
// Settings for sending emails via SwiftMailer
define("EMAIL_ADDRESS", "fdsfsd@fds.com");
define("EMAIL_NAME", "fds");
define("EMAIL_PASSWORD", "fdsf");
define("EMAIL_SERVER", "fsd");
define("MAIL_PORT", 3);
			
// Settings for sending emails via SwiftMailer
define("EMAIL_ADDRESS", "");
define("EMAIL_NAME", "");
define("EMAIL_PASSWORD", "");
define("EMAIL_SERVER", "");
define("MAIL_PORT", );
			
// Settings for sending emails via SwiftMailer
define("EMAIL_ADDRESS", "");
define("EMAIL_NAME", "");
define("EMAIL_PASSWORD", "");
define("EMAIL_SERVER", "");
define("MAIL_PORT", );
			