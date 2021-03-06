<?php
	define('PAGE_NAME', "newPost");

    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));

    require_once 'includes/settings.php';
	require_once 'includes/config.php';
	require_once 'includes/permissionCheck.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID - New Post</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');

		if($user == null || !grantAccess($user->getRoleID(), PAGE_NAME)){
			header('Location: permissionserror.php');
		}

		if (isset($_POST['fromPreview'])) {
			$title = $_POST['title'];
			$category = $_POST['category'];
			$campaign = $_POST['campaign'];
			$content = $_POST['content'];
			$file = $_FILES['featured-image'];
			$imageCaption = $_POST['featured-image-caption'];
		} else {
			$title = '';
			$category = '';
			$campaign = '';
			$content = '';
			$file = '';
			$imageCaption = '';
		}
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
					<?php
						// Check to see if the post has been deleted
						if ($_POST['saveType'] == 'Delete') {
							// Delete the post in question
							$stmt = $db->prepare("DELETE FROM `posts` WHERE `id` = ?");
							$stmt->execute([$_POST['id']]);

							require_once(SITE_ROOT . '/includes/blog_modules/post_deleted_message.php');
						}
					?>
					<section class="page-path">
						<span><a href="./index.php">Blog</a></span>
					</section>
					<div class="page-title">
						<h1>New Post</h1>
					</div>
					<section id="post-editor">
						<form id="postForm" action="editpost.php?action=createNew" method="post"  enctype="multipart/form-data">
							<input type="hidden" name="id" value="0">
							<div class="post-input">
								<label for="post-title" class="section-label">Title</label>
								<input type="text" name="title" id="post-title" value="<?php echo $title; ?>">
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
											if ($category == $cat->getID()) {
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
									<div class="post-input-grow">
										<label for="post-featured-image-caption">Featured image caption</label>
										<input type="text" name="featured-image-caption" id="post-featured-image-caption" value="<?php echo $imageCaption; ?>">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="post-content" class="section-label">Post content</label>
								<textarea name="content" id="post-content"><?php echo $content; ?></textarea>
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
								<option value="0">None</option>
								<?php
									// Get all campaigns
									$stmt = $db->query("SELECT `id` FROM `campaigns`");
										
									foreach ($stmt as $row) {
										$c = new Campaign($db, $row['id']);
										if ($campaign == $c->getID()) {
											echo "<option value='" . $c->getID() . "' selected>" . $c->getTitle() . "</option>";
										} else {
											echo "<option value='" . $c->getID() . "'>" . $c->getTitle() . "</option>";
										}
									}
								?>
							</select>
						</div>
					</section>
					<section>
						<h1>Publish</h1>
						<div class="sidebar-actions">
							<input type="submit" class="button-dark" name="saveType" value="Save Draft">
							<input type="submit" class="button-green" name="saveType" value="Publish">
							<input type="submit" data-url="previewpost.php" id="previewButton" class="button-dark" name="saveType" value="Preview">
						</div>
					</section>
				</aside>
			</form>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>

<!-- Include the TinyMCE WYSIWYG editor -->
<script src="vendor/tinymce/tinymce/tinymce.min.js"></script>
<script>
// Load the TinyMCE editor to the appropriate text area
tinymce.init({
    selector: 'textarea',
    plugins: "image link autolink lists",
    menubar: "file edit format insert view",
    toolbar: "undo redo cut copy paste bold italic underline strikethrough subscript superscript removeformat formats image blockquote link numlist bullist"
});

// Change the URL of the form if the Preview button was selected
$("#previewButton").click(function(e) {
    e.preventDefault();

    var form = $("#postForm");

    form.prop("action", $(this).data("url"));
    form.submit();
});
</script>
</body>
</html>
