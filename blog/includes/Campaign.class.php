<?php

class Campaign extends Content {
	// Name of the table the content resides in
	protected $table = 'campaigns';

	private $startDatetime;
	private $endDatetime;
	private $goalAmount;
	private $amountRaised;

	public function __construct($db, $id = null, $name = null, $slug = null, $content = null, $image = null, $author = null, $startDatetime = null, $endDatetime = null, $goalAmount = null, $amountRaised = null, $imageCaption = null) {
		$this->db = $db;

		// Get by slug
		if (is_null($id) && is_null($name) && !is_null($slug) && is_null($content) && is_null($image) && is_null($author) && is_null($startDatetime)) {
			$this->getBySlug($slug);
			return;
		} else if (!is_null($id) && is_null($name) && is_null($content) && is_null($image) && is_null($author) && is_null($startDatetime)) {
			$this->getByID($id);
			return;
		}

		parent::__construct($db, $id, $name, $slug, $content, $image, $author, '', $imageCaption);

		// Set the other properties
		$this->setStartDatetime($startDatetime);
		$this->setEndDatetime($endDatetime);
		$this->setGoalAmount($goalAmount);
		$this->setAmoutRaised($amountRaised);
	}

	public function getByID($id) {
		parent::getByID($id);

		$stmt = $this->db->prepare("SELECT * FROM `$this->table` WHERE `id` = ?");
		$stmt->execute([$id]);
		$result = $stmt->fetch();

		if (!$stmt->rowCount()) {
			throw new Exception("No campaign with ID $id");
		}

		$this->startDatetime = $result['start_datetime'];
		$this->endDatetime = $result['end_datetime'];
		$this->goalAmount = $result['goal_amount'];
		$this->amountRaised = $result['amount_raised'];
	}

	public function getBySlug($slug) {
		$title = str_replace("-", " ", $slug);
		parent::getBySlug($slug);

		$stmt = $this->db->prepare("SELECT * FROM `$this->table` WHERE `title` = ?");
		$stmt->execute([$title]);
		$result = $stmt->fetch();

		if (!$stmt->rowCount()) {
			throw new Exception("No campaign with slug $slug");
		}

		$this->startDatetime = $result['start_datetime'];
		$this->endDatetime = $result['end_datetime'];
		$this->goalAmount = $result['goal_amount'];
		$this->amountRaised = $result['amount_raised'];
	}

	public function getStartDatetime() {
		// Format the date first
		return date("d/m/Y \a\\t H A", strtotime($this->startDatetime));
	}

	public function getStartDate() {
		return date("d/m/Y", strtotime($this->startDatetime));
	}

	public function getEndDatetime() {
		// Format the date first
		return date("d/m/Y \a\\t H A", strtotime($this->endDatetime));
	}

	public function getEndDate() {
		return date("d/m/Y", strtotime($this->endDatetime));
	}

	public function getGoalAmount() {
		return $this->goalAmount;
	}

	public function getAmountRaised() {
		return $this->amountRaised;
	}

	public function getLink() {
		$title = str_replace(" ", "-", $this->getTitle());
		return '/' . INSTALLED_DIR . '/campaigns/' . $this->getID() . '-' . $title;
	}

	public function getShortDescription() {
		return strip_tags(substr($this->getContent(), 100)) . '...';
	}

	public function setStartDatetime($startDatetime) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `start_datetime` = ? WHERE `id` = ?");
			$stmt->execute([$startDatetime, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Campaign.class.php setStartDatetime() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->startDatetime = $startDatetime;
	}

	public function setEndDatetime($endDatetime) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `end_datetime` = ? WHERE `id` = ?");
			$stmt->execute([$endDatetime, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Campaign.class.php setEndDatetime() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->endDatetime = $endDatetime;
	}

	public function setGoalAmount($goalAmount) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `goal_amount` = ? WHERE `id` = ?");
			$stmt->execute([$goalAmount, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Campaign.class.php setGoalAmount() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->goalAmount = $goalAmount;
	}

	public function setAmoutRaised($amountRaised) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `amount_raised` = ? WHERE `id` = ?");
			$stmt->execute([$amountRaised, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Campaign.class.php setAmoutRaised() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->amountRaised = $amountRaised;
	}
}
