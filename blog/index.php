<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));

    require_once 'includes/settings.php';
	require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID - Home</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');
	?>
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/admin/admin_header.php');
		require_once(SITE_ROOT . '/includes/header.php');
	?>
	<main id="main-content">
		<div class="hero">
			<i class="hero-image"></i>
			<div class="hero-container">
				<div class="hero-text">
					<h1>Who are we?</h1>
					<p>SHAID provides a range of housing advice, support and related services to help young people make the difficult transition to living independently in the community.</p>
					<a href="/<?php echo INSTALLED_DIR; ?>/about.php" class="button-light">I want to hear more</a>
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
						<a href="/<?php echo INSTALLED_DIR; ?>/referrals.php" class="button-dark">Find out more</a>
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
						<a href="/<?php echo INSTALLED_DIR; ?>/pre-tenancy-support.php" class="button-dark">Find out more</a>
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
						<a href="/<?php echo INSTALLED_DIR; ?>/floating-support.php" class="button-dark">Find out more</a>
					</div>
				</div>
			</div>
		</div>
		<div class="section inner-container">
			Subscribe to our newsletter
		</div>
		<?php 
			// Get latest article in category 1 (news category)
			$news = true;

			try {
				$stmt = $db->query("SELECT `id` FROM `posts` WHERE `category_id` = 1 ORDER BY `datetime-published` DESC LIMIT 1");
				$id = $stmt->fetch()['id'];

				$post = new Post($db, $id);

				$description = substr(html_entity_decode(strip_tags($post->getContent())), 0, 150) . '...';
			} catch (Exception $e) {
				$news = false;
			}

			if ($news) {
		?>
		<div class="newspreview">
			<div class="inner-container">
				<div class="newspreview-header">
					<h1>SHAID News</h1>
				</div>
				<div class="newspreview-item inner-container">
					<span class="newspreview-item-date"><?php echo $post->getDatePublished(); ?></span>
					<h2><?php echo $post->getTitle(); ?></h2>
					<div class="newspreview-item-content">
						<div class="newspreview-item-content-img">
							<img src="<?php echo $post->getImagePath(); ?>" alt="<?php echo $post->getImageCaption(); ?>">
						</div>
						<div class="newspreview-item-content-text">
							<p><?php echo $description; ?></p>
							<div class="newspreview-item-content-text-link">
								<a href="<?php echo $post->getLink(); ?>/" class="button-dark">Read article</a>
							</div>
						</div>
					</div>
				</div>
				<div class="newspreview-footer">
					<a href="/<?php echo INSTALLED_DIR; ?>/blog/News/" class="button-light">Read more on our blog</a>
				</div>
			</div>
		</div>
		<?php
			}
		?>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
