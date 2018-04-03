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
			<div class="content-grid">
				<section id="main">
					<section class="info-page-content">
						<div class="content-grid-title">
							<h1>About</h1>
						</div>
						<p>SHAID provides a range of housing advice, support and related services to help young people make the difficult transition to living independently in the community.</p>
						<p>The sort of things we can help you with include:</p>
						<ul>
							<li>Advice if you are thinking of leaving home;</li>
							<li>Help in finding somewhere to live;</li>
							<li>Basic advice on your housing rights;</li>
							<li>Support if you find yourself homeless;</li>
							<li>Help with filling in forms and dealing with red tape, including benefit claims;</li>
							<li>Guidance about managing your money and paying bills;</li>
							<li>Support if you are living on your own;</li>
							<li>Someone to listen to you if you have problems, and help you decide on how to deal with them;</li>
							<li>Learning to plan meals, shop and cook;</li>
							<li>Putting you in touch with comminity groups and facilities;</li>
							<li>Advice on finding interesting things to do with your time (work, training courses, clubs, volunteering, sports);</li>
							<li>Drop-in sessions, a chance to meet other young people in similar situations and chat with support workers.</li>
						</ul>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/../includes/sidebar_modules/about_list.php');
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
