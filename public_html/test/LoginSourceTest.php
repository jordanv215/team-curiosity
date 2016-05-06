<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{LoginSource};

// grab the test parameters
require_once("TeamCuriosityTest.php");

// grab the class to be tested
require_once(dirname(_DIR_) . "/php/classes/LoginSource.php");

/**
 * PHPUnit test for the LoginSource class
 *
 * This is a test of the LoginSource class belonging to the team-curiosity project. All PDO enabled methods are tested for valid and invalid inputs.
 *
 * @see LoginSource
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
	 * test inserting a valid login source
	 */
	public function testInsertValidLoginSource() {
		// count number of table rows
		$numRows = $this->getConnection()->getRowCount("LoginSource");

		//create a new login source and insert it into table
		$LoginSource = new LoginSource(null, $this->LoginSource->getLoginSourceId(), $this->VALID_LOGIN_SOURCE_API_KEY, $this->VALID_LOGIN_SOURCE_PROVIDER);
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
	 * test creating a login source and then deleting it
	 *
	 * @expectedException PDOException
	 */
	public function testDeleteValidLoginSource() {
		// count number of rows
		$numRows = $this->getConnection()->getRowCount("LoginSource");
		
		// create a new login source and insert into table
		$LoginSource = new LoginSource(null, $this->VALID_LOGIN_SOURCE_API_KEY, $this->VALID_LOGIN_SOURCE_PROVIDER);
		$LoginSource->insert($this->getPDO());
		
		// delete it from the table
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("LoginSource"));
		$LoginSource->delete($this->getPDO());
		
		// grab data from table and enforce that login source does not exist
		$pdoLoginSource = LoginSource::getLoginSourceByLoginSourceId($this->getPDO(), $LoginSource->getLoginSourceId());
		$this->assertNull($pdoLoginSource);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("LoginSource"));
	}
	
	/**
	 * test deleting a login source that does not exist
	 * 
	 * @expectedException PDOException
	 */
	public function testDeleteInvalidLoginSource() {
		// create a new login source and attempt to delete it without first inserting it into a table
		$LoginSource = new LoginSource(null, $this->VALID_LOGIN_SOURCE_API_KEY, $this->VALID_LOGIN_SOURCE_PROVIDER);
		$LoginSource->delete($this->getPDO());
	}

	/**
	 * test inserting a login source and regrabbing it from mySQL
	 */
	public function testGetValidLoginSourceByLoginSourceId() {
		// count the number of rows
		$numRows = $this->getConnection()->getRowCount("LoginSource");

		// create a new login source and insert it into the table
		$LoginSource = new LoginSource(null, $this->VALID_LOGIN_SOURCE_API_KEY, $this->VALID_LOGIN_SOURCE_PROVIDER);
		$LoginSource->insert($this->getPDO());

		// grab the data from mySQL and enforce that fields match expectations
		$pdoLoginSource = LoginSource::getLoginSourceByLoginSourceId($this->getPDO(), $LoginSource->getLoginSourceId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("LoginSource"));
		$this->assertEquals($pdoLoginSource->getLoginSourceId(), $this->LoginSource->getLoginSourceId());
		$this->assertEquals($pdoLoginSource->getLoginSourceApiKey(), $this->VALID_LOGIN_SOURCE_API_KEY);
		$this->assertEquals($pdoLoginSource->getLoginSourceProvider(), $this->VALID_LOGIN_SOURCE_PROVIDER);
	}

	/**
	 * test grabbing a login source that does not exist
	 */
	public function testGetInvalidLoginSourceByLoginSourceId() {
		// grab a login source id that exceeds the maximum allowable value
		$LoginSource = LoginSource::getLoginSourceByLoginSourceId($this->getPDO(), TeamCuriosityTest::INVALID_KEY);
		$this->assertNull($LoginSource);
	}

	/**
	 * test grabbing a login source by provider
	 */
	public function testGetValidLoginSourceByLoginSourceProvider() {
		// count number of rows
		$numRows = $this->getConnection()->getRowCount("LoginSource");

		// create a new login source and insert into table
		$LoginSource = new LoginSource(null, $this->VALID_LOGIN_SOURCE_API_KEY, $this->VALID_LOGIN_SOURCE_PROVIDER);
		$LoginSource->insert($this->getPDO());

		// grab data from mySQL and enforce that fields match expectations
		$results = LoginSource::getLoginSourceByLoginSourceProvider($this->getPDO(), $LoginSource->getLoginSourceProvider());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("LoginSource"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\LoginSource", $results);

		// grab the login source from the array and validate it
		$pdoLoginSource = $results[0];
		$this->assertEquals($pdoLoginSource->getLoginSourceUserId(), $this->LoginSource->getLoginSourceId());
		$this->assertEquals($pdoLoginSource->getLoginSourceApiKey(), $this->VALID_LOGIN_SOURCE_API_KEY);
		$this->assertEquals($pdoLoginSource->getLoginSourceProvider(), $this->VALID_LOGIN_SOURCE_PROVIDER);
	}

	/**
	 * test grabbing a login source by a provider that does not exist
	 */
	public function testGetInvalidLoginSourceByLoginSourceProvider () {
		// grab a login source by searching for string that does not exist
		$LoginSource = LoginSource::getLoginSourceByLoginSourceProvider($this->getPDO(), "there's nothing here");
		$this->assertCount(0, $LoginSource);
	}

	/**
	 * test grabbing all login source entries
	 */
	public function testGetAllValidLoginSource() {
		// count number of rows
		$numRows = $this->getConnection()->getRowCount("LoginSource");

		// create a new login source and insert into table
		$LoginSource = new LoginSource(null, $this->VALID_LOGIN_SOURCE_API_KEY, $this->VALID_LOGIN_SOURCE_PROVIDER);
		$LoginSource->insert($this->getPDO());

		// grab data from table and enforce that fields match expectations
		$results = LoginSource::getAllLoginSource($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("LoginSource"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\TeamCuriosity\\LoginSource", $results);
		
		// grab result from array and validate it
		$pdoLoginSource = $results [0];
		$this->assertEquals($pdoLoginSource->getLoginSourceId(), $this->LoginSource->getLoginSourceId());
		$this->assertEquals($pdoLoginSource->getLoginSourceApiKey(), $this->VALID_LOGIN_SOURCE_API_KEY);
		$this->assertEquals($pdoLoginSource->getLoginSourceProvider(), $this->VALID_LOGIN_SOURCE_PROVIDER);
	}
}
?>