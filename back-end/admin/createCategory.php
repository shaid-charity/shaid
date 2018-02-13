<?php

require_once '../includes/settings.php';
require_once '../includes/config.php';
require_once 'header.php';

?>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<!-- Top navbar -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
	  <a class="navbar-brand" href="#">SHAID Admin Panel</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item dropdown active">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          Content
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	          <a class="dropdown-item active" href="createCategory.php">Create Category <span class="sr-only">(current)</span></a>
	          <a class="dropdown-item" href="post.php">Create Post</a>
	        </div>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="contactDB.php">Contact DB</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="usermgmt.php">User Management</a>
	      </li>
	    </ul>

	    <form class="form-inline my-2 my-lg-0" method="POST" style="float:right;">
        	<input type="hidden" name="action" value="LOGOUT"/>
        	<input type='submit' class='btn btn-outline-danger my-2 my-sm-0' value="Log Out" />
      	</form>
	  </div>
	</nav>
	<div class="container">
		<div class="page-header">
			<h1>Create Category</h1>
		</div>
		<br />

<?php


if ($_GET['action'] == 'submit') {
	$message = "";
	$error = false;
	try {
		$cat = new Category($db, null, $_POST['name'], str_replace(' ', '', strtolower($_POST['name'])));
	} catch (PDOException $e) {
		$error = true;

		if ($e->getCode() == '0') {
			$message = "That category already exists!";
		}
		else {
			$message = $e->getMessage();
		}
	}

	if ($error) {
?>

	<div class="alert alert-danger"><?php echo $message; ?></div>

<?php
	} else {
?>

	<div class="alert alert-success">Category successfully added!</div>

<?php
	}
}
?>
		<form action="createCategory.php?action=submit" method="post">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="name">Category name: </label> <input class="form-control col-sm-10" type="text" name="name" id="nameInput"><br />
				<input class="btn btn-primary" type="submit">
			</div>
		</form>