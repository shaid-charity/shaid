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
					<div class="content-grid-title">
						<h1>SHAID Blog</h1>
					</div>
					<section id="articles-list">
						<?php
							// Get some pages, iterate through them
							// Set up the pagination
							$pagination = new Pagination($db, "SELECT id FROM `posts`", array());
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
							$stmt = $db->query("SELECT `id` FROM `posts` ORDER BY `datetime-last-modified` DESC LIMIT $startFrom, 5");
								
							foreach ($stmt as $row) {
								$post = new Post($db, $row['id']);

								// Decide which image we will show (do this here so there is less inline PHP below)
								if ($post->getImagePath() == null) {
									$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/front-end/assets/img/placeholder/blog_image.jpg\');';
								} else {
									$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/back-end/admin/' . htmlentities($post->getImagePath()) . '\');';
								}
						?>

						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="<?php echo $post->getLink(); ?>/" style="<?php echo $imageCSS; ?>"></a>
							<div class="articles-list-entry-info">
								<a href="<?php echo $post->getLink(); ?>/"><h2><?php echo $post->getTitle(); ?></h2></a>
								<p>A description of the most recent blog post.</p>
								<div class="articles-list-entry-actions">
									<ul>
										<li>
											<span><i class="zmdi zmdi-calendar"></i> <time datetime="<?php echo $post->getDatePublished(); ?>"><?php echo $post->getDatePublished(); ?></time></span>
										</li>
										<li>
											<a href="<?php echo $post->getCategory()->getName(); ?>/"><?php echo $post->getCategory()->getName(); ?></a>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<?php } ?>
					</section>
					<nav>
						<ul class="pagination">
							<?php
								echo $pagination->getFirstAndBackLinks() . $pagination->getBeforeLinks() . $pagination->getCurrentPageLinks() . $pagination->getAfterLinks() . $pagination->getNextAndLastLinks();
							?>
						</ul>
					</nav>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/../includes/sidebar_modules/categories_list.php');
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
