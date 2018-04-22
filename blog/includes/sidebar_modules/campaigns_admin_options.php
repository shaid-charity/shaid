<?php
    /*
        View post admin options (sidebar module) - shows admin options for a viewed post.
        * Only CMS pages should show this.
    */

    if ($user != null && $user->getID() == $campaign->getAuthor()->getID()) {
?>
					<section>
						<h1>Admin options</h1>
						<div class="sidebar-actions">
							<a href="/<?php echo INSTALLED_DIR; ?>/editcampaign.php?id=<?php echo $campaign->getID(); ?>" type="button" class="button-dark">Edit</a>
						</div>
					</section>

<?php
	}
?>
