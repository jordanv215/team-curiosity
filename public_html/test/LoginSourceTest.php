<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{loginSource};

// grab the test parameters
require_once("TeamCuriosityTest.php")

// grab the class to be tested
require_once(dirname(_DIR_) . "/php/classes/loginSource.php");

/**
 * PHPUnit test for the loginSource class
 *
 * This is a test of the loginSource class belonging to the team-curiosity project. All PDO enabled methods are tested for * valid and invalid inputs.
 *
 * @see loginSource
 * @author Kai Garrott <garrottkai@gmail.com>
 */
class LoginSourceTest extends TeamCuriosityTest {
	/**
	 * api key of the login source
	 * @var string $VALID_LOGIN_SOURCE_API_KEY
	 */
	protected $VALID_LOGIN_SOURCE_API_KEY = "abc123def456";
	/**
	 * another api key for login source
	 * @var string $VALID_LOGIN_SOURCE_API_KEY2
	 */
	protected $VALID_LOGIN_SOURCE_API_KEY2 = "xyz789uvw000";
	/**
	 * social media login provider
	 * @var string $VALID_LOGIN_SOURCE_PROVIDER
	 */
	protected $VALID_LOGIN_SOURCE_PROVIDER = "congratulations";
	/**
	 * setup method
	 */
	public final function setUp();
	/**
	 * test inserting a valid login source
	 */
	public function testInsertValidLoginSource() {
		// count number of table rows
		$numRows = $this->getConnection()->getRowCount("loginSource");

		//create a new login source and insert it into table
		$loginSource = new LoginSource(null, $this->LoginSource->getLoginSourceId(), $this->VALID_LOGIN_SOURCE_API_KEY, $this->VALID_LOGIN_SOURCE_PROVIDER);
		$LoginSource->insert($this->getPDO());

		// grab data from table and ensure it matches expectations
		$pdoLoginSource = LoginSource::getLoginSourceByLoginSourceId($this->getPDO(), $LoginSource->getLoginSourceId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("LoginSource"));
		$this->assertEquals($pdoLoginSource->getLoginSourceId(), $this->LoginSource->getLoginSourceId());
		$this->assertEquals($pdoLoginSource->getLoginSourceApiKey(), $this->LoginSource->getLoginSourceApiKey());
		$this->assertEquals($pdoLoginSource->getLoginSourceProvider(), $this->LoginSource->getLoginSourceProvider());
	}

	/**
	 *  test inserting a login source with a primary key that already exists
	 *
	 * @expectedException PDOException
	 */
	public function testInsertInvalidLoginSource() {
		// create a login source with a non null id - it should fail
		$LoginSource = new LoginSource(TeamCuriosityTest::INVALID_KEY, $this->VALID_LOGIN_SOURCE_API_KEY, $this->VALID_LOGIN_SOURCE_PROVIDER);
		$LoginSource->insert($this->getPDO());
	}
	
	/**
	 * test inserting a login source, editing it, then updating it
	 */
	public function testUpdateValidLoginSource() {
		// count the number of rows
		$numRows = $this->getConnection()->getRowCount("LoginSource");
		
		//create a new login source and insert it into table
		$LoginSource = new LoginSource(null, $this->LoginSource->getLoginSourceApiKey(), $this->VALID_LOGIN_SOURCE_API_KEY, $this->VALID_LOGIN_SOURCE_PROVIDER);
		$LoginSource->insert($this->getPDO());
		
		// edit the login source and update it in table
		$LoginSource->setLoginSourceApiKey($this->VALID_LOGIN_SOURCE_API_KEY2);
		$LoginSource->update($this->getPDO());
		
		// grab the table data and enforce that fields match expectations
		$pdoLoginSource = LoginSource::getLoginSourceByLoginSourceId($this->getPDO(), $LoginSource->getLoginSourceId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("LoginSource"));
		$this->assertEquals($pdoLoginSource->getLoginSourceApiKey(), $this->LoginSource->getLoginSourceApiKey());
		$this->assertEquals($pdoLoginSource->getLoginSourceProvider(), $this->LoginSource->getLoginSourceProvider());
	}
	
	/**
	 * test updating a login source that already exists
	 *
	 * @expectedException PDOException
	 */
	public function testUpdateInvalidLoginSource() {
		//
	}
}