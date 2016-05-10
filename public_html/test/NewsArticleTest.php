<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{NewsArticle};

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
	protected $VALID_NEWSARTICLESYNOPSIS = "PHPUnit test passing";
	/**
	 * content of the updated NewsArticle
	 * @var string $VALID_NEWSARTICLESYSNOPSIS2
	 *
	 **/
	protected $VALID_NEWSARTICLESYNOPSIS2 = "PHPUnit test is still passing";
	/**
	 * timestamp of the NewsArticle; this starts as null and is assigned later
	 * @var DateTime $VALID_NEWSARTICLEDATE
	 *
	 **/
	protected $VALID_NEWSARTICLEDATE = null;

	/**
	 * test inserting a valid NewsArticle and verify that the actual mySQL data matches
	 **/
	public function testInsertValidNewsArticle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("NewsArticle");

		// create a new NewsArticle and insert to into mySQL
		$NewsArticle = new NewsArticle(null, $this->newsArticleId->getNewsArticleId(), $this->VALID_NewsArticleDate, $this->NewsArticleSynopsis, $this->NewsArticleUrl);
		$NewsArticle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoNewsArticle = NewsArticle::getNewsArticleByNewsArticleId($this->getPDO(), $NewsArticle->getNewsArticleId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("NewsArticle"));
		$this->assertEquals($pdoNewsArticle->getNewsArticleId(), $this->NewsArticle->getNewsArticleId());
		$this->assertEquals($pdoNewsArticle->getNewsArticleSynopsis(), $this->VALID_NewsArticleSynopsis);
		$this->assertEquals($pdoNewsArticle->getNewsArticleDate(), $this->VALID_NewsArticleDATE);
	}

	/**
	 * test inserting a NewsArticle that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidNewsArticle() {
		// create a NewsArticle with a non null NewsArticle id and watch it fail
		$NewsArticle = new NewsArticle(TeamCuriosityTest::INVALID_KEY, $this->NewsArticle->getNewsArticleId(), $this->VALID_NEWSARTICLEDATE, $this->VALID_NEWSARTICLESYNOPSIS, $this->VALID_NEWSARTICLEURL);
		$NewsArticle->insert($this->getPDO());
	}

	/**
	 * test inserting a NewsArticle, editing it, and then updating it
	 **/
	public function testUpdateValidNewsArticle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("NewsArticle");

		// create a new NewsArticle and insert to into mySQL
		$NewsArticle = new NewsArticle(null, $this->NewsArticleId->geNewsArticleId(), $this->VALID_NEWSARTICLEDATE, $this->VALID_NEWSARTICLESYNOPSIS, $this->NEWSARTICLEURL);
		$NewsArticle->insert($this->getPDO());

		// edit the NewsArticle and update it in mySQL
		$NewsArticle->setNewsArticleSynopsis($this->VALID_NEWSARTICLESYSNOPSIS2);
		$NewsArticle->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoNewsArticle = NewsArticle::getNewsArticleByNewsArticleId($this->getPDO(), $NewsArticle->getNewsArticleId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("NewsArticle"));
		$this->assertEquals($pdoNewsArticle->getNewsArticleId(), $this->NewsArticle->getNewsArticleId());
		$this->assertEquals($pdoNewsArticle->getNewsArticleSynopsis(), $this->VALID_NEWSARTICLESYNOPSIS22);
		$this->assertEquals($pdoNewsArticle->getNewsArticleDate(), $this->VALID_NEWSARTICLEDATE);
	}

}