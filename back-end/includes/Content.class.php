<?php

abstract class Content extends DBRecord {
	// We will use dependency injection to pass the DB object to this class
	protected $db;

	// Name of the table the content resides in. Will be overwritten by Content's child classes
	protected $table;

	// The properties of the post
	private $id;
	private $name;
	private $slug;
	private $content;
	private $image;
	private $user;
	private $keywords;

	// TODO: Add author user - need to see Dmytro's code
	public function __construct($db, $id = null, $name = null, $slug = null, $content = null, $image = null, $author = null, $keywords = null) {
		$this->db = $db;

		if (!is_null($id) && is_null($name) && is_null($content) && is_null($image) && is_null($author) && is_null($keywords)) {
			$this->getByID($id);
		} else if (is_null($id) && is_null($name) && !is_null($slug) && is_null($content) && is_null($image) && is_null($author) && is_null($keywords)) {
			$this->getBySlug($slug);
		} else if (is_null($id) && !is_null($name) && !is_null($slug) && !is_null($content) && !is_null($image) && !is_null($keywords) && !is_null($author)) {
			$this->createConstructor($name, $content, $image, $keywords, $slug, $author);
		} else {
			throw new Exception('Incorrect parameters set!');
		}
	}

	private function getByID($id) {
		$stmt = $this->db->prepare("SELECT * FROM `$this->table` WHERE `id` = ?");
		$stmt->execute([$id]);
		$result = $stmt->fetch();

		$this->id = $id;
		$this->name = $result['title'];
		$this->slug = $result['slug'];
		$this->content = $result['content'];
		$this->image = $result['image'];
		$this->category = new Category($this->db, $result['category']);
	}

	/*private function getBySlug($slug) {
		$stmt = $this->db->prepare("SELECT * FROM `$this->table` WHERE `slug` = ?");
		$stmt->execute([$slug]);
		$result = $stmt->fetch();

		$this->id = $result['id'];
		$this->name = $result['name'];
		$this->slug = $result['slug'];
		$this->content = $result['content'];
		$this->image = $result['image'];
		$this->category = new Category($this->db, $result['category']);
	}*/

	private function createConstructor($name, $content, $image, $keywords, $slug, $userID) {
		try {
			$stmt = $this->db->prepare("INSERT INTO `$this->table`(title, content, image, user_id) VALUES (?, ?, ?, ?)");
			$stmt->execute([$name, $content, $image, $userID]);
		} catch (PDOException $e) {
			echo 'Content.class.php createConstructor() error: <br />';
			echo "Title: $name <br />Slug: $slug <br />Content: $content <br />Image: $image <br />Keywords: $keywords <br />Author: $userID";
			throw new Exception($e->getMessage());
		}

		$this->id = $this->db->lastInsertId();
		$this->name = $name;
		$this->slug = $slug;
		$this->content = $content;
		$this->image = $image;
		$this->keywords = $keywords;
	}

	// Get and set methods
	public function getID() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}

	public function getSlug() {
		return $this->slug;
	}

	public function getContent() {
		return $this->content;
	}

	public function getImage() {
		return APP_ROOT . 'images/' . $this->image;
	}

	public function getKeywords() {
		// Return the keywords in array form so they're easier to handle
		// Clean up the keywords as well, so that they're all in the same format
		$words = explode(',', $keywords);

		for ($i=0; $i < sizeof($words); $i++) { 
			$words[i] = trim($words[i]); // Remove any whitespace from the beginning and end of the string
		}

		return $words;
	}

	public function setName($name) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `name` = ? WHERE `id` = ?");
			$stmt->execute([$name, $this->id]);
		} catch (PDOException $e) {
			echo 'Content.class.php setName() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->name = $name;
	}

	public function setSlug($slug) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `slug` = ? WHERE `id` = ?");
			$stmt->execute([$slug, $this->id]);
		} catch (PDOException $e) {
			echo 'Content.class.php setSlug() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->slug = $slug;
	}

	public function setContent($content) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `content` = ? WHERE `id` = ?");
			$stmt->execute([$content, $this->id]);
		} catch (PDOException $e) {
			echo 'Content.class.php setContent() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->content = $content;
	}

	public function setImage($image) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `image` = ? WHERE `id` = ?");
			$stmt->execute([$image, $this->id]);
		} catch (PDOException $e) {
			echo 'Content.class.php setImage() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->image = $image;
	}

	public function setCategory($categoryID) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `category` = ? WHERE `id` = ?");
			$stmt->execute([$categoryID, $this->id]);
		} catch (PDOException $e) {
			echo 'Content.class.php setCategory() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->category = new Category($this->db, $categoryID);
	}

	public function setKeywords($keywords) {
		// Take an array of keywords, make them a comma separated list and store in DB
		$keywordsString = implode(',', $keywords);

		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `keywords` = ? WHERE `id` = ?");
			$stmt->execute([$keywordsString, $this->id]);
		} catch (PDOException $e) {
			echo 'Content.class.php setKeywords() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->keywords = $keywordsString;
	}
}