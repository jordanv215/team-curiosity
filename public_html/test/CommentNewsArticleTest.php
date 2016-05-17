<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{CommentNewsArticle, NewsArticle, User};

// grab the project test parameters
require_once("TeamCuriosityTest.php");

//grab the class under scrutiny
require_once("../php/classes/Autoload.php");

/**
 * FULL PHPUnit test for the commentNewsArticle class
 *
 * This is a complete PHPUnit test of the commentNewsArticle class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see commentNewsArticle
 * @author Anthony Williams <awilliams144@cnm.edu>
 *
 * */
class CommentNewsArticleTest extends TeamCuriosityTest {
	/**
	 * content of the commentNewsArticle
	 * @var string $VALID_COMMENTNEWSARTICLE
	 *
	 **/
protected $VALID_COMMENTNEWSARTICLECONTENT = "PHPUnit test passing";
	/**
	 * content of the updated commentNewsArticle
	 * @var string $VALID_COMMENTNEWSARTICLE2
	 *
	 **/
protected $VALID_COMMENTNEWSARTICLE2 = "PHPUnit test still passing";
	/**
	 * timestamp of the commentNewsArticle; this starts as null and is assigned later
	 * @var \DateTime $VALID_COMMENTNEWSARTICLEDATETIME
	 *
	 **/
protected $VALID_COMMENTNEWSARTICLEDATETIME = null;
	/**
	 * user that comments the commentNewsArticle; this is for foreign key relations
	 * @var user $user
	 *
	 * NewsArticle that is commented; this is for foreign key relations
	 * @var newsArticle $commentNewsArticle
	 **/
	protected $user = null;
	protected $newsArticle = null;
	/**
	 *create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a user to own the test NewsArticle
		$this->user = new User(null, "test@phpunit.de", 12345, "Test Test");
		$this->user->insert($this->getPDO());
		
		// create and insert a newsArticle to own the test NewsArticle
		$this->newsArticle = new NewsArticle(null, null, "example news article synopsis", "this/is/a/url");
		$this->newsArticle->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_COMMENTNEWSARTICLEDATETIME = new \DateTime();
	}
	

/**
 * test inserting a commentNewsArticle that already exists
 *
 * @expectedException /PDOException
 **/
public function testInsertInvalidCommentNewsArticle() {
	// create a commentNewsArticle with a non null commentNewsArticle id and watch it fail
	$commentNewsArticle = new CommentNewsArticle(TeamCuriosityTest::INVALID_KEY, $this->commentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$commentNewsArticle->insert($this->getPDO());
}

/**
 * test inserting a commentNewsArticle, editing it, and then updating it
 **/
public function testUpdateValidCommentNewsArticle() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new commentNewsArticle and insert to into mySQL
	$commentNewsArticle = new CommentNewsArticle(null, $this->commentNewsArticleId->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->COMMENTNEWSARTICLENEWSARTICLEID, $this->COMMENTNEWSARTICLEUSERID);
	$commentNewsArticle->insert($this->getPDO());

	// edit the commentNewsArticle and update it in mySQL
	$commentNewsArticle->setCommentNewsArticleContent($this->VALID_COMMENTNEWSARTICLECONTENT2);
	$commentNewsArticle->update($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdoCommentNewsArticle = CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($this->getPDO(), $commentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleId(), $this->commentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT2);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMENTNEWSARTICLEDATETIME);
}

/**
 * test updating a commentNewsArticle that already exists
 *
 * @expectedException /PDOException
 **/
public function testUpdateInvalidCommentNewsArticle() {
	// create a commentNewsArticle with a non null commentNewsArticle id and watch it fail
	$commentNewsArticle = new CommentNewsArticle(null, $this->commentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$commentNewsArticle->update($this->getPDO());
}

/**
 * test creating a commentNewsArticle and then deleting it
 **/
public function testDeleteValidNewsArticle() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new commentNewsArticle and insert to into mySQL
	$commentNewsArticle = new CommentNewsArticle(null, $this->commentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$commentNewsArticle->insert($this->getPDO());

	// delete the commentNewsArticle from mySQL
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$commentNewsArticle->delete($this->getPDO());

	// grab the data from mySQL and enforce the commentNewsArticle does not exist
	$pdoCommentNewsArticle = CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($this->getPDO(), $commentNewsArticle->getCommentNewsArticleId());
	$this->assertNull($pdoCommentNewsArticle);
	$this->assertEquals($numRows, $this->getConnection()->getRowCount("CommentNewsArticle"));
}

/**
 * test deleting a commentNewsArticle that does not exist
 *
 * @expectedException /PDOException
 **/
public function testDeleteInvalidCommentNewsArticle() {
	// create a commentNewsArticle and try to delete it without actually inserting it
	$commentNewsArticle = new CommentNewsArticle(null, $this->commentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$commentNewsArticle->delete($this->getPDO());
}

/**
 * test inserting a commentNewsArticle and regrabbing it from mySQL
 **/
public function testGetValidCommentNewsArticleByCommentNewsArticleId() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new commentNewsArticle and insert to into mySQL
	$commentNewsArticle = new CommentNewsArticle(null, $this->commentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$commentNewsArticle->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdocommentNewsArticle = commentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($this->getPDO(), $commentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertEquals($pdocommentNewsArticle->getCommentNewsArticleId(), $this->NewsArticle->getNewsArticleId());
	$this->assertEquals($pdocommentNewsArticle->getCommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT);
	$this->assertEquals($pdocommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMENTNEWSARTICLEDATETIME);
	$this->assertEquals($pdocommentNewsArticle->getCommentNewsArticleNewsArticleId().$this->VALID_COMMENTNEWSARTICLENEWSARTICLEID);
	$this->assertEquals($pdocommentNewsArticle->getCommentNewsArticleUserId(), $this->VALID_COMMENTNEWSARTICLEUSERID);
}

/**
 * test grabbing a commentNewsArticle that does not exist
 **/
public function testGetInvalidCommentNewsArticleByCommentNewsArticleId() {
	// grab a profile id that exceeds the maximum allowable profile id
	$commentNewsArticle = CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
	$this->assertNull($commentNewsArticle);
}

/**
 * test grabbing a commentNewsArticle by NewsArticle Content
 **/
public function testGetValidCommentNewsArticleContentByCommentNewsArticleContent() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new commentNewsArticle and insert to into mySQL
	$commentNewsArticle = new CommentNewsArticle(null, $this->commentNewsArticleId->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$commentNewsArticle->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$results = CommentNewsArticle::getCommentNewsArticleContentByCommentNewsArticleContent($this->getPDO(), $commentNewsArticle->getCommentNewsArticleContent());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\CommentNewsArticle");


	// grab the result from the array and validate it
	$pdoCommentNewsArticle = $results[0];
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleId(), $this->commentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMENTNEWSARTICLEDATETIME);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleNewsarticleId(), $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleUserId(), $this->VALID_COMMENTNEWSARTICLEUSERID);
}

/**
 * test grabbing a commentNewsArticle by Content that does not exist
 **/
public function testGetInvalidCommentNewsArticleByCommentNewsArticleContent() {
	// grab a commentNewsArticle by searching for content that does not exist
	$commentNewsArticle = CommentNewsArticle::getCommentNewsArticleContentByCommentNewsArticleContent($this->getPDO(), "you will find nothing");
	$this->assertCount(0, $commentNewsArticle);

}

/**
 * test grabbing all commentNewsArticles
 **/
public function testGetAllValidCommentNewsArticles() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new commentNewsArticle and insert to into mySQL
	$commentNewsArticle = new CommentNewsArticle(null, $this->commentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$commentNewsArticle->insert($this->getPDO());


	// grab the data from mySQL and enforce the fields match our expectations
	$results = CommentNewsArticle::getAllCommentNewsArticles($this->getPDO());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\CommentNewsArticle");

	// grab the result from the array and validate it
	$pdoCommentNewsArticle = $results[0];
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleId(), $this->commentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMENTNEWSARTICLEDATETIME);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleNewsArticleId(), $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleUserId(), $this->VALID_COMMENTNEWSARTICLEUSERID);
	}
}