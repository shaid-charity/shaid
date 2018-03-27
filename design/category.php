<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));
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
					<section id="articles-list">
						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="viewpost.php"></a>
							<div class="articles-list-entry-info">
								<a href="viewpost.php"><h2>A Most Recent Blog Post About Homelessness</h2></a>
								<p>A description of the most recent blog post.</p>
								<div class="articles-list-entry-actions">
									<a href="category.php">Category Name</a>
								</div>
							</div>
						</div>
						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="viewpost.php"></a>
							<div class="articles-list-entry-info">
								<a href="viewpost.php"><h2>Another Blog Post About Homelessness</h2></a>
								<p>A shorter description about this post.</p>
								<div class="articles-list-entry-actions">
									<a href="category.php">Category Name</a>
								</div>
							</div>
						</div>
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
