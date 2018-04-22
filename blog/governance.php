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
	<title>SHAID - Governance</title>
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
						<span><a href="./about.php">About</a></span>
					</section>
					<section class="info-page-content">
						<div class="page-title">
							<h1>Governance</h1>
						</div>
						<p>Governance for the organisation is the responsibility of SHAID’s Board of Directors which consists of representatives from various voluntary and statutory agencies as well as members of the community who have an interest in youth homelessness.  SHAID would like to thank the directors for their continuing support in making it the success it is today.</p>
						<div class="trustee-split">
							<img src="./assets/img/about/governance.png">
							<p><strong>SHAID are always looking for new Trustees with a passion for helping young people in the district. If you would like to get involved please ring SHAID on <a href="tel:01207238241">01207 238241</a>.</strong></p>
						</div>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/includes/sidebar_modules/about_list.php');
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
