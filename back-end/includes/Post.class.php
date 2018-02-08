<?php

class Post extends Content {
	// Name of the table the content resides in
	protected $table = 'gp_posts';

	private $datePublished;
	private $lastModifiedDate;
	private $campaignID; // campaign?
	private $eventID; // event?

	public function __construct($db, $id = null, $name = null, $slug = null, $content = null, $image = null, $categoryID = null, $author = null, $keywords = null) {
		parent::__construct($db, $id, $name, $slug, $content, $image, $categoryID, $author, $keywords);


	}

	public function getDatePublished() {
		return $this->datePublished;
	}

	public function getLastModifiedDate() {
		return $this->lastModifiedDate;
	}

	public function getCampaign() {
		// TODO: Finish, returning campaign object
	}

	public function getEvent() {
		// TODO: Finish, returning event object
	}
}