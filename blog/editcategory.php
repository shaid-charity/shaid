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
				// Get the category's details
				$category = new Category($db, $_GET['id']);

				if (isset($_GET['action']) && $_GET['action'] == 'update') {
					// Update the category
					$category->setName($_POST['title']);
				}
			} else if ($_GET['action'] == 'createNew') {
				// Create a new category
				$name = $_POST['title'];

				if ($_POST['saveType'] == "Create") {
					$category = new Category($db, null, $name);
				}
			}
		?>
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<?php
						// Check to see if the category has been updated
						if (isset($_GET['action']) && ($_GET['action'] == 'update' || $_GET['action'] == 'createNew' || $_GET['action'] == 'fromPreview' || $_GET['action'] == 'makeDraft')) {
							require_once(SITE_ROOT . '/includes/blog_modules/category_published_message.php');
						}
					?>
					<section class="page-path">
						<span><a href="./blog.php">Categories</a></span>
					</section>
					<div class="page-title">
						<h1>Edit Category</h1>
					</div>
					<section id="post-editor">
						<form id="postForm" action="editcategory.php?action=update&id=<?php echo $category->getID(); ?>" method="post" enctype="multipart/form-data">
							<div class="post-input">
								<label for="title" class="section-label">Title</label>
								<input type="text" name="title" id="post-title" value="<?php echo $category->getName(); ?>">
							</div>
					</section>
				</section>
				<aside id="sidebar">
					<section>
						<h1>Info</h1>
						<ul>
							<li>
								<span><strong>Status:</strong>
								Created
								</span>
							</li>
						</ul>
					</section>
					<section>
						<h1>Update</h1>
						<div class="sidebar-actions">
							<input type="submit" class="button-green" name="saveType" value="Update">
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
			<p>Do you really want to delete this category? This action cannot be undone.</p>
			<div class="modal-message-buttons">
				<button type="button" id="cancel-delete-post-button" class="button-dark">Cancel</button>
				<form action="newcategory.php" method="post">
					<button type="submit" id="delete-post-button" class="button-red" name="saveType" value="Delete">Delete</button>
					<input type="hidden" name="id" value="<?php echo $category->getID(); ?>">
				</form>
			</div>
		</div>
	</div>
	<?php
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>

<script src="/<?php echo INSTALLED_DIR; ?>/scripts/blogpost.js" type="text/javascript"></script>
</body>
</html>
