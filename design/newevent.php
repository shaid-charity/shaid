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
					<section class="page-path">
						<span><a href="./events.php">Events</a></span>
					</section>
					<div class="page-title">
						<h1>New Event</h1>
					</div>
					<section id="post-editor">
						<form id="postForm" action="editpost.php?action=createNew" method="post" enctype="multipart/form-data">
							<div class="post-input">
								<label for="title" class="section-label">Title</label>
								<input type="text" name="title" id="post-title">
							</div>
							<div class="post-input">
								<span class="section-label">Start and end dates</span>
								<div class="post-input-row">
									<div class="post-input post-input-grow post-input-padding-right">
										<label for="startDatetime">Start date and time</label>
										<input type="datetime-local" name="startDatetimeInput" id="post-startDatetime">
									</div>
									<div class="post-input post-input-grow post-input-padding-left">
										<label for="endDatetime">End date and time</label>
										<input type="datetime-local" name="endDatetime" id="post-endDatetime">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="closingDatetime" class="section-label">Closing date and time</label>
								<input type=datetime-local name="closingDatetime" id="post-closingDatetime">
							</div>
							<div class="post-input">
								<label for="location" class="section-label">Location</label>
								<input type="text" name="location" id="post-location">
							</div>
							<div class="post-input">
								<span class="section-label">Ticket Information</span>
								<div class="post-input-row">
									<div class="post-input post-input-grow post-input-padding-right">
										<label for="capacity">Capacity</label>
										<input type="number" name="capacity" id="post-capacity">
									</div>
									<div class="post-input post-input-grow post-input-padding-left">
										<label for="ticketPrice">Ticket Price</label>
										<input type="number" step="0.01" name="ticketPrice" id="post-ticketPrice">
									</div>
								</div>
							</div>
							<div class="post-input">
								<span class="section-label">Featured image</span>
								<div class="post-input-row">
									<div class="post-input post-input-padding-right">
										<label for="post-featured-image">Image file</label>
										<input type="file" name="featured-image" id="post-featured-image">
									</div>
									<div class="post-input post-input-grow post-input-padding-left">
										<label for="post-featured-image-caption">Featured image caption</label>
										<input type="text" name="featured-image-caption" id="post-featured-image-caption">
									</div>
								</div>
							</div>
							<div class="post-input">
								<label for="post-content" class="section-label">Event description</label>
								<textarea name="content" id="post-content"></textarea>
							</div>
						</button>
					</section>
				</section>
				<aside id="sidebar">
					<section>
						<h1>Info</h1>
						<ul>
							<li>
								<span><strong>Status:</strong>
								<em>New</em></span>
							</li>
						</ul>
					</section>
					<section>
						<h1>Campaign</h1>
						<div class="sidebar-input">
							<select>
								<option value="">None</option>
								<option value="id1">Campaign 1</option>
							</select>
						</div>
					</section>
					<section>
						<h1>Publish</h1>
						<div class="sidebar-actions">
							<button type="button" class="button-dark">Save Draft</button>
							<button type="button" class="button-green">Publish</button>
							<button type="submit" class="button-dark">Preview</button>
						</div>
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