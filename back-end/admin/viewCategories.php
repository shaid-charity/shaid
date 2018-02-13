<?php

require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once 'header.php';

?>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
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
	      <li class="nav-item dropdown active">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          Content
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	          <a class="dropdown-item" href="createCategory.php">Create Category</a>
	          <a class="dropdown-item active" href="viewCategories.php">View Categories <span class="sr-only">(current)</span></a>
	          <a class="dropdown-item" href="post.php">Create Post</a>
	        </div>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="contactDB.php">Contact DB</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="usermgmt.php">User Management</a>
	      </li>
	    </ul>

	    <form class="form-inline my-2 my-lg-0" method="POST" style="float:right;">
        	<input type="hidden" name="action" value="LOGOUT"/>
        	<input type='submit' class='btn btn-outline-danger my-2 my-sm-0' value="Log Out" />
      	</form>
	  </div>
	</nav>

	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteMOdal" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="deleteModallLabel">Delete Category</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        Are you sure you want to delete the category <span id="categoryName"></span>?
	      </div>
	      <div class="modal-footer">
	        <form action="viewCategories.php?action=delete" method="post">
	        	<input type="hidden" name="categoryID" value="" id="modalID">
	        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	        	<input type="submit" class="btn btn-danger" value="Delete">
	        </form>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="container">
		<div class="page-header">
			<h1>View Categories</h1>
		</div>
		<br />

<?php
		// Delete the category if we have been asked
		if (isset($_GET['action']) && $_GET['action'] == "delete") {
			$error = false;
			try {
				$c = new Category($db, $_POST['categoryID']);
				$c->delete();
			} catch (Exception $e) {
				$error = true;
				echo $e->getMessage();
			}

			if ($error) {
?>
			<div class="alert alert-danger">The category could not be deleted. Check there are no posts in the category.</div>
<?php
			} else {
?>
			<div class="alert alert-success">The category was successfully deleted!</div>
<?php
			}
		}
?>

		<form action="createCategory.php?action=edit" method="post">
			<table class="table table-hover table-striped" id="categoryList">
				<tr>
					<th>Category Name</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>

<?php

// Get all categories
$stmt = $db->query("SELECT `id` FROM `categories`");
	
$categories = Array();
foreach ($stmt as $row) {
	$c = new Category($db, $row['id']);
?>

				<tr><td><?php echo $c->getName(); ?></td><td><button class="btn btn-primary btn-sm" value=<?php echo $c->getID(); ?> name="categoryID">Edit</button></td><td><button onclick="setModalNameAndID('<?php echo $c->getName(); ?>', '<?php echo $c->getID(); ?>');" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">Delete</button></td></tr>

<?php

}

?>

			</table>
		</form>
	</div>
</body>

<script>
function setModalNameAndID(name, id) {
	$('#categoryName').text(name);
	$('#modalID').val(id);
}
</script>
</html>