<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{User, LoginSource};

// grab test parameters
require_once("TeamCuriosityTest.php");

// grab test under scrutiny
require_once("../php/classes/Autoload.php");

/**
 * Full PHPUnit test for the user class
 *
 * This is a complete PHPUnit test of the Tweet class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see user
 * @author Jordan Vinson <jvinson3@cnm.edu>
 **/
class UserTest extends TeamCuriosityTest {
	/**
	 * user email
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAIL = "testtest@test.test";
	/**
	 * @var string $VALID_EMAIL2
	 **/
	protected $VALID_EMAIL2 = "anothertest@test.test";
	/**
	 * user name
	 * @var string $VALID_USERNAME
	 **/
	protected $VALID_USERNAME = "Test User Name";

	/**
	 * Information from the social login api, this is a foreign key relation
	 * @var string
	 */
	protected $loginSource = null;


	//create dependent objects before running each test

	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//create and insert a LoginSource to own the test user
		$this->loginSource = new LoginSource(null, "27dollars", "Bernbook");
		$this->loginSource->insert($this->getPDO());

	}

	//test inserting a valid email and verify that it matches the mySQL data
	public function testInsertValidUser() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("User");

		//create a new user and insert it into mySQL
		$user = new User(null, $this->VALID_EMAIL, $this->loginSource->getLoginSourceId(), $this->VALID_USERNAME);
		$user->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields to match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $this->$user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("User"));
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserName(), $this->VALID_USERNAME);
		$this->assertEquals($pdoUser->getLoginSource(), $this->loginSource->getLoginSource());

	}

	//test inserting something that already exists
	//expecting PDOException

	public function testInsertInvalidUser() {
		$user = new User(TeamCuriosityTest::INVALID_KEY, $this->VALID_EMAIL, $this->VALID_USERNAME);
		$user->insert($this->getPDO());

	}

	//test creating a user, editing it, and then updating it
	public function testUpdateValidUser() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("User");

		// create a new user and insert to into mySQL
		$user = new User(null, $this->VALID_EMAIL, $this->VALID_LOGINSOURCE);
		$user->insert($this->getPDO());

		// edit the Tweet and update it in mySQL
		$user->setUserEmail($this->VALID_EMAIL2);
		$user->update($this->getPDO());

		//create a new user and update it into mySQL
		$pdoUser = setUserId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("User"));
		$this->assertEquals($pdoUser->getUserId(),$user->getUserId());
		$this->assertEquals($pdoUser->getEmail(), $this->VALID_EMAIL2);
		$this->assertEquals($pdoUser->getLoginSource(), $this->VALID_LOGINSOURCE);


	}

/**test updating a user that already exists
 *
* @expectedException \PDOException
**/
	public function testUpdateInvalidUser() {
		//create a user with a non null user id to watch it fail
		$user = new User(null, $this->user->getUserId(), $this->VALID_EMAIL, $this->VALID_LOGINSOURCE);
		$user->update($this->getPDO());

}

	//test creating a User then deleting it

	public function testDeleteValidUser() {
		//count rows
		$numRows = $this->getConnection()->getRowCount("User");

		//create a new User and insert into mySQL
		$user = new User(null, $this->user->getUserId(), $this->VALID_EMAIL, $this->VALID_LOGINSOURCE);
		$user->insert($this->getPDO());

		//delete this User from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("User"));
		$user->delete($this->getPDO());

		//grab the data from mySQL and enforce the User does not exist
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertNull($pdoUser);
		$user->assertEquals($numRows, $this->user->getConnection()->getRowCount("User"));

	}

	//test grabbing a User that does not exist
	public function testGetInvalidUserByUserId() {
		//grab a profile id that exceeds the maximum allowable profile id
		$user = User::getUserByUserId($this->getPDO(), UserTest::INVALID_KEY);
		$this->	assertNull($user);

	}

	//test grabbing a User by Email
	public function testGetInvalidUserByEmail($user) {
		//count number of rows
		$numRows = $this->getConnection()->getRowCount("User");

		// create a new User and insert to into mySQL
		$user = new User(null, $this->userEmail->getUserEmailId(), $this->VALID_EMAIL, $this->VALID_LOGINSOURCE);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = User::getUserByUserId($this->getPDO(), $this->user->getUserEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("User"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\Test\\UserTest", $results);

		// grab the result from the array and validate it
		$pdoUser = $results[0];
		$this->assertEquals($pdoUser->getUserId(), $this->user->getUserId());
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getLoginSource(), $this->VALID_LOGINSOURCE);

	}

	/**
	*test grabbing a User by content that does not exist

	public function testGetInvalidUserByUserId() {
		// grab a user by searching for content that does not exist
		$user = User::getUserByUserId($this->getPDO(), "User not found");
		$this->assertCount(0, $user);
	}
	**/

	//test grabbing all users
	public function testGetAllValidUsers() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("User");

		// create a new User and insert to into mySQL
		$user = new User(null, $this->user->getUserId(), $this->VALID_EMAIL, $this->VALID_LOGINSOURCE);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = User::getAllUsers($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("User"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\Test\\UserTest", $results);

		// grab the result from the array and validate it
		$pdoUser = $results[0];
		$this->assertEquals($pdoUser->getUserId(), $this->user->getUserId());
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getLoginSource(), $this->VALID_LOGINSOURCE);
	}

}











