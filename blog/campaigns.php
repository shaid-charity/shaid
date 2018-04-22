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
	<title>SHAID - Campaigns</title>
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
						<h1>Campaigns</h1>
					</div>
					<div class="articles-list-container">
						<section id="articles-list">
							<?php
								// Get all campaigns
								if ($user == null) {
									$query = "SELECT `id` FROM `campaigns` WHERE `end_datetime` >= now()";
								} else {
									$query = "SELECT `id` FROM `campaigns`";
								}

								// Get some pages, iterate through them
								// Set up the pagination
								$pagination = new Pagination($db, $query, array());
								$pagination->totalRecords();
								$pagination->setLimitPerPage(5);
								$currentPage = $pagination->getPage();

								// Select the correct number of records from the DB
								if (isset($_GET['page'])) {
									$startFrom = ($_GET['page'] - 1) * 5;
								} else {
									$startFrom = 0;
								}

								// Get all categories, order by descending date
								$stmt = $db->query($query . "ORDER BY `start_datetime` DESC LIMIT $startFrom, 5");
									
								foreach ($stmt as $row) {
									$campaign = new Campaign($db, $row['id']);

									// Decide which image we will show (do this here so there is less inline PHP below)
									if ($campaign->getImagePath() == null) {
										$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/assets/img/placeholder/blog_image.jpg\');';
									} else {
										$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/' . htmlentities($campaign->getImagePath()) . '\');';
									}
							?>

							<div class="articles-list-entry">
								<a class="articles-list-entry-thumb" href="<?php echo $campaign->getLink(); ?>/" style="<?php echo $imageCSS; ?>"></a>
								<div class="articles-list-entry-info">
									<a href="<?php echo $campaign->getLink(); ?>/"><h2><?php echo $campaign->getTitle(); ?></h2></a>
									<p>A description of the most recent blog post.</p>
									<div class="articles-list-entry-actions">
										<ul>
											<li>
												<span><i class="zmdi zmdi-calendar"></i> <time datetime="<?php echo $campaign->getStartDateTime(); ?>"><?php echo $campaign->getStartDateTime(); ?></time> to <time datetime="<?php echo $campaign->getEndDateTime(); ?>"><?php echo $campaign->getEndDateTime(); ?></time></span>
											</li>
										</ul>
									</div>
								</div>
							</div>

							<?php } ?>
						</section>
					</div>
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
						require_once(SITE_ROOT . '/includes/sidebar_modules/categories_list.php');
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
