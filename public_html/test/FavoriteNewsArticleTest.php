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
 **/
class FavoriteNewsArticleTest extends TeamCuriosityTest {
	/**
	 * timestamp of the FavoriteNewsArticle; this starts as null and is assigned later
	 * @var \DateTime $VALID_FAVORITENEWSARTICLEDATETIME
	 **/
	protected $VALID_FAVORITENEWSARTICLEDATETIME = null;
	/**
	 * user that favorites the FavoriteNewsArticle; this is for foreign key relations
	 * @var User $user
	 *
	 * NewsArticle that is favorited; this is for foreign key relations
	 * @var NewsArticle $newsArticle
	 **/
	protected $User = null;
	protected $NewsArticle = null;

	/**
	 *create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile to own the test FavoriteNewsArticle
		$this->User = new User(null, "test@phpunit.de", 12345, "Test Test");
		$this->User->insert($this->getPDO());

		// create and insert a NewsArticle to own the test FavoriteNewsArticle
		$this->NewsArticle = new NewsArticle(null, null, "This is a test", "/test/test");
		$this->NewsArticle->insert($this->getPDO());

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
		$FavoriteNewsArticle = new FavoriteNewsArticle(null, $this->User->getUserId(), $this->NewsArticle->getNewsArticleId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$FavoriteNewsArticle->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoFavoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByUserId($this->getPDO(), $FavoriteNewsArticle->getUserId());
		$this->assertEquals($FavoriteNewsArticle + 1, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
		$this->assertEquals($pdoFavoriteNewsArticle->getUserId(), $this->User->getUserId());
		$this->assertEquals($pdoFavoriteNewsArticle->getNewsArticleId(), $this->NewsArticle->getNewsArticleId());
		$this->assertEquals($pdoFavoriteNewsArticle->getNewsArticleDateTime(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
	}

	/** PDOException
	 **/
	public function testInsertInvalidFavoriteNewsArticle() {
		// create a FavoriteNewsArticle with a non null favoriteNewsArticle id and watch it fail
		$FavoriteNewsArticle = new FavoriteNewsArticle(TeamCuriosityTest::INVALID_KEY, $this->User->getUserId(), $this->NewsArticle->getNewsArticleId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$FavoriteNewsArticle->insert($this->getPDO());
	}

	/**
	 * test creating a FavoriteNewsArticle and then deleting it
	 **/
	public function testDeleteValidFavoriteNewsArticle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favoriteNewsArticle");

		// create a new FavoriteNewsArticle and insert into mySQL
		$FavoriteNewsArticle = new FavoriteNewsArticle(null, $this->User->getUserId(), $this->newsArticle->getNewsArticleId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$FavoriteNewsArticle->insert($this->getPDO());

		// delete the FavoriteNewsArticle from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
		$FavoriteNewsArticle->delete($this->getPDO());

		//grab the data from mySQL and enforce the favoriteNewsArticle does not exist
		$pdoFavoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId($this->getPDO(), $FavoriteNewsArticle->getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId());
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
		$FavoriteNewsArticle = new FavoriteNewsArticle(null, $this->User->getUserId(), $this->NewsArticle->getNewsArticleId(),$this->VALID_FAVORITENEWSARTICLEDATETIME);
		$FavoriteNewsArticle->delete($this->getPDO());
	}
	
	/**
	 * test grabbing a FavoriteNewsArticle that does not exist by FavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId
	 **/
	public function testGetInvalidFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId() {
		 //grab a FavoriteNewsArticleNewsArticleIdandFavoriteNewsArticleUser id that exceeds the maximum allowable favoriteNewsArticleNewsArticleIdandFavoriteNewsArticleUser id
		$FavoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($FavoriteNewsArticle);
	}
	/**
	 * test grabbing a FavoriteNewsArticle that does not exist by favoriteNewsArticle newsArticle id
	 */
	public function testGetInvalidFavoriteNewsArticleByFavoriteNewsArticleNewsArticleId() {
		// grab a favoriteNewsArticle NewsArticle id that exceeds the maximum allowable favoriteNewsArticle NewsArticle id
		$FavoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($FavoriteNewsArticle);
	}
	/**
	 * test grabbing a FavoriteNewsArticle that does not exist by FavoriteNewsArticle User Id
	 **/
	public function testGetInvalidFavoriteNewsArticleByFavoriteNEewsArtilceUserId() {
		// grab a favoriteNewsArticle User id that exceeds the maximum allowable favoriteNewsArticle User id
		$FavoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleUserId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($FavoriteNewsArticle);
	}

	/**
	 * test grabbing all FavoriteNewsArticle
	 **/
	public function testGetAllValidFavoriteNewsArticles() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favoriteNewsArticle");

		// create a new FavoriteNewsArticle and insert into into mySQL
		$FavoriteNewsArticle = new FavoriteNewsArticle(null, $this->User->getUserId(), $this->NewsArticle->getNewsArticleId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$FavoriteNewsArticle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields mathc our expectations
		$results = FavoriteNewsArticle::getAllFavoriteNewsArticles($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favoriteNewsArticle"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstanceOf("Edu\\Cnm\\TeamCuriosity\\Test", $results);

		//grab the result from the array and validate it
		$pdoFavoriteNewsArticle = $results[0];
		$this->assertEquals($pdoFavoriteNewsArticle->getUserId(), $this->User->getUserId());
		$this->assertEquals($pdoFavoriteNewsArticle->getNewsArticleId(), $this->NewsArticle->getNewsArticleId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleDateTime(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
 	}
}