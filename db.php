<?php
  global $con;

  if(isset($con))
    return;

  $con = new mysqli("mysql.dur.ac.uk", "bzxr76", "jo88nes", "Xbzxr76_group_project");
  if(mysqli_connect_error()) {
		die("Database connection failed: " . mysqli_connect_error());
  }
?>
