<?php
    /*
        Campaigns Info (sidebar module)- shows info about the campaign.
        * Only CMS pages should show this.
    */
?>
					<section id="campaign-info">
						<h1>Dates</h1>
						<ul>
							<li>
								<span><strong>Start date:</strong> <time datetime="<?php echo $campaign->getStartDatetime(); ?>"><?php echo $campaign->getStartDatetime(); ?></time></span>
							</li>
							<li>
								<span><strong>End date:</strong> <time datetime="<?php echo $campaign->getEndDatetime(); ?>"><?php echo $campaign->getStartDatetime(); ?></time></span>
							</li>
						</ul>
					</section>
