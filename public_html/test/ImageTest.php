<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{Image};

// grab the project test parameters
require_once("../php/classes/Autoload.php");

/**
 * Full PHPUnit test for the Image class
 * 
 * This is a complete PHPUnit test of the Image class. It is complete because *ALL* mySOL/PDO enabled methods are tested for both invalid and valid inputs
 * 
 * @see Image
 * @author Ellen Liu
 **/
class ImageTest extends TeamCuriosityTest {
	/**
	 * Camera of where image was taken
	 * @var string $VALID_IMAGECAMERA
	 **/
	protected $VALID_IMAGECAMERA = "Test Camera";
	/**
	 * description of the Image
	 * @var string $VALID_IMAGEDESCRIPTION
	 **/
	protected $VALID_IMAGEDESCRIPTION = "This is a test";
	/**
	 * timestamp of the Image; this starts as null and is assigned later
	 * @var \DateTime|null $VALID_IMAGEEARTHDATE
	 **/
	protected $VALID_IMAGEEARTHDATE = null;
	/**
	 * local file path of image
	 * @var $VALID_IMAGEPATH
	 **/
	protected $VALID_IMAGEPATH;
	/**
	 * martian date for image
	 * @var int $VALID_IMAGESOL
	 **/
	protected $VALID_IMAGESOL = "1234";
	/**
	 * title of image
	 * @var string $VALID_IMAGETITLE
	 **/
	protected $VALID_IMAGETITLE = "Test Title";
	/**
	 * updated title of image
	 * @var string $VALID_IMAGETITLE2
	 **/
	protected $VALID_IMAGETITLE2;
	/**
	 * invalid image title
	 * @var string $INVALID_IMAGETITLE
	 **/
	protected $INVALID_IMAGETITLE = "123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
	/**
	 * MIME type of image
	 * @var string $VALID_IMAGETYPE
	 **/
	protected $VALID_IMAGETYPE;
	/**
	 * source url of image
	 * @var $VALID_IMAGEURL
	 **/
	protected $VALID_IMAGEURL;

	/**
	 * test inserting a valid Image and verify that the actual mySQL data matches
	 **/
	public function testInsertValidImage() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Image");

