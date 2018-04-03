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
		require_once(SITE_ROOT . '/../includes/global_head.php');
		require_once(SITE_ROOT . '/../includes/admin/admin_head.php');
	?>
	<link href="../style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/../includes/admin/admin_header.php');
		require_once(SITE_ROOT . '/../includes/header.php');
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
							<h1>Pre-Tenancy Support</h1>
						</div>
						<img src="./assets/img/services/pre-tenancy.png" class="info-page-content-banner">
						<p>The Pre Tenancy Support Service offers support to young people aged 18-25 who have issues around housing.</p>
						<p>This type of support includes:</p>
						<ul>
							<li>Advice if you are thinking of leaving home;</li>
							<li>Support if you find yourself homeless;</li>
							<li>Help in finding somewhere to live;</li>
							<li>Access to a support service (the Floating Support Scheme) if you are living on your own and would like help;</li>
							<li>Basic advice on housing rights;</li>
							<li>Help with filling in forms and applying for benefits or grants;</li>
							<li>Help in accessing furniture for your home;</li>
							<li>Someone to talk to if you are having problems;</li>
							<li>Contacts to other services if you require them;</li>
							<li>Contacts with community groups and facilities;</li>
							<li>
								Referral to Monkey for support with fuel, furniture and finance.
								<a href="http://monkey.uk.net/" target="_blank"><img src="./assets/logos/external/monkey.png" class="list-img"></a>
							</li>
						</ul>
						<p><a href="#" class="button-green">Make a referral</a></p>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/../includes/sidebar_modules/services_list.php');
					?>
				</aside>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/../includes/cookie_warning.php');
require_once(SITE_ROOT . '/../includes/footer.php');
		require_once(SITE_ROOT . '/../includes/global_scripts.php');
	?>
</body>
</html>
