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
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/header.php');
	?>
	<main id="main-content">
		<div class="hero">
			<i class="hero-image"></i>
			<div class="hero-container">
				<div class="hero-text">
					<h1>Who are we?</h1>
					<p>SHAID provides a range of housing advice, support and related services to help young people make the difficult transition to living independently in the community.</p>
					<a href="#" class="button-light">I want to hear more</a>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="section inner-container">
			<div class="section-item">
				<div class="section-item-content">
					<div class="section-item-top">
						<i class="section-item-header-image" data-img="img1"></i>
						<h2>Make A Referral</h2>
						<p>Download our referral form to make a referral to SHAID's <b>Housing Support Services</b>. You can also make referrals to our Pre-Tenancy service using our online form.</p>
					</div>
					<div class="section-item-bottom">
						<a href="#" class="button-dark">Find out more</a>
					</div>
				</div>
			</div>
			<div class="section-item">
				<div class="section-item-content">
					<div class="section-item-top">
						<i class="section-item-header-image" data-img="img2"></i>
						<h2>Pre-Tenancy Support</h2>
						<p>SHAID's <b>Pre-Tenancy Support Service</b> is available to anyone aged 18 to 25 who lives within Derwentside and needs assistance in accessing accommodation.</p>
					</div>
					<div class="section-item-bottom">
						<a href="#" class="button-dark">Find out more</a>
					</div>
				</div>
			</div>
			<div class="section-item">
				<div class="section-item-content">
					<div class="section-item-top">
						<i class="section-item-header-image" data-img="img3"></i>
						<h2>Floating Support</h2>
						<p>SHAID's <b>Floating Support Service</b> is available to anyone aged 16 to 25 who lives within Derwentside and needs assistance in managing their tenancy.</p>
					</div>
					<div class="section-item-bottom">
						<a href="#" class="button-dark">Find out more</a>
					</div>
				</div>
			</div>
		</div>
		<div class="newspreview">
			<div class="inner-container">
				<div class="newspreview-header">
					<h1>SHAID News</h1>
				</div>
				<div class="newspreview-item inner-container">
					<span class="newspreview-item-date">18/01/2017</span>
					<h2>National Citizen Service Student Group Fundraise for SHAID</h2>
					<div class="newspreview-item-content">
						<div class="newspreview-item-content-img">
							<img src="./assets/home/news-img-1.png" alt="title here">
						</div>
						<div class="newspreview-item-content-text">
							<p>SHAID were approached by the NCS student group known the 'Little Guardians of the Unfortunate'. As part of the NCS National Week of Social Action, the group wished to carry out...</p>
							<div class="newspreview-item-content-text-link">
								<a href="#" class="button-dark">Read article</a>
							</div>
						</div>
					</div>
				</div>
				<div class="newspreview-footer">
					<a href="#" class="button-light">Read more on our blog</a>
				</div>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
		require_once(SITE_ROOT . '/includes/donations_modal.php');
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
