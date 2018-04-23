<?php
	define('PAGE_NAME', "editEvent");	

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
	<title>SHAID - Edit Event</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');
		
		if($user == null || !grantAccess($user->getRoleID(), PAGE_NAME)){
			die("You dont have permission to access this page");
		}
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
		<?php
			if (isset($_GET['id'])) {
				// Get the event's details
				$event = new Event($db, $_GET['id']);

				if (isset($_GET['action']) && $_GET['action'] == 'update') {
					// Update the event
					$event->setName($_POST['title']);
					$event->setStartDatetime($_POST['startDatetime']);
					$event->setEndDatetime($_POST['endDatetime']);
					$event->setClosingDatetime($_POST['closingDatetime']);
					$event->setCampaign($_POST['campaign']);
					$event->setCapacity($_POST['capacity']);
					$event->setTicketPrice($_POST['ticketPrice']);
					$event->setLocation($_POST['location']);
					$event->setContent($_POST['content']);
					$event->setImageCaption($_POST['featured-image-caption']);

					$file = $_FILES['featured-image'];

					// If a new main image was uploaded, change it
					if (file_exists($file['tmp_name'])) {
						$uploadManager = new UploadManager();
						$uploadManager->setFilename($file['name']);
						$imagePath = $uploadManager->getPath();

						$event->setImage($imagePath);
					}
				}
			} else if ($_GET['action'] == 'createNew') {
				// Create a new event
				$name = $_POST['title'];
				$startDatetime = $_POST['startDatetime'];
				$endDatetime = $_POST['endDatetime'];
				$closingDatetime = $_POST['closingDatetime'];
				$campaignID = $_POST['campaign'];
				$capacity = $_POST['capacity'];
				$ticketsAvailable = $capacity;
				$ticketPrice = $_POST['ticketPrice'];
				$location = $_POST['location'];
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
					$event = new Event($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, $imagePath, $userID, $startDatetime, $endDatetime, $closingDatetime, $campaignID, $capacity, $ticketsAvailable, $ticketPrice, $location, $imageCaption);

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

							require_once(SITE_ROOT . '/includes/blog_modules/post_published_message.php');
						}
					?>
					<section class="page-path">
						<span><a href="./events.php">Events</a></span>
					</section>
					<div class="page-title">
						<h1>New Event</h1>
					</div>
					<section id="post-editor">
						<form id="postForm" action="editpost.php?action=update&id=<?php echo $event->getID(); ?>" method="post" enctype="multipart/form-data">
							<div class="post-input">
								<label for="title" class="section-label">Title</label>
								<input type="text" name="title" id="post-title" value="<?php echo $event->getTitle(); ?>">
							</div>
							<div class="post-input">
								<span class="section-label">Start and end dates</span>
								<div class="post-input-row">
									<div class="post-input post-input-grow post-input-padding-right">
										<label for="startDatetime">Start date and time</label>
										<input type="text" class="datetimepicker" name="startDatetimeInput" id="post-startDatetime" value="<?php echo $event->getStartDatetime(); ?>">
									</div>
									<div class="post-input post-input-grow post-input-padding-left">
										<label for="endDatetime">End date and time</label>
										<input type="text" class="datetimepicker" name="endDatetime" id="post-endDatetime" value="<?php echo $event->getEndDatetime(); ?>">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="closingDatetime" class="section-label">Closing date and time</label>
								<input type="text" class="datetimepicker" name="closingDatetime" id="post-closingDatetime" value="<?php echo $event->getClosingDatetime(); ?>">
							</div>
							<div class="post-input">
								<label for="location" class="section-label">Location</label>
								<input type="text" name="location" id="post-location" value="<?php echo $event->getLocation(); ?>">
							</div>
							<div class="post-input">
								<span class="section-label">Ticket Information</span>
								<div class="post-input-row">
									<div class="post-input post-input-grow post-input-padding-right">
										<label for="capacity">Capacity</label>
										<input type="number" name="capacity" id="post-capacity" value="<?php echo $event->getCapacity(); ?>">
									</div>
									<div class="post-input post-input-grow post-input-padding-left">
										<label for="ticketPrice">Ticket Price</label>
										<input type="number" step="0.01" name="ticketPrice" id="post-ticketPrice" value="<?php echo $event->getTicketPrice(); ?>">
									</div>
								</div>
							</div>
							<div class="post-input">
								<span class="section-label">Featured image</span>
								<div class="post-input-row">
									<div class="post-input post-input-padding-right">
										<label for="post-featured-image">Image file</label>
										<input type="file" name="featured-image" id="post-featured-image">
									</div>
									<div class="post-input post-input-grow post-input-padding-left">
										<label for="post-featured-image-caption">Featured image caption</label>
										<input type="text" name="featured-image-caption" id="post-featured-image-caption" value="<?php echo $event->getImageCaption(); ?>">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="post-content" class="section-label">Event description</label>
								<textarea name="content" id="post-content"><?php echo $event->getContent(); ?></textarea>
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
								Published
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
										if ($event->getCampaign() !== null && $event->getCampaign() != 0 && $c->getID() == $event->getCampaign()->getID()) {
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
			<p>Do you really want to delete this event? This action cannot be undone.</p>
			<div class="modal-message-buttons">
				<button type="button" id="cancel-delete-post-button" class="button-dark">Cancel</button>
				<form action="newevent.php" method="post">
					<button type="submit" id="delete-post-button" class="button-red" name="saveType" value="Delete">Delete</button>
					<input type="hidden" name="id" value="<?php echo $event->getID(); ?>">
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

<!-- Include the jQuery Datetime picker sript -->
<script src="scripts/jquery.datetimepicker.full.min.js"></script>
<script>
// Load the TinyMCE editor to the appropriate text area
tinymce.init({
    selector: 'textarea',
    plugins: "image link autolink lists preview",
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
<script src="/<?php echo INSTALLED_DIR; ?>/scripts/blogpost.js" type="text/javascript"></script>
</body>
</html>
