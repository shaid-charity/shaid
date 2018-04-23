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
	<title>SHAID - New Campaign</title>
	<?php
		define('PAGE_NAME', "newCampaign");
		
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');
	?>
	<link href="style/blog.css" rel="stylesheet">

	<!-- jQuery Datetime picker CSS -->
	<link rel="stylesheet" type="text/css" href="style/jquery.datetimepicker.css" />
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
							$stmt = $db->prepare("DELETE FROM `campaigns` WHERE `id` = ?");
							$stmt->execute([$_POST['id']]);

							require_once(SITE_ROOT . '/includes/blog_modules/post_deleted_message.php');
						}
					?>
					<section class="page-path">
						<span><a href="./campaigns.php">Campaigns</a></span>
					</section>
					<div class="page-title">
						<h1>New Campaign</h1>
					</div>
					<section id="post-editor">
						<form id="postForm" action="editcampaign.php?action=createNew" method="post" enctype="multipart/form-data">
							<div class="post-input">
								<label for="title" class="section-label">Title</label>
								<input type="text" name="title" id="post-title">
							</div>
							<div class="post-input">
								<span class="section-label">Start and end dates</span>
								<div class="post-input-row">
									<div class="post-input post-input-grow post-input-padding-right">
										<label for="startDatetime">Start date and time</label>
										<input type="text" class="datetimepicker" name="startDatetime" id="post-startDatetime">
									</div>
									<div class="post-input post-input-grow post-input-padding-left">
										<label for="endDatetime">End date and time</label>
										<input type="text" class="datetimepicker" name="endDatetime" id="post-endDatetime">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="goalAmount" class="section-label">Goal Amount</label>
								<input type="number" step="0.01" name="goalAmount" id="post-goalAmount">
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
										<input type="text" name="featured-image-caption" id="post-featured-image-caption">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="post-content" class="section-label">Campaign description</label>
								<textarea name="content" id="post-content"></textarea>
							</div>
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
						<h1>Publish</h1>
						<div class="sidebar-actions">
							<input type="submit" class="button-green" name="saveType" value="Publish">
							<input type="submit" data-url="previewcampaign.php" id="previewButton" class="button-dark" name="saveType" value="Preview">
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

<!-- Include the jQuery Datetime picker sript -->
<script src="scripts/jquery.datetimepicker.full.min.js"></script>
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

// Set the datetime picker fields up
$('.datetimepicker').datetimepicker();
</script>
</body>
</html>
