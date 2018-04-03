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
						<span><a href="./downloads.php">Downloads</a></span>
					</section>
					<section class="info-page-content">
						<div class="page-title">
							<h1>Leaflets &amp; Posters</h1>
						</div>
						<div class="downloads-grid downloads-gallery-grid">
							<div class="downloads-grid-item" class="downloads-gallery-column">
								<div class="downloads-gallery-item">
									<a href="assets/documents/leaflets/download/plan4life.jpg" target="_blank">
										<img src="assets/documents/leaflets/thumbs/plan4life.jpg">
									</a>
								</div>
								<div class="downloads-gallery-item">
									<a href="assets/documents/leaflets/download/st_peters_court.pdf" target="_blank">
										<img src="assets/documents/leaflets/thumbs/st_peters_court.png">
									</a>
								</div>
							</div>
							<div class="downloads-grid-item" class="downloads-gallery-column">
								<div class="downloads-gallery-item">
									<a href="assets/documents/leaflets/download/service_guide.pdf" target="_blank">
										<img src="assets/documents/leaflets/thumbs/service_guide.png">
									</a>
								</div>
								<div class="downloads-gallery-item">
									<a href="assets/documents/leaflets/download/floating_support.jpg" target="_blank">
										<img src="assets/documents/leaflets/thumbs/floating_support.jpg">
									</a>
								</div>
							</div>
							<div class="downloads-grid-item" class="downloads-gallery-column">
								<div class="downloads-gallery-item">
									<a href="assets/documents/leaflets/download/cree_services.pdf" target="_blank">
										<img src="assets/documents/leaflets/thumbs/cree_services.png">
									</a>
								</div>
								<div class="downloads-gallery-item">
									<a href="assets/documents/leaflets/download/drop_in.jpg" target="_blank">
										<img src="assets/documents/leaflets/thumbs/drop_in.jpg">
									</a>
								</div>
								<div class="downloads-gallery-item">
									<a href="assets/documents/leaflets/download/pre-tenancy_support.jpg" target="_blank">
										<img src="assets/documents/leaflets/thumbs/pre-tenancy_support.jpg">
									</a>
								</div>
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
