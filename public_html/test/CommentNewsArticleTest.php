<?php
namespace Redrovr\TeamCuriosity\Test;

use Redrovr\TeamCuriosity\{
	CommentNewsArticle, LoginSource, NewsArticle, User
};

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
	 * @var string $VALID_COMMENTNEWSARTICLECONTENT
	 *
	 **/
protected $VALID_COMMENTNEWSARTICLECONTENT = "PHPUnit test passing";
	/**
	 * content of the updated commentNewsArticle
	 * @var string $VALID_COMMENTNEWSARTICLECONTENT2
	 *
	 **/
protected $VALID_COMMENTNEWSARTICLECONTENT2 = "PHPUnit test still passing";
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
	protected $loginSource = null;

	/**
	 * @var User $user
	 */
	protected $user = null;

	/**
	 * @var NewsArticle $newsArticle
	 */
	protected $newsArticle = null;
	/**
	 *create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();
		
		// create a login source for the user
		$this->loginSource = new LoginSource(null, "Test", "Test");
		$this->loginSource->insert($this->getPDO());
		
		// create and insert a user to own the test NewsArticle
		$this->user = new User(null, "test@phpunit.de", $this->loginSource->getLoginSourceId(), "Test Test");
		$this->user->insert($this->getPDO());
		
		// create and insert a newsArticle to own the test NewsArticle
		$this->newsArticle = new NewsArticle(null, null, "example news article content", "this/is/a/url");
		$this->newsArticle->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_COMMENTNEWSARTICLEDATETIME = new \DateTime();
	}
	

/**
 * test inserting a commentNewsArticle that already exists
 *
 * @expectedException \TypeError
 **/
public function testInsertInvalidCommentNewsArticle() {
	// create a commentNewsArticle with a non null commentNewsArticle id and watch it fail
	$commentNewsArticle = new CommentNewsArticle(null, null, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->newsArticle->getNewsArticleId(), $this->user->getUserId());
	$commentNewsArticle->insert($this->getPDO());
}

/**
 * test inserting a commentNewsArticle, editing it, and then updating it
 **/
public function testUpdateValidCommentNewsArticle() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new commentNewsArticle and insert to into mySQL
	$commentNewsArticle = new CommentNewsArticle(null, $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->newsArticle->getNewsArticleId(), $this->user->getUserId());
	$commentNewsArticle->insert($this->getPDO());

	// edit the commentNewsArticle and update it in mySQL
	$commentNewsArticle->setCommentNewsArticleContent($this->VALID_COMMENTNEWSARTICLECONTENT2);
	$commentNewsArticle->update($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdoCommentNewsArticle = CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($this->getPDO(), $commentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT2);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMENTNEWSARTICLEDATETIME);
}

/**
 * test updating a commentNewsArticle that already exists
 *
 * @expectedException \TypeError
 **/
public function testUpdateInvalidCommentNewsArticle() {
	// create a commentNewsArticle with a non null commentNewsArticle id and watch it fail
	$commentNewsArticle = new CommentNewsArticle(null, null, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->newsArticle->getNewsArticleId(), $this->user->getUserId());
	$commentNewsArticle->update($this->getPDO());
}

/**
 * test creating a commentNewsArticle and then deleting it
 **/
public function testDeleteValidNewsArticle() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new commentNewsArticle and insert to into mySQL
	$commentNewsArticle = new CommentNewsArticle(null, $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->newsArticle->getNewsArticleId(), $this->user->getUserId());
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
 * @expectedException \TypeError
 **/
public function testDeleteInvalidCommentNewsArticle() {
	// create a commentNewsArticle and try to delete it without actually inserting it
	$commentNewsArticle = new CommentNewsArticle(null, null, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->newsArticle->getNewsArticleId(), $this->user->getUserId());
	$commentNewsArticle->delete($this->getPDO());
}

/**
 * test inserting a commentNewsArticle and regrabbing it from mySQL
 **/
public function testGetValidCommentNewsArticleByCommentNewsArticleId() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new commentNewsArticle and insert to into mySQL
	$commentNewsArticle = new CommentNewsArticle(null, $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->newsArticle->getNewsArticleId(), $this->user->getUserId());
	$commentNewsArticle->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdoCommentNewsArticle = CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($this->getPDO(), $commentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMENTNEWSARTICLEDATETIME);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleNewsArticleId(),$this->newsArticle->getNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleUserId(), $this->user->getUserId());
}

/**
 * test grabbing a commentNewsArticle that does not exist
 *
 * 
 **/
public function testGetInvalidCommentNewsArticleByCommentNewsArticleId() {
	// grab a profile id that exceeds the maximum allowable profile id
	$commentNewsArticle = CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
	$this->assertNull($commentNewsArticle);
}

/**
 * test grabbing a commentNewsArticle by NewsArticle Content
 **/
public function testGetValidCommentNewsArticleByCommentNewsArticleContent() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new commentNewsArticle and insert to into mySQL
	$commentNewsArticle = new CommentNewsArticle(null, $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->newsArticle->getNewsArticleId(), $this->user->getUserId());
	$commentNewsArticle->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$results = CommentNewsArticle::getCommentNewsArticleContentByCommentNewsArticleContent($this->getPDO(), $commentNewsArticle->getCommentNewsArticleContent());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Redrovr\\TeamCuriosity\\CommentNewsArticle",$results);


	// grab the result from the array and validate it
	$pdoCommentNewsArticle = $results[0];
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleNewsArticleId(), $this->newsArticle->getNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMENTNEWSARTICLEDATETIME);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleNewsarticleId(), $this->newsArticle->getNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleUserId(), $this->user->getUserId());
}

/**
 * test grabbing a commentNewsArticle by Content that does not exist
 **/
public function testGetInvalidCommentNewsArticleByCommentNewsArticleContent() {
	// grab a commentNewsArticle by searching for content that does not exist
	$commentNewsArticle = CommentNewsArticle::getCommentNewsArticleContentByCommentNewsArticleContent($this->getPDO(), "you will find nothing");
	$this->assertCount(0,$commentNewsArticle);

}

/**
 * test grabbing all commentNewsArticles
 **/
public function testGetAllValidCommentNewsArticles() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("CommentNewsArticle");

	// create a new commentNewsArticle and insert to into mySQL
	$commentNewsArticle = new CommentNewsArticle(null, $this->VALID_COMMENTNEWSARTICLECONTENT, $this->VALID_COMMENTNEWSARTICLEDATETIME, $this->newsArticle->getNewsArticleId(), $this->user->getUserId());
	$commentNewsArticle->insert($this->getPDO());


	// grab the data from mySQL and enforce the fields match our expectations
	$results = CommentNewsArticle::getAllCommentNewsArticles($this->getPDO());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CommentNewsArticle"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Redrovr\\TeamCuriosity\\CommentNewsArticle",$results);

	// grab the result from the array and validate it
	$pdoCommentNewsArticle = $results[0];
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleId(), $commentNewsArticle->getCommentNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleContent(), $this->VALID_COMMENTNEWSARTICLECONTENT);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleDateTime(), $this->VALID_COMMENTNEWSARTICLEDATETIME);
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleNewsArticleId(), $this->newsArticle->getNewsArticleId());
	$this->assertEquals($pdoCommentNewsArticle->getCommentNewsArticleUserId(), $this->user->getUserId());
	}
}