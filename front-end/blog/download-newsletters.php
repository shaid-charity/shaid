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
						<span><a href="./downloads.php">Downloads</a></span>
					</section>
					<section class="info-page-content">
						<div class="info-page-split">
							<div class="info-page-info">
								<div class="page-title">
									<h1>Newsletters</h1>
								</div>
								<ul>
									<li><a href="./assets/documents/newsletters/issue_30.pdf">Newsletter issue 30</a></li>
									<li><a href="./assets/documents/newsletters/issue_31.pdf">Newsletter issue 31</a></li>
									<li><a href="./assets/documents/newsletters/issue_32.pdf">Newsletter issue 32</a></li>
									<li><a href="./assets/documents/newsletters/issue_33.pdf">Newsletter issue 33</a></li>
									<li><a href="./assets/documents/newsletters/issue_34.pdf">Newsletter issue 34</a></li>
									<li><a href="./assets/documents/newsletters/issue_35.pdf">Newsletter issue 35</a></li>
								</ul>
							</div>
							<div class="info-page-img">
								<!--
								<img src="assets/img/downloads/newsletters-page.png" class="downloads-page-aside">
								-->
							</div>
						</div>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/../includes/sidebar_modules/downloads_list.php');
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
