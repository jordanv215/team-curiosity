<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{Image};

// grab the project test parameters
require_once(dirname(__DIR__) . "/PHP/classes/autoload.php");

/**
 * Full PHPUnit test for the Image class
 * 
 * This is a complete PHPUnit test of the Image class. It is complete because *ALL* mySOL/PDO enabled methods are tested for both invalid and valid inputs
 * 
 * @see Image
 **/
class ImageTest extends TeamCuriosityTest {
	/**
	 * description of the Image
	 * @var string $VALID_IMAGEDESCRIPTION
	 **/
	protected $VALID_DESCRIPTION = "PHPUnit test passing";
	/**
	 * description of the updated Image
	 * @var string $VALID_IMAGEDESCRIPTION2
	 **/
	protected $VALID_IMAGEDESCRIPTION2 = "PHPUnit test still passing";
	/**
	 * timestamp of the Image; this starts as null and is assigned later
	 * @var DateTime $VALID_IMAGEEARTHDATE
	 **/
	protected $VALID_IMAGEEARTHDATE = null;

	/**
	 *create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile to own the test FavoriteNewsArticle
		$this->image = new Image(null, "test@phpunit.de", 12345, "Test Test");
		$this->image->insert($this->getPDO());

		// create and insert a NewsArticle to own the test FavoriteNewsArticle
		$this->image = new Image(null, null, "This is a test", "/test/test");
		$this->image->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_IMAGEEARTHDATE = new \DateTime();
	}

	/**
	 * test inserting a valid Image and verify that the actual mySQL data matches
	 **/
	public function testInsertValidImage() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("FavoriteNewsArticle");

		//create a new image and insert into mySQL
		$image = new image(null, $this->image->getImageId(), $this->VALID_IMAGEEARTHDATE);
		$image->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoImage = Image::getFavoriteNewsArticleByUserId($this->getPDO(), $image->getImageId());
		$this->assertEquals($image + 1, $this->getConnection()->getRowCount("Image"));
		$this->assertEquals($pdoImage->getImageId(), $this->Image->getImageId());
		$this->assertEquals($pdoImage->getImageId(), $this->image>getImageId());
		$this->assertEquals($pdoImage->getImageEarthDate(), $this->VALID_IMAGEEARTHDATE);
	}

}