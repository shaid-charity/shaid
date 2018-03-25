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
							<a class="articles-list-entry-thumb" href="blogpost.php"></a>
							<div class="articles-list-entry-info">
								<a href="blogpost.php"><h2>A Most Recent Blog Post About Homelessness</h2></a>
								<p>A description of the most recent blog post.</p>
							</div>
						</div>
						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="blogpost.php"></a>
							<div class="articles-list-entry-info">
								<a href="blogpost.php"><h2>Another Blog Post About Homelessness</h2></a>
								<p>A shorter description about this post.</p>
							</div>
						</div>
						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="blogpost.php"></a>
							<div class="articles-list-entry-info">
								<a href="blogpost.php"><h2>Rough Sleeping Up UK-Wide</h2></a>
								<p>What does this tell us about the UK's welfare system?</p>
							</div>
						</div>
						<div class="articles-list-entry">
							<a class="articles-list-entry-thumb" href="blogpost.php"></a>
							<div class="articles-list-entry-info">
								<a href="blogpost.php"><h2>Official Homelessness Statistics Released</h2></a>
								<p>Big news today as the official figures for homelessness have been released&mdash;see our analysis in this in-depth blog post.</p>
							</div>
						</div>
					</section>
				</section>
				<aside id="sidebar">
					<section id="categories-list">
						<h1>Categories</h1>
						<ul>
							<li><a href="#">Category 1</a></li>
							<li><a href="#">Category 2</a></li>
							<li><a href="#">Category 3</a></li>
							<li><a href="#">Category 4</a></li>
							<li><a href="#">Category 5</a></li>
							<li><a href="#">Category 6</a></li>
						</ul>
					</section>
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
