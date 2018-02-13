<?php

// This header file will include everything we need for the user management. This way we do not need to repeat any code.
session_start();
require_once('../includes/db.php');
require_once('../includes/functions.php');

$query = $con->prepare("SELECT session_number FROM sessions WHERE session_id=? AND session_ip=? AND session_expiration > NOW() ORDER BY session_number DESC;");

$query->bind_param("ss", session_id(), $_SERVER["REMOTE_ADDR"]);
$query->execute();
$query->bind_result($session_number);
$query->fetch();
$query->close();

if(empty($session_number)){
  header("Location: login.php?back=" . $_SERVER['PHP_SELF']);
  die('no session number');
    //return;
} else {
    //check if user has permission to access user management
  $query = $con->prepare("SELECT role_id FROM users, sessions WHERE users.user_id = sessions.user_id AND session_number=?");
  $query->bind_param("s", $session_number);
  $query->execute();
  $query->bind_result($role_id);
  $query->fetch();
  $query->close();

  //$role_id 1 is super admin
  if($role_id != 1){
    die("You don't have permission to access this page");
    header("Location: login.php?back=" . $_SERVER['PHP_SELF']);
      //return;
  }
  
  $query = $con->prepare("UPDATE sessions SET session_expiration = DATE_ADD(NOW(), INTERVAL 4 HOUR) WHERE session_number=?");
  $query->bind_param("s", session_id());
  $query->execute();
  $query->close();
}


?>