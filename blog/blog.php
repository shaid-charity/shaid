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
	<title>SHAID - Blog</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');
	?>
	<link href="style/blog.css" rel="stylesheet">
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
					<div class="content-grid-title">
						<h1>SHAID Blog</h1>
					</div>
					<div class="articles-list-container">
						<section id="articles-list">
							<?php
								// If we are not logged in, only get published and approved posts
								$params = array();
								if ($user == null) {
									$query = "SELECT `id` FROM `posts` WHERE `published` = 1 ";
									$query = "SELECT `id` FROM `posts` WHERE `published` = 1 AND `approved` = 1 ";
									
								} else {
									$query = "SELECT `id` FROM `posts` WHERE `user_id`= ? ";
									if(isset($_GET['user_id'])){
										$params = array($_GET['user_id']);
									} else {
										$params = array($user->getID());
									}
								}

								// Get some pages, iterate through them
								// Set up the pagination
								$pagination = new Pagination($db, $query, $params);
								$pagination->totalRecords();
								$pagination->setLimitPerPage(5);
								$currentPage = $pagination->getPage();

								// Select the correct number of records from the DB
								if (isset($_GET['page'])) {
									$startFrom = ($_GET['page'] - 1) * 5;
								} else {
									$startFrom = 0;
								}

								// Get all posts, order by descending date
								$stmt = $db->prepare($query . "ORDER BY `datetime-last-modified` DESC LIMIT $startFrom, 5");
								$stmt->execute($params);
								$countQuery = $query;
								$countQuery = str_replace('`id`', 'COUNT(*)', $countQuery);

								$count = $db->prepare($countQuery);
								$count->execute($params);

								if ($count->fetchColumn() <= 0) {
									require_once(SITE_ROOT . '/includes/blog_modules/no_posts.php');
								} else {
									foreach ($stmt as $row) {
										$post = new Post($db, $row['id']);
	
										// Decide which image we will show (do this here so there is less inline PHP below)
										if ($post->getImagePath() == null) {
											$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/assets/img/placeholder/blog_image.jpg\');';
										} else {
											$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/' . htmlentities($post->getImagePath()) . '\');';
										}
							?>

							<div class="articles-list-entry">
								<a class="articles-list-entry-thumb" href="<?php echo $post->getLink(); ?>/" style="<?php echo $imageCSS; ?>"></a>
								<div class="articles-list-entry-info">
									<a href="<?php echo $post->getLink(); ?>/"><h2><?php echo $post->getTitle(); ?></h2></a>
									<p><?php echo $post->getShortDescription(); ?></p>
									<div class="articles-list-entry-actions">
										<ul>
											<li>
												<span><i class="zmdi zmdi-calendar"></i> <time datetime="<?php echo $post->getDatePublished(); ?>"><?php echo $post->getDatePublished(); ?></time></span>
											</li>
											<li>
												<a href="<?php echo $post->getCategory()->getLink(); ?>/"><?php echo $post->getCategory()->getName(); ?></a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<?php
								}
							?>
					</div>
					<nav>
						<ul class="pagination">
							<?php
								echo $pagination->getFirstAndBackLinks() . $pagination->getBeforeLinks() . $pagination->getCurrentPageLinks() . $pagination->getAfterLinks() . $pagination->getNextAndLastLinks();
							?>
						</ul>
					</nav>
					<?php
						}
					?>
					</section>
				</section>

				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/includes/sidebar_modules/post_list_admin_options.php');
						require_once(SITE_ROOT . '/includes/sidebar_modules/categories_list.php');
						require_once(SITE_ROOT . '/includes/sidebar_modules/newsletter_subscribe.php');
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
