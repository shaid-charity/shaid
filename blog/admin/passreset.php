<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
  require_once("../includes/functions.php");
  require_once("../includes/db.php");
  $query = $con->prepare("SELECT user_id FROM users WHERE email=?");
  $query->bind_param("s", getValidData($_POST["user_email"]));
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.js" crossorigin="anonymous"></script>
  <title>SHAID Admin Style - Password Reset</title>
  <script>
    $(document).ready(function(){
      var password = "";
      
      $("#password_reset_button").click(function(){
        if($("#new_password").val() != $("#repeat_password").val() || !validatePassword(password)){
          $("#repeat_password_field").addClass("has-error");

        } else {
          $("#password_reset_form").submit();
        }
      });

      $("#new_password").on("keyup", function(){
        $("#new_password").removeClass("is-valid");
        $("#new_password").removeClass("is-invalid");
        password = $("#new_password").val();

        if(validatePassword(password)){
          $("#new_password").addClass("is-valid");    
        } else {
          $("#new_password").addClass("is-invalid");
        }
      });

      $("#repeat_password").on("keyup", function(){
        $("#repeat_password").removeClass("is-valid");
        $("#repeat_password").removeClass("is-invalid");
        
        if((password == $("#repeat_password").val()) && validatePassword(password)){
          $("#repeat_password").addClass("is-valid");
        } else {
          $("#repeat_password").addClass("is-invalid");
        }
      });

      function validatePassword(pass){
        if((password.length >= 8) && (password != password.toLowerCase()) && (/([0-9])+/.test(password))){
          return true;          
        } else {
          return false;
        }
      }
    });
  </script>
</head>
<body>
  <div id="login" class="container col-md-4 col-md-offset-4">
    <div class="panel panel-default" style="border-radius:18px; overflow:hidden; padding:15px">
      <form method="POST" id="password_reset_form">  
        <input type="hidden" name="user_email" value="<?php require_once("../includes/functions.php"); echo getValidData($_GET["user_email"]); ?>">
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