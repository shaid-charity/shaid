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
	<link href="../style/blog.css" rel="stylesheet">
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
						// Get the post data we want to preview
						// Create the blog post
						$name = $_POST['title'];
						$categoryID = $_POST['category'];
						$content = $_POST['content'];
						$campaign = $_POST['campaign'];
						$file = $_FILES['image'];

						if (file_exists($file['tmp_name'])) {
							$uploadManager = new UploadManager();
							$uploadManager->setFilename($file['name']);
							$imagePath = $uploadManager->getPath();
						} else {
							$imagePath = '';
						}

						$userID = 1;

						$post = new Post($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, $imagePath, $userID, '', $categoryID);


						$post->setPublished(0);

						if (file_exists($file['tmp_name'])) {
							$uploadManager->upload($file);
						}

						if (file_exists($file['tmp_name'])) {
							$imagePath = $uploadManager->getPath();
						} else {
							$imagePath = '../assets/img/placeholder/blog_image.jpg';
						}
					?>
					<article id="article">
						<section class="page-path">
							<span><a href="./index.php">Blog</a> <i class="zmdi zmdi-chevron-right"></i></span>
						</section>
						<section id="article-title" class="page-title article-title">
							<h1><?php echo $post->getTitle(); ?></h1>
						</section>
						<section id="article-info">
							<section id="article-author">
								<div id="article-author-photo">
									<img src="../assets/img/placeholder/profile_photo.jpg" alt="Jenny Smith">
								</div>
								<div id="article-author-text">
									<span id="article-author-text-name"><a href=""><?php echo $post->getAuthor()->getFullName(); ?></a></span>
									<span id="article-author-text-about">Guest blogger (SomeCharity)</span>
								</div>
							</section>
							<section id="article-date">
								<span><i class="zmdi zmdi-calendar"></i> <time id="date" datetime=""></time></span>
							</section>
						</section>
						<figure id="article-image">
							<img src="<?php echo $imagePath; ?>" alt="Above: Official figures show that 1 in 2 people are homeless.">
							<figcaption>Above: Official figures show that 1 in 2 people are homeless.</figcaption>
						</figure>
						<section id="article-content">
							<?php echo $post->getContent(); ?>
						</section>
					</article>
				</section>
				<aside id="sidebar">
					<section>
						<h1>Post preview</h1>
						<div class="sidebar-actions">
							<form action="editpost.php?action=fromPreview&id=<?php echo $post->getID(); ?>" method="post">
								<button type="submit" class="button-dark" name="saveType" value="Save Draft">Save Draft</button>
								<button type="submit" class="button-green" name="saveType" value="Publish">Publish</button>
								<button type="submit" class="button-dark" name="saveType" value="Edit">Edit</button>
							</form>
						</div>
					</section>
				</aside>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
<script>
	// Get the date, stick it where it needs to go
	var date = new Date(Date.now()).toLocaleString();
	$('#date').text(date);
</script>
</html>
