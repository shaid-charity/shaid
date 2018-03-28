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
					<div class="content-grid-title">
						<h1>SHAID Blog</h1>
					</div>
					<section id="articles-list">
						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="viewpost.php"></a>
							<div class="articles-list-entry-info">
								<a href="viewpost.php"><h2>A Most Recent Blog Post About Homelessness</h2></a>
								<p>A description of the most recent blog post.</p>
								<div class="articles-list-entry-actions">
									<ul>
										<li>
											<span><i class="zmdi zmdi-calendar"></i> <time datetime="2018-03-23T19:00">23/03/2018</time></span>
										</li>
										<li>
											<a href="category.php">Category Name</a>
										</li>
									</ul>
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
						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="viewpost.php"></a>
							<div class="articles-list-entry-info">
								<a href="viewpost.php"><h2>Rough Sleeping Up UK-Wide</h2></a>
								<p>What does this tell us about the UK's welfare system?</p>
								<div class="articles-list-entry-actions">
									<a href="category.php">Category Name</a>
								</div>
							</div>
						</div>
						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="viewpost.php"></a>
							<div class="articles-list-entry-info">
								<a href="viewpost.php"><h2>Official Homelessness Statistics Released</h2></a>
								<p>Big news today as the official figures for homelessness have been released&mdash;see our analysis in this in-depth blog post.</p>
								<div class="articles-list-entry-actions">
									<a href="category.php">Category Name</a>
								</div>
							</div>
						</div>
					</section>
					<nav>
						<ul class="pagination">
							<li><a href="#" class="button-dark button-smaller"><!--Previous-->&laquo;</a></li>
							<li><a href="#" class="button-dark-filled button-smaller">1</a></li>
							<li><a href="#" class="button-dark button-smaller">2</a></li>
							<li><a href="#" class="button-dark button-smaller">3</a></li>
							<li><a href="#" class="button-dark button-smaller"><!--Next-->&raquo;</a></li>
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
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
