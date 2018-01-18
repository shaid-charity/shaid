<?php
require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once 'header.php';

if (isset($_GET['action']) && $_GET['action'] == 'write') {
	// This will eventually allow you to select emails from this screen too
	// For now though, just ensure the emails have been sent via the form
	if (empty($_POST)) {
		throw new Exception('No contacts were selected!');
	}

	if (isset($_POST['all'])) {
		$stmt = $db->query("SELECT `email` FROM `gp_friends`");

		$emails = [];
		foreach ($stmt as $row) {
			$emails[] = $row['email'];
		}

		$_SESSION['emails'] = $emails;
	} else {
		// Save the emails in a session variable so we can access them again
		$emails = [];

		foreach ($_POST as $email) {
			$emails[] = $email;
		}

		$_SESSION['emails'] = $emails;
	}

?>

<form action="sendEmail.php?action=send" method="post">
	<label for="subject">Subject:</label> <input type="text" name="subject"><br />
	<label for="to">To:</label> <?php foreach ($emails as $email) { echo $email . '; '; } ?><br />
	<label for="message">Message:</label><br />
	<textarea name="message"></textarea>
	<input type="submit" value="Send email">
</form>

<?php

} else if (isset($_GET['action']) && $_GET['action'] == 'send') {
	// Create the Transport
	$transport = (new Swift_SmtpTransport(EMAIL_SERVER, EMAIL_PORT, 'tls'))
		->setUsername(EMAIL_ADDRESS)
		->setPassword(EMAIL_PASSWORD);

	// Create a mailer
	$mailer = new Swift_Mailer($transport);

	// Get a version of the message without any HTML tags
	// We can then send the plain text version as a backup, in case the HTML version won't load
	$messageNoHTML = strip_tags($_POST['message']);

	// Create the message - recipient will be set later
	$message = (new Swift_Message($_POST['subject']))
		->setFrom([EMAIL_ADDRESS => EMAIL_NAME])
		->setBody($messageNoHTML)
		->addPart($_POST['message'], 'text/html');

	// Send
	$failed = [];
	$numSent = 0;

	foreach ($_SESSION['emails'] as $email) {
		$message->setTo($email);

		$numSent += $mailer->send($message, $failed);
	}

	echo 'Sent ' . $numSent . ' messages!';
	
	if (!empty($failed)) {
		echo 'Failed to send to: ' . print_r($array);
	}
}