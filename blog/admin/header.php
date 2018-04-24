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
    header("Location: ../login.php");
  }
}

$query = $con->prepare("SELECT user_id, session_number FROM sessions WHERE session_id=? AND session_ip=? AND session_expiration > NOW() ORDER BY session_number DESC;");

$query->bind_param("ss", session_id(), $_SERVER["REMOTE_ADDR"]);
$query->execute();
$query->bind_result($USER_ID, $session_number);
$query->fetch();
$query->close();

if(empty($session_number)){
  //header("Location: ../login.php?back=" . $_SERVER['PHP_SELF']);
  die('no session number');
    //return;
} else {
  //get role id
  $query = $con->prepare("SELECT role_id, disabled FROM users, sessions WHERE users.user_id = sessions.user_id AND session_number=?");
  $query->bind_param("s", $session_number);
  $query->execute();
  $query->bind_result($role_id, $disabled);
  $query->fetch();
  $query->close();

  if($disabled){
    header("Location: login.php");
  }
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

  $page_min_permissions = getPermissionArray();

  $page_name = strrchr($_SERVER['PHP_SELF'], "/");
  if($role_id > $page_min_permissions[$page_name]){
    header("Location: profile.php"); //profile as a default redirect for wrong permission
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
  <!--Editable combobox-->
  <!--<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
  <script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
  <link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
  -->
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|PT+Sans:700" rel="stylesheet">
  <style>
    .hidden {
      display:none !important;
    }

    body {
      padding-bottom: 100px;
    }

    input:invalid {
      border-color: #ffdddd;
    }

    .back-to-shaid {
      display: block;
      position: fixed;
      margin; 0;
      padding: 1.4rem;
      bottom: 0;
      left: 0;
      width: 100%;
      -webkit-appearance: none;
      border: none;
      background-color: #008194;
      color: #FFFFFF;
      font-size: 1.1rem;
      font-family: 'PT Sans', sans-serif;
      text-align: center;
      text-decoration: none;
      text-transform: uppercase;
      line-height: 1;
      transition: all 0.15s ease 0s;
      cursor: pointer;
    }

    .back-to-shaid:hover,
    .back-to-shaid:active {
      background-color: #018ea3;
      text-decoration: none;
      color: #FFFFFF;
    }
  </style>
  <title>SHAID Admin Panel - <?php echo $title ?></title>
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
        <li class="nav-item">
          <a class="nav-link <?php if (CURRENT_PAGE == 'profile') echo 'active'; ?>" href="profile.php">Profile</a>
        </li>
        <li class="nav-item dropdown <?php if (substr(CURRENT_PAGE, 0, 6) == 'social') echo 'active'; if($role_id > 2) echo ' hidden';?>">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Social Media
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item <?php if (CURRENT_PAGE == 'socialPost') echo 'active'; ?>" href="socialPost.php">Post</a>
            <a class="dropdown-item <?php if (CURRENT_PAGE == 'socialTrends') echo 'active'; ?>" href="socialTrends.php">Trends</a>
          </div>
        </li>
        <li class="nav-item <?php if(CURRENT_PAGE == 'companies') echo 'active'; if($role_id > 1) echo ' hidden';?>">
          <a class="nav-link" href="companies.php">Companies</a>
        </li>
        <li class="nav-item <?php if(CURRENT_PAGE == 'usermgmt') echo 'active'; if($role_id > 1) echo ' hidden';?>">
          <a class="nav-link" href="usermgmt.php">Users</a>
        </li>
      </ul>

      <form class="form-inline my-2 my-lg-0" method="POST" style="float:right;">
        <input type="hidden" name="action" value="LOGOUT"/>
        <input type='submit' class='btn btn-outline-danger my-2 my-sm-0' value="Log Out" />
      </form>
    </div>
  </nav>
  <!-- Return to home page button -->
  <a href="../index.php" class="back-to-shaid">
    Back to SHAID home
  </a>
