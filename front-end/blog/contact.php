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
							<h1>Contact us</h1>
						</div>
						<div class="info-page-split">
							<div class="info-page-info">
								<p>
									<strong>Telephone:</strong> <a href="tel:01207238241">01207 238241</a>
									<br><strong>Email:</strong> <a href="mailto:info@shaid.org.uk">info@shaid.org.uk</a>
								</p>
								<p>
									<strong>Main office address:</strong>
									<br>94A Front St
									<br>Stanley Co. Durham
									<br>DH9 0HU
								</p>
								<div id="social-icons">
									<a href="https://www.facebook.com/" target="_blank">
										<img src="./assets/social/svg/facebook (3).svg" alt="Share on Facebook">
									</a>
									<a href="http://www.twitter.com/" target="_blank">
										<img src="./assets/social/svg/twitter (3).svg" alt="Share on Twitter">
									</a>
								</div>
							</div>
							<div class="info-page-img">
								<iframe
									frameborder="0" style="border:0"
									src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDohzq_Q_a8jE77Etbxgt2I3jhpn8OnDLM
									&q=SHAID, 94A Front S, DH9 0HU" allowfullscreen>
								</iframe>
							</div>
						</div>
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
