<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CampaignTest extends TestCase {

	private $db;
	private static $newID;

	// Called before the tests are ran
	public static function setUpBeforeClass() {
		$db = new PDO('mysql:host=localhost;dbport=8889;dbname=gp_test;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock', 'root', 'root');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);

		// Create a test category
		$db->query("INSERT INTO `campaigns`(title) VALUES ('Manual Campaign')");
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
		$db->query('DELETE FROM `campaigns`');
	}

	public function testCreate() {
		$cam = new Campaign($this->db, null, "Test Campaign", str_replace(' ', '-', strtolower("Test Campaign")), "content", "imagePath", 1, "", "", 500, 0, "imageCaption");

		$this->assertInstanceOf(
			Campaign::class,
			$cam
		);
	}

	public function testGetByID() {	
		$cam = new Campaign($this->db, self::$newID);

		$this->assertInstanceOf(
			Campaign::class,
			$cam
		);
	}

	public function testGetID() {
		$cam = new Campaign($this->db, self::$newID);

		$this->assertEquals(self::$newID, $cam->getID());
	}

	public function testGetIDNotExist() {
		$this->expectException(Exception::class);
		$cam = new Campaign($this->db, 1111111);
	}

	public function testGetName() {
		$cam = new Campaign($this->db, self::$newID);

		$this->assertEquals('Manual Campaign', $cam->getTitle());
	}

	public function testSetName() {
		$cam = new Campaign($this->db, self::$newID);
		$cam->setName('A new name');

		$this->assertEquals('A new name', $cam->getTitle());
	}

	public function testSetNameEmpty() {
		$cam = new Campaign($this->db, self::$newID);
		$cam->setName('');

		$this->assertEquals('', $cam->getTitle());
	}

	public function testSetNameLong() {
		$cam = new Campaign($this->db, self::$newID);
		$cam->setName(str_repeat('i', 999999));

		$this->assertEquals(str_repeat('i', 999999), $cam->getTitle());
	}

	public function testSetNameTooLong() {
		$this->expectException(Exception::class);
		$cam = new Campaign($this->db, self::$newID);
		$cam->setName(str_repeat('i', 9999999));
	}

	public function testSetContent() {
		$cam = new Campaign($this->db, self::$newID);
		$cam->setContent('Some content.');

		$this->assertEquals('Some content.', $cam->getContent());
	}

	public function testSetContentEmpty() {
		$cam = new Campaign($this->db, self::$newID);
		$cam->setContent('');

		$this->assertEquals('', $cam->getContent());
	}

	public function testSetContentLong() {
		$cam = new Campaign($this->db, self::$newID);
		$cam->setContent(str_repeat('i', 999999));

		$this->assertEquals(str_repeat('i', 999999), $cam->getContent());
	}

	public function testSetContentUnicode() {
		$cam = new Campaign($this->db, self::$newID);
		$cam->setContent('©µÝ');

		$this->assertEquals('©µÝ', $cam->getContent());
	}
}

?>