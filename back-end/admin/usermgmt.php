<?php
require_once('header.php');
require_once('../includes/db.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
  switch ($_POST["action"]) {
    case 'ADD':
    $permissions = getPermissionString($_POST["role"]);
    $query = $con->prepare("INSERT INTO users VALUES(?,?,?,?,?,?);");
    $query->bind_param("ssssss", getValidData($_POST["user_id"]), getValidData($_POST["first_name"]), getValidData($_POST["last_name"]), getValidData($permissions), $salt = "--------------------", $hash = "undefined");
    $query->execute();
    $query->close();
    break;

    case 'UPDATE':
    $permissions = getPermissionString($_POST["role"]);
    $query = $con->prepare("UPDATE users SET user_id=?, first_name=?, last_name=?, role=? WHERE user_id=?");
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
  header("Location: usermgmt.php");
  die();
}
?>

<html>
<head>
  <title>User Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">

  <!-- Optional theme -->
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.js" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function(){
      function updatePermissionGui(permissions){
        $("#role_mgmt").prop('checked', false);
        $("#role_blog").prop('checked', false);
        $("#role_events").prop('checked', false);
        $("#role_shop").prop('checked', false);

        if(permissions.includes("U")){
          $("#role_mgmt").prop('checked', true); 
        }
        if(permissions.includes("B")){
          $("#role_blog").prop('checked', true);
        }
        if(permissions.includes("E")){
          $("#role_events").prop('checked', true); 
        }
        if(permissions.includes("S")){
          $("#role_shop").prop('checked', true); 
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
  <!-- Top navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
    <a class="navbar-brand" href="#">SHAID Admin Panel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="contactDB.php">Contact DB <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="usermgmt.php">User Management<span class="sr-only">(current)</span></a>
        </li>
      </ul>

      <form class="form-inline my-2 my-lg-0" method="POST" style="float:right;">
        <input type="hidden" name="action" value="LOGOUT"/>
        <input type='submit' class='btn btn-outline-danger my-2 my-sm-0' value="Log Out" />
      </form>
    </div>
  </nav>

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
                  <input type="checkbox" class="form-check-input" name="role[]" id="role_mgmt" value="U">
                  <label class="form-check-label" for="role_mgmt">User Management</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" name="role[]" id="role_blog" value="B">
                  <label class="form-check-label" for="role_blog">Blog</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" name="role[]" id="role_events" value="E">
                  <label class="form-check-label" for="role_events">Events</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" name="role[]" id="role_shop" value="S">
                  <label class="form-check-label" for="role_shop">Shop</label>
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
    
    <table id="table_of_users" class="table table-hover">
      <thead>
        <tr>
          <th>Email</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
        <?php
              //display users based on search query; if empty search or initial load of page -> show all users
          $sql = "SELECT email, first_name, last_name, roles.name FROM users, roles WHERE roles.id = users.role_id";
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
          $query->bind_result($user_email, $first_name, $last_name, $role);

          $user_count = 0;
          while($query->fetch()){
            echo "<tr>";
            echo "<td>$user_email</td>";
            echo "<td>$first_name</td>";
            echo "<td>$last_name</td>";
            echo "<td>$role</td>";
            echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-useraction='update' data-target='#userEditModal' data-userid='" . $user_email . "' data-firstname='" . $first_name . "' data-lastname='" . $last_name . "' data-permissions='" . $role . "'>Edit User</button></td></tr>";
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
