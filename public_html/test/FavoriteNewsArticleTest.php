<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{User, NewsArticle, FavoriteNewsArticle};

// grab the project test parameters
require_once("TeamCuriosityTest.php");

//grab the class under scrutiny
require_once("../php/classes/Autoload.php");

/**
 * FULL PHPUnit test for the FavoriteNewsArticle class
 *
 * This is a complete PHPUnit test of the FavoriteNewsArticle class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 * @author Ellen Liu
 **/
class FavoriteNewsArticleTest extends TeamCuriosityTest {
	/**
	 * timestamp of the FavoriteNewsArticle; this starts as null and is assigned later
	 * @var \DateTime|null $VALID_FAVORITENEWSARTICLEDATETIME
	 **/
	protected $VALID_FAVORITENEWSARTICLEDATETIME = null;
	/**
	 * NewsArticle that is favorited; this is for foreign key relations
	 * @var NewsArticle $newsArticle
	 **/
	protected $user = null;
	/**
	 * user that favorites the FavoriteNewsArticle; this is for foreign key relations
	 * @var $user User
	 **/
	protected $newsArticle = null;

	/**
	 *create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile to own the test FavoriteNewsArticle
		$this->user = new User(null, "test@phpunit.de", 12345, "Test Test");
		$this->user->insert($this->getPDO());

		// create and insert a NewsArticle to own the test FavoriteNewsArticle
		$this->newsArticle = new NewsArticle(null, null, "This is a test", "/test/test");
		$this->newsArticle->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_FAVORITENEWSARTICLEDATETIME = new \DateTime();
	}

	/**
	 * test inserting a valid FavoriteNewsArticle and verify that the actual mySQL data matches
	 **/
	public function testInsertValidFavoriteNewsArticle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("FavoriteNewsArticle");

		//create a new FavoriteNewsArticle and insert into mySQL
		$favoriteNewsArticle = new FavoriteNewsArticle(null, $this->user->getUserId(), $this->newsArticle->getNewsArticleId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoFavoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByUserId($this->getPDO(), $favoriteNewsArticle->getUserId());
		$this->assertEquals($favoriteNewsArticle + 1, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
		$this->assertEquals($pdoFavoriteNewsArticle->getUserId(), $this->User->getUserId());
		$this->assertEquals($pdoFavoriteNewsArticle->getNewsArticleId(), $this->NewsArticle->getNewsArticleId());
		$this->assertEquals($pdoFavoriteNewsArticle->getNewsArticleDateTime(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
	}

	/** PDOException
	 **/
	public function testInsertInvalidFavoriteNewsArticle() {
		// create a FavoriteNewsArticle with a non null favoriteNewsArticle id and watch it fail
		$favoriteNewsArticle = new FavoriteNewsArticle(TeamCuriosityTest::INVALID_KEY, $this->user->getUserId(), $this->newsArticle->getNewsArticleId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());
	}

	/**
	 * test creating a FavoriteNewsArticle and then deleting it
	 **/
	public function testDeleteValidFavoriteNewsArticle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favoriteNewsArticle");

		// create a new FavoriteNewsArticle and insert into mySQL
		$favoriteNewsArticle = new FavoriteNewsArticle(null, $this->User->getUserId(), $this->newsArticle->getNewsArticleId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());

		// delete the FavoriteNewsArticle from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
		$favoriteNewsArticle->delete($this->getPDO());

		//grab the data from mySQL and enforce the favoriteNewsArticle does not exist
		$pdoFavoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId($this->getPDO(), $favoriteNewsArticle->getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId());
		$this->assertNull($pdoFavoriteNewsArticle);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
	}

	/**
	 * test deleting a favoriteNewsArticle that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidFavoriteNewsArticle() {
		// create a FavoriteNewsArticle and try to delete it without actually inserting it
		$favoriteNewsArticle = new FavoriteNewsArticle(null, $this->user->getUserId(), $this->newsArticle->getNewsArticleId(),$this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->delete($this->getPDO());
	}
	
	/**
	 * test grabbing a FavoriteNewsArticle that does not exist by FavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId
	 **/
	public function testGetInvalidFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId() {
		 //grab a FavoriteNewsArticleNewsArticleIdandFavoriteNewsArticleUser id that exceeds the maximum allowable favoriteNewsArticleNewsArticleIdandFavoriteNewsArticleUser id
		$favoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($favoriteNewsArticle);
	}
	/**
	 * test grabbing a FavoriteNewsArticle that does not exist by favoriteNewsArticle newsArticle id
	 */
	public function testGetInvalidFavoriteNewsArticleByFavoriteNewsArticleNewsArticleId() {
		// grab a favoriteNewsArticle NewsArticle id that exceeds the maximum allowable favoriteNewsArticle NewsArticle id
		$favoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($favoriteNewsArticle);
	}
	/**
	 * test grabbing a FavoriteNewsArticle that does not exist by FavoriteNewsArticle User Id
	 **/
	public function testGetInvalidFavoriteNewsArticleByFavoriteNewsArtilceUserId() {
		// grab a favoriteNewsArticle User id that exceeds the maximum allowable favoriteNewsArticle User id
		$favoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleUserId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($favoriteNewsArticle);
	}

	/**
	 * test grabbing all FavoriteNewsArticle
	 **/
	public function testGetAllValidFavoriteNewsArticles() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favoriteNewsArticle");

		// create a new FavoriteNewsArticle and insert into into mySQL
		$favoriteNewsArticle = new FavoriteNewsArticle(null, $this->user->getUserId(), $this->newsArticle->getNewsArticleId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields mathc our expectations
		$results = FavoriteNewsArticle::getAllFavoriteNewsArticles($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favoriteNewsArticle"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstanceOf("Edu\\Cnm\\TeamCuriosity\\Test", $results);

		//grab the result from the array and validate it
		$pdoFavoriteNewsArticle = $results[0];
		$this->assertEquals($pdoFavoriteNewsArticle->getUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteNewsArticle->getNewsArticleId(), $this->newsArticle->getNewsArticleId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleDateTime(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
 	}
}