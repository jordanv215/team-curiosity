<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{
	CommentNewsArticle, NewsArticle};

// grab the project test parameters
require_once("TeamCuriosityTest.php");

//grab the class under scrutiny
require_once("../php/classes/Autoload.php");

/**
 * FULL PHPUnit test for the CommentNewsArticle class
 *
 * This is a complete PHPUnit test of the CommentNewsArticle class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see CommentNewsArticle
 * @author Anthony Williams <awilliams144@cnm.edu>
 *
 * */
class CommentNewsArticleTest extends TeamCuriosityTest {
	/**
	 * content of the CommentNewsArticle
	 * @var string $VALID_COMMENTNEWSARTICLE
	 *
	 **/
protected $VALID_COMMENTNEWSARTICECONTENT = "PHPUnit test passing";
	/**
	 * content of the updated CommentNewsArticle
	 * @var string $VALID_COMMENTNEWSARTICLE2
	 *
	 **/
protected $VALID_COMMENTNEWSARTCLE2 = "PHPUnit test still passing";
	/**
	 * timestamp of the commentNewsArticle; this starts as null and is assigned later
	 * @var \DateTime $VALID_COMMENTNEWSARTICLEDATETIME
	 *
	 **/
protected $VALID_COMMENTNEWSARTICLEDATETIME = null;
	/**
	 * user that comments the CommentNewsArticle; this is for foreign key relations
	 * @var User $user
	 *
	 * NewsArticle that is commented; this is for foreign key relations
	 * @var NewsArticle $CommentNewsArticle
	 **/
	protected $User = null;
	protected $NewsArticle = null;
	/**
	 *create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a user to own the test commentNewsArticle
		$this->user = new User(null, "test@phpunit.de", 12345, "Test Test");
		$this->user->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_COMMENTNEWSARTCLEDATETIME = new \DateTime();
	}
	

/**
 * test inserting a CommentNewsArticle that already exists
 *
 * @expectedException PDOException
 **/
public function testInsertInvalidCommentNewsArticle() {
	// create a CommentNewsArticle with a non null CommentNewsArticle id and watch it fail
	$CommentNewsArticle = new CommentNewsArticle(TeamCuriosityTest::INVALID_KEY, $this->CommentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$CommentNewsArticle->insert($this->getPDO());
}

/**
 * test inserting a CommentNewsArticle, editing it, and then updating it
 **/
public function testUpdateValidCommentNewsArticle() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new CommentNewsArticle and insert to into mySQL
	$CommentNewsArticle = new CommentNewsArticle(null, $this->CommentNewsArticleId->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->COMMENTNEWSARTICLENEWSRTICLEID, $this->COMMENTNEWSARTICLEUSERID);
	$CommentNewsArticle->insert($this->getPDO());

	// edit the commentNewsArticle and update it in mySQL
	$CommentNewsArticle->setCommentNewsArticleContent($this->VALID_COMMENTNEWSARTICLECONTENT2);
	$CommentNewsArticle->update($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdoCommentNewsArticle = CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($this->getPDO(), $CommentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleId(), $this->CommentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCoommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT2);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMENTNEWSARTICLEDATETIME);
}

/**
 * test updating a commentNewsArticle that already exists
 *
 * @expectedException PDOException
 **/
public function testUpdateInvalidCommentNewsArticle() {
	// create a commentNewsArticle with a non null commentNewsArticle id and watch it fail
	$CommentNewsArticle = new CommentNewsArticle(null, $this->CommentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_NEWSACOMMENTARTICLEDATETIME, $this->VALID_COMMENTNEWARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$CommentNewsArticle->update($this->getPDO());
}

/**
 * test creating a commentNewsArticle and then deleting it
 **/
public function testDeleteValidNewsArticle() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new CommentNewsArticle and insert to into mySQL
	$CommentNewsArticle = new CommentNewsArticle(null, $this->CommentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$CommentNewsArticle->insert($this->getPDO());

	// delete the CommentNewsArticle from mySQL
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$CommentNewsArticle->delete($this->getPDO());

	// grab the data from mySQL and enforce the CommentNewsArticle does not exist
	$pdoCommentNewsArticle = CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($this->getPDO(), $CommentNewsArticle->getCommentNewsArticleId());
	$this->assertNull($pdoCommentNewsArticle);
	$this->assertEquals($numRows, $this->getConnection()->getRowCount("CommentNewsArticle"));
}

/**
 * test deleting a CommentNewsArticle that does not exist
 *
 * @expectedException PDOException
 **/
public function testDeleteInvalidCommentNewsArticle() {
	// create a CommentNewsArticle and try to delete it without actually inserting it
	$CommentNewsArticle = new CommentNewsArticle(null, $this->CommentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEEUSERID);
	$CommentNewsArticle->delete($this->getPDO());
}

/**
 * test inserting a CommentNewsArticle and regrabbing it from mySQL
 **/
public function testGetValidCommentNewsArticleByCommentNewsArticleId() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new commentNewsArticle and insert to into mySQL
	$CommentNewsArticle = new ComMentNewsArticle(null, $this->CommentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$CommentNewsArticle->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdoCommentNewsArticle = CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($this->getPDO(), $CommentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleId(), $this->NewsArticle->getNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMENTNEWSARTICLEDATETIME);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleNewsArticleId(), $this->VALID_COMMENTNEWSARTICLENEWARTICLEID);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleUserId(), $this->VALID_COMMENTNEWSARTICLEUSERID);
}

