<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{LoginSource, User, NewsArticle, FavoriteNewsArticle};

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
	protected $loginSource = null;
	/**
	 * user that favorites the FavoriteNewsArticle; this is for foreign key relations
	 * @var $user User
	 **/
	protected $user = null;
	/**
	 * NewsArticle that is favorited; this is for foreign key relations
	 * @var $newsArticle NewsArticle
	 **/
	protected $newsArticle = null;
	/**
	 * timestamp of the FavoriteNewsArticle; this starts as null and is assigned later
	 * @var \DateTime|null $VALID_FAVORITENEWSARTICLEDATETIME
	 **/
	protected $VALID_FAVORITENEWSARTICLEDATETIME = null;

	/**
	 *create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();
		
		// create a LoginSource to populate the user fields
		$this->loginSource = new LoginSource(null, "123abc", "test");
		$this->loginSource->insert($this->getPDO());

		// create and insert a Profile to own the test FavoriteNewsArticle
		$this->user = new User(null, "test@phpunit.de", $this->loginSource->getLoginSourceId(), "Test Test");
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
		$favoriteNewsArticle = new FavoriteNewsArticle( $this->newsArticle->getNewsArticleId(), $this->user->getUserId(),$this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoFavoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId($this->getPDO(), $this->newsArticle->getNewsArticleId(), $this->user->getUserId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleNewsArticleId(), $this->newsArticle->getNewsArticleId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleDateTime(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
	}

	/**
	 * test inserting a newsArticle with invalid key
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidFavoriteNewsArticle() {
		// create a FavoriteNewsArticle with a non null favoriteNewsArticle id and watch it fail
		$favoriteNewsArticle = new FavoriteNewsArticle(TeamCuriosityTest::INVALID_KEY, $this->user->getUserId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());
	}


	/**
	 * test creating a FavoriteNewsArticle and then deleting it
	 **/
	public function testDeleteValidFavoriteNewsArticle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("FavoriteNewsArticle");

		// create a new FavoriteNewsArticle and insert into mySQL
		$favoriteNewsArticle = new FavoriteNewsArticle($this->newsArticle->getNewsArticleId(),$this->user->getUserId(),  $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());

		// delete the FavoriteNewsArticle from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
		$favoriteNewsArticle->delete($this->getPDO());

		//grab the data from mySQL and enforce the favoriteNewsArticle does not exist
		$pdoFavoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId($this->getPDO(), $favoriteNewsArticle->getFavoriteNewsArticleNewsArticleId(), $favoriteNewsArticle->getFavoriteNewsArticleUserId());
		$this->assertNull($pdoFavoriteNewsArticle);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
	}

	/**
	 * test deleting a favoriteNewsArticle that does not exist
	 *
	 * @expectedException \TypeError
	 **/
	public function testDeleteInvalidFavoriteNewsArticle() {
		// create a FavoriteNewsArticle and try to delete it without actually inserting it
		$favoriteNewsArticle = new FavoriteNewsArticle(null, null, $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->delete($this->getPDO());
	}
	
	/**
	 * test grabbing a FavoriteNewsArticle by FavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId
	 **/
	public function testGetFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("FavoriteNewsArticle");

		// create a new FavoriteNewsArticle and insert it into mySQL
		$favoriteNewsArticle = new FavoriteNewsArticle($this->newsArticle->getNewsArticleId(), $this->user->getUserId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());

		// grab a FavoriteNewsArticle from mySQL and enforce the fields match our expectations
		$pdoFavoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleIdAndFavoriteNewsArticleUserId($this->getPDO(),$favoriteNewsArticle->getFavoriteNewsArticleNewsArticleId(), $favoriteNewsArticle->getFavoriteNewsArticleUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleNewsArticleId(), $this->newsArticle->getNewsArticleId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleDateTime(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
	}
	/**
	 * test grabbing a FavoriteNewsArticle by favoriteNewsArticleNewsArticleId
	 */
	public function testGetFavoriteNewsArticleByFavoriteNewsArticleNewsArticleId() {
		// grab a favoriteNewsArticle by NewsArticle id
		$numRows = $this->getConnection()->getRowCount("FavoriteNewsArticle");

		// create a new FavoriteNewsArticle and insert it into mySQL
		$favoriteNewsArticle = new FavoriteNewsArticle($this->newsArticle->getNewsArticleId(), $this->user->getUserId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());

		// grab a FavoriteNewsArticle from mySQL and enforce the fields match our expectations
		$results = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleId($this->getPDO(),$favoriteNewsArticle->getFavoriteNewsArticleNewsArticleId(), $favoriteNewsArticle->getFavoriteNewsArticleUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\FavoriteNewsArticle", $results);

		// grab the results from the array and validate it
		$pdoFavoriteNewsArticle = $results[0];
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleNewsArticleId(), $this->newsArticle->getNewsArticleId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleDateTime(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
	}
	/**
	 * test grabbing a FavoriteNewsArticle by FavoriteNewsArticle User Id
	 **/
	public function testGetFavoriteNewsArticleByFavoriteNewsArticleUserId() {
		// grab a favoriteNewsArticle by User id
		$numRows = $this->getConnection()->getRowCount("FavoriteNewsArticle");

		// create a new FavoriteNewsArticle and insert it into mySQL
		$favoriteNewsArticle = new FavoriteNewsArticle($this->newsArticle->getNewsArticleId(),$this->user->getUserId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());
		
		// grab a FavoriteNewsArticle from mySQL and enforce the fields match our expectations
		$results = FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleUserId($this->getPDO(), $favoriteNewsArticle->getFavoriteNewsArticleUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\FavoriteNewsArticle", $results);

		// grab the results from the array and validate it
		$pdoFavoriteNewsArticle = $results[0];
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleNewsArticleId(), $this->newsArticle->getNewsArticleId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleDateTime(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
	}

	/**
	 * test grabbing all FavoriteNewsArticles
	 **/
	public function testGetAllFavoriteNewsArticles() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("FavoriteNewsArticle");

		// create a new FavoriteNewsArticle and insert into into mySQL
		$favoriteNewsArticle = new FavoriteNewsArticle($this->newsArticle->getNewsArticleId(), $this->user->getUserId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = FavoriteNewsArticle::getAllFavoriteNewsArticles($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("FavoriteNewsArticle"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\FavoriteNewsArticle", $results);

		//grab the result from the array and validate it
		$pdoFavoriteNewsArticle = $results[0];
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleNewsArticleId(), $this->newsArticle->getNewsArticleId());
		$this->assertEquals($pdoFavoriteNewsArticle->getFavoriteNewsArticleDateTime(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
 	}
}