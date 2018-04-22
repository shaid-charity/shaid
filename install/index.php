<!-- TODO: Move this whole folder into /blog and change path of generated config.php -->
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|PT+Sans:700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="../blog/style/main.css" rel="stylesheet">
	<link href="../blog/style/blog.css" rel="stylesheet">
	<link href="../blog/style/admin.css" rel="stylesheet">
	<style>
		.centre {
		    margin: auto;
		    width: 50%;
		    padding: 10px;
		}

		.success {
			color: green;
			font-weight: bold;
		}

		.failed {
			color: red;
			font-weight: bold;
		}

		.row {
			padding-top: 10px;
		}

		.instructions {
			padding-bottom: 10px;
		}

		#logo {
			padding-bottom: 50px;
			display: block;
			width: 25%;
			margin-left: auto;
			margin-right: auto;
		}
	</style>

	<title>SHAID Software Installation</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<img src="../blog/assets/logo.jpg" alt="SHAID" id="logo"/>
<div class="content-grid no-sidebar main-content centre">
	<h1>SHAID Software Installation</h1><br />

	<?php
		if (!defined('PHP_VERSION_ID')) {
		    $version = explode('.', PHP_VERSION);

		    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
		}

		// If no action is set, get database connection details
		if (!isset($_GET['step'])) {
	?>
		<div class="instructions">Please enter your database details. Default values have already been entered, but these may still need to be changed depending on your setup.</div>
		<form action="index.php?step=2" method="post">
			<div class="field post-input"><label for="host">Database host</label><input type="text" name="host" value="localhost"></div>
			<div class="field post-input"><label for="port">Database port</label><input type="number" name="port" value="3306"></div>
			<div class="field post-input"><label for="name">Database name</label><input type="text" name="name" value="gp_new"></div> <!-- TODO: Change default -->
			<div class="field post-input"><label for="user">Database user</label><input type="text" name="user" value="root"></div> <!-- TODO: Change default -->
			<div class="field post-input"><label for="pass">Database user password</label><input type="password" name="pass"></div>
			<div class="field post-input"><input class="button-green" type="submit"></div>
		</form>
	<?php
		} else if ($_GET['step'] == '2') {
			// Step 2 - check DB connection and other system requirements
			
			$host = $_POST['host'];
			$port = $_POST['port'];
			$name = $_POST['name'];
			$user = $_POST['user'];
			$pass = $_POST['pass'];

			$dbConnection = "<span class='success'>Database connection test successful!</span>";
			$success = true;

			try {
				$db = new PDO("mysql:host=" . $host . ";dbport=" . $port . ";dbname=" . $name, $user, $pass);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
			} catch (PDOException $e) {
				$success = false;

				// Get the type of error
				if ($e->getCode() == "2002") {
					$dbConnection = "<span class='failed'>A MySQL server at host $host could not be found!";
				} else if ($e->getCode() == "1049") {
					$dbConnection = "<span class='failed'>A database called $name could not be found!";
				} else {
					$dbConnection = "<span class='failed'>Could not connect to the MySQL server. Check the database port, username and password.";
				}
			}

			// We also need to check the PHP version
			if (PHP_VERSION_ID < 70000) {
				$success = false;
				$phpVersion = "<span class='failed'>Your PHP version is not greater than 7.0!</span>";
			} else {
				$phpVersion = "<span class='success'>You have PHP 7 or greater!</span>";
			}

			// And that the required extensions are installed
			$curlInstalled = "<span class='success'>php-curl is installed and enabled!</span>";

			if (!function_exists('curl_version')) {
				$success = false;
				$curlInstalled = "<span class='failed'>php-curl is not enabled!</span>";
			}
	?>
	<!-- Show the checks -->
	<div class="post-input">Database connection: <?php echo $dbConnection; ?></div>
	<div class="post-input">PHP version: <?php echo $phpVersion; ?></div>
	<div class="post-input">PHP cURL extension: <?php echo $curlInstalled; ?></div>

	<?php
			// If there was an error, the user needs to go back
			if (!$success) {
	?>

	<form action="index.php">
		<div class="post-input"><input class="button-dark" type="submit" value="Go back"></div>
	</form>

	<?php
			} else {

				// We can write the info to the config file
				$text = '<?php
// This is Matthew\'s DB file.
// TODO: Set up everything to use one DB connection

define( "APP_ROOT", realpath(dirname( __FILE__ ) ) . "/../");

//require_once "autoload.php";
//require_once APP_ROOT . "vendor/autoload.php";// Autoloads the packages installed via Composer that we use
//require_once "db.php"; // Require Dmyro\'s db.php

// If someone tries to load this file directly, then deny access
// The IN_APP constant is defined in settings.php
/*if (!defined("IN_APP")) {
	die("You cannot access this file directly");
}*/

// Databse constants that will be defined throughout the application
// TODO: We are opening two connections to the DB so that both my code and Dmytro\'s will work.
// This needs fixing ASAP
define("DB_HOST", "' . $host . '");
define("DB_PORT", "' . $port . '");
define("DB_NAME", "' . $name . '");
define("DB_USER", "' . $user . '");
define("DB_PASS", "' . $pass . '");

// Create a connection to the DB

try {
	$db = new PDO("mysql:host=" . DB_HOST . ";dbport=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
	echo "Error from config.php: <br />";
	echo $e->getMessage();
}'
				;

			file_put_contents('../config.php', $text);

			// At this stage we can also create the tables we need
			$sql = file_get_contents('./db.sql');
			$results = $db->exec($sql);

	?>
	<form action="index.php?step=3" method="post">
		<div class="post-input"><input class="button-green" type="submit" value="Next"></div>
	</form>
	<?php
			}
		} else if ($_GET['step'] == '3') {
	?>
	<div class="instructions">Please enter your email details. This email address will be used when sending newsletters and system notifications.</div>
	<form action="index.php?step=4" method="post">
		<div class="field post-input"><label for="address">Email address</label><input type="email" name="address"></div>
		<div class="field post-input"><label for="name">Email name</label><input type="text" name="name"></div>
		<div class="field post-input"><label for="pass">Email password</label><input type="password" name="pass"></div>
		<div class="field post-input"><label for="server">Email server</label><input type="text" name="host"></div>
		<div class="field post-input"><label for="port">Email server port</label><input type="number" name="port"></div>
		<div class="field post-input"><input class="button-green" type="submit"></div>
	</form>
	<?php
		} else if ($_GET['step'] == '4') {
			// There's no easy way to verify the email info - we'll just have to hope it was correct
			$address = $_POST['address'];
			$name = $_POST['name'];
			$pass = $_POST['pass'];
			$host = $_POST['host'];
			$port = $_POST['port'];

			$text = '
// Settings for sending emails via SwiftMailer
define("EMAIL_ADDRESS", "' . $address . '");
define("EMAIL_NAME", "' . $name . '");
define("EMAIL_PASSWORD", "' . $pass . '");
define("EMAIL_SERVER", "' . $host . '");
define("MAIL_PORT", ' . $port . ');
			';

			file_put_contents('../config.php', $text, FILE_APPEND);
	?>
	<script>
		$(':input').focus(function() {
			var pass = $('input[name=pass]').val();
			var passRetype = $('input[name=passRetype]').val();


			if (pass.length == 0 || passRetype.length == 0) {
				$('form').submit(false);
			} else if (pass != passRetype) {
				$('form').submit(false);
			} else {
				$('form').submit(true);
			}
		});
	</script>
	<div class="instructions">Please create your website administrator account.</div>
	<form action="index.php?step=5" method="post">
		<div class="field post-input"><label for="address">Email address: </label><input type="email" name="address"></div>
		<div class="field post-input"><label for="fname">First name: </label><input type="text" name="fname"></div>
		<div class="field post-input"><label for="sname">Second name: </label><input type="text" name="sname"></div>
		<div class="field post-input"><label for="pass">Password: </label><input type="password" name="pass"></div>
		<div class="field post-input"><label for="passRetype">Retype password: </label><input type="password" name="passRetype"></div>
		<div class="field post-input"><input class="button-green" type="submit"></div>
	</form>
	<?php
		} else if ($_GET['step'] == '5') {
			// config.php is complete, so we can include that for our DB connection
			// TODO: May need to change location
			require_once '../config.php';
			require_once '../back-end/includes/functions.php';

			$email = $_POST['address'];
			$fname = $_POST['fname'];
			$sname = $_POST['sname'];
			$pass = $_POST['pass'];

			if ($pass = $_POST['passRetype']) {
				$salt = generateSalt();
				$hash = hash("sha256", getValidData($pass) . $salt);

				$stmt = $db->prepare("INSERT INTO users(first_name, last_name, email, role_id, pass_salt, pass_hash, guest_blogger, can_represent_company, avatar, biography, disabled) VALUES(?,?,?,1,?,?,0,0,'','',0)");
				$stmt->execute([$fname, $sname, $email, $salt, $hash]);
	?>
	<div class="instructions">Installation has now finished. Remove the /install/ folder from the server.</div>
	<form action="<?php echo $_SERVER['HTTP_HOST']; ?>" method="post">
		<div class="post-input"><input class="button-green" type="submit" value="Finish"></div>
	</form>
	<?php
			} else {
	?>

	<div class="instructions">Your passwords did not match!</div>
	<form action="index.php?step=4" method="post">
		<div class="post-input"><input class="button-green" type="submit" value="Finish"></div>
	</form>

	<?php
			}
		}
	?>
</div>

</body>