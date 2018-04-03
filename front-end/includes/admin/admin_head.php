s<?php
    /*
        Tags that ADMIN pages should have in their <head> tag.
        * Only admin pages should contain this.
    */

    if ($user != null) {
?>
	<!-- Internal stylesheets -->
	<link href="/<?php echo INSTALLED_DIR; ?>/front-end/style/admin.css" rel="stylesheet">

<?php
	}
?>