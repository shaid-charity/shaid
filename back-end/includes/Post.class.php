<?php

class Post extends Content {
	// We will use dependency injection to pass the DB object to this class
	protected $db;

	// Name of the table the content resides in
	protected $table = 'gp_posts';

	
}