/**
 * test grabbing a CommentNewsArticle that does not exist
 **/
public function testGetInvalidCommentNewsArticleByCommentNewsArticleId() {
	// grab a profile id that exceeds the maximum allowable profile id
	$CommentNewsArticle = CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
	$this->assertNull($CommentNewsArticle);
}

/**
 * test grabbing a CommentNewsArticle by NewsArticle Content
 **/
public function testGetValidCommentNewsArticleContentByCommentNewsArticleContent() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new CommentNewsArticle and insert to into mySQL
	$CommentNewsArticle = new CommentNewsArticle(null, $this->CommentNewsArticleId->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$CommentNewsArticle->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$results = CommentNewsArticle::getCommentNewsArticleContentByCommentNewsArticleContent($this->getPDO(), $CommentNewsArticle->getCommentNewsArticleContent());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\CommentNewsArticle\\$results");


	// grab the result from the array and validate it
	$pdoCommentNewsArticle = $results[0];
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleId(), $this->CommentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMENTNEWSARTICLEDATETIME);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleNewsarticleId(), $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleUserId(), $this->VALID_COMMENTNEWSARTICLEUSERID);
}

/**
 * test grabbing a CommentNewsArticle by Content that does not exist
 **/
public function testGetInvalidCommentNewsArticleByCommentNewsArticleContent() {
	// grab a CommentNewsArticle by searching for content that does not exist
	$CommentNewsArticle = CommentNewsArticle::getCommentNewsArticleContentByCommentNewsArticleContent($this->getPDO(), "you will find nothing");
	$this->assertCount(0, $CommentNewsArticle);

}

/**
 * test grabbing all CommentNewsArticles
 **/
public function testGetAllValidCommentNewsArticles() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new CommentNewsArticle and insert to into mySQL
	$CommentNewsArticle = new CommentNewsArticle(null, $this->CommentNewsArticle->getCommentNewsArticleId(), $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID, $this->VALID_COMMENTNEWSARTICLEUSERID);
	$CommentNewsArticle->insert($this->getPDO());


	// grab the data from mySQL and enforce the fields match our expectations
	$results = CommentNewsArticle::getAllCommentNewsArticles($this->getPDO());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\CommentNewsArticle\\$results");

	// grab the result from the array and validate it
	$pdoCommentNewsArticle = $results[0];
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleId(), $this->CommentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMNENTNEWSARTICLEDATETIME);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleNewsArticleId(), $this->VALID_COMMENTNEWSARTICLENEWSARTICLEID);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleUserId(), $this->VALID_COMENTNEWSARTICLEUSERID);
}
}