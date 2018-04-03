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
			<div class="content-grid no-sidebar">
				<section id="main">
					<section class="info-page-content">
						<div class="content-grid-title">
							<h1>Refferals</h1>
						</div>
						<h2>Online</h2>
						<ul>
							<li><strong><a href="./self-referral.php">Pre-Tenancy Self-Referral Form:</a></strong> Use this form to request the services of SHAID for yourself.</li>
							<li><strong><a href="./agency-referral.php">Pre-Tenancy Agency Referral Form:</a></strong> For use agencies in referring clients to SHAID.</li>
						</ul>
						<h2>Referral Forms</h2>
						<p>Visit our <a href="download-referral-forms.php">referral forms downloads</a> page to download a referral form to fill in offline.</p>
					</section>
				</section>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/../includes/footer.php');
		require_once(SITE_ROOT . '/../includes/global_scripts.php');
	?>
</body>
</html>
