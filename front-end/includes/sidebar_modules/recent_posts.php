<?php
    /*
        Recent posts (sidebar module)- shows links to X most recent posts.
        * Only CMS pages should show this.
    */
?>
					<section id="recent-posts">
						<h1>Recent posts</h1>
						<ul>
							<?php
								// Get the last 4 posts by published date
								$stmt = $db->query("SELECT `id` FROM `posts` ORDER BY `datetime-published` DESC LIMIT 4");

								foreach ($stmt as $row) {
									$post = new Post($db, $row['id']);

									// Generate the CSS for the image
									if ($post->getImagePath() == null) {
										$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/front-end/assets/img/placeholder/blog_image.jpg\');';
									} else {
										$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/back-end/admin/' . htmlentities($post->getImagePath()) . '\');';
									}
							?>
							<li>
								<a href="/<?php echo INSTALLED_DIR . '/front-end/blog/' . $post->getLink(); ?>/" class="recent-posts-thumbnail" style="<?php echo $imageCSS; ?>"></a>
								<span><a href="/<?php echo INSTALLED_DIR . '/front-end/blog/' . $post->getLink(); ?>/"><?php echo $post->getTitle(); ?></a></span>
							</li>
							<?php
								}
							?>
						</ul>
					</section>
