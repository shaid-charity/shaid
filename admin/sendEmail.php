<?php
require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once 'header.php';
?>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.js" crossorigin="anonymous"></script>
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

	<div class="container">
		<div class="page-header">
			<h1>Send Email</h1>
		</div>
		<br />

<?php
if ($_GET['action'] == 'send') {
	// Create the Transport
	$transport = new Swift_SmtpTransport(EMAIL_SERVER, EMAIL_PORT, 'tls');
	$transport->setUsername(EMAIL_ADDRESS);
	$transport->setPassword(EMAIL_PASSWORD);

	// Create a mailer
	$mailer = new Swift_Mailer($transport);

	// Get a version of the message without any HTML tags
	// We can then send the plain text version as a backup, in case the HTML version won't load
	$messageNoHTML = strip_tags($_POST['message']);

	// Create the message - recipient will be set later
	$message = new Swift_Message($_POST['subject']);
	$message->setFrom(array(EMAIL_ADDRESS => EMAIL_NAME));
	$message->setBody($messageNoHTML);
	$message->addPart($_POST['message'], 'text/html');

	// Send
	$failed = array();
	$numSent = 0;

	foreach ($_SESSION['emails'] as $email) {
		$message->setTo($email);

		$numSent += $mailer->send($message, $failed);
	}
	print_r($numSent);
	print_r($failed);
	print_r($_SESSION['emails']);
	echo '<div class="alert alert-success">Sent ' . $numSent . ' messages!</div>';

	if (!empty($failed)) {
		echo 'Failed to send to: ' . print_r($array);
	}
}
?>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'write') {
	$toText = '';
	if (isset($_POST['type'])) {
		if ($_POST['type'] == 'all') {
			$stmt = $db->query("SELECT `email` FROM `gp_friends`");
		}
		
		$emails = array();
		foreach ($stmt as $row) {
			$emails[] = $row['email'];
		}
		$toText = 'All contacts';

		$_SESSION['emails'] = $emails;
	} else {
		// Save the emails in a session variable so we can access them again
		$emails = array();

		foreach ($_POST as $email) {
			if (!empty($email)) {
				$emails[] = $email;
				$toText .= $email . '; ';
			}
		}

		$_SESSION['emails'] = $emails;
		print_r(session_save_path());
	}
}
?>
		<form action="sendEmail.php?action=send" method="post">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="subject">Subject:</label> 
				<div class="col-sm-10">
					<input class="form-control" placeholder="Subject" type="text" name="subject">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="to">To:</label> 
				<div class="col-sm-10">
					<input type="text" readonly class="form-control-plaintext" value="<?php echo $toText; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="message">Message:</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="15" name="message"></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label"></label>
				<input class="btn btn-primary ml-3" type="submit" value="Send email">
			</div>
		</form>

	</div>