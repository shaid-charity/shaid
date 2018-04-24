<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PostTest extends TestCase {

	private $db;
	private static $newID;
	private static $categoryID;

	// Called before the tests are ran
	public static function setUpBeforeClass() {
		$db = new PDO('mysql:host=localhost;dbport=8889;dbname=gp_test;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock', 'root', 'root');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);

		// Create a test category
		$db->query("INSERT INTO `categories`(name) VALUES ('Manual Category')");

		$categoryID = $db->lastInsertId();
		self::$categoryID = $categoryID;

		$db->query("INSERT INTO `posts`(title, content, image, category_id) VALUES ('Test Post', 'Some content', 'image.jpg', '$categoryID')");
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
		$db->query('DELETE FROM `categories`');
		$db->query('DELETE FROM `posts`');
		$db->query('DELETE FROM `campaigns`');
	}

	public function testCreate() {
		$post = new Post($this->db, null, 'Create Test Post', 'create', 'Creation worked!', 'test.jpg', 1, '', self::$categoryID);

		$this->assertInstanceOf(
			Post::class,
			$post
		);
	}

	public function testGetByID() {
		$this->assertInstanceOf(
			Post::class,
			new Post($this->db, self::$newID)
		);
	}

	public function testSetLastModifiedDatetime() {
		$post = new Post($this->db, null, 'Create Test Post', 'create', 'Creation worked!', 'test.jpg', 1, '', self::$categoryID);
		$post->setCategory(self::$categoryID); // This will also update last modified date time

		$this->assertNotNull($post->getLastModifiedDate());
	}

	public function testSetCategory() {
		// Create a test category
		$this->db->query("INSERT INTO `categories`(name) VALUES ('Test Category')");

		$categoryID = $this->db->lastInsertId();

		$post = new Post($this->db, null, 'Create Test Post', 'create', 'Creation worked!', 'test.jpg', 1, '', self::$categoryID);
		$post->setCategory($categoryID);

		$this->assertEquals(
			$post->getCategory()->getID(),
			$categoryID
		);
	}

	public function testSetIncorrectCategory() {
		$this->expectException(Exception::class);

		$post = new Post($this->db, null, 'Create Test Post', 'create', 'Creation worked!', 'test.jpg', 1, '', self::$categoryID);
		$post->setCategory(1111111); // Category doesn't exist
	}

	public function testSetCampaign() {
		// Create a test campaign
		$this->db->query("INSERT INTO `campaigns`(title) VALUES ('Test Campaign')");

		$campaignID = $this->db->lastInsertId();

		$post = new Post($this->db, null, 'Create Test Post', 'create', 'Creation worked!', 'test.jpg', 1, '', self::$categoryID);
		$post->setCampaign($campaignID);

		$this->assertEquals(
			$post->getCampaign()->getID(),
			$campaignID
		);
	}

	public function testSetIncorrectCampaign() {
		$this->expectException(Exception::class);

		$post = new Post($this->db, null, 'Create Test Post', 'create', 'Creation worked!', 'test.jpg', 1, '', self::$categoryID);
		$post->setCampaign(1111111); // Campaign doesn't exist
	}

	public function testSetPublishedTrue() {
		$post = new Post($this->db, null, 'Create Test Post', 'create', 'Creation worked!', 'test.jpg', 1, '', self::$categoryID);
		$post->setPublished(true);

		$this->assertEquals(
			$post->isPublished(),
			true
		);
	}

	public function testSetPublishedFalse() {
		$post = new Post($this->db, null, 'Create Test Post', 'create', 'Creation worked!', 'test.jpg', 1, '', self::$categoryID);
		$post->setPublished(false);

		$this->assertEquals(
			$post->isPublished(),
			false
		);
	}

	public function testSetPblishedIncorrect() {
		$post = new Post($this->db, null, 'Create Test Post', 'create', 'Creation worked!', 'test.jpg', 1, '', self::$categoryID);
		$post->setPublished("boop");

		$this->assertEquals(
			$post->isPublished(),
			true
		);
	}
}

?>