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
	<title>SHAID - New Category</title>
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
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<?php
						// Check to see if the post has been deleted
						if ($_POST['saveType'] == 'Delete') {
							// Delete the post in question
							$stmt = $db->prepare("DELETE FROM `categories` WHERE `id` = ?");
							$stmt->execute([$_POST['id']]);

							require_once(SITE_ROOT . '/includes/blog_modules/category_deleted_message.php');
						}
					?>
					<section class="page-path">
						<span><a href="./blog.php">Categories</a></span>
					</section>
					<div class="page-title">
						<h1>New Category</h1>
					</div>
					<section id="post-editor">
						<form id="postForm" action="editcategory.php?action=createNew" method="post" enctype="multipart/form-data">
							<div class="post-input">
								<label for="title" class="section-label">Name</label>
								<input type="text" name="title" id="post-title">
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
						<h1>Create</h1>
						<div class="sidebar-actions">
							<input type="submit" class="button-green" name="saveType" value="Create">
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
</body>
</html>
