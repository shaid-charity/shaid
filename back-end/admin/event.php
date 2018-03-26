<?php

// Define a constant to be used in header.php
define('CURRENT_PAGE', 'eventsCreate');

require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once 'header.php';

// Get the user ID
$stmt = $db->prepare("SELECT users.user_id FROM users, sessions WHERE users.user_id = sessions.user_id AND session_number=?");
$stmt->execute(array($session_number));
$userID = $stmt->fetch()['user_id'];

if (!isset($_GET['action'])) {
	// Get an array of all campaigns
	$stmt = $db->query("SELECT `id` FROM `campaigns`");
	
	$campaigns = Array();
	foreach ($stmt as $row) {
		$campaigns[] = new Campaign($db, $row['id']);
	}
?>


	<div class="container">
		<div class="page-header">
			<h1>Create New Event</h1>
		</div>
		<br />

<form action="event.php?action=submit" method="post" enctype="multipart/form-data">
	<input class="form-control" type="text" name="title" id="titleInput" placeholder="Title"><br />
	<input class="form-control" type="datetime-local" name="startDatetime" id="startDatetimeInput"><br />
	<input class="form-control" type="datetime-local" name="endDatetime" id="endDatetimeInput"><br />
	<input class="form-control" type="datetime-local" name="closingDatetime" id="closingDatetimeInput"><br />
	<select class="form-control form-control-sm" name="campaign">
		<?php
		foreach ($campaigns as $cam) {
			echo '<option value="' . $cam->getID() . '">' . $cam->getTitle() . '</option>';
		}
		?>
	</select><br />
	<input class="form-control" type="number" name="capacity" id="capacityInput" placeholder="Capacity"><br />
	<input class="form-control" type="number" step="0.01" name="ticketPrice" id="ticketPriceInput" placeholder="Ticket Price"><br />
	<input class="form-control" type="text" name="location" id="locationInput" placeholder="Location" placeholder="Location"><br />
	<div class="custom-file">
  		<input type="file" class="custom-file-input" id="image" name="image">
  		<label class="custom-file-label" for="customFile" id="imageLabel">Choose main image</label>
	</div><br /><br />
	<textarea class="form-control" name="content" rows="10"></textarea><br />
	<input class="btn btn-primary" name="saveType" type="submit" value="Create">
</form>

<?php
} else if ($_GET['action'] == 'submit') {
	// Create the event
	$name = $_POST['title'];
	$startDatetime = $_POST['startDatetime'];
	$endDatetime = $_POST['endDatetime'];
	$closingDatetime = $_POST['closingDatetime'];
	$campaignID = $_POST['campaign'];
	$capacity = $_POST['capacity'];
	$ticketsAvailable = $capacity;
	$ticketPrice = $_POST['ticketPrice'];
	$location = $_POST['location'];
	$content = $_POST['content'];
	$file = $_FILES['image'];

	if (file_exists($file['tmp_name'])) {
		$uploadManager = new UploadManager();
		$uploadManager->setFilename($file['name']);
		echo $file['name'];
		print_r($_FILES);
		$imagePath = $uploadManager->getPath();
	} else {
		$imagePath = '';
	}

	if ($_POST['saveType'] == "Create") {
		$event = new Event($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, $imagePath, $userID, $startDatetime, $endDatetime, $closingDatetime, $campaignID, $capacity, $ticketsAvailable, $ticketPrice, $location);
		echo 'Event created.';

		if (file_exists($file['tmp_name'])) {
			$uploadManager->upload($file);
		}
	}
} else if ($_GET['action'] == 'edit') {
	// Make sure an event has been selected to edit
	if (!isset($_GET['id'])) {
		echo '<div class="alert alert-danger">No event selected!</div>';
		return;
	}

	// Get an array of all campaigns
	$stmt = $db->query("SELECT `id` FROM `campaigns`");
	
	$campaigns = Array();
	foreach ($stmt as $row) {
		$campaigns[] = new Campaign($db, $row['id']);
	}

	$event = new Event($db, $_GET['id']);
?>

	<div class="container">
		<div class="page-header">
			<h1>Update Event</h1>
		</div>
		<br />

		<form action="event.php?action=update" method="post" enctype="multipart/form-data">
			<input class="form-control" type="text" name="title" id="titleInput" placeholder="Title" value="<?php echo $event->getTitle(); ?>"><br />
			<input class="form-control" type="datetime-local" name="startDatetime" id="startDatetimeInput" value="<?php echo $event->getStartDatetime(); ?>"><br />
			<input class="form-control" type="datetime-local" name="endDatetime" id="endDatetimeInput" value="<?php echo $event->getEndDatetime(); ?>"><br />
			<input class="form-control" type="datetime-local" name="closingDatetime" id="closingDatetimeInput" value="<?php echo $event->getClosingDatetime(); ?>"><br />
			<select class="form-control form-control-sm" name="campaign">
				<?php

				foreach ($campaigns as $cam) {
					if ($cam->getID() == $event->getCampaign()->getID()){
						echo '<option value="' . $cam->getID() . '" selected>' . $cam->getTitle() . '</option>';
					} else {
						echo '<option value="' . $cam->getID() . '">' . $cam->getTitle() . '</option>';
					}
				}
				?>
			</select><br />
			<input class="form-control" type="number" name="capacity" id="capacityInput" placeholder="Capacity" value="<?php echo $event->getCapacity(); ?>"><br />
			<input class="form-control" type="number" step="0.01" name="ticketPrice" id="ticketPriceInput" placeholder="Ticket Price" value="<?php echo $event->getTicketPrice(); ?>"><br />
			<input class="form-control" type="text" name="location" id="locationInput" placeholder="Location" placeholder="Location" value="<?php echo $event->getLocation(); ?>"><br />
			<div class="custom-file">
					<input type="file" class="custom-file-input" id="image" name="image">
					<label class="custom-file-label" for="customFile" id="imageLabel"><?php echo $event->getImageName(); ?></label>
			</div><br /><br />
			<textarea class="form-control" name="content" rows="10"><?php echo $event->getContent(); ?></textarea><br />
			<input name="id" type="hidden" value="<?php echo $event->getID(); ?>">
			<input type="hidden" name="imagePath" id="imagePath" value="<?php echo $event->getImagePath(); ?>">
			<input class="btn btn-primary" name="saveType" type="submit" value="Create">
		</form>

<?php
} else if ($_GET['action'] == "update") {
	$event = new Event($db, $_POST['id']);
	$event->setName($_POST['title']);
	$event->setStartDatetime($_POST['startDatetime']);
	$event->setEndDatetime($_POST['endDatetime']);
	$event->setClosingDatetime($_POST['closingDatetime']);
	$event->setCampaign($_POST['campaign']);
	$event->setCapacity($_POST['capacity']);
	$event->setTicketPrice($_POST['ticketPrice']);
	$event->setLocation($_POST['location']);
	$event->setContent($_POST['content']);

	// If a new main image was uploaded, change it
	if (file_exists($file['tmp_name'])) {
		$uploadManager = new UploadManager();
		$uploadManager->setFilename($file['name']);
		$imagePath = $uploadManager->getPath();
		$uploadManager->upload($file);

		$event->setImage($imagePath);
	}

	echo '<div class="alert alert-success">Event updated! <a href="viewEvents.php">Go Back.</a></div>';
}

?>

</div>
<!-- Include the TinyMCE WYSIWYG editor -->
<script src="../vendor/tinymce/tinymce/tinymce.min.js"></script>
<script>
// Load the TinyMCE editor to the appropriate text area
tinymce.init({
    selector: 'textarea',
    plugins: "image link autolink lists preview",
    menubar: "file edit format insert view",
    toolbar: "undo redo cut copy paste bold italic underline strikethrough subscript superscript removeformat formats image link numlist bullist preview"
});

// Change the filename label when a file is selected
$('input[type=file]').change(function(){
  var filename = $(this).val().split('\\').pop();
  $('#imageLabel').html(filename);

  if ($('#imagePath')) {
  	$('#imagePreview').hide();
  }
});

// Show the image preview if no new image has been selected
if ($('#imagePath')) {
	$('#imagePreview').attr('src', $('#imagePath').val());
}
</script>
</body>
</html>