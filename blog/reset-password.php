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
			<div class="content-grid no-sidebar">
				<section id="main">
					<?php
						if (isset($_POST['email'])) {
							// If the form was sent, check a user with that email exists
							$stmt = $db->prepare("SELECT `user_id` FROM `users` WHERE email = ?");
							$stmt->execute([$_POST['email']]);

							// If the user exists, create the user object
							if ($stmt->rowCount()) {
								$result = $stmt->fetch();
								$resetUser = new User($db, $result['user_id']);
								$resetUser->generatePasswordResetHash();

								$resetHash = $resetUser->getPasswordResetHash();

								// Now we have the password reset hash, send an email to the user
								$transport = new Swift_SmtpTransport(EMAIL_SERVER, EMAIL_PORT, 'tls');
								$transport->setUsername(EMAIL_ADDRESS);
								$transport->setPassword(EMAIL_PASSWORD);

								// Create a mailer
								$mailer = new Swift_Mailer($transport);

								$siteLink = $_SERVER['HTTP_HOST'] . '/' . INSTALLED_DIR . '/change-password.php?token=' . $resetHash;

								$content = "<h1>SHAID Admin Password Reset</h1><br /><br />" .
											"Please go to <a href='$siteLink'>this link</a> to reset your password.<br /><br />" .
											"If that link does not work, copy/paste the following into your browser:<br /><br />" .
											$siteLink;

								// Get a version of the message without any HTML tags
								// We can then send the plain text version as a backup, in case the HTML version won't load
								$messageNoHTML = strip_tags($content);

								// Create the message - recipient will be set later
								$message = new Swift_Message("SHAID Admin Password Reset");
								$message->setFrom(array(EMAIL_ADDRESS => EMAIL_NAME));
								$message->setBody($messageNoHTML);
								$message->addPart($content, 'text/html');

								// Send
								$message->setTo($resetUser->getEmail());

								$numSent = $mailer->send($message, $failed);
							}

							require_once(SITE_ROOT . '/includes/admin/admin_pass_reset_email.php');
						}
					?>
					<section class="info-page-content">
						<div class="content-grid-title">
							<h1>Password reset</h1>
							<p>Enter the email address associated with your account below to request a new password.</p>
							<form action="reset-password.php" method="post" class="login-form">
								<div class="post-input">
									<label for="email" class="section-label">Email address</label>
									<input type="email" id="email" name="email">
								</div>
								<button type="submit" class="button-green">Submit</button>
							</form>
						</div>
					</section>
				</section>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
