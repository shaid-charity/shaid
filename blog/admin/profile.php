<?php
$title = "Profile";
define('CURRENT_PAGE', 'profile');

require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once 'header.php';

$query = $con->prepare("SELECT email, first_name, last_name, avatar, biography FROM users WHERE user_id=?");
$query->bind_param("s", $USER_ID);
$query->execute();
$query->bind_result($email, $first_name, $last_name, $avatar, $biography);
$query->fetch();
$query->close();

if($_SERVER["REQUEST_METHOD"] == "POST"){
  switch ($_POST["action"]) {
    case 'RESET':
      if ($_POST['pass'] == $_POST['passRetype']) {
        $salt = generateSalt();
        $hash = hash("sha256", getValidData($_POST["pass"]) . $salt);
        $query = $con->prepare("UPDATE users SET pass_salt=?, pass_hash=? WHERE user_id=?");
        $query->bind_param("sss", $salt, $hash, $USER_ID);
        $query->execute();
        $query->close();

        echo '<script>var success = true;</script>';
      } else {
        echo '<script>alert("Passwords did not match, so your password was not changed!);</script>';
      }

      break;
    
    case 'UPDATE':
      $emailExists = checkIfEmailExists($con, $_POST['user_email'], $USER_ID);

      if(validateUser($_POST['user_email'], $_POST['first_name'], $_POST['last_name'], $_POST['biography']) && !$emailExists){   
        // Upload image if one exists
        $file = $_FILES['avatar'];

        // If a new avatar was uploaded, change it
        if (file_exists($file['tmp_name'])) {
          $uploadManager = new UploadManager();
          $uploadManager->setUploadLocation('../images/avatars/');
          $uploadManager->setFilename($file['name']);
          $imagePath = $uploadManager->getPath();
          $uploadManager->upload($file);
        }

        $query = $con->prepare("UPDATE users SET email=?, first_name=?, last_name=?, biography=?, avatar=? WHERE user_id=?;");
        $query->bind_param("ssssss", getValidData($_POST["user_email"]), getValidData($_POST["first_name"]), getValidData($_POST["last_name"]), getValidData($_POST['biography']), getValidData($imagePath), $USER_ID);
        $query->execute();
        $query->close();
        header("Location: profile.php");
      } else {
        if($emailExists){
          echo "<script>alert('This email is already in use');</script>";
        } else {
          echo "<script>alert('something went wrong');</script>";
        }
      }
      break;
    
    default:
      die("Undefined action");
      break;
  }
}

