<?php
    /*
        Tags that all pages should have in their <head> tag. Will be used for
        global meta and stylesheet/link tags.
        * All pages should contain this.
    */
    require_once 'includes/settings.php';
    require_once 'includes/config.php';
    // This header file will include everything we need for the user management. This way we do not need to repeat any code.
    session_start();
    //require_once('includes/db.php');
    require_once('includes/functions.php');

    $query = $con->prepare("SELECT user_id, session_number FROM sessions WHERE session_id=? AND session_ip=? AND session_expiration > NOW() ORDER BY session_number DESC;");

    $query->bind_param("ss", session_id(), $_SERVER["REMOTE_ADDR"]);
    $query->execute();
    $query->bind_result($USER_ID, $session_number);
    $query->fetch();
    $query->close();

    $page_name = strrchr($_SERVER['PHP_SELF'], "/");
    if(empty($session_number) && $page_name != "/login.php") {
        // Not logged in
        //return;
    } else {
        //check if user has permission to access user management
      $query = $con->prepare("SELECT role_id FROM users, sessions WHERE users.user_id = sessions.user_id AND session_number=?");
      $query->bind_param("s", $session_number);
      $query->execute();
      $query->bind_result($role_id);
      $query->fetch();
      $query->close();

      //old permission check

      //$role_id 1 is super admin
      //if($role_id > 1){
      //  die("You don't have permission to access this page");
      //  header("Location: login.php?back=viewPosts.php"); //view posts as a default redirect for wrong permission
    //
      //  //header("Location: login.php?back=" . $_SERVER['PHP_SELF']);
      //    //return;
      //}
      //edit this to manage minimum permission for each page
      
      $query = $con->prepare("UPDATE sessions SET session_expiration = DATE_ADD(NOW(), INTERVAL 4 HOUR) WHERE session_number=?");
      $query->bind_param("s", session_id());
      $query->execute();
      $query->close();

      /*$page_min_permissions = array(
        "/usermgmt.php" => 1,
        "/contactDB.php" => 2,
        "/viewEvents.php" => 3,
        "/event.php" => 3,
        "/campaign.php" => 2,
        "/viewCampaigns.php" => 2,
        "/post.php" => 5,
        "/viewPosts.php" => 5,
        "/createCategory.php" => 3,
        "/viewCategories.php" => 3,
      );

      if($role_id > $page_min_permissions[$page_name]){
        //header("Location: login.php?back=viewPosts.php"); //view posts as a default redirect for wrong permission
        die('incorrect permission...');
      }*/
    }

    // Attempt to get the logged in user
    // Get the user ID
    $stmt = $db->prepare("SELECT users.user_id FROM users, sessions WHERE users.user_id = sessions.user_id AND session_number=?");
    $stmt->execute(array($session_number));
    $userID = $stmt->fetch()['user_id'];

    // Get the user object
    if ($userID != null) {
        $user = new User($db, $userID);
    } else {
        $user = null;
    }
?>
	<!-- Meta -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- External stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|PT+Sans:700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
	<!-- Internal stylesheets -->
	<link rel="stylesheet" href="/<?php echo INSTALLED_DIR; ?>/style/main.css">
  <link rel="icon" type="image/png" href="/<?php echo INSTALLED_DIR; ?>/assets/favicon/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="/<?php echo INSTALLED_DIR; ?>/assets/favicon/favicon-16x16.png" sizes="16x16" />
