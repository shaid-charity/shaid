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
	<title>SHAID</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');
	?>
	<link href="../style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/admin/admin_header.php');
		require_once(SITE_ROOT . '/includes/header.php');
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
							<h1>Aims &amp; Objectives</h1>
						</div>
						<p>It is the aim of SHAID to become a comprehensive provider of services to young people.  To achieve this, our work is based on five objectives to become a more effective service provider and employer, these are:</p>
						<ul>
							<li>To be the service of choice for young people at risk;</li>
							<li>To have a wide and diverse range of services to enable long term sustainability;</li>
							<li>To be the employer of choice for professionals and volunteers who have commitment to working with young people at risk of homelessness or social exclusion;</li>
							<li>To secure the future of shaid through effective financial management and building reserves;</li>
							<li>To continue to achieve appropriate standards of excellence across the organisation.</li>
						</ul>
						<h2>Project Objectives</h2>
						<h3>Housing Advice &amp; Support</h3>
						<ul>
							<li>Continue to improve existing advice and support services;</li>
							<li>Investigate options for shaid to directly manage emergency and supported housing for young people itself;</li>
							<li>Work in partnership with other agencies to increase the housing and support options available to young people including more emergency accommodation;</li>
							<li>Support and develop  supported lodgings schemes;</li>
							<li>Develop a volunteer mentoring scheme; to recruit and train volunteers to support young people in independent living.</li>
						</ul>
						<h3>Education for Living</h3>
						<ul>
							<li>Evaluate, update and reprint SHAID's  literature to the highest of standards to reflect the present market and legislation which is in force at any particular time;</li>
							<li>Investigate the need to produce other publications for young people;</li>
							<li>Increase the range of activities available to young people at SHAID's drop-in facility and replicate the model in other parts of Derwentside;</li>
							<li>Expand SHAID's homelessness prevention programme to more schools, colleges and youth groups.</li>
						</ul>
						<h3>Promoting Social Inclusion</h3>
						<ul>
							<li>Continue supporting and further develop the multi-agency resource centre and signposting service for young people in partnership with other agencies;</li>
							<li>Develop initiatives to enable young people to access other essential services such as employment, training, education and healthcare;</li>
							<li>Develop community-based projects such as regeneration, arts and cultural projects to engage young people in society.</li>
						</ul>
						<h3>Community Links &amp; User Involvement</h3>
						<ul>
							<li>Expand SHAID's membership to ensure greater user involvement and community ownership;</li>
							<li>Broaden the skills and experience of the Board of Directors through securing representation  from the local  business community;</li>
							<li>Develop further innovative approaches to actively involve young people in the delivery of SHAID's services;</li>
							<li>Work in partnership with local housing providers, to develop a district wide initiative to explore different ways in which young people can get involved in decisions which effect their homes and the estates on which they live.</li>
						</ul>
					</section>
				</section>
				<aside id="sidebar">
					<?php
						require_once(SITE_ROOT . '/includes/sidebar_modules/about_list.php');
					?>
				</aside>
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
