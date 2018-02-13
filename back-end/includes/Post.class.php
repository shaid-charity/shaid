<?php

class Post extends Content {
	// Name of the table the content resides in
	protected $table = 'posts';

	private $datePublished;
	private $lastModifiedDate;
	private $campaignID;
	private $eventID;
	private $category;
	private $approved;
	private $published;

	public function __construct($db, $id = null, $name = null, $slug = null, $content = null, $image = null, $author = null, $keywords = null, $categoryID = null, $datePublished = null, $campaignID = null, $eventID = null, $approved = null, $published = null) {
		parent::__construct($db, $id, $name, $slug, $content, $image, $author, $keywords);



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

	public function isApproved() {
		return $this->approved;
	}

	public function isPublished() {
		return $this->published;
	}
}