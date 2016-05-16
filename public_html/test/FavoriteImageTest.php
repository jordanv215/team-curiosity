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
	 * timestamp of the FavoriteImage; this starts as null and is assigned later
	 * @var \DateTime $VALID_FavoriteImageDateTime
	 **/
	protected $image = null;
	/**
	 * user that favorites the FavoriteImage; this is for foreign key relations
	 * @var User $user
	 **/
	 protected $user = null;
	 /** 
	 * image that is favorited; this is for foreign key relations
	 * @var image $image
	 **/
	protected $VALID_FAVORITEIMAGEDATETIME = null;


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
		$this->VALID_FAVORITEIMAGEDATETIME = new \DateTime();
	}


	/**
	 * test inserting a valid FavoriteImage and verify that the actual mySQL data matches
	 **/
	public function testInsertValidFavoriteImage() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("FavoriteImage");

		//create a new FavoriteImage and insert into mySQL
		$favoriteImage = new FavoriteImage(null, $this->user->getUserId(), $this->image->getImageId(), $this->VALID_FAVORITEIMAGEDATETIME);
		$favoriteImage->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoFavoriteImage = FavoriteImage::getFavoriteImageByUserId($this->getPDO(), $favoriteImage->getUserId());
		$this->assertEquals($favoriteImage + 1, $this->getConnection()->getRowCount("FavoriteImage"));
		$this->assertEquals($pdoFavoriteImage->getUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteImage->getImageId(), $this->image->getImageId());
		$this->assertEquals($pdoFavoriteImage->getImageDateTime(), $this->VALID_FAVORITEIMAGEDATETIME);
	}


	/**
	 * test inserting an invalid favorite image
	 * @ Expected Exception \PDO Exception
	 **/
	public function testInsertInvalidFavoriteImage() {
		$favoriteImage = new FavoriteImage(TeamCuriosityTest::INVALID_KEY, $this->image->getImageId(), $this->VALID_FAVORITEIMAGEDATETIME);
		$favoriteImage->insert($this->getPDO());
	}

	/**
	 * test to create favoriteImage and then delete it
	 *
	 **/
	public function testDeleteValidFavoriteImage() {
		//count the number of rows, save
		$numRows = $this->getConnection()->getRowCount("FavoriteImage");

		//create a favoriteImage and insert into mySQL
		$favoriteImage = new FavoriteImage(null, $this->user->getUserId(), $this->image->getImageId(), $this->VALID_FAVORITEIMAGEDATETIME);
		$favoriteImage->insert($this->getPDO());

		// delete the favoriteImage from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteImage"));
		$favoriteImage->delete($this->getPDO());

		// grab the data from mySQL and enforce that the fields match our expectations
		$pdoFavoriteImage = FavoriteImage::getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId($this->getPDO(), $favoriteImage->getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId());
		$this->assertNull($pdoFavoriteImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("FavoriteImage"));
	}

	/**
	 * Test to delete a favoriteImage that doesn't exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidFavoriteImage() {
		$favoriteImage = new FavoriteImage(null, $this->user->getUserId(), $this->image->getImageId(), $this->VALID_FAVORITEIMAGEDATETIME);
		$favoriteImage->delete($this->getPDO());

	}

	/**
	 * test grabbing a FavoriteImage by ImageId and UserId
	 **/
	public function testGetFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId() {
		// count number of rows
		$numRows = $this->getConnection()->getRowCount("FavoriteImage");

		// create a new FavoriteImage and insert to into mySQL
		$favoriteImage = new FavoriteImage(null, $this->user->getUserId(), $this->image->getImageId(), $this->VALID_FAVORITEIMAGEDATETIME);
		$favoriteImage->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavoriteImage = FavoriteImage::getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId($this->getPDO(), $favoriteImage->getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteImage"));
		$this->assertEquals($pdoFavoriteImage->getFavoriteImageUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteImage->getFavoriteImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoFavoriteImage->getFavoriteImageDateTime(), $this->VALID_FAVORITEIMAGEDATETIME);
		$favoriteImage = FavoriteImage::getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId($this->getPDO());
		return($favoriteImage);
	}

	/**
	 * test grabbing a FavoriteImage by favoriteImageImageId
	 **/
	public function testGetFavoriteImageByFavoriteImageImageId() {
		//count number of rows
		$numRows = $this->getConnection()->getRowCount("FavoriteImage");


		//create a favorite image and insert into table
		$favoriteImage = new FavoriteImage($this->image->getImageId(), $this->user->getUserId(),$this->VALID_FAVORITEIMAGEDATETIME);
		$favoriteImage->insert($this->getPDO());


		//grab the data from mySQL and enforce that the fields match our expectations
		$results = FavoriteImage::getFavoriteImageByFavoriteImageImageId($this->getPDO(), $favoriteImage->getFavoriteImageImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\FavoriteImage", $results);


		// grab the result from the array and validate it
		$pdoFavoriteImage = $results[0];
		$this->assertEquals($pdoFavoriteImage->getFavoriteImageUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteImage->getFavoriteImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoFavoriteImage->getFavoriteImageDateTime(), $this->VALID_FAVORITEIMAGEDATETIME);
	}

	/**
	 * Test grabbing a favoriteImage by favoriteImageUserId
	 *
	 **/
	public function testGetFavoriteImageByFavoriteImageUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("FavoriteImage");



		//create a favorite image and insert into mySQL
		$favoriteImage = new FavoriteImage($this->image->getImageId(), $this->user->getUserId(),$this->VALID_FAVORITEIMAGEDATETIME);
		$favoriteImage->insert($this->getPDO());


		//grab the data from mySQL and enforce that the fields match our expectations
		$results = FavoriteImage::getFavoriteImageByFavoriteImageUserId($this->getPDO(), $favoriteImage->getFavoriteImageUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\FavoriteImage", $results);


		// grab the result from the array and validate it
		$pdoFavoriteImage = $results[0];
		$this->assertEquals($pdoFavoriteImage->getFavoriteImageUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteImage->getFavoriteImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoFavoriteImage->getFavoriteImageDateTime(), $this->VALID_FAVORITEIMAGEDATETIME);
	}

	/**
	 * test grabbing all favoriteImages
	 **/
	public function testGetAllFavoriteImages() {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("FavoriteImage");

		// create a new FavoriteImage and insert into mySQL
		$favoriteImage = new FavoriteImage(null, $this->user->getUserId(), $this->image->getImageId(), $this->VALID_FAVORITEIMAGEDATETIME);
		$favoriteImage->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = FavoriteImage::getAllFavoriteImages($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstanceOf("Edu\\Cnm\\TeamCuriosity\\FavoriteImage", $results);

		//grab the result from the array and validate it
		$pdoFavoriteImage = $results[0];
		$this->assertEquals($pdoFavoriteImage->getUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteImage->getImageId(), $this->image->getImageId());
		$this->assertEquals($pdoFavoriteImage->getFavoriteImageDateTime(), $this->VALID_FAVORITEIMAGEDATETIME);

	}


}