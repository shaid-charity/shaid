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
		<?php
			if (isset($_GET['id'])) {
			// Get the post's details
			$post = new Post($db, $_GET['id']);

			if (isset($_GET['action']) && $_GET['action'] == 'update') {
				// Update the post
				$post->setName($_POST['title']);
				$post->setCategory($_POST['category']);
				$post->setContent($_POST['content']);
				$file = $_FILES['image'];

				// If a new main image was uploaded, change it
				if (file_exists($file['tmp_name'])) {
					$uploadManager = new UploadManager();
					$uploadManager->setFilename($file['name']);
					$imagePath = $uploadManager->getPath();
					$uploadManager->upload($file);

					$post->setImage($imagePath);
				}

				if ($_POST['saveType'] == 'Update') {
					$post->setPublished(1);
				} else if ($_POST['saveType'] == 'Save Draft') {
					$post->setPublished(0);
				}
			}
		?>
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<?php
						// Check to see if the post has been updated
						if (isset($_GET['action']) && $_GET['action'] == 'update') {
							if ($post->isPublished()) {
								require_once(SITE_ROOT . '/includes/blog_modules/post_published_message.php');
							} else {
								require_once(SITE_ROOT . '/includes/blog_modules/post_draft_message.php');
							}
						}
					?>
					<section class="page-path">
						<span><a href="./blog.php">Blog</a></span>
					</section>
					<div class="page-title">
						<h1>Edit Post</h1>
					</div>
					<section id="post-editor">
						<form action="editpost.php?action=update&id=<?php echo $post->getID(); ?>" method="post"  enctype="multipart/form-data">
							<div class="post-input">
								<label for="post-title" class="section-label">Title</label>
								<input type="text" name="title" id="post-title" value="<?php echo $post->getTitle(); ?>">
							</div>
							<div class="post-input">
								<label for="post-category" class="section-label">Category</label>
								<select name="category" id="post-category">
									<?php
										$stmt = $db->query("SELECT `id` FROM `categories`");
										
										foreach ($stmt as $row) {
											$cat = new Category($db, $row['id']);

											if ($cat->getID() == $post->getCategoryID()) {
												echo '<option value="' . $cat->getID() . '" selected>' . $cat->getName() . '</option>';
											} else {
												echo '<option value="' . $cat->getID() . '">' . $cat->getName() . '</option>';
											}
										}
									?>
								</select>
							</div>
							<div class="post-input">
								<span class="section-label">Featured image</span>
								<div class="post-input-row">
									<div class="post-input">
										<label for="post-featured-image">Image file</label>
										<input type="file" name="featured-image" id="post-featured-image">
									</div>
									<div class="post-input">
										<label for="post-featured-image-caption">Featured image caption</label>
										<input type="text" name="featured-image-caption" id="post-featured-image-caption">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="post-content" class="section-label">Post content</label>
								<textarea name="content" id="post-content"><?php echo $post->getContent(); ?></textarea>
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
								<?php
									if ($post->isPublished()) {
										echo '<em>Published</em>';
									} else {
										echo '<em>Draft</em>';
									}
								?>
								</span>
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
						<h1>Update</h1>
						<div class="sidebar-actions">
							<input type="submit" class="button-dark" name="saveType" value="Save Draft">
							<input type="submit" class="button-green" name="saveType" value="Update">
							<input type="submit" class="button-dark" name="saveType" value="Preview">
						</div>
					</section>
					<section>
						<h1>Delete</h1>
						<div class="sidebar-actions">
							<button type="button" class="button-red">Delete</button>
						</div>
					</section>
				</aside>
			</form>
			</div>
		</div>
	</main>
	<?php
		}
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
