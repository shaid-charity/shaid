<?php
    /*
        Categories list (sidebar module)- shows list of post categories.
        * Only CMS pages should show this.
    */
?>
					<section id="categories-list">
						<h1>Categories</h1>
						<ul>
							<?php
								$stmt = $db->query("SELECT `id` FROM `categories`");

								foreach ($stmt as $row) {
									$c = new Category($db, $row['id']);
							?>
							<li><a href="<?php echo $c->getLink(); ?>/"><?php echo $c->getName(); ?></a></li>

							<?php
								}
							?>
						</ul>
					</section>
