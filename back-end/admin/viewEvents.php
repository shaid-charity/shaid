<?php

// Define a constant to be used in header.php
define('CURRENT_PAGE', 'eventsView');

require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once 'header.php';

?>

	<div class="container">
		<div class="page-header">
			<h1>View Events</h1>
		</div>
		<br />

		<table class="table table-hover table-striped" id="categoryList">
			<tr>
				<th>Event Name</th>
				<th>Start Date & Time</th>
				<th>End Date & Time</th>
				<th>Edit</th>
			</tr>

<?php

// Set up the pagination
$pagination = new Pagination($db, "SELECT id FROM `events`", array());
$pagination->totalRecords();
$pagination->setLimitPerPage(10);
$currentPage = $pagination->getPage();

// Select the correct number of records from the DB
if (isset($_GET['page'])) {
	$startFrom = ($_GET['page'] - 1) * 10;
} else {
	$startFrom = 0;
}

// Get all events
$stmt = $db->query("SELECT `id` FROM `events` LIMIT $startFrom, 10");
	
foreach ($stmt as $row) {
	$e = new Event($db, $row['id']);
?>

			<tr><td><?php echo $e->getTitle(); ?></td><td><?php echo $e->getStartDatetime(); ?></td><td><?php echo $e->getEndDatetime(); ?></td><td><a class="btn btn-primary btn-sm" href="event.php?action=edit&id=<?php echo $e->getID(); ?>" name="eventID">Edit</a></td></tr>

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