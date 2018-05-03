<?php
$title = "User Management";
define('CURRENT_PAGE', 'usermgmt');

//require_once '../includes/settings.php';
require_once '../includes/db.php';
require_once 'header.php';
require_once '../includes/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
  switch ($_POST["action"]) {
    case 'ADD':
    $emailExists = checkIfEmailExists($con, $_POST['user_email'], -1);

    if(validateUser($_POST['user_email'], $_POST['first_name'], $_POST['last_name'], $_POST['biography']) && !$emailExists){
      //echo "validation successful";
      // If a new avatar was uploaded, change it
      // Upload image if one exists
      $file = $_FILES['avatar'];

      if (file_exists($file['tmp_name'])) {
        $uploadManager = new UploadManager();
        $uploadManager->setUploadLocation('../images/avatars/');
        $uploadManager->setFilename($file['name']);
        $imagePath = $uploadManager->getPath();
      }

      $representing = getRepresenting($_POST["representative"]);
      $query = $con->prepare("INSERT INTO users (first_name, last_name, email, role_id, pass_salt, pass_hash, guest_blogger, company_id, can_represent_company, avatar, biography, disabled) VALUES(?,?,?,?,?,?,?,?,?,?,?,?);");
      $query->bind_param("ssssssssssss", getValidData($_POST["first_name"]), getValidData($_POST["last_name"]), getValidData($_POST["user_email"]), getValidData($_POST["userperm"]), $salt = "undefined", $hash = "undefined", $guest = "0", getValidData($_POST["company"]), getValidData($representing), getValidData($imagePath), getValidData($_POST["biography"]), $disabled = "0");
      $query->execute();
      $query->close();

      // Send email for password reset
      $id = mysqli_insert_id($con);
      $addedUser = new User($db, $id);
      $addedUser->generatePasswordResetHash();

      $resetHash = $addedUser->getPasswordResetHash();

      // Now we have the password reset hash, send an email to the user
      $transport = new Swift_SmtpTransport(EMAIL_SERVER, EMAIL_PORT, 'tls');
      $transport->setUsername(EMAIL_ADDRESS);
      $transport->setPassword(EMAIL_PASSWORD);

      // Create a mailer
      $mailer = new Swift_Mailer($transport);

      $siteLink = $_SERVER['HTTP_HOST'] . '/' . INSTALLED_DIR . '/change-password.php?token=' . $resetHash;

      $content = "<h1>SHAID Admin Password Reset</h1><br /><br />" .
            "Please go to <a href='$siteLink'>this link</a> to reset your password.<br /><br />" .
            "If that link does not work, copy/paste the following into your browser:<br /><br />" .
            $siteLink;

      // Get a version of the message without any HTML tags
      // We can then send the plain text version as a backup, in case the HTML version won't load
      $messageNoHTML = strip_tags($content);

      // Create the message - recipient will be set later
      $message = new Swift_Message("SHAID Admin Password Reset");
      $message->setFrom(array(EMAIL_ADDRESS => EMAIL_NAME));
      $message->setBody($messageNoHTML);
      $message->addPart($content, 'text/html');

      // Send
      $message->setTo($addedUser->getEmail());

      $numSent = $mailer->send($message, $failed); 

      header("Location: usermgmt.php");
    } else {
      if($emailExists){
        echo "<script>alert('This email is already in use'); window.location.replace('usermgmt.php');</script>";
      } else {
        echo "<script>alert('something went wrong');</script>";
      }
    }
    break;

    case 'UPDATE':
    $emailExists = checkIfEmailExists($con, $_POST['user_email'], getValidData($_POST["user_id"]));

    if(validateUser($_POST['user_email'], $_POST['first_name'], $_POST['last_name'], $_POST['biography']) && !$emailExists){
      $representing = getRepresenting($_POST["representative"]);
      $query = null;
      $file = $_FILES['avatar'];

      if(!file_exists($file['tmp_name'])){      
        $query = $con->prepare("UPDATE users SET email=?, first_name=?, last_name=?, role_id=?, company_id=?, can_represent_company=?, biography=? WHERE user_id=?;");
        $query->bind_param("ssssssss", getValidData($_POST["user_email"]), getValidData($_POST["first_name"]), getValidData($_POST["last_name"]), getValidData($_POST["userperm"]), getValidData($_POST["company"]), getValidData($representing), getValidData($_POST['biography']), getValidData($_POST["user_id"]));
      } else {
        $uploadManager = new UploadManager();
        $uploadManager->setUploadLocation('../images/avatars/');
        $uploadManager->setFilename($file['name']);
        $imagePath = $uploadManager->getPath();
        $uploadManager->upload($file);
        

        $query = $con->prepare("UPDATE users SET email=?, first_name=?, last_name=?, role_id=?, company_id=?, can_represent_company=?, biography=?, avatar=? WHERE user_id=?;");
        $query->bind_param("sssssssss", getValidData($_POST["user_email"]), getValidData($_POST["first_name"]), getValidData($_POST["last_name"]), getValidData($_POST["userperm"]), getValidData($_POST["company"]), getValidData($representing), getValidData($_POST['biography']), getValidData($imagePath), getValidData($_POST["user_id"]));
      }
      $query->execute();
      $query->close();
      //header("Location: usermgmt.php");      
    } else {
      if($emailExists){
        echo "<script>alert('This email is already in use');</script>";
      } else {
        echo "<script>alert('validation failed');</script>";
      }
    }
    break;

    case 'DELETE':
    $query = $con->prepare("UPDATE users SET disabled=1 WHERE user_id=?");
    $query->bind_param("s", getValidData($_POST["user_id"]));
    $query->execute();
    $query->close();
    header("Location: usermgmt.php");
    break;

    case 'RESTORE':
    $query = $con->prepare("UPDATE users SET disabled=0 WHERE user_id=?");
    $query->bind_param("s", getValidData($_POST["user_id"]));
    $query->execute();
    $query->close();
    header("Location: usermgmt.php");
    break;

    //not currently used
    case 'RESET':
    $query = $con->prepare("UPDATE users SET pass_salt=?, pass_hash=? WHERE user_id=?");
    $query->bind_param("sss", $salt = "undefined", $hash = "undefined", getValidData($_POST["user_id"]));
    $query->execute();
    $query->close();
    header("Location: usermgmt.php");
    die();
    break;
    
    case 'LOGOUT':
    $query = $con->prepare("DELETE FROM sessions WHERE session_id=?");
    $query->bind_param("s", session_id());
    $query->execute();
    $query->close();
    header("Location: login.php");
    break;

    default:
      die("Something went wrong");
      break;
  }
  //header("Location: usermgmt.php");
  //die();
}
?>

  

  <div class="container">
    <div class="modal fade" id="userEditModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add/Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" id="restore_user_form">
              <input type="hidden" name="action" value="RESTORE"/>
              <input type="hidden" name="user_id" id="restore_id" value=""/>
            </form>
            <form method="POST" id="delete_user_form">
              <input type="hidden" name="action" value="DELETE"/>
              <input type="hidden" name="user_id" id="delete_id" value=""/>
            </form>
            <form method="POST" id="pass_reset_form">
              <input type="hidden" name="action" value="RESET"/>
              <input type="hidden" name="user_id" id="pass_reset_id" value=""/>
            </form>
            <form method="POST" id="user_details_form" enctype="multipart/form-data">
              <input type="hidden" name="action" id="user_details_form_action" value="UPDATE" />
              <input type="hidden" name="user_id" id="user_id" value=""/>
              <div class="form-group">
                <label for="user_email" class="form-control-label">Email:</label>
                <input type="email" class="form-control" id="user_email" name="user_email"
                  pattern="(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|&quot(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*&quot)@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])" required>
                <!-- regex from http://emailregex.com/ -->
              </div>
              <div class="form-group">
                <label for="first_name" class="form-control-label">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" maxlength="30" required>
              </div>
              <div class="form-group">
                <label for="last_name" class="form-control-label">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" maxlength="30" required>
              </div>
              <div class="form-group">
                <label for="userperm" class="form-control-label">Permissions:</label>
                <select class="form-control" name="userperm" id="userperm" required>
                  <?php
                    $query = $con->prepare("SELECT id, name, description FROM roles;");
                    $query->execute();
                    $query->bind_result($id, $name, $description); //description for tooltips
                    while ($query->fetch()) {
                      echo "<option value=".$id." data-toggle='tooltip' title='".$description."'>".$name."</option>";
                    }
                    $query->close();
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="company" class="form-control-label">Company</label>
                <select class="form-control" name="company" id="company" required>
                <?php
                    $query = $con->prepare("SELECT id, name FROM companies;");
                    $query->execute();
                    $query->bind_result($id, $name);
                    while ($query->fetch()) {
                      echo "<option value=".$id.">".$name."</option>";
                    }
                    $query->close();
                  ?>
                </select>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="representative" id="representative" value="1">
                  <label class="form-check-label" for="representative">Represents Company</label>
                </div>
              </div>
              <div class="custom-file">
  		          <input type="file" class="custom-file-input" id="avatar" name="avatar">
  		          <label class="custom-file-label" for="avatar" id="avatar">Choose profile picture</label>
	            </div>
              <div class="form-group">
                </br>
                <label class="form-control-label" for="biography">Biography:</label>
                <textarea class="form-control" id="biography" name="biography" rows="6" maxlength="1000"></textarea>
              </div>
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger mr-auto" id="delete_user">Delete User</button>
              <button type="button" class="btn btn-danger mr-auto" id="restore_user">Restore User</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="submit_user_details">Update User</button>  
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="page-header">
      <h1>User Management</h1>
    </div>
    <br />

    <!--
      <div id="addUser">
        <form method="POST">
          <input type="hidden" name="action" value="ADD" />
          User ID: <input type="text" name="user_id" /></br>
          First Name: <input type="text" name="first_name" /></br>
          Last Name: <input type="text" name="last_name" /></br>
          Permissions: <input type="text" name="permissions" /></br>
          <input type="submit" value="Add User" />
        </form>
      </div>
    -->

    <form class="form-inline" style="float:left;">
      <div class="form-group">
        <div class="input-group">
          <input type="text" class="form-control" name="" id="search_query"/>
          <span class="input-group-append">
            <button type="button" class="btn btn-primary mr-2" id="search_button">Search</button>
          </span>
        </div>
        <button type='button' class='btn btn-primary' data-toggle='modal' data-useraction='add' data-target='#userEditModal'>Add new User</button>
      </div>
    </form>
    
    <table id="table_of_users" class="table table-hover table-striped">
      <thead class="thead-light">
        <tr>
          <th>New</th>
          <th>Email</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Role</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
              //display users based on search query; if empty search or initial load of page -> show all users
          $sql = "SELECT user_id, email, first_name, last_name, roles.name, role_id, company_id, can_represent_company, biography, disabled FROM users, roles WHERE roles.id = users.role_id";
          $query = null;
          if(!empty($_GET["search_query"])){
            $sql .= " AND ((user_id LIKE ?) OR (first_name LIKE ?) OR (last_name LIKE ?)) ORDER BY disabled, first_name, last_name;";
            $search_query = "%" . getValidData($_GET["search_query"]) . "%";
            $query = $con->prepare($sql);
            $query->bind_param("sss", $search_query, $search_query, $search_query);
          } else {
            $sql .= " ORDER BY disabled, first_name, last_name;";
            $query = $con->prepare($sql);
          }
          $query->execute();
          $query->bind_result($user_id, $user_email, $first_name, $last_name, $role, $role_id, $company_id, $can_represent_company, $biography, $disabled);
          $query->store_result();

          $user_count = 0;
          while($query->fetch()){
            if($disabled){
              echo "<tr class='table-danger'>";
            } else {
              echo "<tr>";
            }

            //find if user has any unreviwed posts
            $sql = "SELECT COUNT(id) FROM posts WHERE user_id=? AND approved=0;";
            $countQuery = $con->prepare($sql);
            echo $con->error;
            $countQuery->bind_param("s", $user_id);
            $countQuery->execute();
            $countQuery->bind_result($notApprovedPostsCount);
            $countQuery->fetch();

            //display blue dot if the user has unreviewed posts
            if($notApprovedPostsCount > 0){
              echo "<td style='text-align:center; color:007bff'>&#9673</td>";
            } else {
              echo "<td></td>";
            }
            $countQuery->close();

            echo "<td>$user_email</td>";
            echo "<td>$first_name</td>";
            echo "<td>$last_name</td>";
            echo "<td>$role</td>";
            echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-useraction='update' data-target='#userEditModal' data-userid='".$user_id."' data-useremail='" . $user_email . "' data-firstname='" . $first_name . "' data-lastname='" . $last_name . "' data-permissions='" . $role . "' data-roleid='".$role_id."' data-companyid='".$company_id."' data-representative='".$can_represent_company."' data-biography='".$biography."' data-disabled='$disabled'>Edit User</button></td>";
            echo "<td><button type='button' class='btn btn-primary view_posts_button' data-userid='".$user_id."'>Posts</button></td>";
            echo "</tr>";
            $user_count += 1;
          }
          $user_count = 0;
          $query->close();
        ?>
      </tbody>
    </table>
  </div>
