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
	<title>SHAID - Newsletter</title>
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
					<section class="info-page-content">
						<div class="content-grid-title">
							<h1>Newsletter</h1>
							<?php
								if(isset($_POST['email'])) {
							?>
							<p>You are now subscribed to the SHAID newsletter!</p>
							<p>
								<a href="index.php" class="button-green">Return to home page</a>
								<a href="javascript:void(0)" class="button-dark">Unsubscribe</a>
							</p>
							<?php
								} else {
							?>
							<p>Enter your email address below to subscribe to the SHAID newsletter and keep up to date with our mission.</p>
							<form method="post" class="login-form">
								<div class="post-input">
									<label for="email" class="section-label">Email address</label>
									<input type="text" id="email" name="email">
								</div>
								<button type="submit" class="button-green">Subscribe</button>
							</form>
							<?php
								}
							?>
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
