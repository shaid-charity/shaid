<?php

class Pagination {
	private $db;

	protected $totalNumRecords;
	protected $limitPerPage;
	protected $totalNumPages;
	protected $firstAndBackLinks;
	protected $nextAndLastLinks;
	protected $currentPage;
	protected $beforeLinks;
	protected $afterLinks;

	// The query and the parameters needed for the prepared statement
	protected $query;
	protected $params;

	public function __construct($db, $query, array $params) {
		$this->db = $db;
		$this->query = $query;
		$this->params = $params;

		// So we can concatenate later on
		$this->beforeLinks = '';
		$this->afterLinks = '';
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

		// Generate links to the previous page
		if ($pageNum > 1) {
			$prevPage = $pageNum - 1;

			$this->firstAndBackLinks = "<li><a class='button-dark button-smaller' href='" . $fileAndParams . "page=$prevPage'>&laquo;</a></li>";
		} else {
			$this->firstAndBackLinks = "<li><a class='button-dark button-smaller disabled' href='" . $fileAndParams . "page=$prevPage'>&laquo;</a></li>";
		}

		// Get the surrounding couple of page numbers as well, if possible

		if ($this->totalNumPages > 1) {
			// Get (up to) two page numbers < the current page
			$i = $pageNum;
			$j = 0;

			while ($i > 1 && $j < 2) {
				$i--;
				$this->beforeLinks .= "<li><a class='button-dark button-smaller' href='" . $fileAndParams . "page=$i'>$i</a></li>";
				$j++;
			}

			// Get (up to) two page numbers > the current page
			$i = $pageNum;
			$j = 0;

			while ($i < $this->totalNumPages && $j < 2) {
				$i++;
				$this->afterLinks .= "<li><a class='button-dark button-smaller' href='" . $fileAndParams . "page=$i'>$i</a></li>";
				$j++;
			}
		}

		$this->currentPage = "<li'><a class='button-dark-filled button-smaller' href='#'>$pageNum</a></li>";

		// Generate links to the next page
		if ($pageNum < $this->totalNumPages) {
			$nextPage = $pageNum + 1;

			$this->nextAndLastLinks = "<li><a class='button-dark button-smaller' href='" . $fileAndParams . "page=$nextPage'>&raquo;</a></li>";
		} else {
			$this->nextAndLastLinks = "<li><a class='button-dark button-smaller disabled' href='" . $fileAndParams . "page=$nextPage'>&raquo;</a></li>";
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

	public function getBeforeLinks() {
		return $this->beforeLinks;
	}

	public function getAfterLinks() {
		return $this->afterLinks;
	}
}

?>