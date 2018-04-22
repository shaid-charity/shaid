<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));

    require_once 'includes/settings.php';
	require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID - Links</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');
	?>
	<link href="style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/admin/admin_header.php');
		require_once(SITE_ROOT . '/includes/header.php');
	?>
	<main id="main-content">
		<div class="inner-container">
			<div class="content-grid no-sidebar">
				<section id="main">
					<section class="info-page-content">
						<div class="content-grid-title">
							<h1>Useful Links</h1>
						</div>

						<h2 class="links-page-heading">Homeless UK</h2>
						<span class="links-page-text">
							Information on over 8,000 services, including hostels, day centres and other advice and support services for homeless people.
						</span>
						<span class="links-page-text">
							<a href="http://www.homelessuk.org">http://www.homelessuk.org</a>
						</span>

						<h2 class="links-page-heading">Stonham</h2>
						<span class="links-page-text">
							Stonham is England’s largest provider of housing and support for vulnerable people.
						</span>
						<span class="links-page-text">
							<a href="http://www.homegroup.org.uk/stonham">http://www.homegroup.org.uk/stonham</a>
						</span>

						<h2 class="links-page-heading">DASH</h2>
						<span class="links-page-text">
							Provide Supported Accommodation, Floating Support and Emergency Access Accommodation.
						</span>
						<span class="links-page-text">
							<a href="https://www.dashorg.co.uk">https://www.dashorg.co.uk</a>
						</span>

						<h2 class="links-page-heading">Homeless Link</h2>
						<span class="links-page-text">
							Homeless Link is the national membership organisation for frontline homelessness agencies in England. Our mission is to be a catalyst that will help to bring an end to homelessness.
						</span>
						<span class="links-page-text">
							<a href="https://www.homeless.org.uk">https://www.homeless.org.uk</a>
						</span>

						<h2 class="links-page-heading">Centrepoint</h2>
						<span class="links-page-text">
							Centrepoint is the national charity working to improve the lives of socially excluded, homeless young people. It provides a range of accommodation based services, including emergency nightshelters and short stay hostels, specialist projects for care etc.
						</span>
						<span class="links-page-text">
							<a href="https://centrepoint.org.uk">https://centrepoint.org.uk</a>
						</span>

						<h2 class="links-page-heading">Moving on</h2>
						<span class="links-page-text">
							Moving On is a housing advice and support project for 16-25 year olds in Durham.  We offer advice and assistance to young people who are homeless or experiencing housing difficulties and offer support to young people in their own accommodation.
						</span>
						<span class="links-page-text">
							<a href="https://www.movingondurham.org.uk">https://www.movingondurham.org.uk</a>
						</span>

						<h2 class="links-page-heading">MonKey</h2>
						<span class="links-page-text">
							Running a home can be expensive and you could end up paying for more than you can afford. Monkey can help make your money go further.
						</span>
						<span class="links-page-text">If you have applied to be housed with any of the partner housing providers through Durham Key Options*, are a new tenant setting up home, an existing tenant needing support or have applied to be rehoused, we can help.
						</span>
						<span class="links-page-text">
							Our network of partners including housing providers and voluntary sector organisations will help you.
						</span>
						<span class="links-page-text">
							<a href="http://monkey.uk.net">http://monkey.uk.net</a>
						</span>

						<h2 class="links-page-heading">Stanley Area Action Partnership</h2>
						<span class="links-page-text">
							Find information about Stanley Area Action Partnership (AAP) including activities, events and projects and details about the partnership forum, board and task groups.
						</span>
						<span class="links-page-text">
							<a href="http://www.durham.gov.uk/stanleyaap">http://www.durham.gov.uk/stanleyaap</a>
						</span>

						<h2 class="links-page-heading">Derwent Valley Area Action Partnership</h2>
						<span class="links-page-text">
							Find an overview of the work of Derwent Valley Area Action Partnership (AAP).
						</span>
						<span class="links-page-text">
							<a href="http://www.durham.gov.uk/derwentaap">http://www.durham.gov.uk/derwentaap</a>
						</span>

						<h2 class="links-page-heading">Wellbeing for Life</h2>
						<span class="links-page-text">
							Wellbeing for Life can help you find out what’s around you and how to make the most of it. Wellbeing is about your health, happiness, opportunities and your overall quality of life. The service has a team of experienced staff and volunteers who will work with you and your community group to give you the support and advice you need.
						</span>
						<span class="links-page-text">
							<a href="http://www.wellbeingforlife.net">http://www.wellbeingforlife.net</a>
						</span>

						<h2 class="links-page-heading">Stanley Town Council</h2>
						<span class="links-page-text">
							Stanley Town Council is about the whole area in and around what might be termed 'wider' Stanley and not just the town or town-centre itself. With a population of more than 31,000, the Town Council is the largest local council in the county.
						</span>
						<span class="links-page-text">
							<a href="http://www.stanley-tc.gov.uk">http://www.stanley-tc.gov.uk</a>
						</span>

						<h2 class="links-page-heading">Durham Key Options</h2>
						<span class="links-page-text">
							Durham Key Options. DKO is a partnership between Cestria Housing, Dale and Valley Homes, Derwentside Homes, Durham City Homes, East Durham Homes, livin, Teesdale Housing, and of course, Durham County Council.
						</span>
						<span class="links-page-text">
							We aim to give you more choice in deciding where you want to live. Properties that are available for rent will be advertised each week, both social rents and private. We also advertise shared ownership and affordable homeownership properties.
						</span>
						<span class="links-page-text">
							<a href="https://www.durhamkeyoptions.co.uk">https://www.durhamkeyoptions.co.uk</a>
						</span>

						<h2 class="links-page-heading">Durham County Council</h2>
						<span class="links-page-text">
							The one stop shop for information on all services provided by Durham County Council.
						</span>
						<span class="links-page-text">
							<a href="http://www.durham.gov.uk/article/1843/Home">http://www.durham.gov.uk/article/1843/Home</a>
						</span>
					</section>
				</section>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
