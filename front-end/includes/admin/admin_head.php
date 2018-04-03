<?php
    /*
        Tags that ADMIN pages should have in their <head> tag.
        * Only admin pages should contain this.
    */

    if ($user != null) {
?>
	<!-- Internal stylesheets -->
	<link href="/<?php echo INSTALLED_DIR; ?>/front-end/style/admin.css" rel="stylesheet">

	<!-- Add extra padding so footer links are still visible -->
	<style>
		.footer-charityinfo {
			padding-bottom: 3rem;
		}
	</style>

<?php
	}
?>