?>

  
    <div class="container">
      <div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Reset password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="profile.php" method="post" id="passResetForm">
                <input type="hidden" name="action" value="RESET">
                <div class="form-group">
                  <label for="pass" class="form-control-label">Password:</label>
                  <input type="password" class="form-control" id="pass" name="pass" required>
                  <small class="form-text text-muted">Must contain at least one digit, capital letter, and be at least 8 characters long</small>
               </div>
               <div class="form-group">
                  <label for="passRetype" class="form-control-label">Retype password:</label>
                  <input type="password" class="form-control" id="passRetype" name="passRetype" required>
               </div>
               <div class="modal-footer">
                  <input type="submit" class="btn btn-primary mr-auto" id="submit" value="Change password">
                </div>
             </form>
            </div>
          </div>
        </div>
      </div>

      <div class="page-header">
        <h1>Profile</h1>
      </div>
      </br>
      <div class="alert alert-success" role="alert" id="passResetAlert">
        Your password was successfully changed!
      </div>
      <div id="userInfo">
        <form method="POST" enctype="multipart/form-data" id="user_info_form">
          <input type="hidden" name="action" value="UPDATE"/>
          <table class="table">
            <tr>
              <td>Email:</td>
              <td class="infoDisplay"><?php echo $email;?></td>
              <td class="infoEdit hidden"><input type="email" class="form-control" id="user_email" name="user_email"
                  pattern="(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|&quot(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*&quot)@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])" required
                  value="<?php echo $email;?>">
              </td>
            </tr>
            <tr>
              <td>First Name:</td>
              <td class="infoDisplay"><?php echo $first_name;?></td>
              <td class="infoEdit hidden">
                <input type="text" class="form-control" id="first_name" name="first_name" maxlength="30" required
                value="<?php echo $first_name;?>">              
              </td>
            </tr>
            <tr>
              <td>Last Name:</td>
              <td class="infoDisplay"><?php echo $last_name;?></td>
              <td class="infoEdit hidden">
                <input type="text" class="form-control" id="last_name" name="last_name" maxlength="30" required
                value="<?php echo $last_name;?>">              
              </td>
            </tr>
            <tr>
              <td>Profile Picture:</td>
              <td class="infoDisplay"><img src="<?php echo $avatar; ?>"><?php echo $avatar;?></td>
              <td class="infoEdit hidden">
  		          <input type="file" class="custom-file-input" id="avatar" name="avatar" value="<?php echo $avatar;?>">                
              </td>
            </tr>
            <tr>
              <td>Biography:</td>
              <td class="infoDisplay"><?php echo $biography;?></td>
              <td class="infoEdit hidden">
                <textarea class="form-control" id="biography" name="biography" rows="6" maxlength="1000"><?php echo $biography;?></textarea>                
              </td>
            </tr>
          </table>
        </form>
      </div>
      <div id="controls">
        <button type="button" id="reset" class="btn btn-primary" data-toggle="modal" data-target="#resetPasswordModal">Change Password</button>
        <button type="button" id="edit" class="infoDisplay btn btn-primary">Edit</button>
        <button type="button" id="cancel" class="infoEdit btn btn-primary hidden">Cancel</button>
        <button type="button" id="save" class="infoEdit btn btn-primary hidden">Save</button>
      </div>
      <form method="POST" id="pass_reset_form">
        <form method="POST" id="pass_reset_form">
          <input type="hidden" name="action" value="RESET"/>
        </form>
      </div>
  </body>
  <script>
    $(document).ready(function(){
      var editMode = false;

      if (typeof success == 'undefined') {
        $('#passResetAlert').hide();
      } else {
        $('#passResetAlert').show();
      }

      /*$("#reset").on("click", function(){
        if(confirm("Are you sure want to reset your password? You will be logged out immediately.")){
          $("#pass_reset_form").submit();
        }
      });*/

      $("#edit").on("click", function(){
        toggleView();
      });

      $("#cancel").on("click", function(){
        toggleView();
      });

      $("#save").on("click", function(){
        var emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var email = $("#user_email").val();
        var firstName = $("#first_name").val().trim();
        var lastName = $("#last_name").val();
        
        if(!emailRegex.test(email)){
          alert("Invalid Email");
          return;
        }
        if(!(firstName.length > 0 && firstName.length <= 30)){
          alert("Invalid First Name");
          return;
        }
        if(!(lastName.length > 0 && lastName.length <= 30)){
          alert("Invalid Last Name");
          return;
        }
        $("#user_info_form").submit();
      });

      function toggleView(){
        if(editMode){
          $(".infoEdit").addClass("hidden");
          $(".infoDisplay").removeClass("hidden");
        } else {
          $(".infoEdit").removeClass("hidden");
          $(".infoDisplay").addClass("hidden");
        }
        editMode = !editMode;
      }
    });

    $(document).ready(function(){
      var password = "";
      
      $("#submit").click(function(){
        if($("#pass").val() != $("#passRetype").val() || !validatePassword(password)){
          $("#passRetype").addClass("has-error");

        } else {
          $("#passResetForm").submit();
        }
      });

      $("#pass").on("keyup", function(){
        $("pass").removeClass("is-valid");
        $("#pass").removeClass("is-invalid");
        password = $("#pass").val();

        if(validatePassword(password)){
          $("#pass").addClass("is-valid");    
        } else {
          $("#pass").addClass("is-invalid");
        }
      });

      $("#passRetype").on("keyup", function(){
        $("#passRetype").removeClass("is-valid");
        $("#passRetype").removeClass("is-invalid");
        
        if((password == $("#passRetype").val()) && validatePassword(password)){
          $("#passRetype").addClass("is-valid");
        } else {
          $("#passRetype").addClass("is-invalid");
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
</html>
