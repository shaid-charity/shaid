<?php

class Company {
	protected $db;

	private $id;
	private $name;
	private $url;
	private $iconPath;

	public function __construct($db, $id) {
		$this->db = $db;

		$stmt = $this->db->prepare("SELECT * FROM companies WHERE id = ?");
		$stmt->execute(array($id));
		$result = $stmt->fetch();

		$this->id = $result['id'];
		$this->name = $result['name'];
		$this->url = $result['url'];
		$this->iconPath = $result['icon'];
	}

	public function getID() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getURL() {
		return $this->url;
	}

	public function getIconPath() {
		return '/' . INSTALLED_DIR . '/' . $this->iconPath;
	}
}