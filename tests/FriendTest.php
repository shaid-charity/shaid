<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class FriendTest extends TestCase {

	private $db;
	private static $newID;

	public static function setUpBeforeClass() {
		$db = new PDO('mysql:host=localhost;dbport=8889;dbname=gp_test;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock', 'root', 'root');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);

		$db->query("INSERT INTO `friends`(email, fname, sname) VALUES ('unit@tests.com', 'Unit', 'Test Example')");
		self::$newID = $db->lastInsertId();
	}

	// Called before every single test method
	public function setUp() {
		$this->db = new PDO('mysql:host=localhost;dbport=8889;dbname=gp_test;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock', 'root', 'root');
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$this->db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
	}

	// Called after ALL tests
	public static function tearDownAfterClass() {
		$db = new PDO('mysql:host=localhost;dbport=8889;dbname=gp_test;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock', 'root', 'root');
		$db->query('DELETE FROM `friends`');
	}

	public function testIDConstructor() {
		
		$this->assertInstanceOf(
			Friend::class,
			new Friend($this->db, self::$newID)
		);
	}

	public function testInvalidEmail() {
		$this->expectException(Exception::class);

		// Create a valid object
		$friend = new Friend($this->db, null, "example@example.com", "Test", "InvalidEmail");

		// Try to change the email to an invalid one
		$friend->setEmail('thisisinvalid');
	}

	public function testGetByEmail() {
		$this->assertInstanceOf(
			Friend::class,
			new Friend($this->db, null, 'unit@tests.com'));
	}

	public function testEmailAlreadyExists() {
		$this->expectException(Exception::class);

		$friend = new Friend($this->db, null, 'unit@tests.com', 'Test', 'Email Exists');
	}

	public function testGetID() {
		$f = new Friend($this->db, self::$newID);

		$this->assertEquals(self::$newID, $f->getID());
	}

	public function testGetEmail() {
		$f = new Friend($this->db, self::$newID);

		$this->assertEquals('unit@tests.com', $f->getEmail());
	}

	public function testGetForename() {
		$f = new Friend($this->db, self::$newID);

		$this->assertEquals('Unit', $f->getForename());
	}

	public function testGetSurname() {
		$f = new Friend($this->db, self::$newID);

		$this->assertEquals('Test Example', $f->getSurname());
	}

	public function testSetEmail() {
		$f = new Friend($this->db, self::$newID);
		$f->setEmail('anew@email.com');

		$this->assertEquals('anew@email.com', $f->getEmail());
	}

	public function testSetForename() {
		$f = new Friend($this->db, self::$newID);
		$f->setForename('New');

		$this->assertEquals('New', $f->getForename());
	}

	public function testSetSurname() {
		$f = new Friend($this->db, self::$newID);
		$f->setSurname('Name');

		$this->assertEquals('Name', $f->getSurname());
	}

	public function testDeleteFromDB() {
		$this->expectException(Exception::class);

		$f = new Friend($this->db, self::$newID);
		$f->deleteFromDB();

		$newF = new Friend($this->db, self::$newID);
	}
}

?>