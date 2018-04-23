<?php
    /*
        Newsletter subscribe (sidebar module)- Enables visitors to easily subscribe to newsletter.
        * Only CMS pages should show this.
    */
?>
					<section id="categories-list">
						<h1>Newsletter</h1>
						<form action="newsletter.php" method="post" class="login-form">
							<div class="post-input" style="padding-bottom: 0.5rem;">
								<label for="email" class="section-label" style="padding-top: 0;">Email address</label>
								<input type="email" id="email" name="email">
							</div>
							<button type="submit" class="button-green">Subscribe</button>
						</form>
					</section>
