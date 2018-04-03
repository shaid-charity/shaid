<?php

class User {
	protected $db;

	private $id;
	private $fName;
	private $lName;
	private $email;
	private $roleID;

	public function __construct($db, $id) {
		$this->db = $db;

		$stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
		$stmt->execute(array($id));
		$result = $stmt->fetch();

		$this->id = $result['user_id'];
		$this->fName = $result['first_name'];
		$this->lName = $result['last_name'];
		$this->email = $result['email'];
		$this->roleID = $result['role_id'];
	}

	public function getID() {
		return $this->id;
	}

	public function getFirstName() {
		return $this->fName;
	}

	public function getLastName() {
		return $this->lName;
	}

	public function getFullName() {
		return $this->fName . ' ' . $this->lName;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getRoleID() {
		return $this->roleID;
	}
}