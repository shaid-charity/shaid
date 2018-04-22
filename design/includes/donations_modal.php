<?php
    /*
        Donations modal - Allows user to donate.
        * All pages should contain this.
    */
?>	
	<div id="global-donate-modal" class="modal-container">
		<div id="global-donate-modal-message" class="modal-message">
			<h1>Donate</h1>
			<p>Use the slider below to select your donation amount. All donations are securely handled by PayPal.</p>
			<input
			    type="range"
			    min="0"
			    max="100"
			    step="1"
			    data-buffer="60" />
			<div class="modal-message-button-container">
				<button type="button" id="" class="button-green modal-message-button">Donate</button>
				<button type="button" id="close-global-donate-modal-button" class="button-dark modal-message-button">Cancel</button>
			</div>
		</div>
	</div>
