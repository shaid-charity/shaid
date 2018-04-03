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
	<link href="../style/blog.css" rel="stylesheet">
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
						<span><a href="./downloads.php">Downloads</a></span>
					</section>
					<section class="info-page-content">
						<div class="info-page-split">
							<div class="info-page-info">
								<div class="page-title">
									<h1>Reports</h1>
								</div>
								<ul>
									<li><a href="./assets/documents/reports/annual_general_report_2014-2015.pdf">Annual General Report 2014&ndash;2015</a></li>
									<li><a href="./assets/documents/reports/annual_general_report_2015-2016.pdf">Annual General Report 2015&ndash;2016</a></li>
									<li><a href="./assets/documents/reports/annual_general_report_2016-2017.pdf">Annual General Report 2016&ndash;2017</a></li>
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
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
