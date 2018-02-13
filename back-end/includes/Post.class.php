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

		// Set the other properties
		$this->setCategory($categoryID);
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

	public function setCategory($categoryID) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `category_id` = ? WHERE `id` = ?");
			$stmt->execute([(int) $categoryID, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Post.class.php setCategory() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->category = new Category($this->db, $categoryID);
	}

	public function setPublished($published) {
		if ($published) {
			try {
				$stmt = $this->db->prepare("UPDATE `$this->table` SET `published` = ? WHERE `id` = ?");
				$stmt->execute([1, $this->getID()]);
			} catch (PDOException $e) {
				echo 'Post.class.php setPublished() error: <br />';
				echo $e->getMessage();
			}

			$this->published = 1;
		} else {
			try {
				$stmt = $this->db->prepare("UPDATE `$this->table` SET `published` = ? WHERE `id` = ?");
				$stmt->execute([0, $this->getID()]);
			} catch (PDOException $e) {
				echo 'Post.class.php setPublished() error: <br />';
				echo $e->getMessage();
			}

			$this->published = 0;
		}
	}
}