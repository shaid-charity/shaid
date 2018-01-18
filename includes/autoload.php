<?php
// Create an autoload function that will try to load the class files of any classes we try to use
spl_autoload_register(function($className) {
	$path = 'includes' . DIRECTORY_SEPARATOR . $className . '.class.php';

	// If the file exists, load it
	if (file_exists($path)) {
		require_once $path;
	}

	// Try another path
	$path = '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $className . '.class.php';

	if (file_exists($path)) {
		require_once $path;
	}

	$path = $className . '.class.php';

	// If the file exists, load it
	if (file_exists($path)) {
		require_once $path;
	}
});
?>
