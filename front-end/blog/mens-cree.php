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
		require_once(SITE_ROOT . '/includes/global_head.php');
	?>
	<link href="../style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
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
							<h1>Men's Cree</h1>
						</div>
						<div class="info-page-content-multi">
							<div class="info-page-content-multi-main">
								<img src="./assets/img/services/mens-cree-1.png">
							</div>
							<div class="info-page-content-multi-thumbs">
								<div>
									<img src="./assets/img/services/mens-cree-2.png">
								</div>
								<div>
									<img src="./assets/img/services/mens-cree-3.png">
								</div>
								<div>
									<img src="./assets/img/services/mens-cree-4.png">
								</div>
							</div>
						</div>
						<p>Based at Wear Road Community House, Derwentside Cree is a group for men of all ages designed to reduce isolation, promote positive mental health and social inclusion through: <strong>Peer Support</strong>, <strong>Mentoring</strong> and <strong>Informal Training</strong>.</p>
						<p>Activities on offer include:</p>
						<ul>
							<li>Fishing,</li>
							<li>Guitar tuition,</li>
							<li>Archery,</li>
							<li>Digital photography,</li>
							<li>Walking trips,</li>
							<li>Arts and crafts,</li>
							<li>Accredited training,</li>
							<li>Cookery,</li>
							<li>Woodcrafts,</li>
							<li>Board games,</li>
							<li>Wellbeing courses.</li>
							<li><em>And much more...</em></li>
						</ul>
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
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
