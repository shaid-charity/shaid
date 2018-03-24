<?php

// Define a constant to be used in header.php
define('CURRENT_PAGE', 'contentCreatePost');

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
			<h1>Create Blog Post</h1>
		</div>
		<br />

<form action="post.php?action=submit" method="post" enctype="multipart/form-data">
	<input class="form-control" type="text" name="title" id="titleInput" placeholder="Title"><br />
	<select class="form-control form-control-sm" name="category">
		<?php
		foreach ($categories as $cat) {
			echo '<option value="' . $cat->getID() . '">' . $cat->getName() . '</option>';
		}
		?>
	</select><br />
	<div class="custom-file">
  		<input type="file" class="custom-file-input" id="image" name="image">
  		<label class="custom-file-label" for="customFile" id="imageLabel">Choose main image</label>
	</div><br /><br />
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

	if ($_POST['saveType'] == "Publish") {
		$post = new Post($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, $imagePath, $userID, '', $categoryID);
		echo 'Blog post published.';

		$post->setPublished(1);

		if (file_exists($file['tmp_name'])) {
			$uploadManager->upload($file);
		}
	} else if ($_POST['saveType'] == "Save draft") {
		$post = new Post($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, $imagePath, $userID, '', $categoryID);
		echo 'Blog post draft saved.';

		$post->setPublished(0);

		if (file_exists($file['tmp_name'])) {
			$uploadManager->upload($file);
		}
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

		<form action="post.php?action=update" method="post"  enctype="multipart/form-data">
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
			<img id="imagePreview" /><br />
			<div class="custom-file">
  				<input type="file" class="custom-file-input" id="image" name="image">
  				<label class="custom-file-label" for="customFile" id="imageLabel"><?php echo $post->getImageName(); ?></label>
			</div><br /><br />
			<textarea class="form-control" name="content" rows="10"><?php echo $post->getContent(); ?></textarea><br />
			<input name="id" type="hidden" value="<?php echo $post->getID(); ?>">
			<input class="btn btn-primary" name="saveType" type="submit" value="Publish">
			<input class="btn btn-secondary" name="saveType" type="submit" value="Save draft">
			<input type="hidden" name="imagePath" id="imagePath" value="<?php echo $post->getImagePath(); ?>">
		</form>

<?php
} else if ($_GET['action'] == 'update') {
	$post = new Post($db, $_POST['id']);
	$post->setName($_POST['title']);
	$post->setCategory($_POST['category']);
	$post->setContent($_POST['content']);
	$file = $_FILES['image'];

	// If a new main image was uploaded, change it
	if (file_exists($file['tmp_name'])) {
		$uploadManager = new UploadManager();
		$uploadManager->setFilename($file['name']);
		$imagePath = $uploadManager->getPath();
		$uploadManager->upload($file);

		$post->setImage($imagePath);
	}

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