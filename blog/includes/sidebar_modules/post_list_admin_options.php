<?php
    /*
        View post admin options (sidebar module) - shows admin options for a viewed post.
        * Only CMS pages should show this.
    */
	require_once __DIR__.'/../permissionCheck.php';

    if ($user != null) {
?>
					<section>
						<h1>Admin options</h1>
						<div class="sidebar-actions">
							<a href="/<?php echo INSTALLED_DIR; ?>/newpost.php" type="button" class="button-dark">New post</a>
							<?php 
								if(grantAccess($user->getRoleID(), 'newCategory')){
							?>
							<a href="/<?php echo INSTALLED_DIR; ?>/newcategory.php" type="button" class="button-dark">New category</a>
							<?php }?>
						</div>
					</section>

<?php
	}
?>
