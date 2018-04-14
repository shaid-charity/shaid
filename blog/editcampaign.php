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
		<?php
			if (isset($_GET['id'])) {
				// Get the event's details
				$campaign = new Campaign($db, $_GET['id']);

				if (isset($_GET['action']) && $_GET['action'] == 'update') {
					// Update the campaign
					$campaign->setName($_POST['title']);
					$campaign->setStartDatetime($_POST['startDatetime']);
					$campaign->setEndDatetime($_POST['endDatetime']);
					$campaign->setGoalAmount($_POST['goalAmount']);
					$campaign->setImageCaption($_POST['featured-image-caption']);
					$campaign->setContent($_POST['content']);

					$file = $_FILES['featured-image'];

					// If a new main image was uploaded, change it
					if (file_exists($file['tmp_name'])) {
						$uploadManager = new UploadManager();
						$uploadManager->setFilename($file['name']);
						$imagePath = $uploadManager->getPath();

						$campaign->setImage($imagePath);
					}
				}
			} else if ($_GET['action'] == 'createNew') {
				// Create a new campaign
				$name = $_POST['title'];
				$startDatetime = $_POST['startDatetime'];
				$endDatetime = $_POST['endDatetime'];
				$goalAmount = $_POST['goalAmount'];
				$content = $_POST['content'];
				$imageCaption = $_POST['featured-image-caption'];
				$file = $_FILES['featured-image'];

				if (file_exists($file['tmp_name'])) {
					$uploadManager = new UploadManager();
					$uploadManager->setFilename($file['name']);
					$imagePath = $uploadManager->getPath();
				} else {
					$imagePath = '';
				}

				$userID = $user->getID();

				if ($_POST['saveType'] == "Publish") {
					// New campaign, so assume nothing has been raised yet
					// Maybe change this - will already-running campaigns ever need to be added?
					$campaign = new Campaign($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, $imagePath, $userID, $startDatetime, $endDatetime, $goalAmount, 0, $imageCaption);

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
						// Check to see if the campaign has been updated
						if (isset($_GET['action']) && ($_GET['action'] == 'update' || $_GET['action'] == 'createNew' || $_GET['action'] == 'fromPreview' || $_GET['action'] == 'makeDraft')) {

							require_once(SITE_ROOT . '/includes/blog_modules/post_published_message.php');
						}
					?>
					<section class="page-path">
						<span><a href="./campaigns.php">Campaigns</a></span>
					</section>
					<div class="page-title">
						<h1>Edit Campaign</h1>
					</div>
					<section id="post-editor">
						<form id="postForm" action="editcampaign.php?action=update&id=<?php echo $campaign->getID(); ?>" method="post" enctype="multipart/form-data">
							<div class="post-input">
								<label for="title" class="section-label">Title</label>
								<input type="text" name="title" id="post-title" value="<?php echo $campaign->getTitle(); ?>">
							</div>
							<div class="post-input">
								<span class="section-label">Start and end dates</span>
								<div class="post-input-row">
									<div class="post-input post-input-grow post-input-padding-right">
										<label for="startDatetime">Start date and time</label>
										<input type="datetime-local" name="startDatetime" id="post-startDatetime" value="<?php echo $campaign->getStartDatetime(); ?>">
									</div>
									<div class="post-input post-input-grow post-input-padding-lef">
										<label for="endDatetime">End date and time</label>
										<input type="datetime-local" name="endDatetime" id="post-endDatetime" value="<?php echo $campaign->getEndDatetime(); ?>">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="goalAmount" class="section-label">Goal Amount</label>
								<input type="number" step="0.01" name="goalAmount" id="post-goalAmount" value="<?php echo $campaign->getGoalAmount(); ?>">
							</div>
							<div class="post-input">
								<span class="section-label">Featured image</span>
								<div class="post-input-row">
									<div class="post-input">
										<label for="post-featured-image">Image file</label>
										<input type="file" name="featured-image" id="post-featured-image">
									</div>
									<div class="post-input post-input-grow">
										<label for="post-featured-image-caption">Featured image caption</label>
										<input type="text" name="featured-image-caption" id="post-featured-image-caption" value="<?php echo $campaign->getImageCaption(); ?>">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="post-content" class="section-label">Campaign description</label>
								<textarea name="content" id="post-content"><?php echo $campaign->getContent(); ?></textarea>
							</div>
					</section>
				</section>
				<aside id="sidebar">
					<section>
						<h1>Info</h1>
						<ul>
							<li>
								<span><strong>Status:</strong>
								Published
								</span>
							</li>
						</ul>
					</section>
					<section>
						<h1>Update</h1>
						<div class="sidebar-actions">
							<input type="submit" class="button-green" name="saveType" value="Update">
							<input id="previewButton" data-url="previewcampaign.php" type="submit" class="button-dark" name="saveType" value="Preview">
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
			<p>Do you really want to delete this campaign? This action cannot be undone.</p>
			<div class="modal-message-buttons">
				<button type="button" id="cancel-delete-post-button" class="button-dark">Cancel</button>
				<form action="newcampaign.php" method="post">
					<button type="submit" id="delete-post-button" class="button-red" name="saveType" value="Delete">Delete</button>
					<input type="hidden" name="id" value="<?php echo $campaign->getID(); ?>">
				</form>
			</div>
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
    plugins: "image link autolink lists preview",
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
