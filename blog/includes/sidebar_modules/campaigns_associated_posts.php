<?php
    /*
        Associated Post (campaigns) list (sidebar module)- shows list of posts associated with the campaign.
        * Only CMS pages should show this.
    */
?>
					<?php
						$stmt = $db->prepare("SELECT `id` FROM `posts` WHERE `campaign_id` = ?");
						$stmt->execute([$campaign->getID()]);

						if ($stmt->rowCount()) {
					?>

					<section id="categories-list">
						<h1>Associated Posts</h1>
						<ul>
							<?php
								$stmt = $db->prepare("SELECT `id` FROM `posts` WHERE `campaign_id` = ?");
								$stmt->execute([$campaign->getID()]);

								foreach ($stmt as $row) {
									$post = new Post($db, $row['id']);

									// Generate the CSS for the image
									if ($post->getImagePath() == null) {
										$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/assets/img/placeholder/blog_image.jpg\');';
									} else {
										$imageCSS = 'background-image: url(\'/' . INSTALLED_DIR . '/' . htmlentities($post->getImagePath()) . '\');';
									}
							?>
							<li>
								<a href="<?php echo $post->getLink(); ?>/" class="recent-posts-thumbnail" style="<?php echo $imageCSS; ?>"></a>
								<span><a href="<?php echo $post->getLink(); ?>/"><?php echo $post->getTitle(); ?></a></span>
							</li>

							<?php
								}
							?>
						</ul>
					</section>
					<?php
						}
					?>