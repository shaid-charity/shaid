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
	<link href="./style/blog.css" rel="stylesheet">
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
						<section class="page-path">
							<span><a href="./blog.php">Blog</a> <i class="zmdi zmdi-chevron-right"></i> <a href="./category.php">Category</a></span>
						</section>
						<section id="article-title" class="page-title article-title">
							<h1>Important Blog Post About Homelessness</h1>
						</section>
						<section id="article-info">
							<section id="article-author">
								<div id="article-author-photo">
									<img src="./assets/img/placeholder/profile_photo.jpg" alt="Jenny Smith">
								</div>
								<div id="article-author-text">
									<span id="article-author-text-name"><a href="">Jenny Smith</a></span>
									<span id="article-author-text-about">Guest blogger (SomeCharity)</span>
								</div>
							</section>
							<section id="article-date">
								<span><i class="zmdi zmdi-calendar"></i> 23rd March, 2018</span>
							</section>
						</section>
						<figure id="article-image">
							<img src="./assets/img/placeholder/blog_image.jpg" alt="Above: Official figures show that 1 in 2 people are homeless.">
							<figcaption>Above: Official figures show that 1 in 2 people are homeless.</figcaption>
						</figure>
						<section id="article-content">
							<p>This is an opening paragraph with some <strong>bold text</strong>, some <em>italic text</em>, and some <u>underlined text</u> (should underline be disabled?).</p>
							<p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.</p>
							<p class="article-formatting-blockquote">Block quote</p>
							<p>And another paragraph about it.</p>
							<h2>Subheading 1</h2>
							<p>Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.</p>
							<p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.</p>
							<p>Podcasting operational change management inside of workflows to establish a framework. Taking seamless key performance indicators offline to maximise the long tail. Keeping your eye on the ball while performing a deep dive on the start-up mentality to derive convergence on cross-platform integration.</p>
							<p>Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.</p>
							<h2>Subheading 2</h2>
							<p>Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain clicks-and-mortar solutions without functional solutions.</p>
							<p>Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas. Dynamically innovate resource-leveling customer service for state of the art customer service.</p>
							<p>Objectively innovate empowered manufactured products whereas parallel platforms. Holisticly predominate extensible testing procedures for reliable supply chains. Dramatically engage top-line web services vis-a-vis cutting-edge deliverables.</p>
						</section>
					</article>
					<div class="short-separator-container">
						<div class="short-separator-line">
						</div>
					</div>
					<section id="article-footer">
						<h2>Share this article</h2>
						<section id="social-icons">
							<a href="https://www.facebook.com/sharer/sharer.php?u=example.org" target="_blank">
								<img src="./assets/social/svg/facebook (3).svg" alt="Share on Facebook">
							</a>
							<a href="http://www.twitter.com/share?url=https://example.org/&hashtags=shaid" target="_blank">
								<img src="./assets/social/svg/twitter (3).svg" alt="Share on Twitter">
							</a>
							<a href="https://www.linkedin.com/shareArticle?mini=true&url=http://developer.linkedin.com&title=LinkedIn%20Developer%20Network&summary=My%20favorite%20developer%20program&source=LinkedIn" target="_blank">
								<img src="./assets/social/svg/linkedin (3).svg" alt="Share on LinkedIn">
							</a>
							<a href="http://www.reddit.com/submit?url=http://shaid.org.uk&title=Shaid%20New%20Blog%20Post" target="_blank">
								<img src="./assets/social/svg/reddit (3).svg" alt="Share on Reddit">
							</a>
							<a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl={url}&title={title}&caption={desc}&tags={hash_tags}" target="_blank">
								<img src="./assets/social/svg/tumblr (3).svg" alt="Share on Tumblr">
							</a>
						</section>
					</section>
				</section>
				<aside id="sidebar">
					<section id="post-associated">
						<h1>Campaign</h1>
						<h2>Name Of This Campaign</h2>
						<img src="http://via.placeholder.com/350x150" class="sidebar-large-image">
						<p>A brief description of what this campaign is all about...</p>
						<div class="sidebar-actions">
							<a href="#" class="button-dark">More info</a>
							<a href="#" class="button-dark">Donate</a>
						</div>
					</section>
					<section id="recent-posts">
						<h1>Recent posts</h1>
						<ul>
							<li>
								<div class="recent-posts-thumbnail">
									<img src="http://via.placeholder.com/80x65" alt="Recent post number 1">
								</div>
								<span><a href="#">Recent post number 1</a></span>
							</li>
							<li>
								<div class="recent-posts-thumbnail">
									<img src="http://via.placeholder.com/80x65" alt="Recent post number 2 with a slightly longer title">
								</div>
								<span><a href="#">Recent post number 2 with a slightly longer title</a></span>
							</li>
							<li>
								<div class="recent-posts-thumbnail">
									<img src="http://via.placeholder.com/80x65" alt="Recent post number 3">
								</div>
								<span><a href="#">Recent post number 3</a></span>
							</li>
							<li>
								<div class="recent-posts-thumbnail">
									<img src="http://via.placeholder.com/80x65" alt="Recent post number 3 with a very long title that spans multiple lines and just keeps going">
								</div>
								<span><a href="#">Recent post number 3 with a very long title that spans multiple lines and just keeps going</a></span>
							</li>
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
