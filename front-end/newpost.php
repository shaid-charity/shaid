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
						<h1>New Post</h1>
					</div>
					<section id="post-editor">
						<form action="">
							<div class="post-input">
								<label for="post-title">Title</label>
								<input type="text" name="title" id="post-title">
							</div>
							<div class="post-input">
								<label for="post-category">Category</label>
								<select name="category" id="post-category">
									<option value=""></option>
									<option value="id1">Category 1</option>
									<option value="id2">Category 2</option>
									<option value="id3">Category 3</option>
								</select>
							</div>
							<div class="post-input">
								<label for="post-featured-image">Featured image</label>
								<input type="file" name="featured-image" id="post-featured-image">
							</div>
							<div class="post-input">
								<label for="post-featured-image-caption">Featured image caption</label>
								<input type="text" name="featured-image-caption" id="post-featured-image-caption">
							</div>
							<div class="post-input">
								<label for="post-content">Post content</label>
								<textarea name="content" id="post-content"></textarea>
							</div>
						</button>
					</section>
				</section>
				<aside id="sidebar">
					<section id="admin-sidebar-actions">
						<h1>Options</h1>
						<ul>
							<li><a href="#">Option 1</a></li>
							<li><a href="#">Option 2</a></li>
							<li><a href="#">Option 3</a></li>
							<li><a href="#">Option 4</a></li>
						</ul>
					</section>
					<section id="post-actions">
						<h1>Actions</h1>
						<div class="post-controls">
							<button type="button" class="button-dark button-smaller">Save as Draft</button>
							<button type="button" class="button-dark button-smaller">Preview</button>
						</div>
						<div class="post-controls">
							<button type="submit" class="button-green button-smaller">Publish</button>
						</div>
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
