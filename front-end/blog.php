<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
	?>
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/header.php');
	?>
	<main id="main-content">
		<div class="inner-container">
			<div class="content-grid">
				<section id="main">
					<article id="article">
						<section id="article-category">
							<span><a href="/blog.php">Blog</a> <i class="zmdi zmdi-chevron-right"></i> <a href="#">Category</a></span>
						</section>
						<section id="article-title">
							<h1>Important Blog Post About Homelessness</h1>
						</section>
						<section id="article-info">
							<section id="article-author">
								<div id="article-author-photo">
									<img src="/assets/img/placeholder/profile_photo.jpg" />
								</div>
								<div id="article-author-text">
									<span id="article-author-text-name"><a href="">Jenny Smith</a></span>
									<span id="article-author-text-about">Guest blogger (SomeCharity)</span>
								</div>
							</section>
							<section id="article-date">
								<span><i class="zmdi zmdi-calendar"></i> 23rd March '18</span>
							</section>
							</section>
						<figure id="article-image">
							<img src="/assets/img/placeholder/blog_image.jpg">
							<figcaption>Above: Official figures show that 1 in 2 people are homeless.</figcaption>
						</figure>
						<section id="article-content">
							<p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.</p>
							<p>Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.</p>
							<p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.</p>
							<p>Podcasting operational change management inside of workflows to establish a framework. Taking seamless key performance indicators offline to maximise the long tail. Keeping your eye on the ball while performing a deep dive on the start-up mentality to derive convergence on cross-platform integration.</p>
							<p>Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.</p>
							<p>Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain clicks-and-mortar solutions without functional solutions.</p>
							<p>Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas. Dynamically innovate resource-leveling customer service for state of the art customer service.</p>
							<p>Objectively innovate empowered manufactured products whereas parallel platforms. Holisticly predominate extensible testing procedures for reliable supply chains. Dramatically engage top-line web services vis-a-vis cutting-edge deliverables.</p>
						</section>
					</article>
					<section id="article-footer">
						Below article
					</section>
				</section>
				<aside id="sidebar">
					<section>
						<h3>Campaign</h3>
						<p>A brief description of what this campaign is all about...</p>
						<a href="#" class="button-dark">More info</a>
						<a href="#" class="button-dark">Donate</a>
					</section>
					<section>
						<h3>Recent posts</h3>
						<ul>
							<li>Recent post number 1</li>
							<li>Recent post number 2 with a slightly longer title</li>
							<li>Recent post number 3</li>
						</ul>
					</section>
				</aside>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>