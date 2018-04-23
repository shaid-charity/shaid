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
	<?php
		$campaignLoaded = true;
		try {
			if (isset($_GET['id'])) {
				// Get the campaign's details
				$campaign = new Campaign($db, $_GET['id']);
				// Decide which image we will show (do this here so there is less inline PHP below)
				if ($campaign != null && $campaign->getImagePath() == null) {
					$image = '/' . INSTALLED_DIR . '/assets/img/placeholder/blog_image.jpg';
				} else {
					$image = '/' . INSTALLED_DIR . '/admin/' . htmlentities($campaign->getImagePath());
				}
			}
			if (isset($_GET['slug'])) {
				// Split it up by - and get the id
				$parts = explode('-', $_GET['slug']);
				$id = $parts[0];
				$campaign = new Campaign($db, $id);
				// Decide which image we will show (do this here so there is less inline PHP below)
				if ($campaign != null && $campaign->getImagePath() == null) {
					$image = '/' . INSTALLED_DIR . '/assets/img/placeholder/blog_image.jpg';
				} else {
					$image = '/' . INSTALLED_DIR . '/' . htmlentities($campaign->getImagePath());
				}
			}
		} catch (Exception $e) {
			$campaignLoaded = false;
		}
	?>
	<?php
		if ($campaignLoaded) {
			?>
			<title>SHAID - <?php echo $campaign->getTitle(); ?></title>
		<?php
		} else {
			?>
			<title>SHAID - Campaign Not Found</title>
			<?php
		}
	?>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');
	?>
	<link href="../../style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/admin/admin_header.php');
		require_once(SITE_ROOT . '/includes/header.php');
	?>
	<main id="main-content">
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<?php
						// If the article is a draft and we are not logged in, show an error message
						// Show the same message if the campaign does not exist

						if (!$campaignLoaded) {
							?>
								<article id="article">
									<section class="page-path" style="padding-bottom: 1.5rem;">
										<span><a href="/<?php echo INSTALLED_DIR; ?>/campaigns.php">Campaigns</a></span>
									</section>
									<?php
										require_once(SITE_ROOT . '/includes/blog_modules/campaign_does_not_exist_message.php');
									?>
								</article>
							</section>
							<?php
						} else {
							// Generate link to share
							if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
								$link = 'https://' . $_SERVER['HTTP_HOST'] . $campaign->getLink();
							} else {
								$link = 'http://' . $_SERVER['HTTP_HOST'] . $campaign->getLink();
							}
					?>
					<article id="article">
						<section class="page-path">
							<span><a href="/<?php echo INSTALLED_DIR; ?>/campaigns.php">Campaigns</a></span>
						</section>
						<section id="article-title" class="page-title article-title">
							<h1><?php echo $campaign->getTitle(); ?></h1>
						</section>
						<section id="article-info">
							<section id="article-author">
								<div id="article-author-photo">
									<img src="<?php echo $campaign->getAuthor()->getAvatarPath(); ?>" alt="<?php echo $campaign->getAuthor()->getFullName(); ?>">
								</div>
								<div id="article-author-text">
									<span id="article-author-text-name"><a href=""><?php echo $campaign->getAuthor()->getFullName(); ?></a></span>
									<span id="article-author-text-about"><?php echo $campaign->getAuthor()->getBiography(); ?></span>
								</div>
							</section>
						</section>
						<section class="campaign-donation-section">
							<div class="campaign-donation-meter">
								<div class="campaign-donation-meter-progress" style="width: 50%;">
								</div>
							</div>
							<p>
								<?php echo $campaign->getAmountRaised(); ?> raised of <?php echo $campaign->getGoalAmount(); ?>
							</p>
							<a href="javascript:void(0)" class="button-green">Donate to this Campaign</a>
						</section>
						<figure id="article-image">
							<img src="<?php echo $image; ?>" alt="<?php echo $campaign->getImageCaption(); ?>">
							<figcaption><?php echo $campaign->getImageCaption(); ?></figcaption>
						</figure>
						<section id="article-content">
							<?php echo $campaign->getContent(); ?>
						</section>
					</article>
					<div class="short-separator-container">
						<div class="short-separator-line">
						</div>
					</div>
					<section id="article-footer">
						<h2>Share this campaign</h2>
						<section id="social-icons">
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $link; ?>" target="_blank">
								<img src="../../assets/social/svg/facebook (3).svg" alt="Share on Facebook">
							</a>
							<a href="http://www.twitter.com/share?url=<?php echo $link; ?>&hashtags=shaid" target="_blank">
								<img src="../../assets/social/svg/twitter (3).svg" alt="Share on Twitter">
							</a>
							<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $link; ?>&source=SHAID" target="_blank">
								<img src="../../assets/social/svg/linkedin (3).svg" alt="Share on LinkedIn">
							</a>
							<a href="http://www.reddit.com/submit?url=<?php echo $link; ?>&title=<?php echo $campaign->getTitle(); ?>" target="_blank">
								<img src="../../assets/social/svg/reddit (3).svg" alt="Share on Reddit">
							</a>
							<a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo $link; ?>&title=<?php echo $campaign->getTitle(); ?>&caption=<?php echo $campaign->getContent(); ?>&tags=shaid" target="_blank">
								<img src="../../assets/social/svg/tumblr (3).svg" alt="Share on Tumblr">
							</a>
						</section>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/includes/sidebar_modules/campaigns_admin_options.php');
						require_once(SITE_ROOT . '/includes/sidebar_modules/campaigns_info.php');
						require_once(SITE_ROOT . '/includes/sidebar_modules/campaigns_associated_posts.php');
					?>
				</aside>
				<?php
					}
				?>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
