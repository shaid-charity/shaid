<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CategoryTest extends TestCase {

	private $db;
	private static $newID;

	// Called before the tests are ran
	public static function setUpBeforeClass() {
		$db = new PDO('mysql:host=localhost;dbport=8889;dbname=gp_test;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock', 'root', 'root');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);

		// Create a test category
		$db->query("INSERT INTO `categories`(name) VALUES ('Manual Category')");
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
		$db->query('TRUNCATE FROM `categories`');
	}

	public function testCreate() {
		$cat = new Category($this->db, null, 'Test category');

		$this->assertInstanceOf(
			Category::class,
			$cat
		);
	}

	public function testGetByID() {	
		$cat = new Category($this->db, self::$newID);

		$this->assertInstanceOf(
			Category::class,
			$cat
		);
	}

	public function testGetByName() {
		$this->assertInstanceOf(
			Category::class,
			new Category($this->db, 0, 'Test category')
		);
	}

	public function testGetID() {
		$cat = new Category($this->db, self::$newID);

		$this->assertEquals(self::$newID, $cat->getID());
	}

	public function testGetName() {
		$cat = new Category($this->db, self::$newID);

		$this->assertEquals('Manual Category', $cat->getName());
	}

	public function testSetName() {
		$cat = new Category($this->db, self::$newID);
		$cat->setName('A new name');

		$this->assertEquals('A new name', $cat->getName());
	}

	public function testSetNameEmpty() {
		$cat = new Campaign($this->db, self::$newID);
		$cat->setName('');

		$this->assertEquals('', $cat->getTitle());
	}

	public function testSetNameLong() {
		$cat = new Campaign($this->db, self::$newID);
		$cat->setName(str_repeat('i', 999999));

		$this->assertEquals(str_repeat('i', 999999), $cat->getTitle());
	}

	public function testSetNameTooLong() {
		$this->expectException(Exception::class);
		$cat = new Campaign($this->db, self::$newID);
		$cat->setName(str_repeat('i', 9999999));
	}

	public function testDelete() {
		$cat = new Category($this->db, self::$newID);
		$cat->delete();

		$this->expectException(Exception::class);

		// Try to get the category with the ID of the one we just deleted. Should raise an exception
		$c = new Category($this->db, self::$newID);
	}
}

?>