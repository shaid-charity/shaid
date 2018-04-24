<?php
$title = "Create Category";
// Define a constant to be used in header.php
define('CURRENT_PAGE', 'contentCreateCategory');

require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once 'header.php';

?>

	<div class="container">
		<div class="page-header">
			<h1>Create Category</h1>
		</div>
		<br />

<?php


if ($_GET['action'] == 'submit') {
	$message = "";
	$error = false;
	try {
		$cat = new Category($db, null, $_POST['name'], str_replace(' ', '', strtolower($_POST['name'])));
	} catch (PDOException $e) {
		$error = true;

		if ($e->getCode() == '0') {
			$message = "That category already exists!";
		}
		else {
			$message = $e->getMessage();
		}
	}

	if ($error) {
?>

	<div class="alert alert-danger"><?php echo $message; ?></div>

<?php
	} else {
?>

	<div class="alert alert-success">Category successfully added!</div>

<?php
	}
?>
		<form action="createCategory.php?action=submit" method="post">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="name">Category name: </label> <input class="form-control col-sm-10" type="text" name="name" id="nameInput"><br />
				<input class="btn btn-primary" type="submit">
			</div>
		</form>

<?php
} else if ($_GET['action'] == 'edit') {
	// Make sure a category has been selected to edit
	if (!isset($_GET['id'])) {
		echo '<div class="alert alert-danger">No category selected!</div>';
		return;
	}

	// Get the category we want to edit
	$c = new Category($db, $_GET['id']);
?>

		<form action="createCategory.php?action=submitEdit" method="post">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="name">Category name: </label> <input class="form-control col-sm-10" type="text" name="name" id="nameInput" value="<?php echo $c->getName(); ?>"><br />
				<input type="hidden" name="categoryID" value="<?php echo $c->getID(); ?>">
				<input class="btn btn-primary" type="submit">
			</div>
		</form>
<?php
} else if ($_GET['action'] == 'submitEdit') {
	// Get the category we want to edit
	$c = new Category($db, $_POST['categoryID']);
	$error = false;

	// Set the new name
	try {
		$c->setName($_POST['name']);
	} catch (PDOException $e) {
		 $error = true;
	}

	if ($error) {
?>
		<div class="alert alert-danger">There was an error updating the category!</div>
<?php
	} else {
?>
		<div class="alert alert-success">Category successfully updated!</div>
<?php
	}
?>
		<form action="createCategory.php?action=submitEdit" method="post">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="name">Category name: </label> <input class="form-control col-sm-10" type="text" name="name" id="nameInput" value="<?php echo $c->getName(); ?>"><br />
				<input type="hidden" name="categoryID" value="<?php echo $c->getID(); ?>">
				<input class="btn btn-primary" type="submit">
			</div>
		</form>
<?php
} else {
?>
		<form action="createCategory.php?action=submit" method="post">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="name">Category name: </label> <input class="form-control col-sm-10" type="text" name="name" id="nameInput"><br />
				<input class="btn btn-primary" type="submit">
			</div>
		</form>
<?php
}
?>