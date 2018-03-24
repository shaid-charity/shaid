<?php

// Define a constant to be used in header.php
define('CURRENT_PAGE', 'contentViewCategories');

require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once 'header.php';

?>

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

// Set up the pagination
$pagination = new Pagination($db, "SELECT * FROM `categories`", array());
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
$stmt = $db->query("SELECT `id` FROM `categories` LIMIT $startFrom, 10");
	
foreach ($stmt as $row) {
	$c = new Category($db, $row['id']);
?>

				<tr><td><?php echo $c->getName(); ?></td><td><button class="btn btn-primary btn-sm" value=<?php echo $c->getID(); ?> name="categoryID">Edit</button></td><td><button onclick="setModalNameAndID('<?php echo $c->getName(); ?>', '<?php echo $c->getID(); ?>');" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">Delete</button></td></tr>

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

<script>
function setModalNameAndID(name, id) {
	$('#categoryName').text(name);
	$('#modalID').val(id);
}
</script>
</html>