<?php
    /*
        Campaigns Info (sidebar module)- shows info about the campaign.
        * Only CMS pages should show this.
    */
?>
					<section id="campaign-info">
						<h1>Info</h1>
						<ul>
							<li><strong>Start date:</strong> <time datetime="<?php echo $campaign->getStartDatetime(); ?>"><?php echo $campaign->getStartDatetime(); ?></time></li>
							<li><strong>End date: <time datetime="<?php echo $campaign->getEndDatetime(); ?>"><?php echo $campaign->getStartDatetime(); ?></time></strong></li>
						</ul>
					</section>
