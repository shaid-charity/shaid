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
			<div class="content-grid no-sidebar">
				<section id="main">
					<section class="page-path">
						<span><a href="./referrals.php">Referrals</a></span>
					</section>
					<section class="info-page-content">
						<div class="page-title">
							<h1>Self-Referral</h1>
						</div>
						<p>Please note, this referral form is used to capture the basic information required by SHAID's Pre-Tenancy Worker. A full assessment of your needs will be carried out at your first appointment.</p>
						<iframe src="https://www-shaid-org-uk.filesusr.com/html/e00222_e463aaa667962391dac85a6977fcd680.html" frameborder="0" scrolling="auto" class="external-form-iframe"></iframe>
					</section>
				</section>
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
