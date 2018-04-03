<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
	?>
	<link href="./style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/header.php');
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
							<h1>Agency Referral</h1>
						</div>
						<p>Please note, this referral form is used to capture the basic information required by SHAID's Pre-Tenancy Worker. A full assessment of the young persons needs will be carried out at their first appointment.</p>
						<iframe src="https://www-shaid-org-uk.filesusr.com/html/e00222_2a96b4f29622b323b9b4f1eae32b15ff.html" frameborder="0" scrolling="auto" class="external-form-iframe"></iframe>
					</section>
				</section>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>