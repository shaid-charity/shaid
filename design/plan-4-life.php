<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
	?>
	<link href="./style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
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
						<div class="service-page-split">
							<div class="service-page-split-text">
								<div class="page-title">
									<h1>Plan 4 Life</h1>
								</div>
								<p>SHAID and DurhamWorks Plan 4 Life programme is for people aged 16&ndash;24 living in Co. Durham.</p>
								<p>This project approaches your educational and employment dreams in an informal, creative and fun environment.</p>
								<p>Our aim is to identify individual’s needs and make this experience unique.</p>
								<p>Your future is our priority.</p>
								<p><a href="#" class="button-green">Make a referral</a></p>
							</div>
							<div class="service-page-split-img">
								<img src="./assets/img/services/plan-4-life.png">
							</div>
						</div>
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
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
