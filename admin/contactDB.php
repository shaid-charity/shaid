<?php

require_once '../includes/settings.php';
require_once '../includes/config.php';

?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

<?php

if (!isset($_GET['action']) || isset($_GET['term'])) {
	// Set up the search query, if needed
	// If no search term is entered, just match anything
	if (!isset($_GET['term'])) {
		$searchTerm = '%';
		$searchText = 'Search...';
	} else {
		$searchTerm = '%' . $_GET['term'] . '%';
		$searchText = $_GET['term'];
	}

	// Set up the pagination
	$pagination = new Pagination($db, "SELECT * FROM `gp_friends` WHERE `email` LIKE ? OR `fname` LIKE ? OR `sname` LIKE ?", [$searchTerm, $searchTerm, $searchTerm]);
	$pagination->totalRecords();
	$pagination->setLimitPerPage(10);
	$currentPage = $pagination->getPage();

	// Select the correct number of records from the DB
	if (isset($_GET['page'])) {
		$startFrom = ($_GET['page'] - 1) * 10;
	} else {
		$startFrom = 0;
	}

	// Get all records from the DB
	$stmt = $db->prepare("SELECT * FROM `gp_friends` WHERE `email` LIKE ? OR `fname` LIKE ? OR `sname` LIKE ? LIMIT $startFrom,10");
	$stmt->execute([$searchTerm, $searchTerm, $searchTerm]);

	$friends = Array();
	foreach ($stmt as $row) {
		$friends[] = new Friend($db, $row['id']);
	}
?>
<form action="contactDB.php" method="get">
	<input type="text" id="contactSearch" name="term" placeholder="<?php echo $searchText; ?>">
	<input type="submit" value="Search">
</form>
<form action="sendEmail.php?action=write" method="post">
	<table id="contactDB">
		<tr>
			<th>Email</th>
			<th>Forename</th>
			<th>Surname</th>
			<th>Delete Email</th>
			<th>Select</th> <!-- TODO: Not happy with name of column -->
		</tr>

<?php

	foreach ($friends as $f) {
		echo '<tr><td>' . $f->getEmail() . '</td><td>' . $f->getForename() . '</td><td>' . $f->getSurname() . '</td><td><a href="contactDB.php?action=delete&id=' . $f->getID() . '">Delete</a></td><td><input class="checkbox" type="checkbox" name="' . $f->getEmail() . '" value="' . $f->getEmail() . '"></tr>';
	}

?>

	</table>
	<input type="submit" value="Send email"> <div id="numChecked">0</div>
</form>
<form action="sendEmail.php?action=write" method="post">
	<input type="hidden" name="all" value="yes">
	<input type="submit" value="Send email to all contacts">
</form>
<?php

echo $pagination->getFirstAndBackLinks() . $pagination->getCurrentPageLinks() . $pagination->getNextAndLastLinks();

} else if ($_GET['action'] == 'delete') {
	// Get the Friend we want
	$friend = new Friend($db, $_GET['id']);
	$friend->deleteFromDB();
?>
<p>Friend delete successfully. <a href="contactDB.php">Go back to contact DB.</a></p>

<?php
} 
?>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/script.js"></script>
<script>
$('.checkbox').change(function() {
	if (this.checked) {
		$('#numChecked').text(parseInt($('#numChecked').text()) + 1);
	} else {
		$('#numChecked').text(parseInt($('#numChecked').text()) - 1);
	}
});
</script>
</html>