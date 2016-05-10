<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("Autoload.php");

/**
 * Login Source class
 *
 * This class provides functionality to the LoginSource table, which contains data pulled from social media login APIs
 *
 * @author Kai Garrott <garrottkai@gmail.com>
 * @version 1.0.0
 */
class LoginSource implements \JsonSerializable {
	/**
	 * unique id of the specific login source; this is the primary key
	 * @var int $loginSourceId
	 */
	private $loginSourceId;
	/**
	 * client api key for the login source - not to be confused with the user's temporary auth token
	 * @var string $loginSourceApiKey
	 */
	private $loginSourceApiKey;
	/**
	 * human-readable name of the login source
	 * @var string $loginSourceProvider
	 */
	private $loginSourceProvider;

}