<?php
    /*
        Already logged in (admin module) - Notifies user they are already logged in.
        * Only CMS admin pages should show this.
    */
?>
					<div class="article-message-banner">
						You are already logged in as <?php echo $user->getFullName(); ?>.
					</div>
