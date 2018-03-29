<?php
    /*
        Tags that all pages should have in their <head> tag. Will be used for
        global meta and stylesheet/link tags.
        * All pages should contain this.
    */
    require_once '../../back-end/includes/settings.php';
?>
	<!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- External stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|PT+Sans:700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
	<!-- Internal stylesheets -->
	<link rel="stylesheet" href="/<?php echo INSTALLED_DIR; ?>/front-end/style/main.css">
