<?php
    /*
        Website header - contains logo, search bar and navigation.
        * All pages should contain this.
    */
    require_once 'includes/settings.php';
    require_once 'includes/donations.configg.php';
?>
	<header id="header">
		<div class="header-content">
			<div class="header-logo">
				<a href="/<?php echo INSTALLED_DIR; ?>/index.php">
					<img src="/<?php echo INSTALLED_DIR; ?>/assets/logos/header-logo-old.jpg" alt="SHAID">
				</a>
			</div>
			<span class="header-text">Single Homeless Action Initiative in Durham</span>
			<div class="header-right">
				<form action="/<?php echo INSTALLED_DIR; ?>/search.php" class="search header-search">
					<input type="text" name="term" placeholder="Search" />
					<button><i type="submit" class="material-icons">search</i></button>
				</form>
			</div>
		</div>
	</header>
	<nav role="navigation" id="navbar" class="navbar">
		<div class="navigation inner-container">
			<button type="button" class="navigation-menu-button" id="nav-button">
				<i class="material-icons" id="nav-button-icon">menu</i>
				<!--<i class="zmdi zmdi-menu" id="nav-button-icon"></i>-->
				<span>Menu</span>
			</button>
			<div class="navigation-items" id="nav-items">
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
				</ul>
				<div class="navigation-search">
					<form action="search.php" method="get" class="search menu-search">
						<input type="text" name="term" placeholder="Search" />
						<button type="submit"><i class="material-icons">search</i></button>
					</form>
				</div>
			</div>
			<div class="navigation-right">
				<?php
					//<a href="javascript:void(0)" id="global-donate-button" class="button-green">Make a donation</a>
				?>
				<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=<?php echo DONATE_BUTTON_ID; ?>" target="_blank" id="global-donate-button" class="button-green">Make a donation</a>
			</div>
		</div>
	</nav>
	<div class="lead-padding" id="nav-padding">
	</div>
