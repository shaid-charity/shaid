<?php
    /*
        View post admin options (sidebar module) - shows admin options for a viewed post.
        * Only CMS pages should show this.
    */
	require_once __DIR__.'/../permissionCheck.php';

    if ($user != null && grantAccess($user->getRoleID(), "newCampaign")) {
?>
					<section>
						<h1>Admin options</h1>
						<div class="sidebar-actions">
							<a href="/<?php echo INSTALLED_DIR; ?>/newcampaign.php" type="button" class="button-dark">New Campaign</a>
						</div>
					</section>

<?php
	}
?>
