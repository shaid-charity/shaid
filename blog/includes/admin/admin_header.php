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
					<li>&bull;</li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/newpost.php">New Blog Post</a></li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/newcategory.php">New Blog Category</a></li>
					<li>&bull;</li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/newevent.php">New Event</a></li>
					<li><a href="/<?php echo INSTALLED_DIR; ?>/newcampaign.php">New Campaign</a></li>
				</ul>
			</div>
			<div class="info-banner-button">
				<a href="javascript:void(0)" onclick="document.getElementById('logoutForm').submit();">Log out</a>
			</div>
			<form id="logoutForm" method="post" action="/<?php echo INSTALLED_DIR; ?>/login.php">
        		<input type="hidden" name="logout" value="LOGOUT"/>
      		</form>
		</div>
	</div>

<?php
	}
?>
