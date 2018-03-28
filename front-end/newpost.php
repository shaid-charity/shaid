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
						<h1>New Post</h1>
					</div>
					<section id="post-editor">
						<form action="">
							<div class="post-input">
								<label for="post-title" class="section-label">Title</label>
								<input type="text" name="title" id="post-title">
							</div>
							<div class="post-input">
								<label for="post-category" class="section-label">Category</label>
								<select name="category" id="post-category">
									<?php
										// Get all categories
										$stmt = $db->query("SELECT `id` FROM `categories`");
										
										$categories = Array();
										foreach ($stmt as $row) {
											$cat = new Category($db, $row['id']);
											echo '<option value="' . $cat->getID() . '">' . $cat->getName() . '</option>';
										}
									?>
								</select>
							</div>
							<div class="post-input">
								<span class="section-label">Featured image</span>
								<div class="post-input-row">
									<div class="post-input">
										<label for="post-featured-image">Image file</label>
										<input type="file" name="image" id="post-featured-image">
									</div>
									<div class="post-input">
										<label for="post-featured-image-caption">Featured image caption</label>
										<input type="text" name="featured-image-caption" id="post-featured-image-caption">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="post-content" class="section-label">Post content</label>
								<textarea name="content" id="post-content"></textarea>
							</div>
						</button>
					</section>
				</section>
				<aside id="sidebar">
					<section>
						<h1>Info</h1>
						<ul>
							<li>
								<span><strong>Status:</strong>
								<em>New</em></span>
							</li>
						</ul>
					</section>
					<section>
						<h1>Campaign</h1>
						<div class="sidebar-input">
							<select>
								<option value="">None</option>
								<option value="id1">Campaign 1</option>
							</select>
						</div>
					</section>
					<section>
						<h1>Publish</h1>
						<div class="sidebar-actions">
							<button type="button" class="button-dark">Save Draft</button>
							<button type="button" class="button-green">Publish</button>
							<button type="submit" class="button-dark">Preview</button>
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

<!-- Include the TinyMCE WYSIWYG editor -->
<script src="../back-end/vendor/tinymce/tinymce/tinymce.min.js"></script>
<script>
// Load the TinyMCE editor to the appropriate text area
tinymce.init({
    selector: 'textarea',
    plugins: "image link autolink lists preview",
    menubar: "file edit format insert view",
    toolbar: "undo redo cut copy paste bold italic underline strikethrough subscript superscript removeformat formats image link numlist bullist preview"
});
</script>
</body>
</html>
