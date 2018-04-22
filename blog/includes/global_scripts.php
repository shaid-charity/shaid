<?php
    /*
        Scripts that all pages should contain before their closing body tag.
        * All pages should contain this.
    */
    require_once 'includes/settings.php';
?>
	<!-- External scripts -->
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<!-- Internal scripts -->
	<script src="/<?php echo INSTALLED_DIR; ?>/scripts/navbar.js" type="text/javascript"></script>
	<script src="/<?php echo INSTALLED_DIR; ?>/scripts/donate.js" type="text/javascript"></script>

	<!-- Cookie warning script -->
	<script>
		function getCookie(name) {
    		name += "=";
			var decodedCookie = decodeURIComponent(document.cookie);
			var cookies = decodedCookie.split(';');

			// Loop through all cookies
			for (var i = 0; i < cookies.length; i++) {
			    var c = cookies[i];
			    while (c.charAt(0) == ' ') {
			        c = c.substring(1);
			    }

			    // If the cookies is found...
			    if (c.indexOf(name) == 0) {
			        return c.substring(name.length, c.length);
			    }
			}

			return "";
		}

		// If the cookie cookieConsent is stored in the browser, do not show the warning
		if (getCookie("cookieConsent") == "consented") {
			$(".cookie-warning").hide();
		}

		// If the dismiss button is clicked
		$("#dismiss-cookie-warning").click(function() {
			// Set the expiry date to be 1 year
			var expiryDate = new Date();
			expiryDate.setTime(expiryDate.getTime() + (365 * 24 * 60 * 60 * 1000)); // Need to convert time from miliseconds

			var expiryString = "expires=" + expiryDate.toUTCString();

			// Add the cookie. path=/ ensures it is belongs to the whole domain
			document.cookie = "cookieConsent=consented;" + expiryString + ";path=/"; 

			// Also hide the current warning shown
			$(".cookie-warning").hide();
		});
	</script>
