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
		$this->db = $db;

		// Get by slug
		if (is_null($id) && is_null($name) && !is_null($slug) && is_null($content) && is_null($image) && is_null($author) && is_null($keywords)) {
			$this->getBySlug($slug);
			return;
		} else if (!is_null($id) && is_null($name) && is_null($content) && is_null($image) && is_null($author) && is_null($keywords)) {
			$this->getByID($id);
			return;
		}

		parent::__construct($db, $id, $name, $slug, $content, $image, $author, $keywords);

		// Set the other properties
		$this->setCategory($categoryID);
		$this->setPublishedDateTime();
	}

	public function getByID($id) {
		parent::getByID($id);

		$stmt = $this->db->prepare("SELECT * FROM `$this->table` WHERE `id` = ?");
		$stmt->execute([$id]);
		$result = $stmt->fetch();

		$this->datePublished = $result['datetime-published'];
		$this->lastModifiedDate = $result['datetime-last-modified'];
		$this->category = new Category($this->db, $result['category_id']);
		$this->published = $result['published'];
	}

	public function getBySlug($slug) {
		$title = str_replace("-", " ", $slug);
		parent::getBySlug($slug);

		$stmt = $this->db->prepare("SELECT * FROM `$this->table` WHERE `title` = ?");
		$stmt->execute([$title]);
		$result = $stmt->fetch();

		$this->datePublished = $result['datetime-published'];
		$this->lastModifiedDate = $result['datetime-last-modified'];
		$this->category = new Category($this->db, $result['category_id']);
		$this->published = $result['published'];
	}

	public function getDatePublished() {
		return $this->datePublished;
	}

	public function getLastModifiedDate() {
		return $this->lastModifiedDate;
	}

	public function getCampaign() {
		return $this->campaign;
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

	public function getCategory() {
		return $this->category;
	}

	public function getLink() {
		return $this->category->getName() . '/' . $this->getID() . '-' . $this->getTitle();
	}

	// This function is private as we will never need the user to manually update the last modified datetime
	private function setLastModifiedDateTime() {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `datetime-last-modified` = NOW() WHERE `id` = ?");
			$stmt->execute([$this->getID()]);
		} catch (PDOException $e) {
			echo 'Post.class.php setLastModifiedDateTime() error: <br />';
			throw new Exception($e->getMessage());
		}

		// Because we set the datetime from MySQL, we can't use PHP's datetime function to get the time as it may be slightly different
		$stmt = $this->db->prepare("SELECT `datetime-last-modified` FROM `$this->table` WHERE `id` = ?");
		$stmt->execute([$this->getID()]);

		foreach ($stmt as $row) {
			$this->lastModifiedDate = $row['datetime-last-modified'];
		}
	}

	// For now, we don't need the user to manually set the published datetime. This might change if we want to include that ability
	private function setPublishedDateTime() {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `datetime-published` = NOW() WHERE `id` = ?");
			$stmt->execute([$this->getID()]);
		} catch (PDOException $e) {
			echo 'Post.class.php setPublishedDateTime() error: <br />';
			throw new Exception($e->getMessage());
		}

		// Because we set the datetime from MySQL, we can't use PHP's datetime function to get the time as it may be slightly different
		$stmt = $this->db->prepare("SELECT `datetime-published` FROM `$this->table` WHERE `id` = ?");
		$stmt->execute([$this->getID()]);

		foreach ($stmt as $row) {
			$this->datePublished = $row['datetime-published'];
		}

		// Also set the last modified datetime
		$this->setLastModifiedDateTime();
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

		// Also set the last modified datetime
		$this->setLastModifiedDateTime();
	}

	public function setCampaign($campaignID) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `campaign_id` = ? WHERE `id` = ?");
			$stmt->execute([(int) $campaignID, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Post.class.php setCampaign() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->campaign = new Campaign($this->db, $campaignID);

		// Also set the last modified datetime
		$this->setLastModifiedDateTime();
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

			$this->setPublishedDateTime();
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

		$this->setLastModifiedDateTime();

		// Also set the last modified datetime
		$this->setLastModifiedDateTime();
	}
}