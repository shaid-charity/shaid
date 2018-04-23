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
	<title>SHAID - Post Preview</title>
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
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<?php
						// Get the post data we want to preview
						// Create the blog post
						if ($_POST['id'] == 0) {
							// We came from newpost.php
							$action = 'newpost.php';
							$title = $_POST['title'];
							$category = new Category($db, $_POST['category']);
							$campaign = $_POST['campaign'];
							$content = $_POST['content'];
							$file = $_FILES['featured-image'];
							$imageCaption = $_POST['featured-image-caption'];

							if (file_exists($file['tmp_name'])) {
								$uploadManager = new UploadManager();
								$uploadManager->setFilename($file['name']);
								$imagePath = $uploadManager->getPath();
							} else {
								$imagePath = 'assets/img/placeholder/460x230.png';
							}

							$author = $user;
							$date = date("d/m/Y");
							$id = 0;
						} else {
							// Came from editpost.php
							//$post = new Post($db, null, $name, str_replace(' ', '-', strtolower($name)), $content, $imagePath, $userID, '', $categoryID);
							$post = new Post($db, $_POST['id']);

							$title = $post->getTitle();
							$category = $post->getCategory();
							$content = $post->getContent();
							$campaign = (!is_null($post->getCampaign()) ? $post->getCampaign()->getID() : 0);
							$author = $post->getAuthor();
							$date = $post->getLastModifiedDate();
							$imagePath = $post->getImagePath();
							$imageCaption = $post->getImageCaption();
							$id = $post->getID();
							$action = 'editpost.php?action=fromPreview&id=' . $id;
						}
					?>
					<article id="article">
						<section class="page-path">
							<span><a href="./index.php">Blog</a> <i class="zmdi zmdi-chevron-right"></i></span>
						</section>
						<section id="article-title" class="page-title article-title">
							<h1><?php echo $title; ?></h1>
						</section>
						<section id="article-info">
							<section id="article-author">
								<div id="article-author-photo">
									<img src="<?php echo $author->getAvatarPath(); ?>" alt="<?php echo $author->getFullName(); ?>">
								</div>
								<div id="article-author-text">
									<span id="article-author-text-name"><a href="<?php echo $author->getProfileLink(); ?>"><?php echo $author->getFullName(); ?></a></span>
									<span id="article-author-text-about"><?php echo $author->getCompany()->getName(); ?></span>
								</div>
							</section>
							<section id="article-date">
								<span><i class="zmdi zmdi-calendar"></i> <time id="date" datetime="<?php echo $date ?>"><?php echo $date; ?></time></span>
							</section>
						</section>
						<figure id="article-image">
							<img src="<?php echo $imagePath; ?>" alt="Above: Official figures show that 1 in 2 people are homeless.">
							<figcaption><?php echo $imageCaption; ?></figcaption>
						</figure>
						<section id="article-content">
							<?php echo $content; ?>
						</section>
					</article>
				</section>
				<aside id="sidebar">
					<section>
						<h1>Post preview</h1>
						<form action="<?php echo $action; ?>" method="post" class="sidebar-actions">
							<input type="hidden" name="fromPreview" value="true">
							<input type="hidden" name="title" id="post-title" value="<?php echo $title; ?>">
							<input type="hidden" name="category" value="<?php echo $category->getID(); ?>">	
							<input type="hidden" name="featured-image" id="post-featured-image" value="<?php echo $imagePath; ?>">
							<input type="hidden" name="featured-image-caption" id="post-featured-image-caption" value="<?php echo $imageCaption; ?>">
							<input type="hidden" name="content" id="content" value="<?php echo $content; ?>">
							<button type="submit" class="button-dark" name="saveType" value="Edit">Edit</button>
						</form>
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
</html>
