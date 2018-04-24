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
								<span><strong>Start date:</strong> <time datetime="<?php echo $campaign->getNiceStartDatetime(); ?>"><?php echo $campaign->getNiceStartDatetime(); ?></time></span>
							</li>
							<li>
								<span><strong>End date:</strong> <time datetime="<?php echo $campaign->getNiceEndDatetime(); ?>"><?php echo $campaign->getNiceStartDatetime(); ?></time></span>
							</li>
						</ul>
					</section>
