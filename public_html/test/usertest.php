<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\\TeamCuriosity\{User};

// grab test parameters
require_once("TeamCuriosityTest.php");

// grab test under scrutiny
require_once (dirname(__DIR__)) . "/php/classes/Autoload.php");

/**
 * Full PHPUnit test for the user class
 *
 * This is a complete PHPUnit test of the Tweet class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see user
 * @author Jordan Vinson <jvinson3@cnm.edu>
 */
class UserTest extends TeamCuriosityTest {
	/**
	 * user
	 * @var string $VALID_USER
	 */
	protected $VALID_EMAIL = "PHPUnit test passing";
	protected $VALID_EMAIL2 = "PHPUnit test passing again";
	/**
	 * user
	 * @var string $VALID_USER2
	 **/
	protected $VALID_USERNAME = "PHPUnit test still passing";

	protected $LoginSource = null;

	//create dependant objects before running each test

	public final function setup() {
		//run the default setup() method first
		parent::setup();

		//create and insert a LoginSource to own the test user
		$this->LoginSource = new LoginSource(null, "@phpunit", "@testphpunit.de", "12125551212");
		$this->loginSource->insert($this->getPDO());

		$this->VALID_EMAIL = new \User();

	}

	//test inserting a valid email and verify that it matches the mySQL data
	public function testInsertValidUser() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Email");

		//create a new user and insert it into mySQL
		$User = new User(null, $this->User->getUserId(), $this->VALID_EMAIL, $this->VALID_USERNAME);
		$User->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields to match our expectations
		$pdoUser = User::getUserbyUserID($this->getPDO(), $User->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getEmail(), $this->Email->getEmail());
		$this->assertEquals($pdoUsername->getUsername(), $this->Username->getUsername());
		$this->assertEquals($pdoLoginSource->getLoginSource(), $this->loginSource->getLoginSource());

	}

	//test inserting something that already exists
	//expecting PDOException

	public function testInsertInvalidUser() {
		$User = new User(UserTest::INVALID_KEY, $this->User->$getUserId(), $this->VALID_EMAIL, $this->VALID_USERNAME);
		$User->insert($this->getPDO());

	}

	//test creating a user, editing it, and then updating it
	public function testUpdateValidUser() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		//create a new user and update it into mySQL
		$User->setUserbyUserId($this->getPDO(), $User->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $this->user->getUserId());
		$this->assertEquals($pdoUser->getEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getLoginSource(), $this->VALID_LOGINSOURCE);


	}

//test updating a user that already exists
//@expectedException PDOException
	public function testUpdateInvalidUser() {
		//create a user with a non null user id to watch it fail
		$User-> new User(null, $this->User->getUserId(), $this->VALID_EMAIL, $this->VALID_LOGINSOURCE);
		$User->update($this->getPDO());

}

	//test creating a User then deleting it

	public function testDeleteValidUser() {
		//count rows
		$numRows = $this->getConnection()->getRowCount("User");

		//create a new User and insert into mySQL
		$User = new User(null, $this->User->getUserId(), $this->VALID_EMAIL, $this->VALID_LOGINSOURCE);
		$User->insert($this->getPDO());

		//delete this User from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("User"));
		$User->delere($this->getPDO());

		//grab the data from mySQL and enforce the User does not exist
		$pdoUser = User::GetUserbyUserId($this->getPDO(), $User->getUserId());
		$this->assertNul($pdoUser);
		$User->assertEquals($numRows, $this->User->getConnection()->getRowCount("User"));

	}

	//test grabbing a User that does not exist
	public function testGetInvalidUserbyUserId() {
		//grab a profile id that exceeds the maximum allowable profile id
		$User = User::getUserbyUserId($this->getPDO(), UserTest::INVALID_KEY);
		$this->assertNull($User);
	}







}






