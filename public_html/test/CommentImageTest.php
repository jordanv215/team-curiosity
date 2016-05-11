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
	 * @var \DateTime $VALID_COMMENT_IMAGE_DATE_TIME
	 */
	protected $VALID_COMMENT_IMAGE_DATE_TIME = null;
	/**
	 * user that created the comment - a foreign key relation
	 * @var User User
	 */
	protected $user = null;
	/**
	 * photo that was commented on; foreign key relation
	 * @var Image Image
	 */
	protected $image = null;

	/**
	 * create dependent objects before running test
	 */
	public final function setUp() {
		// runs the default setUp() method first
		parent::setUp();

		// create and insert user to make the comment
		$this->user = new User(null, "test@phpunit.de", 123456789, "Test Test"); // @todo pretty sure this is incorrect
		$this->user->insert($this->getPDO());

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
		$commentImage = new CommentImage(null, $this->user->getUserId(), $this->image->getImageId(), $this->VALID_COMMENT_IMAGE_CONTENT, $this->VALID_COMMENT_IMAGE_DATE_TIME);
		$commentImage->insert($this->getPDO());

		// grab data from table and enforce that fields match expectations
		$pdoCommentImage = CommentImage::getCommentImageByCommentImageId($this->getPDO(), $commentImage->getCommentImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentImage"));
		$this->assertEquals($pdoCommentImage->getCommentImageUserId(), $this->user->getUserId());
		$this->assertEquals($pdoCommentImage->getCommentImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoCommentImage->getCommentImageContent(), $this->VALID_COMMENT_IMAGE_CONTENT);
		$this->assertEquals($pdoCommentImage->getCommentImageDateTime(), $this->VALID_COMMENT_IMAGE_DATE_TIME);
	}
	
	/**
	 * test inserting a comment that already exists
	 * 
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidCommentImage() {
		// create an image comment with a non-null id; it should fail
		$commentImage = new CommentImage(TeamCuriosityTest::INVALID_KEY, $this->VALID_COMMENT_IMAGE_CONTENT, $this->VALID_COMMENT_IMAGE_DATE_TIME, $this->image->getImageId(), $this->user->getUserId());
		$commentImage->insert($this->getPDO());
	}
	
	/**
	 * test inserting an image comment, editing it, and then updating it
	 */
	public function testUpdateValidCommentImage() {
		// count number of rows in table
		$numRows = $this->getConnection()->getRowCount("CommentImage");

		// create a new image comment and insert into table
		$commentImage = new CommentImage(null, $this->VALID_COMMENT_IMAGE_CONTENT, $this->VALID_COMMENT_IMAGE_DATE_TIME, $this->image->getImageId(), $this->user->getUserId());
		$commentImage->insert($this->getPDO());

		// edit the comment and update table entry
		$commentImage->setCommentImage($this->VALID_COMMENT_IMAGE_CONTENT2);
		$commentImage->update($this->getPDO());

		// grab data from table and enforce that fields match expectations
		$pdoCommentImage = CommentImage::getCommentImageByCommentImageId($this->getPDO(), $commentImage->getCommentImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentImage"));
		$this->assertEquals($pdoCommentImage->getCommentImageContent(), $this->VALID_COMMENT_IMAGE_CONTENT2);
		$this->assertEquals($pdoCommentImage->getCommentImageDateTime(), $this->VALID_COMMENT_IMAGE_DATE_TIME);
		$this->assertEquals($pdoCommentImage->getCommentImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoCommentImage->getCommentImageUserId(), $this->user->getUserId());
	}

	/**
	 * test updating an image comment that already exists
	 *
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidCommentImage() {
		// create an image comment with a non-null id; it should fail
		$commentImage = new CommentImage($this->TeamCuriosityTest->INVALID_KEY, $this->VALID_COMMENT_IMAGE_CONTENT, $this->VALID_COMMENT_IMAGE_DATE_TIME, $this->image->getImageId(), $this->user->getUserId());
		$commentImage->update($this->getPDO());
	}

	/**
	 * test creating an image comment and then deleting it
	 */
	public function testDeleteValidCommentImage() {
		// count number of table rows
		$numRows = $this->getConnection()->getRowCount("CommentImage");

		// create a new comment and insert into table
		$commentImage = new CommentImage(null, $this->VALID_COMMENT_IMAGE_CONTENT, $this->VALID_COMMENT_IMAGE_DATE_TIME, $this->image->getImageId(), $this->user->getUserId());
		$commentImage->insert($this->getPDO());

		// delete the tweet from the table
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentImage"));
		$commentImage->delete($this->getPDO());

		// grab the data from mySQL and enforce that the image comment does not exist
		$pdoCommentImage = CommentImage::getCommentImageByCommentImageId($this->getPDO(), $commentImage->getCommentImageId());
		$this->assertNull($pdoCommentImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("CommentImage"));
	}

	/**
	 * test deleting an image comment that does not exist
	 *
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidCommentImage() {
		// create a comment and try to delete it without actually inserting it
		$commentImage = new CommentImage(null, $this->VALID_COMMENT_IMAGE_CONTENT, $this->VALID_COMMENT_IMAGE_DATE_TIME, $this->image->getImageId(), $this->user->getUserId());
		$commentImage->delete($this->getPDO());
	}

	/**
	 * test inserting an image comment and then regrabbing it from DB
	 */
	public function testGetValidCommentImageByCommentImageId() {
		// count number of rows
		$numRows = $this->getConnection()->getRowCount("CommentImage");

		// create a new image comment and insert into table
		$commentImage = new CommentImage(null, $this->VALID_COMMENT_IMAGE_CONTENT, $this->VALID_COMMENT_IMAGE_DATE_TIME, $this->image->getImageId(), $this->user->getUserId());
		$commentImage->insert($this->getPDO());

		// grab data from mySQL and enforce that fields match expectations
		$pdoCommentImage = CommentImage::getCommentImageByCommentImageId($this->getPDO(), $commentImage->getCommentImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentImage"));
		$this->assertEquals($pdoCommentImage->getCommentImageContent(), $this->VALID_COMMENT_IMAGE_CONTENT);
		$this->assertEquals($pdoCommentImage->getCommentImageDateTime(), $this->VALID_COMMENT_IMAGE_DATE_TIME);
		$this->assertEquals($pdoCommentImage->getCommentImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoCommentImage->getCommentImageUserId(), $this->user->getUserId());
	}

	/**
	 * test grabbing an image comment that does not exist
	 */
	public function testGetInvalidCommentImageByCommentImageId() {
		// grab a profile id that is out of range
		$commentImage = CommentImage::getCommentImageByCommentImageId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($commentImage);
	}

	/**
	 * test grabbing an image comment by image comment content
	 */
	public function testGetValidCommentImageByCommentImageContent() {
		// count number of rows
		$numRows = $this->getConnection()->getRowCount("CommentImage");

		// create a new image comment and insert into table
		$commentImage = new CommentImage(null, $this->VALID_COMMENT_IMAGE_CONTENT, $this->VALID_COMMENT_IMAGE_DATE_TIME, $this->image->getImageId(), $this->user->getUserId());
		$commentImage->insert($this->getPDO());

		// grab data from table and enforce that fields match expectations
		$results = CommentImage::getCommentImageByCommentImageContent($this->getPDO(), $commentImage->getCommentImageContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\CommentImage", $results);

		// grab the result from the array and validate it
		$pdoCommentImage = $results[0];
		$this->assertEquals($pdoCommentImage->getCommentImageContent(), $this->VALID_COMMENT_IMAGE_CONTENT);
		$this->assertEquals($pdoCommentImage->getCommentImageDateTime(), $this->VALID_COMMENT_IMAGE_DATE_TIME);
		$this->assertEquals($pdoCommentImage->getCommentImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoCommentImage->getCommentImageUserId(), $this->user->getUserId());
	}

	/**
	 * test grabbing an image comment by content that does not exist
	 */
	public function testGetInvalidCommentImageByCommentImageContent() {
		// grab an image comment by searching for content that does not exist
		$commentImage = CommentImage::getCommentImageByCommentImageContent($this->getPDO(), "LOL good luck");
		$this->assertCount(0, $commentImage);
	}

	/**
	 * test grabbing all image comments
	 */
	public function testGetAllCommentImage() {
		// count number of table rows
		$numRows = $this->getConnection()->getRowCount("CommentImage");

		// create a new image comment and insert into table
		$commentImage = new CommentImage(null, $this->VALID_COMMENT_IMAGE_CONTENT, $this->VALID_COMMENT_IMAGE_DATE_TIME, $this->image->getImageId(), $this->user->getUserId());
		$commentImage->insert($this->getPDO());

		// grab data from table and enforce that fields match expectations
		$results = CommentImage::getAllCommentImage($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\CommentImage", $results);

		// grab the result from the array and validate it
		$pdoCommentImage = $results[0];
		$this->assertEquals($pdoCommentImage->getCommentImageContent(), $this->VALID_COMMENT_IMAGE_CONTENT);
		$this->assertEquals($pdoCommentImage->getCommentImageDateTime(), $this->VALID_COMMENT_IMAGE_DATE_TIME);
		$this->assertEquals($pdoCommentImage->getCommentImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoCommentImage->getCommentImageUserId(), $this->user->getUserId());
	}
}