<?php
    /*
        View post admin options (sidebar module) - shows admin options for a viewed post.
        * Only CMS pages should show this.
    */
	echo $user->getRoleID();
    if ($user != null && ($user->getID() == $post->getAuthor()->getID() || $user->getRoleID() == 1)) {
?>
					<section>
						<h1>Admin options</h1>
						<div class="sidebar-actions">
							<a href="/<?php echo INSTALLED_DIR; ?>/editpost.php?id=<?php echo $post->getID(); ?>" type="button" class="button-dark">Edit</a>
							<a href="/<?php echo INSTALLED_DIR; ?>/editpost.php?action=makeDraft&id=<?php echo $post->getID(); ?>" type="button" class="button-dark">Make draft</a>
							<!-- Dmytro asked for this -->
							<?php 
							if($user->getRoleID() <= 1){
							?>
							<a href="/<?php echo INSTALLED_DIR; ?>/afile.php" type="button" class="button-dark">Approve</a>
							<?php
							}
							?>
						</div>
					</section>

<?php
	}
?>
