<?php
global $con;

if(isset($con))
	return;

//$con = new mysqli("mysql.dur.ac.uk", "dcs0zz26", "mo4rning", "Xdcs0zz26_shaid");
$con = new mysqli("localhost", "root", "root", "gp");

if(mysqli_connect_error()) {
	die("Database connection failed: " . mysqli_connect_error());
}
?>
