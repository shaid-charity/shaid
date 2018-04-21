<?php

class Category extends DBRecord {

	// We will use dependency injection to pass the DB object to this class
	protected $db;

	// The properties of the category
	private $id;
	private $name;

	public function __construct(PDO $db, $id = null, $name = null) {
		$this->db = $db;

		// Choose the correct constructor.
		if (!is_null($id) && is_null($name)) {
			$this->getByID($id);
		} else if (is_null($id) && !is_null($name)) {
			$this->createConstructor($name);
		} else if (!is_null($id) && !is_null($name)) {
			$this->getByName($name);
		} else {
			throw new Exception('Incorrect parameters');
		}
	}

	private function getByID($id) {
		$stmt = $this->db->prepare('SELECT * FROM `categories` WHERE `id` = ?');
		$stmt->execute([$id]);
		$result = $stmt->fetch();

		// If no result was returned
		if ($result['name'] == null) {
			throw new Exception("No category with ID " . $id);
		}

		$this->id = $id;
		$this->name = $result['name'];
	}

	private function getByName($name) {
		$stmt = $this->db->prepare('SELECT * FROM `categories` WHERE `name` = ?');
		$stmt->execute([$name]);
		$result = $stmt->fetch();

		// If no result was returned
		if ($result['name'] == null) {
			throw new Exception("No category with name '" . $name . "'");
		}

		$this->id = $result['id'];
		$this->name = $result['name'];
	}

	private function createConstructor($name) {
		try {
			$stmt = $this->db->prepare('INSERT INTO `categories`(name) VALUES (?)');
			$stmt->execute([$name]);
		} catch (PDOException $e) {
			// Hopefully this will catch any DB errors (e.g. slug is not unique)
			echo $e->getMessage();
			throw new $e;
		}

		$this->id = $this->db->lastInsertId();
		$this->name = $name;
	}

	// Get and set methods
	public function getID() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getLink() {
		return '/' . INSTALLED_DIR . '/blog/' . str_replace(" ", "-",  $this->name);
	}

	public function setName($name) {
		try {
			$stmt = $this->db->prepare("UPDATE `categories` SET `name` = ? WHERE `id` = ?");
			$stmt->execute([$name, $this->id]);
		} catch (PDOException $e) {
			echo 'Category.class.php setName() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->name = $name;
	}

	public function delete() {
		try {
			$stmt = $this->db->prepare("DELETE FROM `categories` WHERE `id` = ?");
			$stmt->execute([$this->id]);
		} catch (PDOException $e) {
			echo 'Category.class.php delete() error: <br />';
			echo $e->getMessage();
		}

		// Get rid of all the properties of the object just in case someone tries to access it
		$this->id = null;
		$this->name = null;
	}
}