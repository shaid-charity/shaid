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
	<title>SHAID - Change Password</title>
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
						if (!isset($_GET['token']) && !isset($_POST['pass'])) {
							require_once(SITE_ROOT . '/includes/admin/admin_pass_reset_invalid_token.php');
						} else if (isset($_POST['pass'])) {
							// Check the token is valid
							$stmt = $db->prepare("SELECT `user_id` FROM `users` WHERE password_reset_hash = ?");
							$stmt->execute([$_POST['token']]);

							// If the user exists, create the user object
							if ($stmt->rowCount()) {
								$result = $stmt->fetch();
								$resetUser = new User($db, $result['user_id']);

								// (Try to) reset the password
								$test = $resetUser->resetPassword($_POST['token'], $_POST['pass']);
								if ($test) {
									require_once(SITE_ROOT . '/includes/admin/admin_pass_reset_success.php');
								}
							} else {
								require_once(SITE_ROOT . '/includes/admin/admin_pass_reset_invalid_token.php');
							}
						} else {
							// Check the token is valid
							$stmt = $db->prepare("SELECT `user_id` FROM `users` WHERE password_reset_hash = ?");
							$stmt->execute([$_GET['token']]);

							// If the user exists, create the user object
							if (!$stmt->rowCount()) {
								require_once(SITE_ROOT . '/includes/admin/admin_pass_reset_invalid_token.php');
							}
						}
					?>
					<section class="info-page-content">
						<div class="content-grid-title">
							<h1>Change password</h1>
							<p>Enter your new password below.</p>
							<form action="change-password.php" method="post" class="login-form">
								<div class="post-input">
									<label for="pass" class="section-label">Password</label>
									<input type="password" id="pass" name="pass">
									<label for="passRepeat" class="section-label">Retype Password</label>
									<input type="password" id="passRepeat" name="passRepeat">
									<input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">

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
