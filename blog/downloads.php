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
	<title>SHAID - Downloads</title>
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
			<div class="content-grid no-sidebar">
				<section id="main">
					<section class="info-page-content">
						<div class="content-grid-title">
							<h1>Downloads</h1>
						</div>
						<p>Click on a link below to enter the relevant download portal.</p>
						<div class="downloads-grid">
							<div class="downloads-grid-item">
								<div>
									<a href="download-leaflets.php">
										<img src="./assets/img/downloads/leaflets.png">
									</a>
									<span>Leaflets &amp; Posters</span>
								</div>
							</div>
							<div class="downloads-grid-item">
								<div>
									<a href="download-newsletters.php">
										<img src="./assets/img/downloads/newsletters.png">
									</a>
									<span>Newsletters</span>
								</div>
							</div>
							<div class="downloads-grid-item">
								<div>
									<a href="download-reports.php">
										<img src="./assets/img/downloads/reports.png">
									</a>
									<span>Reports</span>
								</div>
							</div>
							<div class="downloads-grid-item">
								<div>
									<a href="download-referral-forms.php">
										<img src="./assets/img/downloads/referrals.png">
									</a>
									<span>Referral Forms</span>
								</div>
							</div>
							<div class="downloads-grid-item">
								<div>
									<a href="download-recruitment-paperwork.php">
										<img src="./assets/img/downloads/recruitment.png">
									</a>
									<span>Recruitment Paperwork</span>
								</div>
							</div>
						</div>
					</section>
				</section>
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
