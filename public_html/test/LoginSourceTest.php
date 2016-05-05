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
	 * @var string $VALID_LOGINSOURCEID
	 */
	protected $VALID_LOGIN_SOURCE_API_KEY;
	/**
	 * social media login provider
	 * @var string $VALID_LOGIN_SOURCE_PROVIDER
	 */
	protected $VALID_LOGIN_SOURCE_PROVIDER;
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
		$this->assertEquals($pdoLoginSource->)
	}
}