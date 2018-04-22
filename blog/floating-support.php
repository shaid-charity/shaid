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
	<title>SHAID - Floating Support</title>
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
					<section class="page-path">
						<span><a href="./services.php">Services</a></span>
					</section>
					<section class="info-page-content">
						<div class="page-title">
							<h1>Floating Support</h1>
						</div>
						<img src="./assets/img/services/floating.png" class="info-page-content-banner">
						<p>The primary role of the Floating Support Scheme is to offer young people age 16-25 support in their own tenancies or in the transitional period towards independent living.</p>
						<p>The support offered includes:</p>
						<ul>
							<li>Housing rights &amp; responsibility;</li>
							<li>Applying for benefits and grants;</li>
							<li>Budgeting and paying bills;</li>
							<li>Finding furniture;</li>
							<li>Reporting repairs;</li>
							<li>Learning skills to help you successfully maintain your tenancy;</li>
							<li>Building self confidence;</li>
							<li>Networking with specialist agency;</li>
							<li>Befriending &amp; emotional support;</li>
							<li>Advice on education, training or employment;</li>
							<li>Advocacy.</li>
						</ul>
						<p><a href="#" class="button-green">Make a referral</a></p>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/includes/sidebar_modules/services_list.php');
					?>
				</aside>
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
