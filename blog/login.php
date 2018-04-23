<?php
    $root=pathinfo($_SERVER['SCRIPT_FILENAME']);
    define('BASE_FOLDER',  basename($root['dirname']));
    define('SITE_ROOT',    realpath(dirname(__FILE__)));

    require_once 'includes/settings.php';
	require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHAID - Log in</title>
	<?php
		require_once(SITE_ROOT . '/includes/global_head.php');
		require_once(SITE_ROOT . '/includes/admin/admin_head.php');
	?>
	<link href="style/blog.css" rel="stylesheet">
</head>
<body>
	<?php
		require_once(SITE_ROOT . '/includes/admin/admin_header.php');
		require_once(SITE_ROOT . '/includes/header.php');

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
	      if($_POST["logout"] == "LOGOUT") {
	      	echo 'session id: ' . session_id();
	        $query = $con->prepare("DELETE FROM sessions WHERE session_id=?");
	        $query->bind_param("s", session_id());
	        $query->execute();
	        $query->close();
	        //header("Location: login.php");
	      }
			
		  if(!empty($_POST['username'])) {
		    $user_email = $_POST['username'];
		    $pass = $_POST['password'];
		    $query = $con->prepare("SELECT user_id, first_name, last_name, pass_salt, pass_hash, disabled FROM users WHERE email=?");
		    $query->bind_param("s", $user_email);
		    $query->execute();
		    $query->bind_result($user_id, $first_name, $last_name, $salt, $hash, $disabled);
		    $query->fetch();
		    $query->close();

				//if the access to the account has been disabled
				if($disabled == 1){
					echo "<script>window.location.replace('login.php');</script>";
					die("This account has been disabled. Please contact your system administrator.");	
				}	

		    if(!empty($hash)){
		      if($hash == "undefined") {
		        //password has not been set yet
		        header("Location: passreset.php?user_email=" . $user_email);
		        die();
		      } else {
		        //check if password is correct
		        if(hash("sha256", $pass . $salt) == $hash){
		          session_start();
		          //possible session variables to use as a greeting in the future
		          $_SESSION["first_name"] = $first_name;
		          $_SESSION["last_name"] = $last_name;

		          //add login record into sessions table with 4 hour expiry timer
		          $query = $con->prepare("INSERT INTO sessions (session_id, user_id, session_ip, session_expiration) VALUES(?, ?, ?, DATE_ADD(NOW(), INTERVAL 4 HOUR));");
		          $query->bind_param("sss", session_id(), $user_id, $_SERVER['REMOTE_ADDR']);
		          $query->execute();
		          $query->close();

		          // Decide where to go back to
		          if (!isset($_GET['back'])) {
		            header("Location: index.php");
		            die();
		          } else {
		            header("Location: " . $_GET['back']);
		            die();
		          }
		        }
		      }
		    }
		  }
		}
	?>
	<main id="main-content">
		<div class="inner-container">
			<div class="content-grid no-sidebar">
				<section id="main">
					<?php
						// Only show the login form if the user is not already logged in
						if ($_POST['logout'] == 'LOGOUT') {
							require_once(SITE_ROOT . '/includes/admin/admin_logged_out_notice.php');
						}
						else if ($user != null) {
							require_once(SITE_ROOT . '/includes/admin/admin_already_logged_in_notice.php');
						} else {
					?>
					<section class="info-page-content">
						<div class="content-grid-title">
							<h1>Log in</h1>
							<form method="post" class="login-form">
								<div class="post-input">
									<label for="username" class="section-label">Username</label>
									<input type="text" id="username" name="username">
								</div>
								<div class="post-input">
									<label for="password" class="section-label">Password</label>
									<input type="password" id="password" name="password">
								</div>
								<button type="submit" class="button-green">Log in</button>
								<span class="login-password-reset"><a href="reset-password.php">Reset my password</a></span>
							</form>
						</div>
					</section>
					<?php
						}
					?>
				</section>
			</div>
		</div>
	</main>
	<?php
		require_once(SITE_ROOT . '/includes/cookie_warning.php');
		require_once(SITE_ROOT . '/includes/footer.php');
		require_once(SITE_ROOT . '/includes/global_scripts.php');
	?>
</body>
</html>