</body>
<script>
  $(document).ready(function(){
    //$("#company").editableSelect();

    var last_role = 5;
    $("#userEditModal").on("show.bs.modal", function(event){
      var user = $(event.relatedTarget);
      var modal = $(this);
      if(user.data("useraction") === "update"){
        modal.find("#pass_reset_id").val(user.data("userid"));
        modal.find("#delete_id").val(user.data("userid"));
        modal.find("#restore_id").val(user.data("userid"));
        modal.find("#user_id").val(user.data("userid"));
        modal.find("#user_email").val(user.data("useremail"));
        modal.find("#first_name").val(user.data("firstname"));
        modal.find("#last_name").val(user.data("lastname"));
        modal.find("#user_details_form_action").val("UPDATE");
        modal.find("#userperm").val(user.data("roleid"));
        modal.find("#company").val(user.data("companyid"));
        modal.find("#biography").val(user.data("biography"));
        if(user.data("representative") === 1){
          $("#representative").prop("checked", true);
        }
        $("#submit_user_details").html("Update user");
        if(user.data("disabled") == '0'){
          $("#restore_user").hide();          
          $("#delete_user").show();
        } else {
          $("#delete_user").hide();          
          $("#restore_user").show();
        }
        
        last_role = user.data("roleid");
      } else if(user.data("useraction") === "add"){
        last_role = 5;
        modal.find("#user_email").val("");
        modal.find("#first_name").val("");
        modal.find("#last_name").val("");
        modal.find("#userperm").val(5);
        modal.find("#company").prop("selectedIndex", 0);
        modal.find("#biography").val("");
        $("#representative").prop("checked", false);
        modal.find("#user_details_form_action").val("ADD");
        $("#submit_user_details").html("Add user");
        $("#delete_user").hide();
        $("#restore_user").hide();
        $("#pass_reset").hide();        
      }
    });
    $("#submit_user_details").click(function(event){
      //simple validation, will possibly add regex for first and last name
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
      $("#user_details_form").submit();
    });
    $("#delete_user").click(function(){
      if(confirm("Are you sure want to delete this user?")){
        $("#delete_user_form").submit();
      }
    });
    
    $("#restore_user").click(function(){
      if(confirm("Are you sure want to restore this user account?")){
        $("#restore_user_form").submit();
      }
    });

    //not currently used
    $("#pass_reset").on("click", function(){
      if(confirm("Are you sure want to reset password for this user?")){
        $("#pass_reset_form").submit();
      }
    });
    $("#search_button").click(function(){
      window.location.replace("usermgmt.php?search_query=" + $("#search_query").val());
    });
    $(".view_posts_button").on("click", function(event){
      var userID = $(this).data("userid");
      //alert("display posts for user id: " + userID);
      window.location.replace("../blog.php?user_id=" + userID);
    });
    $("#userperm").on("change", function(){
      var current_role = $("option:selected", this).val();
      if(current_role == 1 && confirm("Are you sure want to give this user access to everything?")){
        $("#userperm").val(current_role);
        last_role = current_role;          
      } else if(current_role > 1) {
        $("#userperm").val(current_role);          
        last_role = current_role;
      } else {
        $("#userperm").val(last_role);
      }
      
    });
  });
</script>
</html>
