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
	<title>SHAID - New Friend of SHAID</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');
	?>
	<link href="style/blog.css" rel="stylesheet">

	<style>
		#friend-forename {
			margin-right: 1rem;
		}
	</style>
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
						// Check to see if a user has been added
						// If the user is not logged in, show an error message
						if ($user == null) {
							require_once(SITE_ROOT . '/includes/admin/admin_not_logged_in_notice.php');
						} else {
							if ($_GET['action'] == 'submit') {
								// Create a new instantce of the Friend class, adding it to the DB in the process
								$email = $_POST['email'];
								$fname = $_POST['forename'];
								$sname = $_POST['surname'];
								$type = $_POST['type'];

								$friend = new Friend($db, null, $email, $fname, $sname, $type);

								require_once(SITE_ROOT . '/includes/blog_modules/friend_created_message.php');
							}
					?>
					<section class="page-path">
						<span><a href="./index.php">Home</a></span>
					</section>
					<div class="page-title">
						<h1>New Friend of SHAID</h1>
					</div>
					<section id="post-editor">
						<form id="postForm" action="newfriend.php?action=submit" method="post"  enctype="multipart/form-data">
							<div class="post-input">
								<label for="email" class="section-label">Email</label>
								<input type="email" name="email" id="friend-email">
							</div>
							<div class="post-input">
								<div class="post-input-row">
									<div class="post-input">
										<label for="forename">Forename</label>
										<input type="text" name="forename" id="friend-forename">
									</div>
									<div class="post-input">
										<label for="surname">Surname</label>
										<input type="text" name="surname" id="friend-surname">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="type" class="section-label">Type of Friend</label> <!-- Need a better heading for this -->
								<select name="type" id="friend-type">
									<option value="Newsletter" default>Newsletter Only</option>
									<option value="Donor">Donor</option>
								</select>
							</div>
					</section>
				</section>
				<?php
					}
				?>
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
							<input type="submit" class="button-green" name="saveType" value="Add Friend">
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
