<?php

// This class essentially acts as a helper class, with a number of helper functions to be used when handling DB stuff
abstract class DBRecord {

	protected function isEmailValid($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		return true;
		}

		return false;
	}
}