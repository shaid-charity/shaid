<?php

require_once '../includes/settings.php';
require_once '../includes/config.php';

if (!isset($_GET['slug'])) {
	die("Post slug has not been sent.");
}

$slug = $_GET['slug'];

// Get the post
// Test slug: published-post-with-published-and-modified-time
$post = new Post($db, null, null, $slug);

if (!$post->isPublished()) {
	die("Post not published");
}
?>

<h1><?php echo $post->getTitle(); ?></h1>

<br />
<strong>Published date: </strong><?php echo $post->getDatePublished(); ?><br />
<br />

<?php echo $post->getContent(); ?>