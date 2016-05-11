<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{
	User, Image, FavoriteImage
};

//grab the test parameters
require_once("TeamCuriosityTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/Autoload.php");

/**
 * FULL PHPUnit test for the FavoriteImage class
 *
 * This is a complete PHPUnit test of the FavoriteImage class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see FavoriteImage
 * @author Jordan Vinson <jvinson3@cnm.edu>
 *
 **/
class FavoriteImageTest extends TeamCuriosityTest {
	/**
	 * user that favorites the FavoriteImage; this is for foreign key relations
	 * @var User $user
	 **/
	 protected $user = null;
	 /** 
	 * image that is favorited; this is for foreign key relations
	 * @var image $image
	 **/
	protected $VALID_FavoriteImageDateTime = null;
	/**
	 * timestamp of the FavoriteImage; this starts as null and is assigned later
	 * @var \DateTime $VALID_FavoriteImageDateTime
	 **/
	protected $image = null;

	/**
	 *create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile to own the test favoriteImage
		$this->user = new User(null, "test@phpunit.de", 12345, "Test Test");
		$this->user->insert($this->getPDO());

		// create and insert an image to own the test favoriteImage
		$this->image = new Image(null, null, "This is a test", "/test/test");
		$this->image->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_FavoriteImageDateTime = new \DateTime();
	}


	/**
	 * test inserting a valid FavoriteImage and verify that the actual mySQL data matches
	 **/
	public function testInsertValidFavoriteImage() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("FavoriteImage");

		//create a new FavoriteImage and insert into mySQL
		$FavoriteImage = new FavoriteImage(null, $this->User->getUserId(), $this->image->getImageId(), $this->VALID_FavoriteImageDateTime);
		$FavoriteImage->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoFavoriteImage = FavoriteImage::getFavoriteImageByUserId($this->getPDO(), $FavoriteImage->getUserId());
		$this->assertEquals($FavoriteImage + 1, $this->getConnection()->getRowCount("FavoriteImage"));
		$this->assertEquals($pdoFavoriteImage->getUserId(), $this->User->getUserId());
		$this->assertEquals($pdoFavoriteImage->getImageId(), $this->Image->getImageId());
		$this->assertEquals($pdoFavoriteImage->getImageDateTime(), $this->VALID_FavoriteImageDateTime);
	}


	/**
	 * PDO Exception
	 */
	public function testInsertInvalidFavoriteImage() {
		$favoriteImage = new FavoriteImage(TeamCuriosityTest::INVALID_KEY, $this->User->getUserId(), $this->image->getImageId(), $this->VALID_FavoriteImageDateTime);
		$favoriteImage->insert($this->getPDO());
	}

	/**
	 * test to create favoriteImage and then delete it
	 *
	 */
	public function testDeleteInvalidFavoriteImage() {
		//count the number of rows, save
		$numRows = $this->getConnection()->getRowCount("favoriteImage");

		//create a favoriteImage and insert into mySQL
		$favoriteImage = new favoriteImage(null, $this->user->getUserId(), $this->image->getImageId(), $this->VALID_FavoriteImageDateTime);
		$favoriteImage->insert($this->getPDO());

		// delete the favoriteImage from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favoriteImage"));
		$favoriteImage->delete($this->getPDO());

		// grab the data from mySQL and enforce the favoriteImage that does not exist
		$pdoFavoriteImage = FavoriteImage::getFavoriteImageByFavoriteImageIdAndFavoriteImageUserId($this->getPDO(), $favoriteImage->getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId());
		$this->assertNull($pdoFavoriteImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("FavoriteImage"));
	}

	/**
	 * Test to delete a favoriteImage that doesn't exist
	 *
	 * @expectedException \PDOException
	 */
	public function testGetInvalidFavoriteImage() {
		$favoriteImage = new FavoriteImage(null, $this->user->getUserId(), $this->image->getImageId(), $this->VALID_FavoriteImageDateTime);
		$favoriteImage->delete($this->getPDO());

	}

	/**
	 * /**
	 * test grabbing a FavoriteImage that does not exist by FavoriteImageImageIdAndFavoriteImageUserId
	 **/
	public function testGetInvalidFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId() {
		//grab a FavoriteImageImageIdAndFavoriteImageUserId that exceeds the maximum allowable favoriteImageImageIdAndFavoriteImageUserId
		$favoriteImage = FavoriteImage:: getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($favoriteImage);
	}

	/**
	 * test grabbing a FavoriteImage that does not exist by favoriteImageImageId
	 */
	public function testGetInvalidFavoriteImageByFavoriteImageImageId() {
		// grab a favoriteImageImageId that exceeds the maximum allowable favoriteImageImageId
		$favoriteImage = FavoriteImage::getFavoriteImageByFavoriteImageImageId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($favoriteImage);
	}

	/**
	 * Test grabbing a favoriteImage that doesnt exist by favoriteImageUserId
	 *
	 */
	public function testGetInvalidFavoriteImageByFavoriteImageUserId() {
		//grab a favoriteImageUserId that exceeds max allowed amount
		$favoriteImage = favoriteImage::getFavoriteImageByFavoriteImageUserId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($favoriteImage);
	}

	/**
	 * test grabbing all favoriteImage
	 */
	public function testGetAllValidFavoriteImages() {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("FavoriteImage");

		// create a new FavoriteImage and insert into mySQL
		$favoriteImage = new favoriteImage(null, $this->user->getUserId(), $this->image->getImageId(), $this->VALID_FavoriteImageDateTime);
		$favoriteImage->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = FavoriteImage::getAllFavoriteImage($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstanceOf("Edu\\Cnm\\TeamCuriosity\\Test", $results);

		//grab the result from the array and validate it
		$pdoFavoriteImage = $results[0];
		$this->assertEquals($pdoFavoriteImage->getUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteImage->getImageId(), $this->image->getImageId());
		$this->assertEquals($pdoFavoriteImage->getFavoriteImageDateTime(), $this->VALID_FavoriteImageDateTime);

	}


}