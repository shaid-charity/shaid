<?php
    /*
        Donations modal - Allows user to donate.
        * All pages should contain this.
    */
?>	
	<div id="campaign-donate-modal" class="modal-container">
		<div id="campaign-donate-modal-message" class="modal-message">
			<div class="donation-header-split">
				<h1>Donate</h1>
				<div>
					<img src="/assets/logos/external/paypal/paypal_xxsmall.png">
				</div>
			</div>

			<p>Choose your donation amount below.</p>

			<div class="donation-input">
				<span class="donation-currency-symbol">&pound;</span>
				<input class="donation-input-amount" id="donationAmount" autocomplete="off" placeholder="0.00" pattern="[0-9]*" value="" type="text" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')">
			</div>

			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" class="modal-message-button-container-full-width">
			    <input type="hidden" name="cmd" value="_donations" />
			    <input type="hidden" name="business" value="<?php echo DONATE_MERCHANT_ID; ?>" />
			    <input type="hidden" name="item_name" value="SHAID Campaign: <?php echo $campaign->getTitle(); ?>">
			    <input type="hidden" name="currency_code" value="GBP">
			    <input type="hidden" name="tax" value="0">
			    <input type="hidden" name="lc" value="UK">
			    <input type="hidden" name="amount" value="10">
				<input type="submit" class="button-green modal-message-button-full-width" value="Donate via PayPal">
			    </span><img width="1" height="1" alt="" src="plugins/system/tmlazyload/blank.gif" class="lazy" data-src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" border="0" /></span>
			</form>
		</div>
	</div>
