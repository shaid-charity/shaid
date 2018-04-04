<?php
// This header file will include everything we need for the user management. This way we do not need to repeat any code.
session_start();
require_once('../includes/db.php');
require_once('../includes/functions.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if($_POST["action"] == "LOGOUT"){
    $query = $con->prepare("DELETE FROM sessions WHERE session_id=?");
    $query->bind_param("s", session_id());
    $query->execute();
    $query->close();
    header("Location: login.php");
  }
}

$query = $con->prepare("SELECT user_id, session_number FROM sessions WHERE session_id=? AND session_ip=? AND session_expiration > NOW() ORDER BY session_number DESC;");

$query->bind_param("ss", session_id(), $_SERVER["REMOTE_ADDR"]);
$query->execute();
$query->bind_result($USER_ID, $session_number);
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

  //old permission check

  //$role_id 1 is super admin
  //if($role_id > 1){
  //  die("You don't have permission to access this page");
  //  header("Location: login.php?back=viewPosts.php"); //view posts as a default redirect for wrong permission
//
  //  //header("Location: login.php?back=" . $_SERVER['PHP_SELF']);
  //    //return;
  //}
  //edit this to manage minimum permission for each page
  
  $query = $con->prepare("UPDATE sessions SET session_expiration = DATE_ADD(NOW(), INTERVAL 4 HOUR) WHERE session_number=?");
  $query->bind_param("s", session_id());
  $query->execute();
  $query->close();

  $page_min_permissions = array(
    "/usermgmt.php" => 1,
    "/contactDB.php" => 2,
    "/viewEvents.php" => 3,
    "/event.php" => 3,
    "/campaign.php" => 2,
    "/viewCampaigns.php" => 2,
    "/post.php" => 5,
    "/viewPosts.php" => 5,
    "/createCategory.php" => 3,
    "/viewCategories.php" => 3,
  );

  $page_name = strrchr($_SERVER['PHP_SELF'], "/");
  if($role_id > $page_min_permissions[$page_name]){
    header("Location: login.php?back=viewPosts.php"); //view posts as a default redirect for wrong permission
  }
}

?>

<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" href="css/style.css">
  <style>
    .hidden {
      display:none;
    }
  </style>
</head>

<body>
  <!-- Top navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
    <a class="navbar-brand" href="#">SHAID Admin Panel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown <?php if (substr(CURRENT_PAGE, 0, 7) == 'content') echo 'active'; ?>">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Content
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item <?php if (CURRENT_PAGE == 'contentCreateCategory') echo 'active'; if($role_id > 3) echo ' hidden';?>" href="createCategory.php">Create Category</a>
              <a class="dropdown-item <?php if (CURRENT_PAGE == 'contentViewCategories') echo 'active'; if($role_id > 3) echo ' hidden';?>" href="viewCategories.php">View Categories</a>
              <a class="dropdown-item <?php if (CURRENT_PAGE == 'contentCreatePost') echo 'active'; ?>" href="post.php">Create Post</a>
              <a class="dropdown-item <?php if (CURRENT_PAGE == 'contentViewPosts') echo 'active'; ?>" href="viewPosts.php">View Posts</a>
          </div>
        </li>
        <li class="nav-item dropdown <?php if (substr(CURRENT_PAGE, 0, 9) == 'campaigns') echo 'active'; if($role_id > 2) echo ' hidden';?>">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Campaigns
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item <?php if (CURRENT_PAGE == 'campaignsCreate') echo 'active'; ?>" href="campaign.php">Create Campaign</a>
            <a class="dropdown-item <?php if (CURRENT_PAGE == 'campaignsView') echo 'active'; ?>" href="viewCampaigns.php">View Campaigns</a>
          </div>
        </li>
        <li class="nav-item dropdown <?php if (substr(CURRENT_PAGE, 0, 6) == 'events') echo 'active'; if($role_id > 3) echo ' hidden';?>">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Events
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item <?php if (CURRENT_PAGE == 'eventsCreate') echo 'active'; ?>" href="event.php">Create Event</a>
            <a class="dropdown-item <?php if (CURRENT_PAGE == 'eventsView') echo 'active'; ?>" href="viewEvents.php">View Events</a>
          </div>
        </li>
        <li class="nav-item <?php if (CURRENT_PAGE == 'contactDB') echo 'active'; if($role_id > 2) echo ' hidden';?>">
          <a class="nav-link" href="contactDB.php">Contact DB <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item <?php if($role_id > 1) echo ' hidden';?>">
          <a class="nav-link" href="usermgmt.php">User Management</a>
        </li>
      </ul>

      <form class="form-inline my-2 my-lg-0" method="POST" style="float:right;">
        <input type="hidden" name="action" value="LOGOUT"/>
        <input type='submit' class='btn btn-outline-danger my-2 my-sm-0' value="Log Out" />
      </form>
    </div>
  </nav>