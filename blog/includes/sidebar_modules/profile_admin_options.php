<?php
    /*
        View post admin options (sidebar module) - shows admin options for a viewed post.
        * Only CMS pages should show this.
    */

    if ($user != null && $user->getID() == $_GET['id']) {
?>
					<section>
						<h1>Admin options</h1>
						<div class="sidebar-actions">
							<a href="/<?php echo INSTALLED_DIR; ?>/admin/profile.php" type="button" class="button-dark">Edit profile</a>
						</div>
					</section>

<?php
	}
?>
