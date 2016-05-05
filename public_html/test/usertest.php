<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\\TeamCuriosity\{user};

// grab test parameters
require_once ("TeamCuriosityTest.php");

// grab test under scrutiny
require_once (dirname(__DIR__)) . "/php/classes/foo.php");

/**
 * Full PHPUnit test for the user class
 *
 * This is a complete PHPUnit test of the Tweet class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see user
 * @author Jordan Vinson <jvinson3@cnm.edu>
 */
class usertest extends TeamCuriosityTest {
	/**
	 * content of this tweet
	 * @var string $VALID_USER
	 */
	protected $VALID_USER = "PHPUnit test passing";
	/**
	 * content of the updated Tweet
	 * @var string $VALID_USER2
	 **/
	protected $VALID_USER2= "PHPUnit test passing";

}






