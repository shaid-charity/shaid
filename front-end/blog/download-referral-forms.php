<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));

    require_once '../../back-end/includes/settings.php';
	require_once '../../back-end/includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
	?>
	<link href="../style/blog.css" rel="stylesheet">
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
						<span><a href="./downloads.php">Downloads</a></span>
					</section>
					<section class="info-page-content">
						<div class="info-page-split">
							<div class="info-page-info">
								<div class="page-title">
									<h1>Referral Forms</h1>
								</div>
								<ul>
									<li><a href="./assets/documents/forms/pre-tenancy_self_referral_form.pdf">Pre-Tenancy Self-Referral Form</a></li>
									<li><a href="./assets/documents/forms/generic_housing_support_referral_form.pdf">Generic Housing Support Referral Form</a></li>
									<li><a href="./assets/documents/forms/social_isolation_navigator_referral_form.pdf">Social Isolation Navigator Referral Form</a></li>
									<li><a href="./assets/documents/forms/st_peters_court_referral_form.pdf">St Peter's Court Referral Form</a></li>
									<li><a href="./assets/documents/forms/cree_services_referral_form.pdf">Cree Services Referral Form</a></li>
									<li><a href="./assets/documents/forms/plan4life_referral_form.pdf">Plan 4 Life Referral Form</a></li>
								</ul>
							</div>
							<div class="info-page-img">
							</div>
						</div>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/includes/sidebar_modules/downloads_list.php');
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
