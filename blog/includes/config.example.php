<?php
// This is Matthew's DB file.
// TODO: Set up everything to use one DB connection

define( "APP_ROOT", realpath(dirname( __FILE__ ) ) . '/../');

require_once 'autoload.php';
require_once APP_ROOT . 'vendor/autoload.php';// Autoloads the packages installed via Composer that we use
require_once 'db.php'; // Require Dmyro's db.php

// If someone tries to load this file directly, then deny access
// The IN_APP constant is defined in settings.php
if (!defined('IN_APP')) {
	die('You cannot access this file directly');
}

// Databse constants that will be defined throughout the application
// TODO: We are opening two connections to the DB so that both my code and Dmytro's will work.
// This needs fixing ASAP
define('DB_HOST', 'host');
define('DB_PORT', 'port');
define('DB_NAME', 'database');
define('DB_USER', 'user');
define('DB_PASS', 'password');

// Create a connection to the DB
if(isset($con))
	return;

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(mysqli_connect_error()) {
	die("Database connection failed: " . mysqli_connect_error());
}

// Settings for sending emails via SwiftMailer
define('EMAIL_ADDRESS', 'email');
define('EMAIL_NAME', 'Sender Name');
define('EMAIL_PASSWORD', 'password');
define('EMAIL_SERVER', 'SMTP.Server.com');
define('EMAIL_PORT', 587);

// eBay settings for store.php
return [
    'sandbox' => [
        'credentials' => [
            'devId' => '',
            'appId' => '',
            'certId' => '',
        ],
        'userAuthToken' => ''
    ],
    'production' => [
        'credentials' => [
            'devId' => '',
            'appId' => '',
            'certId' => '',
        ],
        'userAuthToken' => ''
    ]
];