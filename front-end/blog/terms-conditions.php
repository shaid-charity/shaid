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
			<div class="content-grid no-sidebar">
				<section id="main">
					<section class="info-page-content">
						<div class="page-title">
							<h1>Terms &amp; Conditions</h1>
						</div>
						<h2>1. Definitions</h2>
						<p>In the context of these terms and conditions, the following words shall have the following meanings:</p>
						<ol>
							<li>"SHAID" means Single Homeless Action Initiative in Durham , a charity registered under number 1074505 and a company limited by guarantee registered under number 3659370, having its registered office at 94a Front Street Stanley Co. Durham DH9 0HU;</li>
							<li>“the Website” means any website under the ownership or control of SHAID from which a link has been created to these terms and conditions;</li>
							<li>“the Material” means all of the information, data, text, graphics, links or computer code published on, contained or available on the Website.</li>
						</ol>
						<h2>2. Applicable terms and conditions</h2>
						<p>The Website is owned by SHAID and your use made of this site (including registrations and donations made via the Website), is subject to these terms and conditions. SHAID reserves the right to modify or revise these terms and conditions at any time by updating the text of this page. Your continued use of the website after any changes have been made constitutes your acceptance of the modified terms and conditions.</p>
						<h2>3. Use of the website</h2>
						<p>You are entitled to view any parts of the Website which are not password protected and to use for your own purposes the information set out in the Website provided it is used for information purposes, for reproduction for your personal use only.</p>
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
