<?php
    /*
        Campaigns Info (sidebar module)- shows info about the campaign.
        * Only CMS pages should show this.
    */
?>
					<section id="campaign-info">
						<h1>Info</h1>
						<ul>
							<li><strong>Start date:</strong> <time datetime="<?php echo $campaign->getStartDatetime(); ?>"><?php echo $campaign->getStartDate(); ?></time></li>
							<li><strong>End date:</strong></li>
						</ul>
					</section>
					<section id="campaign-sidebar-donate">
						<h1>Donate</h1>
						<ul>
							<li>...</li>
						</ul>
					</section>
