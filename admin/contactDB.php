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
	      <li class="nav-item active">
	        <a class="nav-link" href="contactDB.php">Contact DB <span class="sr-only">(current)</span></a>
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
	$pagination = new Pagination($db, "SELECT * FROM `gp_friends` WHERE `email` LIKE ? OR `fname` LIKE ? OR `sname` LIKE ? OR `type` LIKE ?", array($searchTerm, $searchTerm, $searchTerm, $searchTerm));
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
	$stmt = $db->prepare("SELECT * FROM `gp_friends` WHERE `email` LIKE ? OR `fname` LIKE ? OR `sname` LIKE ? OR `type` LIKE ? LIMIT $startFrom,10");
	$stmt->execute(array($searchTerm, $searchTerm, $searchTerm, $searchTerm));

	$friends = Array();
	foreach ($stmt as $row) {
		$friends[] = new Friend($db, $row['id']);
	}
?>
<div class="container">
	<div class="page-header">
		<h1>Contact DB</h1>
	</div>
	<br />

	<form class="form-inline" action="contactDB.php" method="get">
		<div class="input-group">
			<input class="form-control" type="text" id="contactSearch" name="term" placeholder="<?php echo $searchText; ?>">
			<div class="input-group-append">
				<input class="btn btn-primary" type="submit" value="Search">
			</div>
		</div>
	</form>
	<form action="sendEmail.php?action=write" method="post">
		<table class="table table-hover table-striped" id="contactDB">
			<tr>
				<th>Email</th>
				<th>Forename</th>
				<th>Surname</th>
				<th>Type</th>
				<th>Delete Email</th>
				<th>Select</th> <!-- TODO: Not happy with name of column -->
			</tr>

<?php

	foreach ($friends as $f) {
		echo '<tr><td>' . $f->getEmail() . '</td><td>' . $f->getForename() . '</td><td>' . $f->getSurname() . '</td><td>' . $f->getType() . '<td><a class="delete" href="contactDB.php?action=delete&id=' . $f->getID() . '">Delete</a></td><td><input class="checkbox" type="checkbox" name="' . $f->getEmail() . '" value="' . $f->getEmail() . '"></tr>';
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
		<button class="btn btn-primary" type="submit" name="sendEmail">Send email to selected</button> <label for="sendEmail" id="numChecked">0</label> <label>currently selected emails</label>
	</form>
	<form action="sendEmail.php?action=write" method="post">
		<input type="hidden" name="type" value="all">
		<input class="btn btn-primary" type="submit" value="Send email to all contacts">
	</form>

<?php

} else if ($_GET['action'] == 'delete') {
	// Get the Friend we want
	$friend = new Friend($db, $_GET['id']);
	$friend->deleteFromDB();
?>
	<div class="alert alert-success" role="alert">Friend delete successfully. <a href="contactDB.php">Go back to contact DB.</a></div>
</div>
<?php
} 
?>

</body>

<script src="js/script.js"></script>
<script>
$('.delete').click(function(){
    return confirm("Are you sure you want to delete the contact?");
});

$('.checkbox').change(function() {
	if (this.checked) {
		$('#numChecked').text(parseInt($('#numChecked').text()) + 1);
	} else {
		$('#numChecked').text(parseInt($('#numChecked').text()) - 1);
	}
});
</script>
</html>