<?php
// This is Dmytro's DB file
global $con;

if(isset($con))
	return;

$con = new mysqli("host", "username", "password", "databaseName");

if(mysqli_connect_error()) {
	die("Database connection failed: " . mysqli_connect_error());
}
?>
