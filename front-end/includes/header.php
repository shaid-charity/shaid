<?php
    /*
        Website header - contains logo, search bar and navigation.
        * All pages should contain this.
    */
?>
	<header id="header">
		<div class="header-content">
			<div class="header-logo">
				<a href="#">
					<!-- ORIGINAL FROM SHAID SITE: <img src="assets/logo-small.png" alt="SHAID" /> -->
					<!-- NEWER "DIFFERENT" VERSION: <img src="assets/logos/header-logo.png" alt="SHAID" /> -->
					<img src="/assets/logos/header-logo-old.jpg" alt="SHAID" />
				</a>
			</div>
			<span class="header-text">Single Homeless Action Initiative in Durham</span>
			<div class="header-right">
				<form action="" class="search header-search">
					<input type="text" placeholder="Search" />
					<button><i type="submit" class="material-icons">search</i></button>
				</form>
			</div>
		</div>
	</header>
	<nav role="navigation" id="navbar">
		<div class="navigation inner-container">
			<button type="button" class="navigation-menu-button" id="nav-button">
				<i class="material-icons" id="nav-button-icon">menu</i>
				<!--<i class="zmdi zmdi-menu" id="nav-button-icon"></i>-->
				<span>Menu</span>
			</button>
			<div class="navigation-items" id="nav-items">
				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">News</a></li>
					<li><a href="#">Events</a></li>
					<li><a href="#">Services</a></li>
					<li><a href="#">Online Referrals</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
				<div class="navigation-search">
					<form action="" class="search menu-search">
						<input type="text" placeholder="Search" />
						<button type="submit"><i class="material-icons">search</i></button>
					</form>
				</div>
			</div>
			<div class="navigation-right">
				<a href="#" class="button-green">Make a donation</a>
			</div>
		</div>
	</nav>
	<div class="lead-padding" id="nav-padding">
	</div>
