<?php

class Event extends Content {
	// Name of the table the content resides in
	protected $table = 'events';

	private $startDatetime;
	private $endDatetime;
	private $campaign;
	private $closingDatetime;
	private $capacity;
	private $ticketsAvailable;
	private $ticketPrice;
	private $location;

	public function __construct($db, $id = null, $name = null, $slug = null, $content = null, $image = null, $author = null, $startDatetime = null, $endDatetime = null, $closingDatetime = null, $campaign = null, $capacity = null, $ticketsAvailable = null, $ticketPrice = null, $location = null, $imageCaption = null) {
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
		$this->setClosingDatetime($closingDatetime);
		$this->setCampaign($campaign);
		$this->setCapacity($capacity);
		$this->setTicketsAvailable($ticketsAvailable);
		$this->setTicketPrice($ticketPrice);
		$this->setLocation($location);
	}

	public function getByID($id) {
		parent::getByID($id);

		$stmt = $this->db->prepare("SELECT * FROM `$this->table` WHERE `id` = ?");
		$stmt->execute([$id]);
		$result = $stmt->fetch();

		$this->startDatetime = $result['start_datetime'];
		$this->endDatetime = $result['end_datetime'];
		$this->closingDatetime = $result['closing_datetime'];
		$this->campaign = new Campaign($this->db, $result['campaign_id']);
		$this->capacity = $result['capacity'];
		$this->ticketsAvailable = $result['tickets_available'];
		$this->ticketPrice = $result['ticket_price'];
		$this->location = $result['location'];
	}

	public function getBySlug($slug) {
		$title = str_replace("-", " ", $slug);
		parent::getBySlug($slug);

		$stmt = $this->db->prepare("SELECT * FROM `$this->table` WHERE `title` = ?");
		$stmt->execute([$title]);
		$result = $stmt->fetch();

		$this->startDatetime = $result['start_datetime'];
		$this->endDatetime = $result['end_datetime'];
		$this->closingDatetime = $result['closing_datetime'];
		$this->campaign = new Campaign($this->db, $result['campaign_id']);
		$this->capacity = $result['capacity'];
		$this->ticketsAvailable = $result['tickets_available'];
		$this->ticketPrice = $result['ticket_price'];
		$this->location = $result['location'];
	}

	public function getStartDatetime() {
		return $this->startDatetime;
	}

	public function getEndDatetime() {
		return $this->endDatetime;
	}

	public function getClosingDatetime() {
		return $this->closingDatetime;
	}

	public function getCampaign() {
		return $this->campaign;
	}

	public function getCapacity() {
		return $this->capacity;
	}

	public function getTicketsAvailable() {
		return $this->ticketsAvailable;
	}

	public function getTicketPrice() {
		return $this->ticketPrice;
	}

	public function getLocation() {
		return $this->location;
	}

	public function setStartDatetime($startDatetime) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `start_datetime` = ? WHERE `id` = ?");
			$stmt->execute([$startDatetime, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Event.class.php setStartDatetime() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->startDatetime = $startDatetime;
	}

	public function setEndDatetime($endDatetime) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `end_datetime` = ? WHERE `id` = ?");
			$stmt->execute([$endDatetime, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Event.class.php setEndDatetime() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->endDatetime = $endDatetime;
	}

	public function setClosingDatetime($closingDatetime) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `closing_datetime` = ? WHERE `id` = ?");
			$stmt->execute([$closingDatetime, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Event.class.php setClosingDatetime() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->closingDatetime = $closingDatetime;
	}

	public function setCampaign($campaignID) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `campaign_id` = ? WHERE `id` = ?");
			$stmt->execute([$campaignID, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Event.class.php setCampaign() error: <br />';
			throw new Exception($e->getMessage());
		}

		if ($campaignID == 0) {
			$this->campaign = 0;
		} else {
			$this->campaign = new Campaign($this->db, $campaignID);
		}
	}

	public function setCapacity($capacity) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `capacity` = ? WHERE `id` = ?");
			$stmt->execute([$capacity, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Event.class.php capacity() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->capacity = $capacity;
	}

	public function setTicketsAvailable($ticketsAvailable) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `tickets_available` = ? WHERE `id` = ?");
			$stmt->execute([$ticketsAvailable, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Event.class.php ticketsAvailable() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->ticketsAvailable = $ticketsAvailable;
	}

	public function setTicketPrice($ticketPrice) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `ticket_price` = ? WHERE `id` = ?");
			$stmt->execute([$ticketPrice, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Event.class.php ticketPrice() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->ticketPrice = $ticketPrice;
	}

	public function setLocation($location) {
		try {
			$stmt = $this->db->prepare("UPDATE `$this->table` SET `location` = ? WHERE `id` = ?");
			$stmt->execute([$location, $this->getID()]);
		} catch (PDOException $e) {
			echo 'Event.class.php location() error: <br />';
			throw new Exception($e->getMessage());
		}

		$this->location = $location;
	}
}