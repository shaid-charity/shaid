<?php
	define('PAGE_NAME', "editPost");	

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
	<title>SHAID - Edit Post</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');

		if($user == null || !grantAccess($user->getRoleID(), PAGE_NAME)){
			echo "<script>alert('".grantAccess($user->getRoleID(), PAGE_NAME)."');</script>";
			die("You dont have permission to access this page");
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
		<?php
			if (isset($_GET['id'])) {
				// Get the post's details
				$post = new Post($db, $_GET['id']);

				// Make the post a draft if need be
				if (isset($_GET['action']) && $_GET['action'] == 'makeDraft') {
					$post->setPublished(0);
				} else if(isset($_GET['action']) && $_GET['action'] == 'approve'){
					$post->approve();
					//there must be a better way than this
					echo "<script>window.location.replace('viewpost.php?id=".$_GET['id']."')</script>";
					die();
				} else if (isset($_GET['action']) && $_GET['action'] == 'update') {
					// Update the post
					$post->setName($_POST['title']);
					$post->setCategory($_POST['category']);
					$post->setContent($_POST['content']);
					$post->setCampaign($_POST['campaign']);
					$post->setImageCaption($_POST['featured-image-caption']);
					$file = $_FILES['featured-image'];

					// If a new main image was uploaded, change it
					if (file_exists($file['tmp_name'])) {
						$uploadManager = new UploadManager();
						$uploadManager->setFilename($file['name']);
						$imagePath = $uploadManager->getPath();

						$post->setImage($imagePath);
					}

					if ($_POST['saveType'] == 'Update') {
						$post->setPublished(1);
					} else if ($_POST['saveType'] == 'Save Draft') {
						$post->setPublished(0);
					}
				} else if (isset($_GET['action']) && $_GET['action'] == 'fromPreview') {
					if ($_POST['saveType'] == 'Save Draft') {
						$post->setPublished(0);

						if (file_exists($file['tmp_name'])) {
						$uploadManager->upload($file);
					}
					} else if ($_POST['saveType'] == 'Publish') {
						$post->setPublished(1);

						if (file_exists($file['tmp_name'])) {
						$uploadManager->upload($file);
					}
					}

					// If the Edit button was selected, do nothing
				}
			} else if ($_GET['action'] == 'createNew') {
				// Create a new post
				// Create the blog post
				$name = $_POST['title'];
				$categoryID = $_POST['category'];
				$content = $_POST['content'];
				$campaign = $_POST['campaign'];
				$file = $_FILES['featured-image'];
				$imageCaption = $_POST['featured-image-caption'];

				if (file_exists($file['tmp_name'])) {
					$uploadManager = new UploadManager();
					$uploadManager->setFilename($file['name']);
					$imagePath = $uploadManager->getPath();
				} else {
					$imagePath = '';
				}

				$userID = $user->getID();

				if ($_POST['saveType'] == "Publish") {
					$post = new Post($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, $imagePath, $userID, '', $categoryID);

					$post->setImageCaption($imageCaption);
					$post->setPublished(1);

					if (file_exists($file['tmp_name'])) {
						$uploadManager->upload($file);
					}
				} else if ($_POST['saveType'] == "Save Draft") {
					$post = new Post($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, $imagePath, $userID, '', $categoryID);

					$post->setImageCaption($imageCaption);
					$post->setPublished(0);

					if (file_exists($file['tmp_name'])) {
						$uploadManager->upload($file);
					}
				}
			}
		?>
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<?php
						// Check to see if the post has been updated
						if (isset($_GET['action']) && ($_GET['action'] == 'update' || $_GET['action'] == 'createNew' || $_GET['action'] == 'fromPreview' || $_GET['action'] == 'makeDraft')) {

							if ($post->isPublished() && $_POST['saveType'] != "Edit") {
								require_once(SITE_ROOT . '/includes/blog_modules/post_published_message.php');
							} else if ($_POST['saveType'] != "Edit" || $_GET['action'] == 'makeDraft') {
								require_once(SITE_ROOT . '/includes/blog_modules/post_draft_message.php');
							}
						}
					?>
					<section class="page-path">
						<span><a href="./index.php">Blog</a></span>
					</section>
					<div class="page-title">
						<h1>Edit Post</h1>
					</div>
					<section id="post-editor">
						<form id="postForm" action="editpost.php?action=update&id=<?php echo $post->getID(); ?>" method="post"  enctype="multipart/form-data">
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

											if ($cat->getID() == $post->getCategory()->getID()) {
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
										<input type="text" name="featured-image-caption" id="post-featured-image-caption" value="<?php echo $post->getImageCaption(); ?>">
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
							<select name="campaign">
								<option value="0">None</option>
								<?php
									// Get all campaigns
									$stmt = $db->query("SELECT `id` FROM `campaigns`");
										
									foreach ($stmt as $row) {
										$c = new Campaign($db, $row['id']);
										if ($post->getCampaign() !== null && $c->getID() == $post->getCampaign()->getID()) {
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
						<h1>Update</h1>
						<div class="sidebar-actions">
							<input type="submit" class="button-dark" name="saveType" value="Save Draft">
							<input type="submit" class="button-green" name="saveType" value="Update">
							<input id="previewButton" data-url="previewpost.php" type="submit" class="button-dark" name="saveType" value="Preview">
						</div>
					</section>
					<section>
						<h1>Delete</h1>
						<div class="sidebar-actions">
							<button type="button" id="delete-post-button" class="button-red">Delete</button>
						</div>
					</section>
				</aside>
			</form>
			</div>
		</div>
	</main>
	<div id="delete-post-modal" class="modal-container">
		<div id="delete-post-message" class="modal-message">
			<h1>Are you sure?</h1>
			<p>Do you really want to delete this post? This action cannot be undone.</p>
			<form action="newpost.php" method="post" class="modal-message-button-container">
				<button type="button" id="cancel-delete-post-button" class="button-dark modal-message-button">Cancel</button>
				<button type="submit" id="delete-post-button" class="button-red modal-message-button" name="saveType" value="Delete">Delete</button>
				<input type="hidden" name="id" value="<?php echo $post->getID(); ?>">
			</form>
		</div>
	</div>
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
    toolbar: "undo redo cut copy paste bold italic underline strikethrough subscript superscript removeformat formats image link numlist bullist preview"
});

// Change the URL of the form if the Preview button was selected
$("#previewButton").click(function(e) {
    e.preventDefault();

    var form = $("#postForm");

    form.prop("action", $(this).data("url"));
    form.submit();
});
</script>
<script src="/<?php echo INSTALLED_DIR; ?>/scripts/blogpost.js" type="text/javascript"></script>
</body>
</html>
