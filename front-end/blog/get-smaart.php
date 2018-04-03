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
	?>
	<link href="../style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
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
							<h1>Get SMAART</h1>
						</div>
						<img src="./assets/img/services/get-smaart.png" class="info-page-content-banner">
						<p>Get SMAART (<strong>Sensible Money Advice Achieves Real Tenancies</strong>) is an informal training programme lasting 3-4hrs. Training is aimed at offering advice to anyone who has experienced eviction, or who are potential first time tenants wishing to live independently.</p>
						<p>Overview of training content:</p>
						<ul>
							<li>Pros and cons of renting different types of accommodation;</li>
							<li>What is a tenancy;</li>
							<li>Rights and responsibilities of Tenant/Landlords;</li>
							<li>Practicalities of moving in/out;</li>
							<li>Where to go for help;</li>
							<li>Budgeting, Costings of setting up and running a home;</li>
							<li>Balancing the bills;</li>
							<li>Universal credits explained;</li>
							<li>Tackling debt;</li>
							<li>Digital inclusion;</li>
							<li>Useful contacts;</li>
						</ul>
						<p>This free training can be delivered in house or at an external venue (room hire charges may apply).</p>
						<p><a href="mailto:audshut@gmail.com?subject=Get SMAART info request" class="button-green">Request further information</a></p>
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
		require_once(SITE_ROOT . '/../includes/footer.php');
		require_once(SITE_ROOT . '/../includes/global_scripts.php');
	?>
</body>
</html>
