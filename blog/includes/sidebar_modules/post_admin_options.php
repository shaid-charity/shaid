<?php
    /*
        View post admin options (sidebar module) - shows admin options for a viewed post.
        * Only CMS pages should show this.
    */

    if ($user != null) {
?>
					<section>
						<h1>Admin options</h1>
						<div class="sidebar-actions">
							<a href="/<?php echo INSTALLED_DIR; ?>/editpost.php?id=<?php echo $post->getID(); ?>" type="button" class="button-dark">Edit</a>
							<a href="/<?php echo INSTALLED_DIR; ?>/editpost.php?action=makeDraft&id=<?php echo $post->getID(); ?>" type="button" class="button-dark">Make draft</a>
						</div>
					</section>

<?php
	}
?>
