<?php

require_once '../includes/settings.php';
require_once '../includes/config.php';

if (!isset($_GET['action'])) {

	// Get an array of all categories
	$stmt = $db->query("SELECT `id` FROM `categories`");
	
	$categories = Array();
	foreach ($stmt as $row) {
		$categories[] = new Category($db, $row['id']);
	}
?>

<form action="post.php?action=submit" method="post">
	<label for="title">Title: </label> <input type="text" name="title" id="titleInput"><br />
	<label for="category">Category; </label><select name="category">
		<?php
		foreach ($categories as $cat) {
			echo '<option value="' . $cat->getID() . '">' . $cat->getName() . '</option>';
		}
		?>
	</select><br />
	<textarea name="content"></textarea><br />
	<input type="submit">
</form>

<?php
} else if ($_GET['action'] == 'submit') {
	// Create the blog post
	$name = $_POST['title'];
	$categoryID = $_POST['category'];
	$content = $_POST['content'];

	$post = new Post($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, '', 1, '', $categoryID);
	echo 'Blog post created.';
}
?>