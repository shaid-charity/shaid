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
						<div class="page-title">
							<h1>Recruitment Paperwork</h1>
						</div>
						<p>TBC.</p>
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
		require_once(SITE_ROOT . '/../includes/footer.php');
		require_once(SITE_ROOT . '/../includes/global_scripts.php');
	?>
</body>
</html>
