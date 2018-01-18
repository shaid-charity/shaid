<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
  require_once("../includes/functions.php");
  require_once("../includes/db.php");
  $query = $con->prepare("SELECT user_id FROM users WHERE user_id=?");
  $query->bind_param("s", getValidData($_POST["user_id"]));
  $query->execute();
  $query->bind_result($user_id);
  $query->fetch();
  $query->close();

  if(!empty($user_id)){
    $salt = generateSalt();
    $query = $con->prepare("UPDATE users SET pass_salt=?, pass_hash=? WHERE user_id=?");
    $query->bind_param("sss", $salt, hash("sha256", getValidData($_POST["new_password"]) . $salt), $user_id);
    $query->execute();
    $query->close();
    header("Location: login.php");
    die();
  } else {
    header("Location: passreset.php");
    die();
  }
}

?>

<html>
<head>
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function(){
      $("#password_reset_button").click(function(){
        if($("#new_password").val() != $("#repeat_password").val()){
          $("#repeat_password_field").addClass("has-error");

        } else {
          $("#password_reset_form").submit();
        }
      });
    });
  </script>
</head>
<body>
  <div id="login" class="container col-md-4 col-md-offset-4">
    <div class="panel panel-default" style="border-radius:18px; overflow:hidden; padding:15px">
      <form method="POST" id="password_reset_form">  
        <input type="hidden" name="user_id" value="<?php require_once('functions.php'); echo getValidData($_GET["user_id"]); ?>">
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></div>
            <input class="form-control" type="password" name="new_password" id="new_password" placeholder="New Password"></br>
          </div>
        </br>
        <div class="form-group" id="repeat_password_field">
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></div>
              <input class="form-control" type="password" id="repeat_password" placeholder="Repeat Password"></br>
            </div>
          </br>
        </div>
        <button type="button" id="password_reset_button" class="btn btn-primary btn-block">Reset Password</button>
      </form>
      <div>
      </div>
    </body>
    </html>
