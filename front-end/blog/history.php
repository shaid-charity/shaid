<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));

    require_once '../../back-end/includes/settings.php';
	require_once '../../back-end/includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID</title>
	<?php
		require_once(SITE_ROOT . '/../includes/global_head.php');
	?>
	<link href="../style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/../includes/header.php');
	?>
	<main id="main-content">
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<section class="page-path">
						<span><a href="./about.php">About</a></span>
					</section>
					<section class="info-page-content">
						<div class="page-title">
							<h1>History</h1>
						</div>
						<h2>How it all started</h2>
						<p><strong>Single Homeless Action Initiative in Derwentside</strong> (SHAID) grew out of a local seminar, held in September 1993, in the relation to the housing needs of young single people. Concern had been growing within the Statutory and Voluntary Sectors in the District, for the diverse range of difficulties that appeared to be worsening for this age group.</p>
						<p><strong>The following problems were identified:</strong></p>
						<ul>
							<li>The lack of suitable accommodation for young people;</li>
							<li>The difficulties that they experienced flying to gain tenancies;</li>
							<li>The lack of support through tenancies;</li>
							<li>The need to raise awareness of housing issues through education;</li>
							<li>The need to research hidden homelessness;</li>
							<li>The need to change allocations policies;</li>
							<li>The lack of emergency accommodation, sheltered and hostel accommodation.</li>
						</ul>
						<p>The conclusion was that it was necessary to proceed on a joint basis as an inter-agency response which SHAID would facilitate with its main aim being seeking solutions to young people's housing issues by the most effective, co-ordinated means.</p>
						<p><strong>SHAID was formally launched in October 1993 by the then Minister of State for Environment and Transport, Hillary Armstrong.</strong></p>
						<p>Up until 1997 SHAID remained an inter-agency focus group who regularly held awareness raising seminars on issues relating to housing and young people. This all changed when SHAID received a National Lottery Grant enabling them in 1998 to employ 3 workers to work directly with young people in housing need from our then base in the Louisa Centre Stanley.</p>
						<p>Since then much has changed, for example we now have over twenty staff members spread across 3 sites, <strong>94a Front St Stanley</strong> (our head office) <strong>Wear Road Community House</strong> and <strong>St Peter's Court</strong> (our supported accommodation project for former armed services personnel). Such expansion and diversification is vital to the charities continuing survival in such a hard economic climate. However, one thing has remained constant and that is our commitment to providing a quality service that young people can rely upon in a time of need.</p>
						<h2>Change of Name</h2>
						<p>As of the 1st April 2014 Single Homeless Action Initiative in Derwentside became <strong>Single Homeless Action Initiative in Durham.</strong></p>
						<h2>Why the Change?</h2>
						<p>For some time now SHAID have worked with people outside our usual geographical area on specific projects. The change in name reflects this expansion into different areas.</p>
						<p>At present there are no changes to areas covered by our core services; Pre-Tenancy Support and Floating Support as funding for said projects is solely for the Derwentside area.</p>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/../includes/sidebar_modules/about_list.php');
					?>
				</aside>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/../includes/footer.php');
		require_once(SITE_ROOT . '/../includes/global_scripts.php');
	?>
</body>
</html>
