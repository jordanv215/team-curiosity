<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{NewsArticle};
use MongoDB\BSON\Type;

// grab the project test parameters
require_once("TeamCuriosityTest.php");

//grab the class under scrutiny
require_once("../php/classes/Autoload.php");

/**
 * FULL PHPUnit test for the NewsArticle class
 *
 * This is a complete PHPUnit test of the NewsArticle class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see NewsArticle
 * @author Anthony Williams <awilliams144@cnm.edu>
 *
 * */
class NewsArticleTest extends TeamCuriosityTest {
	/**
	 *
	 * content of the NewsArticle
	 * @var string $VALID_NEWSARTICLESYNOPSIS
	 **/
	protected $VALID_NEWSARTICLESYNOPSIS = "Water was found on Mars";
	/**
	 * content of the updated NewsArticle
	 * @var string $VALID_NEWSARTICLESYSNOPSIS2
	 *
	 **/
	protected $VALID_NEWSARTICLESYNOPSIS2 = "Orange juice was found on Mars";
	/**
	 * timestamp of the NewsArticle; this starts as null and is assigned later
	 * @var \DateTime | null $VALID_NEWSARTICLEDATE
	 *
	 **/
	protected $VALID_NEWSARTICLEDATE = null;
	/**
	 * source url of the news article
	 * @var string $VALID_NEWSARTICLEURL
	 **/
	protected $VALID_NEWSARTICLEURL = "This/is/a/test";

	/**
	 *create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		$this->VALID_NEWSARTICLEDATE = new \DateTime();
	}

	/**
	 * test inserting a valid NewsArticle and verify that the actual mySQL data matches
	 **/
	public function testInsertValidNewsArticle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("NewsArticle");

