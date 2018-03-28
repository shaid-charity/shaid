<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));

    require_once '../back-end/includes/settings.php';
	require_once '../back-end/includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
	?>
	<link href="./style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/header.php');
	?>
	<main id="main-content">
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<section class="page-path">
						<span><a href="./blog.php">Blog</a></span>
					</section>
					<div class="page-title">
						<h1>Category Name</h1>
					</div>
					<?php
						// Check an ID was given and that it exists
						if (!isset($_GET['id'])) {
					?>
					<div class="article-message-banner">
						No category ID given.
					</div>

					<?php
						} else {
							// Check the ID exists
							try {
								$category = new Category($db, $_GET['id']);
							} catch (Exception $e) {
					?>
					<div class="article-message-banner">
						Check the selected category exists!
					</div>

					<?php
							}
						}
					?>
					<section id="articles-list">

						<?php
							// Get all posts in category
							// Set up the pagination
							$pagination = new Pagination($db, "SELECT id FROM `posts` WHERE `category_id` = ?", array($_GET['id']));
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
							$stmt = $db->prepare("SELECT `id` FROM `posts` WHERE `category_id` = ? ORDER BY `datetime-last-modified` DESC LIMIT $startFrom, 5");
							$stmt->execute([$_GET['id']]);
								
							foreach ($stmt as $row) {
								$p = new Post($db, $row['id']);

								// Decide which image we will show (do this here so there is less inline PHP below)
								if ($p->getImagePath() == null) {
									$imageCSS = 'background-image: url(\'assets/img/placeholder/blog_image.jpg\');';
								} else {
									$imageCSS = 'background-image: url(\'../back-end/admin/' . htmlentities($p->getImagePath()) . '\');';
								}
						?>
						
						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="viewpost.php" style="<?php echo $imageCSS; ?>"></a>
							<div class="articles-list-entry-info">
								<a href="viewpost.php"><h2><?php echo $p->getTitle(); ?></h2></a>
								<p>A description of the most recent blog post.</p>
								<div class="articles-list-entry-actions">
									<ul>
										<li>
											<span><i class="zmdi zmdi-calendar"></i> <time datetime="<?php echo $p->getDatePublished(); ?>"><?php echo $p->getDatePublished(); ?></time></span>
										</li>
										<li>
											<a href="category.php"><?php echo $p->getCategory()->getName(); ?></a>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<?php } ?>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/includes/sidebar_modules/categories_list.php');
						require_once(SITE_ROOT . '/includes/sidebar_modules/recent_posts.php');
					?>
				</aside>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
