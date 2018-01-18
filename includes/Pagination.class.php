<?php

class Pagination {
	private $db;

	protected $totalNumRecords;
	protected $limitPerPage;
	protected $totalNumPages;
	protected $firstAndBackLinks;
	protected $nextAndLastLinks;
	protected $currentPage;

	// The query and the parameters needed for the prepared statement
	protected $query;
	protected $params;

	public function __construct($db, $query, array $params) {
		$this->db = $db;
		$this->query = $query;
		$this->params = $params;
	}

	public function totalRecords() {
		$stmt = $this->db->prepare($this->query);
		$stmt->execute($this->params);

		$this->totalNumRecords = $stmt->rowCount();

		if (!$this->totalNumRecords) {
			throw new Exception('No records were found!');
		}
	}

	public function setLimitPerPage($limitPerPage) {
		$this->limitPerPage = $limitPerPage;

		// Calculate the number of pages needed
		if (!empty($this->totalNumRecords)) {
			$this->totalNumPages = ceil($this->totalNumRecords / $this->limitPerPage);
		}
	}

	// Get the current page
	public function getPage() {
		// The current PHP file and any parameters (excluding the page parameter)
		$fileAndParams = $_SERVER['PHP_SELF'] . '?';

		foreach ($_GET as $param => $value) {
			// We don't want to include the page parameter
			if ($param == 'page') {
				continue;
			}

			$fileAndParams = $fileAndParams . $param . '=' . $value . '&';
		}

		$pageNum = (int) (isset($_GET['page'])) ? $_GET['page'] : $pageNum = 1;

		// Make sure we are within the range 1 - totalNumPages
		if ($pageNum > $this->totalNumPages) {
			$pageNum = $this->totalNumPages;
		} else if ($pageNum < 1) {
			$pageNum = 1;
		}

		// Generate links to page 1 and the previous page
		if ($pageNum > 1) {
			$prevPage = $pageNum - 1;

			$this->firstAndBackLinks = "<div class='first-last'><a href='" . $fileAndParams . "page=1'>First</a> <a href='". $fileAndParams . "page=$prevPage'>Back</a></div>";
		}

		$this->currentPage = "<div class='page-count'>(Page $pageNum of $this->totalNumPages)</div>";

		// Generate links to the last page and the next page
		if ($pageNum < $this->totalNumPages) {
			$nextPage = $pageNum + 1;

			$this->nextAndLastLinks = "<div class='next-last'><a href='" . $fileAndParams . "page=$nextPage'>Next</a> <a href='" . $fileAndParams . "page=$this->totalNumPages'>Last</a></div>";
		}

		return $pageNum;
	}

	// Just some get methods now
	public function getFirstAndBackLinks() {
		return $this->firstAndBackLinks;
	}

	public function getCurrentPageLinks() {
		return $this->currentPage;
	}

	public function getNextAndLastLinks() {
		return $this->nextAndLastLinks;
	}
}

?>