		// create a new NewsArticle and insert to into mySQL
		$newsArticle = new NewsArticle(null, $this->VALID_NEWSARTICLEDATE, $this->VALID_NEWSARTICLESYNOPSIS, $this->VALID_NEWSARTICLEURL);
		$newsArticle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoNewsArticle = NewsArticle::getNewsArticleByNewsArticleId($this->getPDO(), $newsArticle->getNewsArticleId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("NewsArticle"));
		$this->assertEquals($pdoNewsArticle->getNewsArticleId(), $newsArticle->getNewsArticleId());
		$this->assertEquals($pdoNewsArticle->getNewsArticleSynopsis(), $this->VALID_NEWSARTICLESYNOPSIS);
		$this->assertEquals($pdoNewsArticle->getNewsArticleDate(), $this->VALID_NEWSARTICLEDATE);
		$this->assertEquals($pdoNewsArticle->getNewsArticleUrl(), $this->VALID_NEWSARTICLEURL);
	}

	/**
	 * test inserting a NewsArticle that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidNewsArticle() {
		// create a NewsArticle with a non null NewsArticle id and watch it fail
		$newsArticle = new NewsArticle(TeamCuriosityTest::INVALID_KEY, $this->VALID_NEWSARTICLEDATE, $this->VALID_NEWSARTICLESYNOPSIS, $this->VALID_NEWSARTICLEURL);
		$newsArticle->insert($this->getPDO());
	}

	/**
	 * test inserting a NewsArticle, editing it, and then updating it
	 **/
	public function testUpdateValidNewsArticle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("NewsArticle");

		// create a new NewsArticle and insert to into mySQL
		$newsArticle = new NewsArticle(null, $this->VALID_NEWSARTICLEDATE, $this->VALID_NEWSARTICLESYNOPSIS, $this->VALID_NEWSARTICLEURL);
		$newsArticle->insert($this->getPDO());

		// edit the NewsArticle and update it in mySQL
		$newsArticle->setNewsArticleSynopsis($this->VALID_NEWSARTICLESYNOPSIS2);
		$newsArticle->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoNewsArticle = NewsArticle::getNewsArticleByNewsArticleId($this->getPDO(), $newsArticle->getNewsArticleId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("NewsArticle"));
		$this->assertEquals($pdoNewsArticle->getNewsArticleId(), $newsArticle->getNewsArticleId());
		$this->assertEquals($pdoNewsArticle->getNewsArticleSynopsis(), $this->VALID_NEWSARTICLESYNOPSIS2);
		$this->assertEquals($pdoNewsArticle->getNewsArticleDate(), $this->VALID_NEWSARTICLEDATE);
	}
	/**
	 * test updating a NewsArticle that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidNewsArticle() {
		// create a NewsArticle with a non null NewsArticle id and watch it fail
		$newsArticle = new NewsArticle(null, null, $this->VALID_NEWSARTICLESYNOPSIS, $this->VALID_NEWSARTICLEURL);
		$newsArticle->update($this->getPDO());
	}

	/**
	 * test creating a NewsArticle and then deleting it
	 **/
	public function testDeleteValidNewsArticle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("NewsArticle");

		// create a new NewsArticle and insert to into mySQL
		$newsArticle = new NewsArticle(null, $this->VALID_NEWSARTICLEDATE, $this->VALID_NEWSARTICLESYNOPSIS, $this->VALID_NEWSARTICLEURL);
		$newsArticle->insert($this->getPDO());

		// delete the NewsArticle from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("NewsArticle"));
		$newsArticle->delete($this->getPDO());

		// grab the data from mySQL and enforce the NewsArticle does not exist
		$pdoNewsArticle = NewsArticle::getNewsArticleByNewsArticleId($this->getPDO(), $newsArticle->getNewsArticleId());
		$this->assertNull($pdoNewsArticle);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("NewsArticle"));
	}

	/**
	 * test deleting a NewsArticle that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidNewsArticle() {
		// create a NewsArticle and try to delete it without actually inserting it
		$newsArticle = new NewsArticle(null, $this->VALID_NEWSARTICLEDATE, $this->VALID_NEWSARTICLESYNOPSIS, $this->VALID_NEWSARTICLEURL);
		$newsArticle->delete($this->getPDO());
	}

	/**
	 * test inserting a NewsArticle and regrabbing it from mySQL
	 **/
	public function testGetValidNewsArticleByNewsArticleId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("NewsArticle");

		// create a new NewsArticle and insert to into mySQL
		$newsArticle = new NewsArticle(null, $this->VALID_NEWSARTICLEDATE, $this->VALID_NEWSARTICLESYNOPSIS, $this->VALID_NEWSARTICLEURL);
		$newsArticle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoNewsArticle = NewsArticle::getNewsArticleByNewsArticleId($this->getPDO(), $newsArticle->getNewsArticleId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("NewsArticle"));
		$this->assertEquals($pdoNewsArticle->getNewsArticleId(), $newsArticle->getNewsArticleId());
		$this->assertEquals($pdoNewsArticle->getNewsArticleDate(), $this->VALID_NEWSARTICLEDATE);
		$this->assertEquals($pdoNewsArticle->getNewsArticleSynopsis(), $this->VALID_NEWSARTICLESYNOPSIS);
		$this->assertEquals($pdoNewsArticle->getNewsArticleUrl(), $this->VALID_NEWSARTICLEURL);
	}

	/**
	 * test grabbing a NewsArticle that does not exist
	 **/
	public function testGetInvalidNewsArticleByNewsArticleId() {
		// grab a profile id that exceeds the maximum allowable profile id
		$newsArticle = NewsArticle::getNewsArticleByNewsArticleId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($newsArticle);
	}

	/**
	 * test grabbing a NewsArticle by NewsArticle Synopsis
	 **/
	public function testGetValidNewsArticleByNewsArticleSynopsis() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("NewsArticle");

		// create a new NewsArticle and insert to into mySQL
		$newsArticle = new NewsArticle(null,$this->VALID_NEWSARTICLEDATE, $this->VALID_NEWSARTICLESYNOPSIS, $this->VALID_NEWSARTICLEURL);
		$newsArticle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = NewsArticle::getNewsArticleByNewsArticleSynopsis($this->getPDO(), $newsArticle->getNewsArticleSynopsis());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("NewsArticle"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\NewsArticle", $results);

		// grab the result from the array and validate it
		$pdoNewsArticle = $results[0];
		$this->assertEquals($pdoNewsArticle->getNewsArticleId(), $newsArticle->getNewsArticleId());
		$this->assertEquals($pdoNewsArticle->getNewsArticleDate(), $this->VALID_NEWSARTICLEDATE);
		$this->assertEquals($pdoNewsArticle->getNewsArticleSynopsis(), $this->VALID_NEWSARTICLESYNOPSIS);
		$this->assertEquals($pdoNewsArticle->getNewsArticleUrl(), $this->VALID_NEWSARTICLEURL);
	}

	/**
	 * test grabbing a NewsArticle by Synopsis that does not exist
	 **/
	public function testGetInvalidNewsArticleByNewsArticleSynopsis() {
		// grab a NewsArticle by searching for content that does not exist
		$newsArticle = NewsArticle::getNewsArticleByNewsArticleSynopsis($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $newsArticle);
		
	}

	/**
	 * test grabbing a NewsArticle by NewsArticle Date
	 **/
	public function testGetValidNewsArticleByNewsArticleDate() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("NewsArticle");

		// create a new NewsArticle and insert to into mySQL
		$newsArticle = new NewsArticle(null,$this->VALID_NEWSARTICLEDATE, $this->VALID_NEWSARTICLESYNOPSIS, $this->VALID_NEWSARTICLEURL);
		$newsArticle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = NewsArticle::getNewsArticleByNewsArticleDate($this->getPDO(), $newsArticle->getNewsArticleDate());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("NewsArticle"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\NewsArticle", $results);

		// grab the result from the array and validate it
		$pdoNewsArticle = $results[0];
		$this->assertEquals($pdoNewsArticle->getNewsArticleId(), $newsArticle->getNewsArticleId());
		$this->assertEquals($pdoNewsArticle->getNewsArticleDate(), $this->VALID_NEWSARTICLEDATE);
		$this->assertEquals($pdoNewsArticle->getNewsArticleSynopsis(), $this->VALID_NEWSARTICLESYNOPSIS);
		$this->assertEquals($pdoNewsArticle->getNewsArticleUrl(), $this->VALID_NEWSARTICLEURL);
	}

	/**
	 * test grabbing a NewsArticle by Date that does not exist
	 *
	 * @expectedException \TypeError
	 **/
	public function testGetInvalidNewsArticleByNewsArticleDate() {
		// grab a NewsArticle by searching for a date that does not exist
		$newsArticle = NewsArticle::getNewsArticleByNewsArticleDate($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $newsArticle);

	}

	/**
	 * test grabbing all NewsArticles
	 **/
	public function testGetAllValidNewsArticles() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("NewsArticle");

		// create a new NewsArticle and insert to into mySQL
		$newsArticle = new NewsArticle(null, $this->VALID_NEWSARTICLEDATE, $this->VALID_NEWSARTICLESYNOPSIS, $this->VALID_NEWSARTICLEURL);
		$newsArticle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = NewsArticle::getAllNewsArticles($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("NewsArticle"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\NewsArticle", $results);

		// grab the result from the array and validate it
		$pdoNewsArticle = $results[0];
		$this->assertEquals($pdoNewsArticle->getNewsArticleId(), $newsArticle->getNewsArticleId());
		$this->assertEquals($pdoNewsArticle->getNewsArticleDate(), $this->VALID_NEWSARTICLEDATE);
		$this->assertEquals($pdoNewsArticle->getNewsArticleSynopsis(), $this->VALID_NEWSARTICLESYNOPSIS);
		$this->assertEquals($pdoNewsArticle->getNewsArticleUrl(), $this->VALID_NEWSARTICLEURL);
	}

}
