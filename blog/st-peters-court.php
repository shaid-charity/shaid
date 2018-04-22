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
	<title>SHAID - St Peter's Court</title>
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
							<h1>St Peter's Court</h1>
						</div>
						<div class="info-page-content-multi">
							<div class="info-page-content-multi-main">
								<img src="./assets/img/services/st-peters-court-1.png">
							</div>
							<div class="info-page-content-multi-thumbs">
								<div>
									<img src="./assets/img/services/st-peters-court-2.png">
								</div>
								<div>
									<img src="./assets/img/services/st-peters-court-3.png">
								</div>
								<div>
									<img src="./assets/img/services/st-peters-court-4.png">
								</div>
							</div>
						</div>
						<p>St Peter's Court is a complex of sixteen self-contained fully furnished apartments. The development, situated within  Sacriston a village 3 miles from Durham City is specifically designed for former armed services personnel.</p>
						<p>In addition to the living  quarters there is also  an IT suite and  communal common room.</p>
						<p>Externally there is a car park,  tenants allotment and garden.</p>
						<p>SHAID can offer tenants support &amp; advice on issues including   possible funding avenues for training and employment as well as provide housing support when a  tenant decides to move on.</p>
						<p>Tenants may stay at St Peters Court for up to two years.</p>
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
