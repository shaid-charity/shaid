<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  require_once('../includes/db.php');
  if(!empty($_POST['user'])){
    $user_email = $_POST['user'];
    $pass = $_POST['pass'];
    $query = $con->prepare("SELECT user_id, first_name, last_name, pass_salt, pass_hash, disabled FROM users WHERE email=?");
    $query->bind_param("s", $user_email);
    $query->execute();
    $query->bind_result($user_id, $first_name, $last_name, $salt, $hash, $disabled);
    $query->fetch();
    $query->close();

    if($disabled){
      //echo "<script>alert('Your account has been disabled. Please contact system administrator');</script>";
      //header("Location: login.php");
      die('Your account has been disabled. Please contact system administrator');          
    } else {
      if(!empty($hash)){
        if($hash == "undefined") {
          //password has not been set yet
          header("Location: passreset.php?user_email=" . $user_email);
          die();
        } else {
          //check if password is correct
          if(hash("sha256", $pass . $salt) == $hash){
            session_start();
            //possible session variables to use as a greeting in the future
            $_SESSION["first_name"] = $first_name;
            $_SESSION["last_name"] = $last_name;
  
            //add login record into sessions table with 4 hour expiry timer
            $query = $con->prepare("INSERT INTO sessions (session_id, user_id, session_ip, session_expiration) VALUES(?, ?, ?, DATE_ADD(NOW(), INTERVAL 4 HOUR));");
            $query->bind_param("sss", session_id(), $user_id, $_SERVER['REMOTE_ADDR']);
            $query->execute();
            $query->close();
  
            // Decide where to go back to
            if (!isset($_GET['back'])) {
              header("Location: viewPosts.php");
              die();
            } else {
              header("Location: " . $_GET['back']);
              die();
            }
          }
        }
      } else {
        header("Location: login.php");
        die();
      }
    }
  } else {
    header("Location: login.php");
    die();
  }
}
?>

<html>
<head>
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.js" crossorigin="anonymous"></script>
  <title>SHAID Admin Panel - Login</title>

</head>
<body>
  <div id="login" class="container col-md-4 col-md-offset-4">
    <div class="panel panel-default" style="border-radius:18px; overflow:hidden; padding:15px">
      <form method="POST">
        <div class="input-group">
          <div class="input-group-prepend"><span class="fa fa-user input-group-text pt-2"></div>
            <input class="form-control" type="text" name="user" placeholder="Username"></br>
          </div>
        </br>
        <div class="input-group">
          <div class="input-group-prepend"><span class="fa fa-key input-group-text pt-2"></div>
            <input class="form-control" type="password" name="pass" placeholder="Password"></br>
          </div>
        </br>
        <input type="submit" class="btn btn-primary btn-block" value="Log in">
      </form>
      <div>
      </div>
    </body>
    </html>
