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
	<title>SHAID</title>
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
			<div class="content-grid no-sidebar">
				<section id="main">
					<div class="content-grid-title">
						<h1>Search</h1>
					</div>
					<h2 class="search-section-title">SHAID Blog</h2>
					<div class="search-section-container">
					<?php
						// Check we have a search term
						if (!isset($_GET['term'])) {
							require_once(SITE_ROOT . '/includes/blog_modules/search_no_results.php');
						} else {
							$term = $_GET['term'];
							$postsQuery = "SELECT DISTINCT `id` from `posts` WHERE (match(`title`) against(? IN BOOLEAN MODE) OR match(`content`) against(? IN BOOLEAN MODE) OR match(`image_caption`) against(? IN BOOLEAN MODE))";

							// If we are not logged in, only get published posts
							if ($user == null) {
								$postsQuery .= " AND `published` = 1 ";
							}

							// Get some pages, iterate through them
							// Set up the pagination
							$displayResultsList = true; // Boolean to output articles-list
							try {
								$pagination = new Pagination($db, $postsQuery, array($term, $term, $term));
								$pagination->totalRecords();
								$pagination->setLimitPerPage(3);
								$currentPage = $pagination->getPage();

								// Select the correct number of records from the DB
								if (isset($_GET['page'])) {
									$startFrom = ($_GET['page'] - 1) * 3;
								} else {
									$startFrom = 0;
								}

								// Get all posts, order by descending date
								$stmt = $db->prepare($postsQuery . " ORDER BY `datetime-last-modified` DESC LIMIT $startFrom, 3");
								$stmt->execute([$term, $term, $term]);

								// If the list is empty, we have come to the end of the campaigns
								if (!$stmt->rowCount()) {
									$displayResultsList = false;
									$type = 'blog posts';
									require(SITE_ROOT . '/includes/blog_modules/search_no_more_results.php');
									$stmt = array();
								}
							}
							catch (Exception $error) {
								$displayResultsList = false;
								require_once(SITE_ROOT . '/includes/blog_modules/search_no_results.php');
							}
							if ($displayResultsList) {
								echo '<section id="articles-list">';
							}
					?>
						<?php
							foreach ($stmt as $row) {
								$post = new Post($db, $row['id']);

								// See if the search term appears in the description
								// This function will not return true, so we check to see it hasn't returned false
								$strippedContent = html_entity_decode(strip_tags($post->getContent()));
								if (stristr($post->getContent(), $term) != false) {
									$pos = stripos($strippedContent, $term);

									// Place <span class="search-term"></span> tags around the found search term so we can highlight it
									if ($pos == 0) {
										// Get surrounding 120 characters for a description
										$description = substr($strippedContent, 0, 120);

										// Highlight the search term in the description
										$descPos = stripos($description, $term);

										$description = '<span class="search-term">' . substr($description, 0, strlen($term)) . '</span>' . substr($description, strlen($term), strlen($description)) . '...';
									} else {
										// Get surrounding 120 characters for a description
										if (!(($pos - 60) < 0)) {
											$description = substr($strippedContent, $pos - 60, 120);

											// Highlight the search term in the description
											$descPos = stripos($description, $term);

											$description = '...' . substr($description, 0, $descPos) . '<span class="search-term">' . substr($description, $descPos, strlen($term)) . '</span>' . substr($description, $descPos + strlen($term), strlen($description)) . '...';
										} else {
											$description = substr($strippedContent, 0, 120);

											// Highlight the search term in the description
											$descPos = stripos($description, $term);

											$description = substr($description, 0, $descPos) . '<span class="search-term">' . substr($description, $descPos, strlen($term)) . '</span>' . substr($description, $descPos + strlen($term), strlen($description)) . '...';
										}
									}
								} else {
									$description = substr($strippedContent, 0, 120);
								}

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
								<a href="<?php echo $post->getLink(); ?>/"><h2 class="search-result-title"><?php echo $post->getTitle(); ?></h2></a>
								<p><?php echo $description; ?></p>
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

						<?php

							}

							if ($displayResultsList) {
								echo '</section>';
							}
						?>
					</div>

					<!-- ========== BEGIN EVENTS SECTION =========== -->
					<h2 class="search-section-title">SHAID Events</h2>
					<div class="search-section-container">
					<?php
						$eventsQuery = "SELECT DISTINCT `id` from `events` WHERE (match(`title`) against(? IN BOOLEAN MODE) OR match(`content`) against(? IN BOOLEAN MODE) OR match(`image_caption`) against(? IN BOOLEAN MODE))";

						// Get some pages, iterate through them
						// Set up the pagination
						$displayResultsList = true; // Boolean to output articles-list
						try {
							$eventsPagination = new Pagination($db, $eventsQuery, array($term, $term, $term));
							$eventsPagination->totalRecords();
							$eventsPagination->setLimitPerPage(3);
							$currentPage = $eventsPagination->getPage();

							// Select the correct number of records from the DB
							if (isset($_GET['page'])) {
								$startFrom = ($_GET['page'] - 1) * 3;
							} else {
								$startFrom = 0;
							}

							// Get all events, order by descending date
							$eventsStmt = $db->prepare($eventsQuery . " ORDER BY `start_datetime` DESC LIMIT $startFrom, 3");
							$eventsStmt->execute([$term, $term, $term]);

							// If the list is empty, we have come to the end of the campaigns
							if (!$eventsStmt->rowCount()) {
								$displayResultsList = false;
								$type = 'events';
								require(SITE_ROOT . '/includes/blog_modules/search_no_more_results.php');
								$eventsStmt = array();
							}
						}
						catch (Exception $error) {
							$displayResultsList = false;
							require(SITE_ROOT . '/includes/blog_modules/search_no_results.php');
							$eventsStmt = array();
						}
						if ($displayResultsList) {
							echo '<section id="articles-list">';
						}
					?>
						<?php
							foreach ($eventsStmt as $row) {
								$event = new Event($db, $row['id']);

								// See if the search term appears in the description
								// This function will not return true, so we check to see it hasn't returned false
								$strippedContent = html_entity_decode(strip_tags($event->getContent()));
								if (stristr($event->getContent(), $term) != false) {
									$pos = stripos($strippedContent, $term);

									// Place <span class="search-term"></span> tags around the found search term so we can highlight it
									if ($pos == 0) {
										// Get surrounding 120 characters for a description
										$description = substr($strippedContent, 0, 120);

										// Highlight the search term in the description
										$descPos = stripos($description, $term);

										$description = '<span class="search-term">' . substr($description, 0, strlen($term)) . '</span>' . substr($description, strlen($term), strlen($description)) . '...';
									} else {
										// Get surrounding 120 characters for a description
										if (!(($pos - 60) < 0)) {
											$description = substr($strippedContent, $pos - 60, 120);

											// Highlight the search term in the description
											$descPos = stripos($description, $term);

											$description = '...' . substr($description, 0, $descPos) . '<span class="search-term">' . substr($description, $descPos, strlen($term)) . '</span>' . substr($description, $descPos + strlen($term), strlen($description)) . '...';
										} else {
											$description = substr($strippedContent, 0, 120);

											// Highlight the search term in the description
											$descPos = stripos($description, $term);

											$description = substr($description, 0, $descPos) . '<span class="search-term">' . substr($description, $descPos, strlen($term)) . '</span>' . substr($description, $descPos + strlen($term), strlen($description)) . '...';
										}
									}
								} else {
									$description = substr($strippedContent, 0, 120);
								}

								// Decide which image we will show (do this here so there is less inline PHP below)
								if ($event->getImagePath() == null) {
									$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/assets/img/placeholder/blog_image.jpg\');';
								} else {
									$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/' . htmlentities($event->getImagePath()) . '\');';
								}
						?>

						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="<?php echo $event->getLink(); ?>/" style="<?php echo $imageCSS; ?>"></a>
							<div class="articles-list-entry-info">
								<a href="<?php echo $event->getLink(); ?>/"><h2 class="search-result-title"><?php echo $event->getTitle(); ?></h2></a>
								<p><?php echo $description; ?></p>
								<div class="articles-list-entry-actions">
									<ul>
										<li>
											<span><i class="zmdi zmdi-calendar"></i> <time datetime="<?php echo $event->getStartDatetime(); ?>"><?php echo $event->getStartDatetime(); ?></time></span>
										</li>
									</ul>
								</div>
							</div>
						</div>

					<?php

						}

						if ($displayResultsList) {
							echo '</section>';
						}
					?>
					</div>

					<!-- ========== BEGIN CAMPAIGNS SECTION =========== -->
					<h2 class="search-section-title">SHAID Campaigns</h2>
					<div class="search-section-container">

					<?php
						$campaignsQuery = "SELECT DISTINCT `id` from `campaigns` WHERE (match(`title`) against(? IN BOOLEAN MODE) OR match(`content`) against(? IN BOOLEAN MODE) OR match(`image_caption`) against(? IN BOOLEAN MODE))";

						// Get some pages, iterate through them
						// Set up the pagination
						$displayResultsList = true; // Boolean to output articles-list
						try {
							$campaignsPagination = new Pagination($db, $campaignsQuery, array($term, $term, $term));
							$campaignsPagination->totalRecords();
							$campaignsPagination->setLimitPerPage(3);
							$currentPage = $campaignsPagination->getPage();

							// Select the correct number of records from the DB
							if (isset($_GET['page'])) {
								$startFrom = ($_GET['page'] - 1) * 3;
							} else {
								$startFrom = 0;
							}

							// Get all campaigns, order by descending date
							$campaignsStmt = $db->prepare($campaignsQuery . " ORDER BY `start_datetime` DESC LIMIT $startFrom, 3");
							$campaignsStmt->execute([$term, $term, $term]);

							// If the list is empty, we have come to the end of the campaigns
							if (!$campaignsStmt->rowCount()) {
								$displayResultsList = false;
								$type = 'campaigns';
								require(SITE_ROOT . '/includes/blog_modules/search_no_more_results.php');
								$campaignsStmt = array();
							}
						}
						catch (Exception $error) {
							$displayResultsList = false;
							require(SITE_ROOT . '/includes/blog_modules/search_no_results.php');
							$campaignsStmt = array();
						}

						if ($displayResultsList) {
							echo '<section id="articles-list">';
						}
					?>
						<?php
							foreach ($campaignsStmt as $row) {
								$campaign = new Campaign($db, $row['id']);

								// See if the search term appears in the description
								// This function will not return true, so we check to see it hasn't returned false
								$strippedContent = html_entity_decode(strip_tags($campaign->getContent()));
								if (stristr($campaign->getContent(), $term) != false) {
									$pos = stripos($strippedContent, $term);

									// Place <span class="search-term"></span> tags around the found search term so we can highlight it
									if ($pos == 0) {
										// Get surrounding 120 characters for a description
										$description = substr($strippedContent, 0, 120);

										// Highlight the search term in the description
										$descPos = stripos($description, $term);

										$description = '<span class="search-term">' . substr($description, 0, strlen($term)) . '</span>' . substr($description, strlen($term), strlen($description)) . '...';
									} else {
										// Get surrounding 120 characters for a description
										if (!(($pos - 60) < 0)) {
											$description = substr($strippedContent, $pos - 60, 120);

											// Highlight the search term in the description
											$descPos = stripos($description, $term);

											$description = '...' . substr($description, 0, $descPos) . '<span class="search-term">' . substr($description, $descPos, strlen($term)) . '</span>' . substr($description, $descPos + strlen($term), strlen($description)) . '...';
										} else {
											$description = substr($strippedContent, 0, 120);

											// Highlight the search term in the description
											$descPos = stripos($description, $term);

											$description = substr($description, 0, $descPos) . '<span class="search-term">' . substr($description, $descPos, strlen($term)) . '</span>' . substr($description, $descPos + strlen($term), strlen($description)) . '...';
										}
									}
								} else {
									$description = substr($strippedContent, 0, 120);
								}

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
								<a href="<?php echo $campaign->getLink(); ?>/"><h2 class="search-result-title"><?php echo $campaign->getTitle(); ?></h2></a>
								<p><?php echo $description; ?></p>
								<div class="articles-list-entry-actions">
									<ul>
										<li>
											<span><i class="zmdi zmdi-calendar"></i> <time datetime="<?php echo $campaign->getStartDatetime(); ?>"><?php echo $campaign->getStartDatetime(); ?></time></span>
										</li>
									</ul>
								</div>
							</div>
						</div>

					<?php

						}

						if ($displayResultsList) {
							echo '</section>';
						}
					?>
					</div>

					<!-- ========== BEGIN PAGINATION =========== -->
					<nav>
						<ul class="pagination">
							<?php
								// Choose the pagination object with the post pages. There's probablly a better way to do this but, eh, it works
								$totalPages = [$pagination->getTotalRecords(), $eventsPagination->getTotalRecords(), $campaignsPagination->getTotalRecords()];
								$paginations = [$pagination, $eventsPagination, $campaignsPagination];

								// The index gets the first max if there are multiple
								$i = array_keys($totalPages, max($totalPages))[0];

								echo $paginations[$i]->getFirstAndBackLinks() . $paginations[$i]->getBeforeLinks() . $paginations[$i]->getCurrentPageLinks() . $paginations[$i]->getAfterLinks() . $paginations[$i]->getNextAndLastLinks();
							?>
						</ul>
					</nav>
				</section>
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
