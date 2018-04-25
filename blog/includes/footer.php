<?php
    /*
        Website footer - contains important links and information.
        * All pages should contain this.
    */
?>	
	<footer>
		<div class="footer-contents inner-container">
			<div class="footer-section footer-navigation">
				<h2>Navigation</h2>
				<ul>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/index.php">Home</a></li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/blog.php">Blog</a></li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/campaigns.php">Campaigns</a></li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/about.php">About</a></li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/services.php">Services</a></li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/store.php">Store</a></li>
					<?php
						/* <li><a href="/<?php echo INSTALLED_DIR; ?>/events.php">Events</a></li> */
					?>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/referrals.php">Referrals</a></li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/downloads.php">Downloads</a></li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/contact.php">Contact</a></li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/links.php">Useful Links</a></li>
				</ul>
			</div>
			<div class="footer-section">
				<h2>Keep updated</h2>
				<div class="footer-social-container">
					<span class="footer-social-button">
						<a href="/<?php echo INSTALLED_DIR; ?>/newsletter.php" data-platform="email">
							<i class="zmdi zmdi-email"></i>
							<span class="footer-social-button-label">Email</span>
						</a>
					</span>
					<span class="footer-social-button">
						<a href="https://facebook.com" target="_blank" data-platform="facebook">
							<i class="zmdi zmdi-facebook-box"></i>
							<span class="footer-social-button-label">Facebook</span>
						</a>
					</span>
					<span class="footer-social-button">
						<a href="https://twitter.com" target="_blank" data-platform="twitter">
							<i class="zmdi zmdi-twitter"></i>
							<span class="footer-social-button-label">Twitter</span>
						</a>
					</span>
					<span class="footer-social-button">
						<a href="https://youtube.com" target="_blank" data-platform="youtube">
							<i class="zmdi zmdi-youtube-play"></i>
							<span class="footer-social-button-label">YouTube</span>
						</a>
					</span>
				</div>
			</div>
			<div class="footer-section">
				<h2>Get in touch</h2>
				<p><b>Tel:</b> <a href="tel:01207238241" class="footer-contact-link">01207 238241</a></p>
				<p><b>Email:</b> <a href="mailto:info@shaid.org.uk" class="footer-contact-link">info@shaid.org.uk</a></p>
				<div class="footer-address-container">
					<p><b>Main office:</b></p>
					<p><span class="footer-address">94A Front St<br>Stanley Co. Durham<br>DH9 0HU</span></p>
				</div>
			</div>
		</div>
		<div class="footer-charityinfo inner-container">
			<p>Single Homeless Action Initiative in Durham Ltd is a registered company, number 3659370, and a registered charity, number 1074505.</p>
			<ul>
				<li><a href="/<?php echo INSTALLED_DIR; ?>/terms-conditions.php">Terms and Conditions</a></li>
				<li>&bull;</li>
				<li><a href="/<?php echo INSTALLED_DIR; ?>/privacy-policy.php">Privacy Policy</a></li>
				<li>&bull;</li>
				<?php
					if ($user == null) {
				?>
				<li><a href="/<?php echo INSTALLED_DIR; ?>/login.php">Log in</a></li>
				<?php
					} else {
				?>
				<li><a href="/<?php echo INSTALLED_DIR; ?>/admin/">Admin Panel</a></li>
				<li>&bull;</li>
				<li><a href="javascript:void(0)" onclick="$('#logoutForm').submit();">Log out</a></li>
				<?php
					}
				?>
 			</ul>
		</div>
	</footer>
