<?php

class UploadManager {
	// Some settings, set to their defaults
	private $uploadLocation = "../images/";
	private $filename = "name.ext";
	private $allowedExtensions = array("image/jpeg", "image/png");

	// Allow the above settings to be changed as needed
	public function setUploadLocation($newLocation) {
		$this->uploadLocation = $newLocation;
	}

	public function setFilename($newFilename) {
		$this->filename = $newFilename;
	}

	public function setAllowedExtensions($newAllowed) {
		if (is_array($newAllowed)) {
			$this->allowedExtensions = $newAllowed;
		} else {
			$this->allowedExtensions = array($newAllowed);
		}
	}

	// Some helper functions we will use throughout the rest of this class
	public function getFileExtension($file) {
		$info = finfo_open(FILEINFO_MIME_TYPE);
		$ext = finfo_file($info, $file['tmp_name']);
		finfo_close($info);

		return $ext;
	}

	public function validateFile($file) {
		// Check that the file exists
		if (empty($file['name'])) {
			return "Error: File not found!";
		}

		// Check it is the correct type
		$fileExtension = $this->getFileExtension($file);
		if (!in_array($fileExtension, $this->allowedExtensions)) {
			return "Error: File type not allowed!";
		}

		return true;
	}

	// Upload a file
	public function upload($file) {
		$isValid = $this->validateFile($file);

		// If the file is not valid, return the error message
		if (!$isValid) {
			return $isValid;
		}

		// Otherwise we can upload the file
		$location = $this->uploadLocation . $this->filename;

		if (!is_dir($this->uploadLocation)) {
			return '<strong>Incorrect directory set!</strong>';
		}
		
		if (!is_writable($this->uploadLocation)) {
			return "<strong>Incorrect permissions on directory!</strong>";
		}

		if (move_uploaded_file($file['tmp_name'], $location)) {
			return true;
		} else {
			return "Error: Permissions error.";
		}
	}

	// Delete a file
	public function delete($filename) {
		// Check the file exists
		if (!file_exists($filename)) {
			return 'Error: File not found!';
		}

		unlink($filename);
		return true;
	}

	public function getPath() {
		return $this->uploadLocation . $this->filename;
	}
}