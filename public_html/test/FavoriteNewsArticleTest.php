<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{User, NewsArticle, FavoriteNewsArticle};

// grab the project test parameters
require_once ("TeamCuriosityTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * FULL PHPUnit test for the FavoriteNewsArticle class
 *
 * This is a complete PHPUnit test of the FavoriteNewsArticle class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 **/
class FavoriteNewsArticleTest extends TeamCuriosityTest {
	/**
	 * timestamp of the FavoriteNewsArticle; this starts as null and is assigned later
	 * @var DateTime $VALID_FAVORITENEWSARTICLEDATETIME
	 **/
	protected $VALID_FAVORITENEWSARTICLEDATETIME = null;
	/**
	 * user that favorites the FavoriteNewsArticle; this is for foreign key relations
	 * @var User $user
	 *
	 * NewsArticle that is favorited; this is for foreign key relations
	 * @var NewsArticle $newsArticle
	 **/
	protected $user = null;
	protected $newsArticle = null;

	/**
	 *create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile to own the test FavoriteNewsArticle
		$this->user = new User(null, "@phpunit", "test@phpunit.de", "+12125551212");
		$this->user->insert($this->getPDO());

		// create and insert a NewsArticle to own the test FavoriteNewsArticle
		$this->newsArticle = new NewsArticle(null, "@phpunit", "test@phpunit.de", "+12125551212");
		$this->newsArticle->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_FAVORITENEWSARTICLEDATETIME = new \DateTime();
	}
	
	/**
	 * test inserting a valid FavoriteNewsArticle and verify that the actual mySQL data matches
	 **/
	public function  testInsertValidFavoriteNewsArticle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favoriteNewsArticle");
		
		//create a new FavoriteNewsArticle and insert into mySQL
		$favoriteNewsArticle = new FavoriteNewsArticle(null, $this->user->getUserId(), $this->newsArticle->getNewsArticleId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());
		
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoFavoriteNewsArticle = FavoriteNewsArticle::getFavoriteNewsArticleByUserId($this->getPDO(), $favoriteNewsArticle->getUserId());
		$this->assertEquals($favoriteNewsArticle + 1, $this->getConnection()->getRowCount("favoriteNewsArticle"));
		$this->assertEquals($pdoFavoriteNewsArticle->getUserId(), $this->user->getUserId());
		$this->assertEquals($pdoFavoriteNewsArticle->getNewsArticleId(), $this->newsArticle->getNewsArticleId());
		$this->assertEquals($pdoFavoriteNewsArticle->getNewsArticleDateTime(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
	}
	
	/**
	 * test inserting a FavoriteNewsArticle that already exists
	 * 
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidFavoriteNewsArticle() {
		// create a FavoriteNewsArticle with a non null favoriteNewsArticle id and watch it fail
		$favoriteNewsArticle = new FavoriteNewsArticle(TeamCuriosityTest::INVALID_KEY, $this->user->getUserId(), $this->newsArticle->getNewsArticleId(), $this->VALID_FAVORITENEWSARTICLEDATETIME);
		$favoriteNewsArticle->insert($this->getPDO());
	}
	
	/**
	 * test inserting a FavoriteNewsArticle, editing it, and then updateing it
	 **/
	public function testUpdateValidFavoriteNewsArticle() {
		// count the number of row s and save it for later
		$numRows = $this->getConnection()->getRowCount("favoriteNewsArticle");
		
		
	}
}