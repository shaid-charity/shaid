<?php
define('CURRENT_PAGE', 'companies');

require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'header.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
  switch ($_POST["action"]) {
    case 'ADD':
      // Upload image if one exists
      $file = $_FILES['logo'];
      $uploadManager = new UploadManager();
      $uploadManager->setUploadLocation('../images/logos/');
      $uploadManager->setFilename($file['name']);
      $imagePath = $uploadManager->getPath();
      $uploadManager->upload($file);

      $query = $con->prepare("INSERT INTO companies (name, url, icon) VALUES (?,?,?);");
      $query->bind_param("sss", getValidData($_POST["name"]), getValidData($_POST["url"]), getValidData($imagePath));
      $query->execute();
      $query->close();
      break;
    
    case 'UPDATE':
      $query = null;
      // Upload image if one exists
      $file = $_FILES['logo'];

      if(file_exists($file['tmp_name'])){
        $uploadManager = new UploadManager();
        $uploadManager->setUploadLocation('../images/logos/');
        $uploadManager->setFilename($file['name']);
        $imagePath = $uploadManager->getPath();
        $uploadManager->upload($file);

        $query = $con->prepare("UPDATE companies SET name=?, url=?, icon=? WHERE id=?");
        $query->bind_param("ssss", getValidData($_POST["name"]), getValidData($_POST["url"]), getValidData($imagePath), getValidData($_POST["company_id"]));
      } else {
        $query = $con->prepare("UPDATE companies SET name=?, url=? WHERE id=?");
        $query->bind_param("ssss", getValidData($_POST["name"]), getValidData($_POST["url"]), getValidData($_POST["company_id"]));
      }
      $query->execute();
      $query->close();
      break;
    
    case 'DELETE':
      $query = $con->prepare("DELETE FROM companies WHERE id=?");
      $query->bind_param("s", getValidData($_POST["company_id"]));
      $query->execute();
      $query->close();
      break;

    default:
      die("Undefined action");
      break;
  }
}

?>

  <div class="container">
    <div class="modal fade" id="companyEditModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Company</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" id="delete_company_form">
              <input type="hidden" name="action" value="DELETE"/>
              <input type="hidden" name="company_id" id="delete_id" value=""/>
            </form>
            <form method="POST" id="company_details_form" enctype="multipart/form-data">
              <input type="hidden" name="action" id="company_details_form_action" value="UPDATE" />
              <input type="hidden" name="company_id" id="company_id" value=""/>
              
              <div class="form-group">
                <label for="name" class="form-control-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="70" required/>
              </div>
              <div class="form-group">
                <label for="url" class="form-control-label">URL:</label>
                <input type="text" class="form-control" id="url" name="url" maxlength="100" required/>
              </div>
              <div class="custom-file">
  		          <input type="file" class="custom-file-input" id="logo" name="logo">
  		          <label class="custom-file-label" for="logo">Company Logo</label>
              </div>
              
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="submit_company_details">Update</button>  
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="page-header">
      <h1>Companies</h1>
    </div>
    <br/>

    <form class="form-inline" style="float:left;">
      <div class="form-group">
        <div class="input-group">
          <input type="text" class="form-control" name="" id="search_query"/>
          <span class="input-group-append">
            <button type="button" class="btn btn-primary mr-2" id="search_button">Search</button>
          </span>
        </div>
        <button type='button' class='btn btn-primary' data-toggle='modal' data-action='add' data-target='#companyEditModal'>Add company</button>
      </div>
    </form>

    <table class="table">
      <thead class="thead-light">
        <th>Icon</th>
        <th>Name</th>
        <th>URL</th>
        <th>Edit</th>
        <th>Delete</th>
      </thead>
      <tbody>
      <?php
        $query = null;
        if(isset($_GET["search_query"])){
          $query = $con->prepare("SELECT id, name, icon, url FROM companies WHERE name LIKE '%".getValidData($_GET["search_query"])."%'");
          $query->execute();
        } else {
          $query = $con->prepare("SELECT id, name, icon, url FROM companies");
          $query->execute();
        }
        $query->bind_result($id, $name, $icon, $url);
        $query->store_result();
        
        while($query->fetch()){
          echo "<tr>";
          echo "<td><img src='$icon'</td>";
          echo "<td>$name</td>";
          echo "<td>$url</td>";
          echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#companyEditModal' data-action='update' data-id='$id' data-name='$name' data-url='$url' data-icon='$icon'>Edit</button></td>";
          
          $countQuery = $con->prepare("SELECT COUNT(user_id) FROM users WHERE company_id=?");
          $countQuery->bind_param("s", $id);
          $countQuery->execute();
          $countQuery->bind_result($count);
          $countQuery->fetch();
          if($count == 0){
            echo "<td><button type='button' class='btn btn-danger delete_company' data-id='$id'>Delete</button></td>";
          } else {
            echo "<td></td>";
          }
          $countQuery->close();

          echo "</tr>";
        }
        $query->close();
      ?>
      </tbody>
    </table>
  </div>
</body>
<script>
  $(document).ready(function(){
    $("#companyEditModal").on("show.bs.modal", function(event){
      var company = $(event.relatedTarget);

      if(company.data("action") === "update"){
        $("#name").val(company.data("name"));
        $("#url").val(company.data("url"));
        $("#company_id").val(company.data("id"));
        $("#company_details_form_action").val("UPDATE");
        $("#submit_company_details").html("Update");
      } else if(company.data("action") === "add"){
        $("#name").val("");
        $("#url").val("");
        $("#logo").val("");
        $("#company_id").val("");
        $("#company_details_form_action").val("ADD");
        $("#submit_company_details").html("Add");                
      }
    });

    $("#submit_company_details").on("click", function(){
      if($("#name").val().length != 0 &&  $("#url").val().length != 0){
        $("#company_details_form").submit();
      }
    });

    $(".delete_company").on("click", function(event){
      $("#delete_id").val($(this).data("id"));
      if(confirm("Are you sure want to delete this company from the list?")){
        $("#delete_company_form").submit();
      }
    });

    $("#search_button").click(function(){
      window.location.replace("companies.php?search_query=" + $("#search_query").val());
    });
  });
</script>
</html>