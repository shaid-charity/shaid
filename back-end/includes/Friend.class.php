<?php

class Friend extends DBRecord {

	// We will use dependency injection to pass the DB object to the object
	protected $db;

	// Object properties
	private $id;
	private $email;
	private $fname;
	private $sname;
	private $type;

	/* We want two different ways of creating a Friend object: from an existin record in the DB, or a new record to be added to the DB.
	This means we need two different constructors; however, PHP does not allow this. Instead we use non-required parameters for the 
	actual constructor, and decide ourselves which method we should call. */
	public function __construct(PDO $db, $id =  null, $email = null, $fname = null, $sname = null, $type = null) {
		$this->db = $db;

		// For sanity, we will check for both the set and unset values
		if (!is_null($id) && is_null($email) && is_null($fname) && is_null($sname)) {
			// We want to get an existing record from the DB
			$this->idConstructor($id);
		} else if (is_null($id) && !is_null($email) && is_null($fname) && is_null($sname)) {
			$this->getByEmail($email);
		}
		else if (is_null($id) && !(is_null($email) && is_null($fname) && is_null($sname) && is_null($type))) {
			// We need to create a record in the DB
			$this->createConstructor($email, $fname, $sname, $type);
		} else {
			// The constructor cannot be used in this way
			throw new Exception('The Friend class cannot be initiated like that.');
		}
	}

	private function idConstructor($id) {
		// Get the friend from the DB
		$stmt = $this->db->prepare("SELECT * FROM `friends` WHERE `id` = ?");
		$stmt->execute(array($id));
		$result = $stmt->fetch();

		if ($result['email'] == null) {
			throw new Exception('No contact exists with ID ' . $id);
		}
		
		$this->id = $id;
		$this->email = $result['email'];
		$this->fname = $result['fname'];
		$this->sname = $result['sname'];
		$this->type = $result['type'];
	}

	private function getByEmail($email) {
		// Get the friend from the DB via email
		$stmt = $this->db->prepare("SELECT * FROM `friends` WHERE `email` = ?");
		$stmt->execute(array($email));
		$result = $stmt->fetch();

		if ($result['email'] == null) {
			throw new Exception('No contact exists with email ' . $email);
		}

		$this->id = $result['id'];
		$this->email = $result['email'];
		$this->fname = $result['fname'];
		$this->sname = $result['sname'];
		$this->type = $result['type'];
	}

	private function createConstructor($email, $fname, $sname, $type) {
		// Add a record to the DB and set the objects properties

		$alreadyExists = true;

		// First we need to ensure a record with the same email doesn't already exist
		try {
			$friend = new Friend($this->db, null, $email);
		} catch (Exception $e) {
			// A contact with the same email does not exist
			$alreadyExists = false;
		}

		if (!$alreadyExists) {
			if (!parent::isEmailValid($email)) {
				throw new Exception("Friend.class.php: Invalid email!");
			}

			try {
				$stmt = $this->db->prepare("INSERT INTO `friends`(email, fname, sname, type) VALUES (?, ?, ?, ?)");
				$stmt->execute(array($email, $fname, $sname, $type));
			} catch (PDOException $e) {
				echo 'Friend.class.php createConstructor() error: <br />';
				throw new Exception($e->getMessage());
			}

			$this->id = $this->db->lastInsertId();
			$this->email = $email;
			$this->fname = $fname;
			$this->sname = $sname;
			$this->type = $type;
		} else {
			// Throw an error saying the contact already exists
			throw new Exception('A contact already exists with the email ' . $email);
		}
	}

	public function setDB(PDO $db) {
		$this->db = $db;
	}

	public function getDB() {
		return $this->db;
	}

	// Get methods
	public function getID() {
		return $this->id;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getForename() {
		return $this->fname;
	}

	public function getSurname() {
		return $this->sname;
	}

	public function getType() {
		return $this->type;
	}

	// Set methods
	public function setEmail($email) {
		if (!parent::isEmailValid($email)) {
			throw new Exception("Friend.class.php: Invalid email!");
		}
		
		try {
			$stmt = $this->db->prepare("UPDATE `friends` SET `email` = ? WHERE `id` = ?");
			$stmt->execute(array($email, $this->id));
		} catch (PDOException $e) {
			echo 'Friend.class.php setEmail() error: <br />';
			throw new Exception($e->getMessage());
		}

	 	$this->email = $email;
	}

	public function setForename($fname) {
		try {
			$stmt = $this->db->prepare("UPDATE `friends` SET `fname` = ? WHERE `id` = ?");
			$stmt->execute(array($fname, $this->id));
		} catch (PDOException $e) {
			echo 'Friend.class.php setForename() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->fname = $fname;
	}

	public function setSurname($sname) {
		try {
			$stmt = $this->db->prepare("UPDATE `friends` SET `sname` = ? WHERE `id` = ?");
			$stmt->execute(array($sname, $this->id));
		} catch (PDOException $e) {
			echo 'Friend.class.php setSurname() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->sname = $sname;
	}

	public function deleteFromDB() {
		// Note that the object will still exist until the page has been served
		try {
			$stmt = $this->db->prepare("DELETE FROM `friends` WHERE `id` = ?");
			$stmt->execute(array($this->id));
		} catch (PDOException $e) {
			echo 'Friend.class.php deleteFromDB() error: <br />';
			throw new Exception($e->getMessage());
		}
	}
}

?>