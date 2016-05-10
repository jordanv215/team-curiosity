<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{
	User, image, favoriteImage
};

//grab the test parameters
require_once("TeamCuriosityTest.php");

//grab the class under scrutiny
require_once("../php/classes/Autoload.php");

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
	 * timestamp of the FavoriteImage; this starts as null and is assigned later
	 * @var \DateTime $VALID_FavoriteImageDateTime
	 **/
	protected $VALID_FavoriteImageDateTime = null;
	/**
	 * user that favorites the FavoriteImage; this is for foreign key relations
	 * @var User $user
	 *
	 * image that is favorited; this is for foreign key relations
	 * @var image $image
	 **/
	protected $user = null;
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
		$this->image = new image(null, null, "This is a test", "/test/test");
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
		$FavoriteImage = new favoriteImage(null, $this->User->getUserId(), $this->image->getImageId(), $this->VALID_FavoriteImageDateTime);
		$FavoriteImage->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoFavoriteImage = favoriteImage::getFavoriteImageByUserId($this->getPDO(), $FavoriteImage->getUserId());
		$this->assertEquals($FavoriteImage + 1, $this->getConnection()->getRowCount("FavoriteImage"));
		$this->assertEquals($pdoFavoriteImage->getUserId(), $this->User->getUserId());
		$this->assertEquals($pdoFavoriteImage->getImageId(), $this->image->getImageId());
		$this->assertEquals($pdoFavoriteImage->getImageDateTime(), $this->VALID_FavoriteImageDateTime);
	}


	/**
	 * PDO Exception
	 */
publc function testInsertInvalidFavoriteImage() {
	$favoriteImage = new favoriteImage(TeamCuriosityTest::INVALID_KEY, $this->User->getUserId(), $this->image->getImageId(), $this->VALID_FavoriteImageDateTime);
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
		$favoriteImage = new favoriteImage(null, $this->user->getUserId(), $this->image->getImageId(), $this->VALID_FavoriteImageDateTime);
		$favoriteImage->delete($this->getPDO());

	}

	/**
	 * /**
	 * test grabbing a FavoriteImage that does not exist by FavoriteImageImageIdAndFavoriteImageUserId
	 **/
	public function testGetInvalidFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId() {
		//grab a FavoriteImageImageIdAndFavoriteImageUserId that exceeds the maximum allowable favoriteImageImageIdAndFavoriteImageUserId
		$favoriteImage = favoriteImage:: getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
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
		$favoriteImage = favoriteImage::getFavoriteImageByFavoriteImageUserId($this->getPDO(),TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($favoriteImage);

	}



}