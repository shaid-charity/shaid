<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));

    require_once 'includes/settings.php';
	require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');
	?>
	<link href="style/blog.css" rel="stylesheet">

	<style>
		/* spacing */

		table {
		  	width: 100%;
		  	text-align: center;
		}

		table td:first-child {
    		width: 1px !important;
		}

		thead th:nth-child(1) {
		  	width: 50%;
		}

		thead th:nth-child(2) {
		  	width: 20%;
		}

		thead th:nth-child(3) {
		  	width: 15%;
		}

		thead th:nth-child(4) {
		  	width: 35%;
		}

		th, td {
		  	padding: 20px;
		}
	</style>
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/admin/admin_header.php');
		require_once(SITE_ROOT . '/includes/header.php');

		// Do we need to delete anyone first?
		if ($_GET['action'] == 'delete' && isset($_GET['id'])) {
			$friend = new Friend($db, $_GET['id']);
			$email = $friend->getEmail();
			$friend->deleteFromDB();
			$friend = null;
		}

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
		$pagination = new Pagination($db, "SELECT * FROM `friends` WHERE `email` LIKE ? OR `fname` LIKE ? OR `sname` LIKE ? OR `type` LIKE ?", array($searchTerm, $searchTerm, $searchTerm, $searchTerm));
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
		$stmt = $db->prepare("SELECT * FROM `friends` WHERE `email` LIKE ? OR `fname` LIKE ? OR `sname` LIKE ? OR `type` LIKE ? LIMIT $startFrom,10");
		$stmt->execute(array($searchTerm, $searchTerm, $searchTerm, $searchTerm));

		$friends = Array();
		foreach ($stmt as $row) {
			$friends[] = new Friend($db, $row['id']);
		}
	?>
	<main id="main-content">
		<div class="inner-container">
			<div class="content-grid no-sidebar">
				<section id="main">
					<section class="info-page-content">
						<div class="content-grid-title">
							<h1>Contact Database</h1>
							<?php
								if ($_GET['action'] == 'delete' && isset($_GET['id'])) {
									require_once(SITE_ROOT . '/includes/admin/admin_contact_deleted.php');
								}
							?>
							<form class="" action="contactdb.php" method="get">
								<div class="">
									<input class="form-control" type="text" id="contactSearch" name="term" placeholder="<?php echo $searchText; ?>">
									<button type="submit" class="button-green">Submit</button>
								</div>
							</form>
						</div>

						<form id="emailForm" action="sendemail.php" method="post">
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
							<button class="button-green" type="submit" name="sendEmail">Send email to selected</button> <label for="sendEmail" id="numChecked">0</label> <label>currently selected emails</label>
						</form>

						<form action="sendemail.php" method="post">
							<input type="hidden" name="type" value="all">
							<button class="button-dark" type="submit" value="Send email to all contacts">Send email to all contacts</button>
						</form>
					</section>
				</section>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>

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

// Change the URL of the form if the Preview button was selected
$("#previewButton").click(function(e) {
    e.preventDefault();

    var form = $("#emailForm");

    form.prop("action", "newfriend.php");
    form.submit();
});
</script>
</body>
</html>