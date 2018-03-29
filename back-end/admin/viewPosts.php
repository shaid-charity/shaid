<?php

// Define a constant to be used in header.php
define('CURRENT_PAGE', 'contentViewPosts');

require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once 'header.php';

?>

	<div class="container">
		<div class="page-header">
			<h1>View Posts</h1>
		</div>
		<br />

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

//list posts by user if provided in GET (will add permission check as well)
//uncomment to enable
//we should also possibly list all posts belonging to a single user

//if(isset($_GET['user_id']) && $role_id < 3){
//	$stmt = $db->query("SELECT `id` FROM `posts` WHERE user_id = " . getValidData($_GET["user_id"]) . " LIMIT $startFrom, 10");
//} else {
//	$stmt = $db->query("SELECT `id` FROM `posts` LIMIT $startFrom, 10");
//}
// Get all posts
$stmt = $db->query("SELECT `id` FROM `posts` LIMIT $startFrom, 10");
	
foreach ($stmt as $row) {
	$p = new Post($db, $row['id']);
?>

			<tr><td><?php echo $p->getTitle(); ?></td><td><?php echo $p->getCategoryName(); ?></td><td><?php echo $p->getLastModifiedDate(); ?></td><td><a class="btn btn-primary btn-sm" href="post.php?action=edit&id=<?php echo $p->getID(); ?>" name="postID">Edit</a></td></tr>

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
	</div>
</body>
</html>