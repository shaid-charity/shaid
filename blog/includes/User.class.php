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
	private $resetHash;
	private $resetRequestTime;

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
		$this->resetHash = $result['password_reset_hash'];
		$this->resetRequestTime = strtotime($result['password_reset_request_datetime']);

		if (is_null($this->avatarPath) || $this->avatarPath == '') {
			$this->avatarPath = '../assets/img/placeholder/profile_photo.png';
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

	public function getProfileLink() {
		return '/' . INSTALLED_DIR . '/viewprofile.php?id=' . $this->id;
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
		return '/' . INSTALLED_DIR . '/' . substr($this->avatarPath, 2);
	}

	public function getPasswordResetHash() {
		return $this->resetHash;
	}

	public function generatePasswordResetHash() {
		$salt = generateSalt();
		$hash = hash("sha256", time() . $salt);

		try {
			$stmt = $this->db->prepare("UPDATE `users` SET `password_reset_salt` = ?, `password_reset_hash` = ?, `password_reset_request_datetime` = NOW() WHERE `user_id` = ?");
			$stmt->execute([$salt, $hash, $this->id]);
		} catch (Exception $e) {
			return false;
		}

		$this->resetHash = $hash;
		return true;
	}

	public function isResetWithinTimeframe() {
		// Check it has been less than 24 hours since the password reset has been requested
		// 86400 is 24 hours in seconds
		return time() <= ($this->resetRequestTime + 86400);
	}

	public function resetPassword($givenHash, $newPassword) {
		// Check the given hash is the same as the has in the DB
		if ($givenHash != $this->resetHash) {
			return false;
		}

		// Check the link has been accessed within 24 hours
		if(!$this->isResetWithinTimeframe()) {
			return false;
		}

		// If we have gotten this far, we can reset the password
		$salt = generateSalt();
		$hash = hash("sha256", getValidData($newPassword) . $salt);

		try {
			// Also remove the reset hash so the same link cannot be used again
			$stmt = $this->db->prepare("UPDATE `users` SET `pass_salt` = ?, `pass_hash` = ?, `password_reset_hash` = ?, `password_reset_salt` = ?  WHERE `user_id` = ?");
			$stmt->execute([$salt, $hash, "", "", $this->id]);
		} catch (Exception $e) {
			return "db error";
		}

		return true;
	}
}
