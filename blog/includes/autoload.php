<?php
// Create an autoload function that will try to load the class files of any classes we try to use
spl_autoload_register(function($className) {
	$path = 'includes' . DIRECTORY_SEPARATOR . $className . '.class.php';

	// If the file exists, load it
	if (file_exists($path)) {
		require_once $path;
		return;
	}

	// Try another path
	$path = '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $className . '.class.php';

	if (file_exists($path)) {
		require_once $path;
		return;
	}

	$path = $className . '.class.php';

	// If the file exists, load it
	if (file_exists($path)) {
		require_once $path;
		return;
	}

	// Try yet another path
	$path = '..' . DIRECTORY_SEPARATOR . 'back-end' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $className . '.class.php';

	// If the file exists, load it
	if (file_exists($path)) {
		require_once $path;
		return;
	}

	// Try yet another path
	$path = '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'back-end' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $className . '.class.php';

	// If the file exists, load it
	if (file_exists($path)) {
		require_once $path;
		return;
	}
});
?>
