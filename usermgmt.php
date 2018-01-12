<?php
  session_start();
  require_once('db.php');
  require_once('functions.php');
  $query = $con->prepare("SELECT session_number FROM sessions WHERE session_id=? AND session_ip=? AND session_expiration > NOW();");
  $query->bind_param("ss", session_id(), $_SERVER["REMOTE_ADDR"]);
  $query->execute();
  $query->bind_result($session_number);
  $query->fetch();
  $query->close();

  if(empty($session_number)){
    header("Location: login.php");
    return;
  } else {
    $query = $con->prepare("UPDATE sessions SET session_expiration = DATE_ADD(NOW(), INTERVAL 4 HOUR) WHERE session_number=?");
    $query->bind_param("s", session_id());
    $query->execute();
    $query->close();
  }

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    switch ($_POST["action"]) {
      case 'ADD':
        $permissions = getPermissionString($_POST["user_perm"]);
        $query = $con->prepare("INSERT INTO users VALUES(?,?,?,?,?,?);");
        $query->bind_param("ssssss", getValidData($_POST["user_id"]), getValidData($_POST["first_name"]), getValidData($_POST["last_name"]), getValidData($permissions), $salt = "--------------------", $hash = "undefined");
        $query->execute();
        $query->close();
        break;

      case 'UPDATE':
        $permissions = getPermissionString($_POST["user_perm"]);
        $query = $con->prepare("UPDATE users SET user_id=?, first_name=?, last_name=?, user_perm=? WHERE user_id=?");
        $query->bind_param("sssss", getValidData($_POST["user_id"]), getValidData($_POST["first_name"]), getValidData($_POST["last_name"]), getValidData($permissions), getValidData($_POST["old_id"]));
        $query->execute();
        $query->close();
        break;

      case 'DELETE':
        $query = $con->prepare("DELETE FROM users WHERE user_id=?");
        $query->bind_param("s", getValidData($_POST["user_id"]));
        $query->execute();
        $query->close();
        break;

      default:
        # code...
        break;
    }
    header("Location: usermgmt.php");
    die();
  }
?>

