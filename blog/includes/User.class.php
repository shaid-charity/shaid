<?php

class User {
	protected $db;

	private $id;
	private $fName;
	private $lName;
	private $email;
	private $roleID;
	private $disabled;
	private $biography;
	private $company;
	private $guestBlogger;
	private $avatarPath;

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
		$this->disabled = $result['disabled'];
		$this->biography = $result['biography'];
		$this->company = new Company($this->db, $result['company_id']);
		$this->guestBlogger = $result['guest_blogger'];
		$this->avatarPath = $result['avatar'];

		if (is_null($this->avatarPath) || $this->avatarPath == 'none') {
			$this->avatarPath = 'assets/img/placeholder/profile_photo.jpg';
		}
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

	public function isDisabled() {
		return $this->disabled;
	}

	public function getBiography() {
		return $this->biography;
	}

	public function isGuestBlogger() {
		return $this->guestBlogger;
	}

	public function getCompany() {
		return $this->company;
	}

	public function getAvatarPath() {
		return '/' . INSTALLED_DIR . '/' . $this->avatarPath;
	}
}