		//create a new image and insert into mySQL
		$image = new Image(null, $this->VALID_IMAGECAMERA, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGEEARTHDATE, $this->VALID_IMAGEPATH, $this->VALID_IMAGESOL, $this->VALID_IMAGETITLE, $this->VALID_IMAGETYPE, $this->VALID_IMAGEURL);
		$image->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Image"));
		$this->assertEquals($pdoImage->getImageCamera(), $this->VALID_IMAGECAMERA);
		$this->assertEquals($pdoImage->getImageDescription(), $this->VALID_IMAGEDESCRIPTION);
		$this->assertEquals($pdoImage->getImageEarthDate(), $this->VALID_IMAGEEARTHDATE);
		$this->assertEquals($pdoImage->getImagePath(), $this->VALID_IMAGEPATH);
		$this->assertEquals($pdoImage->getImageSol(), $this->VALID_IMAGESOL);
		$this->assertEquals($pdoImage->getImageTitle(), $this->VALID_IMAGETITLE);
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
		$this->assertEquals($pdoImage->getImageUrl(), $this->VALID_IMAGEURL);
	}

	/**
	 * test inserting an image that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidImage() {
		// create a image with a non null image id and watch it fail
		$image = new Image(TeamCuriosityTest::INVALID_KEY, $this->VALID_IMAGECAMERA, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGEEARTHDATE, $this->VALID_IMAGEPATH, $this->VALID_IMAGESOL, $this->VALID_IMAGETITLE, $this->VALID_IMAGETYPE, $this->VALID_IMAGEURL);
		$image->insert($this->getPDO());
	}

	/**
	 * test creating an Image and then deleting it
	 **/
	public function testDeleteValidImage() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Image");

		//create a new Image and insert into mySQL
		$image = new Image(null, $this->image->getImageId(), $this->VALID_IMAGECAMERA, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGEEARTHDATE, $this->VALID_IMAGESOL, $this->VALID_IMAGETITLE);
		$image->insert($this->getPDO());

		// delete the Image from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Image"));
		$image->delete($this->getPDO());

		// grab the data from mySQL and enforce the Image does not exist
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertNull($pdoImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("Image"));
	}

	/**
	 * test deleting an Image that does not exist
	 *
	 * @expectedException \PDOException
	**/
	public function testDeleteInvalidImage() {
		// create a Image and try to delete it without actually inserting it
		$image = new Image(null, $this->image->getImageId(), $this->VALID_IMAGECAMERA, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGEEARTHDATE, $this->VALID_IMAGESOL, $this->VALID_IMAGETITLE);
		$image->delete($this->getPDO());
	}

	/**
	 * test grabbing an Image that does not exist
	 **/
	public function testGetInvalidImageByImageId() {
		// grab an image id that exceeds the maximum allowable image id
		$image = Image::getImageByImageId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($image);
	}

	/**
	 * test grabbing a Image by image camera
	 **/
	public function testGetValidImageByImageCamera() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Image");

		// create a new image and insert into mySQL
		$image = new Image(null, $this->image->getImageId(), $this->VALID_IMAGECAMERA, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGEEARTHDATE, $this->VALID_IMAGESOL, $this->VALID_IMAGETITLE);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Image::getImageByImageCamera($this->getPDO(), $image->getImageCamera());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Image"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\Test", $results);

		// grab the result from the array and validate it
		$pdoImage = $results[0];
		$this->assertEquals($pdoImage->getImageId(), $image->getImageId());
		$this->assertEquals($pdoImage->getImageByImageCamera(), $this->VALID_IMAGECAMERA);
		$this->assertEquals($pdoImage->getImageByImageDescription(), $this->VALID_IMAGEDESCRIPTION);
		$this->assertEquals($pdoImage->getImageByEarthDate(), $this->VALID_IMAGEEARTHDATE);
		$this->assertEquals($pdoImage->getImageByImageSol(), $this->VALID_IMAGESOL);
		$this->assertEquals($pdoImage->getImageByImageTitle(), $this->VALID_IMAGETITLE);
	}


	/**
	 * test grabbing an Image by image description
	 **/
	public function testGetValidImageByImageDescription() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Image");

		// create a new image and insert into mySQL
		$image = new Image(null, $this->image->getImageId(), $this->VALID_IMAGECAMERA, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGEEARTHDATE, $this->VALID_IMAGESOL, $this->VALID_IMAGETITLE);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Image::getImageByImageDescription($this->getPDO(), $image->getImageDescription());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Image"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\Test", $results);

		// grab the result from the array and validate it
		$pdoImage = $results[0];
		$this->assertEquals($pdoImage->getImageId(), $image->getImageId());
		$this->assertEquals($pdoImage->getImageByImageCamera(), $this->VALID_IMAGECAMERA);
		$this->assertEquals($pdoImage->getImageByImageDescription(), $this->VALID_IMAGEDESCRIPTION);
		$this->assertEquals($pdoImage->getImageByEarthDate(), $this->VALID_IMAGEEARTHDATE);
		$this->assertEquals($pdoImage->getImageByImageSol(), $this->VALID_IMAGESOL);
		$this->assertEquals($pdoImage->getImageByImageTitle(), $this->VALID_IMAGETITLE);
	}

	/**
	 * test grabbing an Image by image earth date
	 **/
	public function testGetValidImageByImageEarthDate() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Image");

		// create a new image and insert into mySQL
		$image = new Image(null, $this->image->getImageId(), $this->VALID_IMAGECAMERA, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGEEARTHDATE, $this->VALID_IMAGESOL, $this->VALID_IMAGETITLE);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Image::getImageByImageEarthDate($this->getPDO(), $image->getImageCamera());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Image"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\Test", $results);

		// grab the result from the array and validate it
		$pdoImage = $results[0];
		$this->assertEquals($pdoImage->getImageId(), $image->getImageId());
		$this->assertEquals($pdoImage->getImageByImageCamera(), $this->VALID_IMAGECAMERA);
		$this->assertEquals($pdoImage->getImageByImageDescription(), $this->VALID_IMAGEDESCRIPTION);
		$this->assertEquals($pdoImage->getImageByEarthDate(), $this->VALID_IMAGEEARTHDATE);
		$this->assertEquals($pdoImage->getImageByImageSol(), $this->VALID_IMAGESOL);
		$this->assertEquals($pdoImage->getImageByImageTitle(), $this->VALID_IMAGETITLE);
	}



	/**
	 * test grabbing an Image by image sol
	 **/
	public function testGetValidImageByImageSol() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Image");

		// create a new image and insert into mySQL
		$image = new Image(null, $this->image->getImageId(), $this->VALID_IMAGECAMERA, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGEEARTHDATE, $this->VALID_IMAGESOL, $this->VALID_IMAGETITLE);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Image::getImageByImageSol($this->getPDO(), $image->getImageSol());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Image"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\Test", $results);

		// grab the result from the array and validate it
		$pdoImage = $results[0];
		$this->assertEquals($pdoImage->getImageId(), $image->getImageId());
		$this->assertEquals($pdoImage->getImageByImageCamera(), $this->VALID_IMAGECAMERA);
		$this->assertEquals($pdoImage->getImageByImageDescription(), $this->VALID_IMAGEDESCRIPTION);
		$this->assertEquals($pdoImage->getImageByEarthDate(), $this->VALID_IMAGEEARTHDATE);
		$this->assertEquals($pdoImage->getImageByImageSol(), $this->VALID_IMAGESOL);
		$this->assertEquals($pdoImage->getImageByImageTitle(), $this->VALID_IMAGETITLE);
	}


	/**
	 * test grabbing a Image by image title
	 **/
	public function testGetValidImageByImageTitle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Image");

		// create a new image and insert into mySQL
		$image = new Image(null, $this->image->getImageId(), $this->VALID_IMAGECAMERA, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGEEARTHDATE, $this->VALID_IMAGESOL, $this->VALID_IMAGETITLE);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Image::getImageByTitle($this->getPDO(), $image->getImageTitle());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Image"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\Test", $results);

		// grab the result from the array and validate it
		$pdoImage = $results[0];
		$this->assertEquals($pdoImage->getImageId(), $image->getImageId());
		$this->assertEquals($pdoImage->getImageByImageCamera(), $this->VALID_IMAGECAMERA);
		$this->assertEquals($pdoImage->getImageByImageDescription(), $this->VALID_IMAGEDESCRIPTION);
		$this->assertEquals($pdoImage->getImageByEarthDate(), $this->VALID_IMAGEEARTHDATE);
		$this->assertEquals($pdoImage->getImageByImageSol(), $this->VALID_IMAGESOL);
		$this->assertEquals($pdoImage->getImageByImageTitle(), $this->VALID_IMAGETITLE);
	}


	/**
	 * test grabbing all Images
	 **/
	public function testGetAllImages() {
		// count the number of tow s and save it for later
		$numRows = $this->getConnection()->getRowCount("Image");

		// create a new Image and insert into mySQL
		$image = new Image(null, $this->image->getImageId(), $this->VALID_IMAGECAMERA, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGEEARTHDATE, $this->VALID_IMAGESOL, $this->VALID_IMAGETITLE);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Image::getAllImages($this->getPDO(), $image->getImageCamera());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Image"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\Test", $results);

		// grab the result from the array and validate it
		$pdoImage = $results[0];
		$this->assertEquals($pdoImage->getImageId(), $image->getImageId());
		$this->assertEquals($pdoImage->getImageByImageCamera(), $this->VALID_IMAGECAMERA);
		$this->assertEquals($pdoImage->getImageByImageDescription(), $this->VALID_IMAGEDESCRIPTION);
		$this->assertEquals($pdoImage->getImageByEarthDate(), $this->VALID_IMAGEEARTHDATE);
		$this->assertEquals($pdoImage->getImageByImageSol(), $this->VALID_IMAGESOL);
		$this->assertEquals($pdoImage->getImageByImageTitle(), $this->VALID_IMAGETITLE);
	}
}