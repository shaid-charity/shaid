<?php
require_once('header.php');
require_once('../includes/db.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
  switch ($_POST["action"]) {
    case 'ADD':
    $representing = getRepresenting($_POST["representative"]);
    $query = $con->prepare("INSERT INTO users (first_name, last_name, email, role_id, pass_salt, pass_hash, guest_blogger, company_id, can_represent_company, biography) VALUES(?,?,?,?,?,?,?,?,?,?);");
    $query->bind_param("ssssssssss", getValidData($_POST["first_name"]), getValidData($_POST["last_name"]), getValidData($_POST["user_email"]), getValidData($_POST["userperm"]), $salt = "--------------------", $hash = "undefined", $guest = "0", getValidData($_POST["company"]), getValidData($representing), getValidData($_POST["biography"]));
    $query->execute();
    $query->close();
    break;

    case 'UPDATE':
    $representing = getRepresenting($_POST["representative"]);
    $query = $con->prepare("UPDATE users SET email=?, first_name=?, last_name=?, role_id=?, company_id=?, can_represent_company=?, biography=? WHERE user_id=?;");
    $query->bind_param("ssssssss", getValidData($_POST["user_email"]), getValidData($_POST["first_name"]), getValidData($_POST["last_name"]), getValidData($_POST["userperm"]), getValidData($_POST["company"]), getValidData($representing), getValidData($_POST['biography']), getValidData($_POST["user_id"]));
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

      $("#userEditModal").on("show.bs.modal", function(event){
        var permissions = "";
        var user = $(event.relatedTarget);
        var modal = $(this);
        if(user.data("useraction") === "update"){
          modal.find("#delete_id").val(user.data("userid"));
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
          $("#delete_user").show();

        } else if(user.data("useraction") === "add"){
          modal.find("#user_email").val("");
          modal.find("#first_name").val("");
          modal.find("#last_name").val("");
          modal.find("#userperm").val(5);
          modal.find("#company").val(1);
          modal.find("#biography").val("");
          $("#representative").prop("checked", false);
          modal.find("#user_details_form_action").val("ADD");
          $("#submit_user_details").html("Add user");
          $("#delete_user").hide();
        }
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
              <input type="hidden" name="user_id" id="user_id" value=""/>
              <div class="form-group">
                <label for="user_email" class="form-control-label">Email:</label>
                <input type="text" class="form-control" id="user_email" name="user_email">
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
                <label for="userperm" class="form-control-label">Permissions:</label>
                <select class="form-control" name="userperm" id="userperm">
                  <?php
                    $query = $con->prepare("SELECT id, name, description FROM roles;");
                    $query->execute();
                    $query->bind_result($id, $name, $description); //description for tooltips
                    while ($query->fetch()) {
                      echo "<option value=".$id.">".$name."</option>";
                    }
                    $query->close();
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="company" class="form-control-label">Company</label>
                <select class="form-control" name="company" id="company">
                <?php
                    $query = $con->prepare("SELECT id, name FROM companies;");
                    $query->execute();
                    $query->bind_result($id, $name); //description for tooltips
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
                <textarea class="form-control" id="biography" name="biography" rows="6"></textarea>
              </div>
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger mr-auto" id="delete_user">Delete User</button>
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
          $sql = "SELECT user_id, email, first_name, last_name, roles.name, role_id, company_id, can_represent_company, biography FROM users, roles WHERE roles.id = users.role_id";
          $query = null;
          if(!empty($_GET["search_query"])){
            $sql .= " AND ((user_id LIKE ?) OR (first_name LIKE ?) OR (last_name LIKE ?));";
            $search_query = "%" . getValidData($_GET["search_query"]) . "%";
            $query = $con->prepare($sql);
            $query->bind_param("sss", $search_query, $search_query, $search_query);
          } else {
            $query = $con->prepare($sql);
          }
          $query->execute();
          $query->bind_result($user_id, $user_email, $first_name, $last_name, $role, $role_id, $company_id, $can_represent_company, $biography);

          $user_count = 0;
          while($query->fetch()){
            echo "<tr>";
            echo "<td>$user_email</td>";
            echo "<td>$first_name</td>";
            echo "<td>$last_name</td>";
            echo "<td>$role</td>";
            echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-useraction='update' data-target='#userEditModal' data-userid='".$user_id."' data-useremail='" . $user_email . "' data-firstname='" . $first_name . "' data-lastname='" . $last_name . "' data-permissions='" . $role . "' data-roleid='".$role_id."' data-companyid='".$company_id."' data-representative='".$can_represent_company."' data-biography='".$biography."'>Edit User</button></td></tr>";
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
