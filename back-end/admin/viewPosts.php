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
	          <a class="dropdown-item" href="post.php">Create Post</a>
	          <a class="dropdown-item active" href="viewPosts.php">View Posts <span class="sr-only">(current)</span></a>
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

	<div class="container">
		<div class="page-header">
			<h1>View Posts</h1>
		</div>
		<br />

		<form action="post.php?action=edit" method="post">
			<table class="table table-hover table-striped" id="categoryList">
				<tr>
					<th>Post Name</th>
					<th>Post Category</th>
					<th>Last Edited Time</th>
					<th>Edit</th>
				</tr>

<?php

// Set up the pagination
$pagination = new Pagination($db, "SELECT id FROM `posts`", array());
$pagination->totalRecords();
$pagination->setLimitPerPage(10);
$currentPage = $pagination->getPage();

// Select the correct number of records from the DB
if (isset($_GET['page'])) {
	$startFrom = ($_GET['page'] - 1) * 10;
} else {
	$startFrom = 0;
}

// Get all categories
$stmt = $db->query("SELECT `id` FROM `posts` LIMIT $startFrom, 10");
	
foreach ($stmt as $row) {
	$p = new Post($db, $row['id']);
?>

				<tr><td><?php echo $p->getTitle(); ?></td><td><?php echo $p->getCategoryName(); ?></td><td><?php echo $p->getLastModifiedDate(); ?></td><td><button class="btn btn-primary btn-sm" value=<?php echo $p->getID(); ?> name="postID">Edit</button></td></tr>

<?php

}

?>

			</table>

			<nav>
			<ul class="pagination justify-content-center">
<?php

echo $pagination->getFirstAndBackLinks() . $pagination->getBeforeLinks() . $pagination->getCurrentPageLinks() . $pagination->getAfterLinks() . $pagination->getNextAndLastLinks();

?>

			</ul>
		</nav>
		
		</form>
	</div>
</body>
</html>