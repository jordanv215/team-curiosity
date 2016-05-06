<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{User, Image, CommentImage};

// grab the test parameters
require_once("TeamCuriosityTest.php");

// grab the class to be tested
require_once(dirname(__DIR__) . "/php/classes/Autoload.php");

/**
 * Full PHPUnit test for the CommentImage class
 * 
 * This is a complete test of the CommentImage class. It tests all PDO-enabled methods for valid and invalid inputs.
 * 
 * @see CommentImage
 * @author Kai Garrott <garrottkai@gmail.com>
 */

class CommentImageTest extends TeamCuriosityTest {
	/**
	 * content of the image comment
	 * @var string $VALID_COMMENT_IMAGE_CONTENT
	 */
	protected $VALID_COMMENT_IMAGE_CONTENT = "You are experiencing incredible success";
	/**
	 * content of the updated image comment
	 * @var string $VALID_COMMENT_IMAGE_CONTENT2
	 */
	protected $VALID_COMMENT_IMAGE_CONTENT2 = "More incredible success";
	/**
	 * timestamp of the image comment - assigned by mySQL
	 * @var DateTime $VALID_COMMENT_IMAGE_DATE_TIME
	 */
	protected $VALID_COMMENT_IMAGE_DATE_TIME = null;
	/**
	 * id of user that created the comment - a foreign key relation
	 *  @todo what goes here?
	 * @var User
	 */
	protected $commentImageUserId = null;
	/**
	 * id of photo that was commented on; foreign key relation
	 * @todo what about here?
	 * @var
	 */
	protected $commentImageImageId = null;

	/**
	 * create dependent objects before running test
	 */
	public final function setUp() {
		// runs the default setUp() method first
		parent::setUp();

		// create and insert user to make the comment
		$this->User = new User(null, "test@phpunit.de", 123456789, "Test Test"); // @todo pretty sure this is incorrect
		$this->User->insert($this->getPDO());

		// calculate the date, using time the test was set up
		$this->VALID_COMMENT_IMAGE_DATE_TIME = new \DateTime();
	}

	/**
	 * test inserting a valid image comment and verifying that the mySQL data matches
	 */
	public function testInsertValidCommentImage() {
		// count the number of rows
		$numRows = $this->getConnection()->getRowCount("CommentImage");

		// create a new image comment and insert into table
		$CommentImage = new CommentImage(null, $this->commentImageUserId, $this->commentImageImageId, $this->VALID_COMMENT_IMAGE_CONTENT, $this->VALID_COMMENT_IMAGE_DATE_TIME);
		$CommentImage->insert($this->getPDO());

		// grab data from table and enforce that fields match expectations
		$pdoCommentImage = CommentImage::getCommentImageByCommentImageId($this->getPDO(), $CommentImage->getCommentImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentImage"));
		$this->assertEquals($pdoCommentImage->getCommentImageUserId(), $this->commentImageUserId);
		$this->assertEquals($pdoCommentImage->getCommentImageImageId(), $this->commentImageImageId);
		$this->assertEquals($pdoCommentImage->getCommentImageContent(), $this->VALID_COMMENT_IMAGE_CONTENT);
		$this->assertEquals($pdoCommentImage->getCommentImageDateTime(), $this->VALID_COMMENT_IMAGE_DATE_TIME);
	}
	
	/**
	 * test inserting a comment that already exists
	 * 
	 * @expectedException PDOException
	 */
	public function testInsertInvalidCommentImage() {
		// create an image comment with a non-null id; it should fail
		$CommentImage = new CommentImage(TeamCuriosityTest::INVALID_KEY, $this->VALID_COMMENT_IMAGE_CONTENT, $this->VALID_COMMENT_IMAGE_DATE_TIME, $this->commentImageImageId, $this->commentImageUserId);
		$CommentImage->insert($this->getPDO());
	}
	
	/**
	 * test inserting an image comment, editing it, and then updating it
	 */
	
}