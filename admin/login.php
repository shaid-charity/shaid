<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  require_once('../includes/db.php');
  if(!empty($_POST['user'])){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $query = $con->prepare("SELECT first_name, last_name, pass_salt, pass_hash FROM users WHERE user_id=?");
    $query->bind_param("s", $user);
    $query->execute();
    $query->bind_result($first_name, $last_name, $salt, $hash);
    $query->fetch();
    $query->close();

    if(!empty($hash)){
      if($hash == "undefined") {
        header("Location: passreset.php?user_id=" . $user);
        die();
      } else {
        if(hash("sha256", $pass . $salt) == $hash){
          session_start();
          $_SESSION["first_name"] = $first_name;
          $_SESSION["last_name"] = $last_name;

          $query = $con->prepare("INSERT INTO sessions (session_id, user_id, session_ip, session_expiration) VALUES(?, ?, ?, DATE_ADD(NOW(), INTERVAL 4 HOUR));");
          $query->bind_param("sss", session_id(), $user, $_SERVER['REMOTE_ADDR']);
          $query->execute();
          $query->close();
          header("Location: usermgmt.php");
          die();
        }
      }
    } else {
      header("Location: login.php");
      die();
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