<html>
  <head>
    <title>User Management</title>
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
        function updatePermissionGui(permissions){
          $("#user_perm_mgmt").prop('checked', false);
          $("#user_perm_blog").prop('checked', false);
          $("#user_perm_events").prop('checked', false);
          $("#user_perm_shop").prop('checked', false);

          if(permissions.includes("U")){
            $("#user_perm_mgmt").prop('checked', true); 
          }
          if(permissions.includes("B")){
            $("#user_perm_blog").prop('checked', true);
          }
          if(permissions.includes("E")){
            $("#user_perm_events").prop('checked', true); 
          }
          if(permissions.includes("S")){
            $("#user_perm_shop").prop('checked', true); 
          }
        }

        $("#userEditModal").on("show.bs.modal", function(event){
          var permissions = "";
          var user = $(event.relatedTarget);
          var modal = $(this);
          if(user.data("useraction") === "update"){
            modal.find("#user_id").val(user.data("userid"));
            modal.find("#old_id").val(user.data("userid"));
            modal.find("#delete_id").val(user.data("userid"));
            modal.find("#first_name").val(user.data("firstname"));
            modal.find("#last_name").val(user.data("lastname"));
            modal.find("#user_details_form_action").val("UPDATE");
            $("#submit_user_details").html("Update user");
            $("#delete_user").removeClass("hidden");
            permissions = user.data("permissions");

          } else if(user.data("useraction") === "add"){
            modal.find("#user_id").val("");
            modal.find("#old_id").val("");
            modal.find("#delete_id").val("");
            modal.find("#first_name").val("");
            modal.find("#last_name").val("");
            modal.find("#user_details_form_action").val("ADD");
            $("#submit_user_details").html("Add user");
            $("#delete_user").addClass("hidden");
            permissions = "";
          }

          updatePermissionGui(permissions);
        });

        $("#submit_user_details").click(function(event){
          $("#user_details_form").submit();
        });

        $("#delete_user").click(function(){
          if(confirm("Are you sure want to delete this user?")){
            $("#delete_user_form").submit();
          }
        });

        $("#search_button").click(function(){
          window.location.replace("usermgmt.php?search_query=" + $("#search_query").val());
        });
      });
    </script>
  </head>
  <body>
    <div class="container">
      <div class="modal fade" id="userEditModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="delete_user_form">
                <input type="hidden" name="action" value="DELETE"/>
                <input type="hidden" name="user_id" id="delete_id" value=""/>
              </form>
              <form method="POST" id="user_details_form">
                <input type="hidden" name="action" id="user_details_form_action" value="UPDATE" />
                <input type="hidden" name="old_id" id="old_id" value=""/>
                <div class="form-group">
                  <label for="user_id" class="form-control-label">User ID:</label>
                  <input type="text" class="form-control" id="user_id" name="user_id">
                </div>
                <div class="form-group">
                    <label for="first_name" class="form-control-label">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name">
                </div>
                <div class="form-group">
                    <label for="last_name" class="form-control-label">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name">
                </div>
                <div class="form-group">
                  <label class="form-control-label">Permissions:</label>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="user_perm[]" id="user_perm_mgmt" value="U">
                    <label class="form-check-label" for="user_perm_mgmt">User Management</label>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="user_perm[]" id="user_perm_blog" value="B">
                    <label class="form-check-label" for="user_perm_blog">Blog</label>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="user_perm[]" id="user_perm_events" value="E">
                    <label class="form-check-label" for="user_perm_events">Events</label>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="user_perm[]" id="user_perm_shop" value="S">
                    <label class="form-check-label" for="user_perm_shop">Shop</label>
                  </div>
                </div>
              </form>
              <div class="modal-footer">
                <button style="float:left" type="button" class="btn btn-danger" id="delete_user">Delete User</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit_user_details">Update User</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      
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

      <form class="form-inline">
        <div class="form-group" style="display:inline;">
          <div class="input-group">
            <input type="text" class="form-control" name="" id="search_query"/>
            <span class="input-group-btn">
              <button type="button" class="btn btn-primary" id="search_button">Search</button>
            </span>
          </div>
          <button type='button' class='btn btn-primary' data-toggle='modal' data-useraction='add' data-target='#userEditModal'>Add new User</button>
        </div>
      </form>    
      
      <table id="table_of_users" class="table table-hover">
        <thead>
          <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Permissions</th>
          </tr>
        </thead>
        <tbody>
          <?php
            //display users based on search query; if empty search or initial load of page -> show all users
            $sql = "SELECT user_id, first_name, last_name, user_perm FROM users";
            $query = null;
            if(!empty($_GET["search_query"])){
              $sql .= " WHERE (user_id LIKE ?) OR (first_name LIKE ?) OR (last_name LIKE ?)";
              $search_query = "%" . getValidData($_GET["search_query"]) . "%";
              $query = $con->prepare($sql);
              $query->bind_param("sss", $search_query, $search_query, $search_query);
            } else {
              $query = $con->prepare($sql);
            }
            $query->execute();
            $query->bind_result($user_id, $first_name, $last_name, $user_perm);

            $user_count = 0;
            while($query->fetch()){
              echo "<tr>";
              echo "<td>$user_id</td>";
              echo "<td>$first_name</td>";
              echo "<td>$last_name</td>";
              echo "<td>$user_perm</td>";
              echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-useraction='update' data-target='#userEditModal' data-userid='" . $user_id . "' data-firstname='" . $first_name . "' data-lastname='" . $last_name . "' data-permissions='" . $user_perm . "'>Edit User</button></td></tr>";
              $user_count += 1;
            }
            $user_count = 0;
            $query->close();
          ?>
        </tbody>
      </table>
    </div>
  </body>
</html>
