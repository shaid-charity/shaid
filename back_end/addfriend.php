<?php
require_once 'includes/settings.php';
require_once 'includes/config.php';

if (!isset($_GET['action'])) {
?>

<html>
<body>

	<form action="addfriend.php?action=submit" method="post">
		Email: <input type="email" name="email"><br />
		Forename: <input type="text" name="fname"><br />
		Surname: <input type="text" name="sname"><br />
		<br />
		<input type="submit">
	</form>

<?php
} else if (isset($_GET['action']) && $_GET['action'] == 'submit') {
	// Create a new instantce of the Friend class, adding it to the DB in the process
	$email = $_POST['email'];
	$fname = $_POST['fname'];
	$sname = $_POST['sname'];

	$friend = new Friend($db, null, $email, $fname, $sname);
?>

	Created new Friend record: <br /><br />
	<strong>ID:</strong> <?php echo $friend->getID(); ?> <br />
	<strong>Email:</strong> <?php echo $friend->getEmail(); ?> <br />
	<strong>Forename:</strong> <?php echo $friend->getForename(); ?> <br />
	<strong>Surname:</strong> <?php echo $friend->getSurname(); ?> <br />

<?php
}
?>
