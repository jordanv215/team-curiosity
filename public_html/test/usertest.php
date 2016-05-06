<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{User};

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

	//create dependent objects before running each test

	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//create and insert a LoginSource to own the test user
		$this->LoginSource = new LoginSource(null, "@phpunit", "@testphpunit.de", "12125551212");
		$this->LoginSource->insert($this->getPDO());
	}

	//test inserting a valid email and verify that it matches the mySQL data
	public function testInsertValidUser() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("email");

		//create a new user and insert it into mySQL
		$user = new User(null, $this->user->getUserId(), $this->VALID_EMAIL, $this->VALID_USERNAME);
		$user->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields to match our expectations
		$pdoUser = User::getUserbyUserID($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getEmail(), $this->email->getEmail());
		$this->assertEquals($pdoUsername->getUsername(), $this->username->getUsername());
		$this->assertEquals($pdoLoginSource->getLoginSource(), $this->loginSource->getLoginSource());

	}

	/** test inserting something that already exists
	* @expectedException PDOException
	*/

	public function testInsertInvalidUser() {
		$user = new User(UserTest::INVALID_KEY, $this->User->getUserId(), $this->VALID_EMAIL, $this->VALID_USERNAME);
		$user->insert($this->getPDO());

	}

	//test creating a user and then deleting it











}






