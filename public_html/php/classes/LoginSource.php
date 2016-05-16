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
	/**
	 * constructor for this LoginSource
	 *
	 * @param int|null $newLoginSourceId id of new loginSource
	 * @param string $newLoginSourceApiKey key for social login api
	 * @param string $newLoginSourceProvider name of social login source
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newLoginSourceId = null, string $newLoginSourceApiKey, string $newLoginSourceProvider) {
		try {
			$this->setLoginSourceId($newLoginSourceId);
			$this->setLoginSourceApiKey($newLoginSourceApiKey);
			$this->setLoginSourceProvider($newLoginSourceProvider);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for login source id
	 *
	 * @return int|null value of login source id
	 **/
	public function getLoginSourceId() {
		return($this->loginSourceId);
	}

	/**
	 * mutator method for login source id
	 *
	 * @param int|null $newLoginSourceId new value of login source id
	 * @throws \RangeException if $newLoginSourceId is not positive
	 * @throws \TypeError if $newLoginSourceId is not an integer
	 **/
	public function setLoginSourceId(int $newLoginSourceId = null) {
		// base case: if the id is null, this a new loginSource without a mySQL assigned id (yet)
		if($newLoginSourceId === null) {
			$this->loginSourceId = null;
			return;
		}

		// verify the login source id is positive
		if($newLoginSourceId <= 0) {
			throw(new \RangeException("login source id is not positive"));
		}

		// convert and store the tweet id
		$this->loginSourceId = $newLoginSourceId;
	}

	/**
	 * accessor method for api key
	 *
	 * @return string value of login source api key
	 **/
	public function getLoginSourceApiKey() {
		return($this->loginSourceApiKey);
	}

	/**
	 * mutator method for api key
	 *
	 * @param string $newLoginSourceApiKey new value of api key
	 * @throws \RangeException if $newLoginSourceApiKey is too long
	 * @throws \TypeError if $newLoginSourceApiKey is not an integer
	 **/
	public function setLoginSourceApiKey(string $newLoginSourceApiKey) {
		// verify the api key is secure
		$newLoginSourceApiKey = trim($newLoginSourceApiKey);
		$newLoginSourceApiKey = filter_var($newLoginSourceApiKey, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newLoginSourceApiKey) === true) {
			throw(new \InvalidArgumentException("api key content is empty or insecure"));
		}

		// verify the api key will fit in the database
		if(strlen($newLoginSourceApiKey) > 256) {
			throw(new \RangeException("api key too large"));
		}

		// store the tweet content
		$this->loginSourceApiKey = $newLoginSourceApiKey;
	}

	/**
	 * accessor method for login source provider
	 *
	 * @return string value of login source provider
	 **/
	public function getLoginSourceProvider() {
		return($this->loginSourceProvider);
	}

	/**
	 * mutator method for login source provider
	 *
	 * @param string $newLoginSourceProvider new social login provider
	 * @throws \InvalidArgumentException if $newLoginSourceProvider is not a string or insecure
	 * @throws \RangeException if $newLoginSourceProvider is > 128 characters
	 * @throws \TypeError if $newLoginSourceProvider is not a string
	 **/
	public function setLoginSourceProvider(string $newLoginSourceProvider) {
		// verify the input is secure
		$newLoginSourceProvider = trim($newLoginSourceProvider);
		$newLoginSourceProvider = filter_var($newLoginSourceProvider, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newLoginSourceProvider) === true) {
			throw(new \InvalidArgumentException("Login source provider is empty or insecure"));
		}

		// verify the input will fit in the database
		if(strlen($newLoginSourceProvider) > 128) {
			throw(new \RangeException("login source name too long"));
		}

		// store the login source provider
		$this->loginSourceProvider = $newLoginSourceProvider;
	}


	/**
	 * inserts this login source into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the loginSourceId is null (i.e., don't insert a login source that already exists)
		if($this->loginSourceId !== null) {
			throw(new \PDOException("not a new login source"));
		}

		// create query template
		$query = "INSERT INTO LoginSource(loginSourceId, loginSourceApiKey, loginSourceProvider) VALUES(:loginSourceId, :loginSourceApiKey, :loginSourceProvider)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["loginSourceId" => $this->loginSourceId, "loginSourceApiKey" => $this->loginSourceApiKey, "loginSourceProvider" => $this->loginSourceProvider];
		$statement->execute($parameters);

		// update the null login source id with value generated by mySQL
		$this->loginSourceId = intval($pdo->lastInsertId());
	}


	/**
	 * deletes this LoginSource from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		// enforce the loginSourceId is not null (i.e., don't delete a LoginSource that hasn't been inserted)
		if($this->loginSourceId === null) {
			throw(new \PDOException("unable to delete a login source that does not exist"));
		}

		// create query template
		$query = "DELETE FROM LoginSource WHERE loginSourceId = :loginSourceId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["loginSourceId" => $this->loginSourceId];
		$statement->execute($parameters);
	}

	/**
	 * updates this LoginSource in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) {
		// enforce the loginSourceId is not null (i.e., don't update a LoginSource that hasn't been inserted)
		if($this->loginSourceId === null) {
			throw(new \PDOException("unable to update a login source that does not exist"));
		}

		// create query template
		$query = "UPDATE LoginSource SET loginSourceId = :loginSourceId, loginSourceApiKey = :loginSourceApiKey, loginSourceProvider = :loginSourceProvider WHERE loginSourceId = :loginSourceId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["loginSourceId" => $this->loginSourceId, "loginSourceApiKey" => $this->loginSourceApiKey, "loginSourceProvider" => $this->loginSourceProvider];
		$statement->execute($parameters);
	}

	/**
	 * gets the LoginSource by id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $loginSourceId id to search for
	 * @return LoginSource|null LoginSource found or null if none
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getLoginSourceByLoginSourceId(\PDO $pdo, int $loginSourceId) {
		// count the number of table rows
		$

		// create query template
		$query = "SELECT tweetId, profileId, tweetContent, tweetDate FROM tweet WHERE tweetContent LIKE :tweetContent";
		$statement = $pdo->prepare($query);

		// bind the tweet content to the place holder in the template
		$tweetContent = "%$tweetContent%";
		$parameters = array("tweetContent" => $tweetContent);
		$statement->execute($parameters);

		// build an array of tweets
		$tweets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tweet = new Tweet($row["tweetId"], $row["profileId"], $row["tweetContent"], $row["tweetDate"]);
				$tweets[$tweets->key()] = $tweet;
				$tweets->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($tweets);
	}

	/**
	 * gets the Tweet by tweetId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $tweetId tweet id to search for
	 * @return Tweet|null Tweet found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getTweetByTweetId(\PDO $pdo, int $tweetId) {
		// sanitize the tweetId before searching
		if($tweetId <= 0) {
			throw(new \PDOException("tweet id is not positive"));
		}

		// create query template
		$query = "SELECT tweetId, profileId, tweetContent, tweetDate FROM tweet WHERE tweetId = :tweetId";
		$statement = $pdo->prepare($query);

		// bind the tweet id to the place holder in the template
		$parameters = array("tweetId" => $tweetId);
		$statement->execute($parameters);

		// grab the tweet from mySQL
		try {
			$tweet = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$tweet = new Tweet($row["tweetId"], $row["profileId"], $row["tweetContent"], $row["tweetDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($tweet);
	}

	/**
	 * gets all Tweets
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Tweets found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllTweets(\PDO $pdo) {
		// create query template
		$query = "SELECT tweetId, profileId, tweetContent, tweetDate FROM tweet";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of tweets
		$tweets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tweet = new Tweet($row["tweetId"], $row["profileId"], $row["tweetContent"], $row["tweetDate"]);
				$tweets[$tweets->key()] = $tweet;
				$tweets->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($tweets);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["tweetDate"] = intval($this->tweetDate->format("U")) * 1000;
		return($fields);
	}
}