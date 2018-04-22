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
		if (isset($_GET['id'])) {
			// Get the post's details
			$post = new Post($db, $_GET['id']);

			// Decide which image we will show (do this here so there is less inline PHP below)
			if ($post != null && $post->getImagePath() == null) {
				$image = '/' . INSTALLED_DIR . '/assets/img/placeholder/blog_image.jpg';
			} else {
				$image = '/' . INSTALLED_DIR . '/admin/' . htmlentities($post->getImagePath());
			}
		}

		if (isset($_GET['slug'])) {
			// Split it up by - and get the id
			$parts = explode('-', $_GET['slug']);
			$id = $parts[0];

			$post = new Post($db, $id);

			// Decide which image we will show (do this here so there is less inline PHP below)
			if ($post != null && $post->getImagePath() == null) {
				$image = '/' . INSTALLED_DIR . '/assets/img/placeholder/blog_image.jpg';
			} else {
				$image = '/' . INSTALLED_DIR . '/' . htmlentities($post->getImagePath());
			}
		}
	?>
	<title>SHAID - <?php echo $post->getTitle(); ?></title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');
	?>
	<link href="../../../style/blog.css" rel="stylesheet">
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
						// Show the same message if the post does not exist

						if ($post->getCategory() == null || (!$post->isPublished() && $user == null)) {
							?>
								<article id="article">
									<?php
										require_once(SITE_ROOT . '/includes/blog_modules/post_does_not_exist_message.php');
									?>
								</article>
							</section>
							<?php
						} else {
							// Generate link to share
							if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
								$link = 'https://' . $_SERVER['HTTP_HOST'] . $post->getLink();
							} else {
								$link = 'http://' . $_SERVER['HTTP_HOST'] . $post->getLink();
							}
					?>
					<article id="article">
						<section class="page-path">
							<span><a href="/<?php echo INSTALLED_DIR; ?>/blog.php">Blog</a> <i class="zmdi zmdi-chevron-right"></i> <a href="<?php echo $post->getCategory()->getLink(); ?>/"><?php echo $post->getCategory()->getName(); ?></a></span>
						</section>
						<section id="article-title" class="page-title article-title">
							<h1><?php echo $post->getTitle(); ?></h1>
						</section>
						<section id="article-info">
							<section id="article-author">
								<div id="article-author-photo">
									<img src="<?php echo $post->getAuthor()->getAvatarPath(); ?>" alt="<?php echo $post->getAuthor()->getFullName(); ?>">
								</div>
								<div id="article-author-text">
									<span id="article-author-text-name"><a href=""><?php echo $post->getAuthor()->getFullName(); ?></a></span>
									<span id="article-author-text-about"><?php echo $post->getAuthor()->getBiography(); ?></span>
								</div>
							</section>
							<section id="article-date">
								<span><i class="zmdi zmdi-calendar"></i> <time datetime="<?php echo $post->getDatePublished(); ?>"><?php echo $post->getDatePublished(); ?></time></span>
							</section>
						</section>
						<figure id="article-image">
							<img src="<?php echo $image; ?>" alt="<?php echo $post->getImageCaption(); ?>">
							<figcaption><?php echo $post->getImageCaption(); ?></figcaption>
						</figure>
						<section id="article-content">
							<?php echo $post->getContent(); ?>
						</section>
					</article>
					<div class="short-separator-container">
						<div class="short-separator-line">
						</div>
					</div>
					<section id="article-footer">
						<h2>Share this article</h2>
						<section id="social-icons">
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $link; ?>" target="_blank">
								<img src="../../../assets/social/svg/facebook (3).svg" alt="Share on Facebook">
							</a>
							<a href="http://www.twitter.com/share?url=<?php echo $link; ?>&hashtags=shaid" target="_blank">
								<img src="../../../assets/social/svg/twitter (3).svg" alt="Share on Twitter">
							</a>
							<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $link; ?>&source=SHAID" target="_blank">
								<img src="../../../assets/social/svg/linkedin (3).svg" alt="Share on LinkedIn">
							</a>
							<a href="http://www.reddit.com/submit?url=<?php echo $link; ?>&title=<?php echo $post->getTitle(); ?>" target="_blank">
								<img src="../../../assets/social/svg/reddit (3).svg" alt="Share on Reddit">
							</a>
							<a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo $link; ?>&title=<?php echo $post->getTitle(); ?>&caption=<?php echo $post->getContent(); ?>&tags=shaid" target="_blank">
								<img src="../../../assets/social/svg/tumblr (3).svg" alt="Share on Tumblr">
							</a>
						</section>
					</section>
				</section>
				<?php
					}
				?>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/includes/sidebar_modules/post_admin_options.php');

						if (!is_null($post->getCampaign())) {
					?>
					<section id="post-associated">
						<h1>Campaign</h1>
						<?php
							$campaign = $post->getCampaign();
						?>
						<h2><?php echo $campaign->getTitle(); ?></h2>
						<img src="<?php echo $campaign->getImagePath(); ?>" class="sidebar-large-image">
						<p><?php echo strip_tags($campaign->getShortDescription()); ?></p>
						<div class="sidebar-actions">
							<a href="<?php echo $campaign->getLink(); ?>" class="button-dark">More info</a>
							<a href="#" class="button-dark">Donate</a>
						</div>
					</section>
					<?php
						}
						require_once(SITE_ROOT . '/includes/sidebar_modules/recent_posts.php');
					?>
				</aside>
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
