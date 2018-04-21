<?php

spl_autoload_register(function($className) {
	$path = '..' . DIRECTORY_SEPARATOR . 'blog' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $className . '.class.php';

	// If the file exists, load it
	if (file_exists($path)) {
		require_once $path;
		return;
	}

	$path = 'blog' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $className . '.class.php';

	// If the file exists, load it
	if (file_exists($path)) {
		require_once $path;
		return;
	}

	
});