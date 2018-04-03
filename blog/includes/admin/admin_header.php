<?php
    /*
        Admin header - contains admin navigation options.
        * Displayed only if logged in.
    */

    if ($user != null) {
?>
	<div class="admin-header info-banner">
		<div class="inner-container info-banner-content">
			<div class="info-banner-text">
				<ul class="info-banner-nav">
					<li>Logged in as <a href="#"><?php echo $user->getFullName(); ?></a></li>
					<li>&bull;</li>
					<li><a href="#">Admin panel</a></li>
				</ul>
			</div>
			<div class="info-banner-button">
				<a onclick="document.getElementById('logoutForm').submit();">Log out</a>
			</div>
			<form id="logoutForm" method="post" action="/<?php echo INSTALLED_DIR; ?>/login.php">
        		<input type="hidden" name="logout" value="LOGOUT"/>
      		</form>
		</div>
	</div>

<?php
	}
?>
