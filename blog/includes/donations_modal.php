<?php
    /*
        Donations modal - Allows user to donate.
        * All pages should contain this.
    */
?>	
	<div id="global-donate-modal" class="modal-container">
		<div id="global-donate-modal-message" class="modal-message">
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

			<div class="modal-message-button-container-full-width">
				<a href="" type="button" id="" class="button-green modal-message-button-full-width">Donate via PayPal</a>
			</div>
		</div>
	</div>
