<?php

class Post extends Content {
	// Name of the table the content resides in
	protected $table = 'gp_posts';

	public function __construct($db, $id = null, $name = null, $slug = null, $content = null, $image = null, $categoryID = null, $author = null, $keywords = null) {
		parent::__construct($db, $id, $name, $slug, $content, $image, $categoryID, $author, $keywords);

		
	}
}