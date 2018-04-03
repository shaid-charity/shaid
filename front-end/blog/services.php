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
					<section class="info-page-content">
						<div class="content-grid-title">
							<h1>Services</h1>
						</div>
						<p>We offer a wide variety of support services to the people of across County Durham.</p>
						<p>Currently the services we offer include:</p>
						<ul>
							<li><strong><a href="#">Pre-Tenancy Support:</a></strong> for young people aged 18-25 who wish to access indepenant or supported accommodation.</li>
							<li><strong><a href="#">Floating Support:</a></strong> for young people aged 16-25 who would like assistance managing their own tenancy.</li>
							<li><strong><a href="#">St Peters Court:</a></strong> supported accommodation for ex armed forces personnel. </li>
							<li><strong><a href="#">Mens Cree:</a></strong> peer support and activy group for men aged 16+.</li>
							<li><strong><a href="#">Plan 4 Life:</a></strong> a Youth Inclusion Initiative training programme for young people aged 16 - 25.</li>
							<li><strong><a href="#">Get SMAART:</a></strong> informal group training for young people enabling them to sustain a tenancy.</li>
						</ul>
						<div class="content-grid-title">
							<h1>Service Case Studies</h1>
						</div>
						<div class="content-grid-flex-row">
							<div>
								<img src="./assets/img/silhouettes/woman1.png">
								<h2><a href="./assets/documents/services/ruths-story.pdf" target="_blank">Ruth's Story</a></h2>
								<p>Ruth self-referred to SHAID's Floating Support Service for support around housing.</p>
								<a href="./assets/documents/services/ruths-story.pdf" target="_blank" class="button-dark">Read more</a>
							</div>
							<div>
								<img src="./assets/img/silhouettes/man1.png">
								<h2><a href="./assets/documents/services/shanes-story.pdf" target="_blank">Shane's Story</a></h2>
								<p>Shane is a 28 year old male who became a tenant at St Peters Court on 18th February 2013.</p>
								<a href="./assets/documents/services/shanes-story.pdf" target="_blank" class="button-dark">Read more</a>
							</div>
							<div>
								<img src="./assets/img/silhouettes/man2.png">
								<h2><a href="./assets/documents/services/brians-story.pdf" target="_blank">Brian's Story</a></h2>
								<p>Brian was referred to SHAID’s Social   Isolation Navigator by The Wellbeing Team.</p>
								<a href="./assets/documents/services/brians-story.pdf" target="_blank" class="button-dark">Read more</a>
							</div>
						</div>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/../includes/sidebar_modules/services_list.php');
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
