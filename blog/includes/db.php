<?php
// This is Dmytro's DB file
global $con;

if(isset($con))
	return;

$con = new mysqli("localhost", "root", "root", "gp_new", 8889);

if(mysqli_connect_error()) {
	die("Database connection failed: " . mysqli_connect_error());
}
?>
