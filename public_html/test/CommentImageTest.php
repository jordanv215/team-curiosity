<?php
namespace Edu\Cnm\TeamCuriosity\Test;

use Edu\Cnm\TeamCuriosity\{User, Image, CommentImage};

// grab the test parameters
require_once("TeamCuriosityTest.php");

// grab the class to be tested
require_once(dirname(__DIR__) . "/php/classes/Autoload.php");

/**
 * Full PHPUnit test for the CommentImage class
 * 
 * This is a complete test of the CommentImage class. It tests all PDO-enabled methods for valid and invalid inputs.
 * 
 * @see CommentImage
 * @author Kai Garrott <garrottkai@gmail.com>
 */

class CommentImageTest extends TeamCuriosityTest {
	/**
	 * content of the image comment
	 * @var string $VALID_COMMENT_IMAGE_CONTENT
	 */
	protected $VALID_COMMENT_IMAGE_CONTENT = "You are experiencing incredible success";
	/**
	 * content of the updated image comment
	 * @var string $VALID_COMMENT_IMAGE_CONTENT2
	 */
	protected $VALID_COMMENT_IMAGE_CONTENT2 = "More incredible success";
	/**
	 * timestamp of the image comment - assigned by mySQL
	 * @var DateTime $VALID_COMMENT_IMAGE_DATE_TIME
	 */
	protected $VALID_COMMENT_IMAGE_DATE_TIME = null;
	/**
	 * id of user that created the comment - a foreign key
	 * @var User User
	 */
}