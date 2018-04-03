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
		require_once(SITE_ROOT . '/../includes/admin/admin_head.php');
	?>
	<style>
	<?php
		require_once '../style/blog.css';
	?>
	</style>
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/../includes/admin/admin_header.php');
		require_once(SITE_ROOT . '/../includes/header.php');
	?>
	<main id="main-content">
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<section class="page-path">
						<span><a href="./blog.php">Blog</a></span>
					</section>
					<div class="page-title">
						<h1><?php echo $_GET['name']; ?></h1>
					</div>
					<?php
						// Check an ID was given and that it exists
						if (!isset($_GET['id']) && !isset($_GET['name'])) {
					?>
					<div class="article-message-banner">
						No category given.
					</div>

					<?php
						} else if (isset($_GET['id'])) {
							// Check the ID exists
							echo 'using id';
							try {
								$category = new Category($db, $_GET['id']);
							} catch (Exception $e) {
					?>

					<div class="article-message-banner">
						Check the selected category exists!
					</div>

					<?php
							}
						} else if (isset($_GET['name'])) {
							// Check the name exists
							$name = htmlspecialchars_decode($_GET['name']);
							try {
								$category = new Category($db, true, $name);
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
							$pagination = new Pagination($db, "SELECT id FROM `posts` WHERE `category_id` = ?", array($category->getID()));
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
							$stmt->execute([$category->getID()]);
								
							foreach ($stmt as $row) {
								$p = new Post($db, $row['id']);

								// Decide which image we will show (do this here so there is less inline PHP below)
								if ($p->getImagePath() == null) {
									$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/front-end/assets/img/placeholder/blog_image.jpg\');';
								} else {
									$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/back-end/admin/' . htmlentities($p->getImagePath()) . '\');';
								}
						?>
						
						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="<?php echo $p->getID() . '-' . $p->getTitle(); ?>/" style="<?php echo $imageCSS; ?>"></a>
							<div class="articles-list-entry-info">
								<a href="<?php echo $p->getID() . '-' . $p->getTitle(); ?>/"><h2><?php echo $p->getTitle(); ?></h2></a>
								<p>A description of the most recent blog post.</p>
								<div class="articles-list-entry-actions">
									<ul>
										<li>
											<span><i class="zmdi zmdi-calendar"></i> <time datetime="<?php echo $p->getDatePublished(); ?>"><?php echo $p->getDatePublished(); ?></time></span>
										</li>
										<li>
											<a href="<?php echo $p->getCategory()->getName(); ?>/"><?php echo $p->getCategory()->getName(); ?></a>
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
						require_once(SITE_ROOT . '/../includes/sidebar_modules/categories_list.php');
						require_once(SITE_ROOT . '/../includes/sidebar_modules/recent_posts.php');
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
