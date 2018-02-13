<?php

require_once '../includes/settings.php';
require_once '../includes/config.php';

if (!isset($_GET['action'])) {

	// Get an array of all categories

?>

<form action="post.php?action=submit" method="post">
	<label for="title">Title: </label> <input type="text" name="title" id="titleInput"><br />
	<label for="category">Category; </label><select name="category">

	</select><br />
	<textarea name="content"></textarea><br />
	<input type="submit">
</form>

<?php
} else if ($_GET['action'] == 'submit') {
	// Create the blog post
	$name = $_POST['title'];
	//$categoryID = $_POST['category'];
	$content = $_POST['content'];

	$post = new Post($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, '', 1, '');
	echo 'Blog post created.';
}
?>