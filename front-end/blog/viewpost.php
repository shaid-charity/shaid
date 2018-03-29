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
	<link href="../../../style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/../includes/header.php');
	?>
	<main id="main-content">
		<?php
			if (isset($_GET['id'])) {
				// Get the post's details
				$post = new Post($db, $_GET['id']);

				// Decide which image we will show (do this here so there is less inline PHP below)
				if ($post->getImagePath() == null) {
					$image = '/' . INSTALLED_DIR . '/front-end/assets/img/placeholder/blog_image.jpg';
				} else {
					$image = '/' . INSTALLED_DIR . '/back-end/admin/' . htmlentities($post->getImagePath());
				}
			}

			if (isset($_GET['slug'])) {
				// Split it up by - and get the id
				$parts = explode('-', $_GET['slug']);
				$id = $parts[0];

				$post = new Post($db, $id);

				// Decide which image we will show (do this here so there is less inline PHP below)
				if ($post->getImagePath() == null) {
					$image = '/' . INSTALLED_DIR . '/front-end/assets/img/placeholder/blog_image.jpg';
				} else {
					$image = '/' . INSTALLED_DIR . '/back-end/admin/' . htmlentities($post->getImagePath());
				}
			}
		?>
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<article id="article">
						<section class="page-path">
							<span><a href="../../index.php">Blog</a> <i class="zmdi zmdi-chevron-right"></i> <a href="/<?php echo INSTALLED_DIR . '/front-end/blog/' . $post->getCategory()->getName(); ?>/">Category</a></span>
						</section>
						<section id="article-title" class="page-title article-title">
							<h1><?php echo $post->getTitle(); ?></h1>
						</section>
						<section id="article-info">
							<section id="article-author">
								<div id="article-author-photo">
									<img src="../../../assets/img/placeholder/profile_photo.jpg" alt="Jenny Smith">
								</div>
								<div id="article-author-text">
									<span id="article-author-text-name"><a href=""><?php echo $post->getAuthor()->getFullName(); ?></a></span>
									<span id="article-author-text-about">Guest blogger (SomeCharity)</span>
								</div>
							</section>
							<section id="article-date">
								<span><i class="zmdi zmdi-calendar"></i> <time datetime="<?php echo $post->getDatePublished(); ?>"><?php echo $post->getDatePublished(); ?></time></span>
							</section>
						</section>
						<figure id="article-image">
							<img src="<?php echo $image; ?>" alt="Above: Official figures show that 1 in 2 people are homeless.">
							<figcaption>Above: Official figures show that 1 in 2 people are homeless.</figcaption>
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
							<a href="https://www.facebook.com/sharer/sharer.php?u=example.org" target="_blank">
								<img src="../../../assets/social/svg/facebook (3).svg" alt="Share on Facebook">
							</a>
							<a href="http://www.twitter.com/share?url=https://example.org/&hashtags=shaid" target="_blank">
								<img src="../../../assets/social/svg/twitter (3).svg" alt="Share on Twitter">
							</a>
							<a href="https://www.linkedin.com/shareArticle?mini=true&url=http://developer.linkedin.com&title=LinkedIn%20Developer%20Network&summary=My%20favorite%20developer%20program&source=LinkedIn" target="_blank">
								<img src="../../../assets/social/svg/linkedin (3).svg" alt="Share on LinkedIn">
							</a>
							<a href="http://www.reddit.com/submit?url=http://shaid.org.uk&title=Shaid%20New%20Blog%20Post" target="_blank">
								<img src="../../../assets/social/svg/reddit (3).svg" alt="Share on Reddit">
							</a>
							<a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl={url}&title={title}&caption={desc}&tags={hash_tags}" target="_blank">
								<img src="../../../assets/social/svg/tumblr (3).svg" alt="Share on Tumblr">
							</a>
						</section>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/../includes/sidebar_modules/post_admin_options.php');
					?>
					<section id="post-associated">
						<h1>Campaign</h1>
						<?php
							// If no campaign is associated...
							if ($post->getCampaign() == null) {
						?>
						<h2>No campaign</h2>
						<?php
							} else {
								$campaign = $post->getCampaign();
						?>
						<h2><?php echo $campaign->getTitle(); ?></h2>
						<img src="http://via.placeholder.com/350x150" class="sidebar-large-image">
						<p>A brief description of what this campaign is all about...</p>
						<div class="sidebar-actions">
							<a href="#" class="button-dark">More info</a>
							<a href="#" class="button-dark">Donate</a>
						</div>
						<?php
							}
						?>
					</section>
					<?php
						require_once(SITE_ROOT . '/../includes/sidebar_modules/recent_posts.php');
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
