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
	          <a class="dropdown-item" href="viewCategories.php">View Categories</a>
	          <a class="dropdown-item active" href="post.php">Create Post <span class="sr-only">(current)</span></a>
	          <a class="dropdown-item" href="viewPosts.php">View Posts</a>
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

<?php

if (!isset($_GET['action'])) {

	// Get an array of all categories
	$stmt = $db->query("SELECT `id` FROM `categories`");
	
	$categories = Array();
	foreach ($stmt as $row) {
		$categories[] = new Category($db, $row['id']);
	}
?>


	<div class="container">
		<div class="page-header">
			<h1>Create Blog Post</h1>
		</div>
		<br />

<form action="post.php?action=submit" method="post">
	<input class="form-control" type="text" name="title" id="titleInput" placeholder="Title"><br />
	<select class="form-control form-control-sm" name="category">
		<?php
		foreach ($categories as $cat) {
			echo '<option value="' . $cat->getID() . '">' . $cat->getName() . '</option>';
		}
		?>
	</select><br />
	<textarea class="form-control" name="content" rows="10"></textarea><br />
	<input class="btn btn-primary" name="saveType" type="submit" value="Publish">
	<input class="btn btn-secondary" name="saveType" type="submit" value="Save draft">
</form>

<?php
} else if ($_GET['action'] == 'submit') {
	// Create the blog post
	$name = $_POST['title'];
	$categoryID = $_POST['category'];
	$content = $_POST['content'];

	if ($_POST['saveType'] == "Publish") {
		$post = new Post($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, '', 1, '', $categoryID);
		echo 'Blog post published.';

		$post->setPublished(1);
	} else if ($_POST['saveType'] == "Save draft") {
		$post = new Post($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, '', 1, '', $categoryID);
		echo 'Blog post draft saved.';

		$post->setPublished(0);
	}
} else if ($_GET['action'] == 'edit') {
	// Get an array of all categories
	$stmt = $db->query("SELECT `id` FROM `categories`");
	
	$categories = Array();
	foreach ($stmt as $row) {
		$categories[] = new Category($db, $row['id']);
	}

	$post = new Post($db, $_POST['postID']);
?>

	<div class="container">
		<div class="page-header">
			<h1>Update Blog Post</h1>
		</div>
		<br />

		<form action="post.php?action=update" method="post">
			<input class="form-control" type="text" name="title" id="titleInput" placeholder="Title" value="<?php echo $post->getTitle(); ?>"><br />
			<select class="form-control form-control-sm" name="category">
				<?php
				foreach ($categories as $cat) {
					if ($cat->getID() == $post->getCategoryID){
						echo '<option value="' . $cat->getID() . '" selected>' . $cat->getName() . '</option>';
					} else {
						echo '<option value="' . $cat->getID() . '">' . $cat->getName() . '</option>';
					}
				}
				?>
			</select><br />
			<textarea class="form-control" name="content" rows="10"><?php echo $post->getContent(); ?></textarea><br />
			<input name="id" type="hidden" value="<?php echo $post->getID(); ?>">
			<input class="btn btn-primary" name="saveType" type="submit" value="Publish">
			<input class="btn btn-secondary" name="saveType" type="submit" value="Save draft">
		</form>

<?php
} else if ($_GET['action'] == 'update') {
	$post = new Post($db, $_POST['id']);
	$post->setName($_POST['title']);
	$post->setCategory($_POST['category']);
	$post->setContent($_POST['content']);

	if ($_POST['saveType'] == "Publish") {
		$post->setPublished(1);
?>

		<div class="alert alert-success">Blog post updated and published! <a href="viewPosts.php">Go Back.</a></div>

<?php
	} else {
		$post->setPublished(0);
?>

		<div class="alert alert-success">Blog post updated and draft saved! <a href="viewPosts.php">Go Back.</a></div>

<?php
	}
}
?>

</div>
</body>
</html>