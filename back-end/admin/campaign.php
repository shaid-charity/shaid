<?php

// Define a constant to be used in header.php
define('CURRENT_PAGE', 'campaignsCreate');

require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once 'header.php';

// Get the user ID
$stmt = $db->prepare("SELECT users.user_id FROM users, sessions WHERE users.user_id = sessions.user_id AND session_number=?");
$stmt->execute(array($session_number));
$userID = $stmt->fetch()['user_id'];

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
			<h1>Create New Campaign</h1>
		</div>
		<br />

<form action="campaign.php?action=submit" method="post" enctype="multipart/form-data">
	<input class="form-control" type="text" name="title" id="titleInput" placeholder="Title"><br />
	<input class="form-control" type="datetime-local" name="startDatetime" id="startDatetimeInput"><br />
	<input class="form-control" type="datetime-local" name="endDatetime" id="endDatetimeInput"><br />
	<input class="form-control" type="number" step="0.01" name="goalAmount" id="goalAmountInput"><br />
	<div class="custom-file">
  		<input type="file" class="custom-file-input" id="image" name="image">
  		<label class="custom-file-label" for="customFile" id="imageLabel">Choose main image</label>
	</div><br /><br />
	<textarea class="form-control" name="content" rows="10"></textarea><br />
	<input class="btn btn-primary" name="saveType" type="submit" value="Create">
</form>

<?php
} else if ($_GET['action'] == 'submit') {
	// Create the campaign
	$name = $_POST['title'];
	$startDatetime = $_POST['startDatetime'];
	$endDatetime = $_POST['endDatetime'];
	$goalAmount = $_POST['goalAmount'];
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
		$campaign = new Campaign($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, $imagePath, $userID, $startDatetime, $endDatetime, $goalAmount, 0);
		echo 'Campaign created.';

		if (file_exists($file['tmp_name'])) {
			$uploadManager->upload($file);
		}
	}
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