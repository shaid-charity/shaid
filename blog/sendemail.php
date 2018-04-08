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
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/admin/admin_header.php');
		require_once(SITE_ROOT . '/includes/header.php');
	?>
	<main id="main-content">
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<?php
						// Check to see if the email needs sending
						if ($_GET['action'] == 'send') {
							// Create the Transport
							$transport = new Swift_SmtpTransport(EMAIL_SERVER, EMAIL_PORT, 'tls');
							$transport->setUsername(EMAIL_ADDRESS);
							$transport->setPassword(EMAIL_PASSWORD);

							// Create a mailer
							$mailer = new Swift_Mailer($transport);

							// Get a version of the message without any HTML tags
							// We can then send the plain text version as a backup, in case the HTML version won't load
							$messageNoHTML = strip_tags($_POST['content']);

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

							require_once(SITE_ROOT . '/includes/admin/admin_email_sent_notice.php');

							if (!empty($failed)) {
								echo 'Failed to send to: ' . print_r($array);
							}
						} else {
							// Decide who we are sending it to
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
							}
						}
					?>
					<section class="page-path">
						<span><a href="./index.php">Home</a></span>
					</section>
					<div class="page-title">
						<h1>Send Email</h1>
					</div>
					<section id="post-editor">
						<form id="postForm" action="sendemail.php?action=send" method="post"  enctype="multipart/form-data">
							<div class="post-input">
								<label for="subject" class="section-label">Subject</label>
								<input type="text" name="subject" id="email-subject">
							</div>
							<div class="post-input">
								<label for="content" class="section-label">Email content</label>
								<textarea name="content" id="email-content"></textarea>
							</div>
						</button>
					</section>
				</section>
				<aside id="sidebar">
					<section>
						<h1>Info</h1>
						<ul>
							<li>
								<span><strong>Status:</strong>
								<em>New</em></span>
							</li>
						</ul>
					</section>
					<section>
						<h1>Send</h1>
						<div class="sidebar-actions">
							<input type="submit" class="button-green" name="saveType" value="Send">
						</div>
					</section>
				</aside>
			</form>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>

<!-- Include the TinyMCE WYSIWYG editor -->
<script src="vendor/tinymce/tinymce/tinymce.min.js"></script>
<script>
// Load the TinyMCE editor to the appropriate text area
tinymce.init({
    selector: 'textarea',
    plugins: "image link autolink lists preview",
    menubar: "file edit format insert view",
    toolbar: "undo redo cut copy paste bold italic underline strikethrough subscript superscript removeformat formats image link numlist bullist preview"
});
</script>
</body>
</html>
