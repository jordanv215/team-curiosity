<?php
namespace Redrovr\TeamCuriosity;

require_once("Autoload.php");

/**
 * user class of the Curiosity team ERD
  this user class will use social media log ins in order to allow users to share and save pictures to their social media site and keep their login data off of our direct database
 * @author Jordan Vinson <jvinson3@cnm.edu>
 * version 1.0.0*
 *
 **/
class User implements \JsonSerializable {

	/**
	 * id for this user; this is the primary key
	 * @var int $userId
	 **/
	private $userId;

	/**
	 * email for this user
	 * @var string $userEmail
	 **/
	private $userEmail;

	/**
	 * login source id for this user; this is a foreign key
	 * @var int $userLoginId
	 **/
	private $userLoginId;

	/**
	 * user id key from login provider
	 * @var string $userProviderKey
	 **/
	private $userProviderKey;

	/**
	 * username for this user;
	 * @var string $userName
	 **/
	private $userName;


	/**
	 * constructor for this user
	 *
	 * @param int|null $newUserId id of this user or null if a new user
	 * @param string|null $newUserEmail email address of user or null
	 * @param int $newUserLoginId login source id of the person logging in to this site
	 * @param string $newUserProviderKey user id key from login provider
	 * @param string $newUserName username of new user
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newUserId = null, string $newUserEmail, int $newUserLoginId = null, string $newUserProviderKey, string $newUserName) {
		try {
			$this->setUserId($newUserId);
			$this->setUserEmail($newUserEmail);
			$this->setUserLoginId($newUserLoginId);
			$this->setUserProviderKey($newUserProviderKey);
			$this->setUserName($newUserName);
		} catch
		(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller)
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for userId
	 *
	 * @return int|null value of user id
	 **/

	public function getUserId() {
		return ($this->userId);
	}

	/**
	 * mutator method for userId
	 *
	 * @param int|null $newUserId new value of user id; null if not yet inserted into DB
	 * @throws \RangeException if $newUserId is not positive
	 * @throws \TypeError if $newUserId is not an integer
	 **/
	public function setUserId(int $newUserId = null) {
		//base case: if the user id is null, this is a new user without an assigned mySQL id (yet)
		if($newUserId === null) {
			$this->userId = null;
			return;
		}

		//verify the user id is positive
		if($newUserId <= 0) {
			throw(new \RangeException("user id is not positive"));
		}
		//convert and store user id
		$this->userId = $newUserId;
	}

	/**
	 * accessor method for userLoginId
	 *
	 * @return int value for userLoginId
	 **/
	public function getUserLoginId() {
		return ($this->userLoginId);
	}

	/**
	 * mutator method for userLoginId
	 *
	 * @param int $newUserLoginId new value for login id
	 * @throws \RangeException if $newUserLoginId is not positive
	 * @throws \TypeError if $newUserLoginId is not an integer
	 **/
	public function setUserLoginId(int $newUserLoginId) {
		//verify the userLoginId is positive
		if($newUserLoginId <= 0) {
			throw(new \RangeException("login id is not positive"));
		}

		//convert and store userLoginId
		$this->userLoginId = $newUserLoginId;
	}

	/**
	 * accessor method for user name
	 *
	 * @return string value for username
	 **/
	public function getUserName() {
		return ($this->userName);
	}

	/**
	 * mutator method for userName
	 *
	 * @param string $newUserName new value for userName
	 * @throws \InvalidArgumentException if value is not a string or is insecure
	 * @throws \RangeException if $newUserName is > 128 characters
	 * @throws \TypeError if $newUserName is not a string
	 **/
	public function setUserName(string $newUserName) {
		// verify the user name is secure
		$newUserName = trim($newUserName);
		$newUserName = filter_var($newUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserName) === true) {
			throw(new \InvalidArgumentException("user name is empty or insecure"));
		}

		// verify the username will fit in the database field
		if(strlen($newUserName) > 128) {
			throw(new \RangeException("user name is too long"));
		}

		//store the user name
		$this->userName = $newUserName;
	}

	/** accessor method for user email
	 *
	 * @return string|null value of email
	 **/
	public function getUserEmail() {
		return ($this->userEmail);
	}

	/**
	 * mutator method for userEmail
	 *
	 * @param string|null $newUserEmail new value for user email or null if not provided
	 * @throws \RangeException if $newUserEmail is > 128 characters
	 * @throws \TypeError if $newUserEmail is not a string
	 **/
	public function setUserEmail(string $newUserEmail) {
		// verify that the email is secure
		$newUserEmail = trim($newUserEmail);
		$newUserEmail = filter_var($newUserEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify that email will fit in the database field
		if(strlen($newUserEmail) > 128) {
			throw(new \RangeException("email address is too long"));
		}

		//store user email
		$this->userEmail = $newUserEmail;
	}

	/**
	 * accessor method for user provider key
	 *
	 * @return string value of user provider key
	 **/
	public function getUserProviderKey() {
		return ($this->userProviderKey);
	}

	/**
	 * mutator method for userProviderKey
	 *
	 * @param string $newUserProviderKey new value for userProviderKey
	 * @throws \InvalidArgumentException if value is not a string or is insecure
	 * @throws \RangeException if $newUserProviderKey is > 96 characters
	 * @throws \TypeError if $newUserProviderKey is not a string
	 **/
	public function setUserProviderKey(string $newUserProviderKey) {
		// verify the user provider key is secure
		$newUserProviderKey = trim($newUserProviderKey);
		$newUserProviderKey = filter_var($newUserProviderKey, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserProviderKey) === true) {
			throw(new \InvalidArgumentException("user provider key is empty or insecure"));
		}

		// verify the user provider key will fit in the database field
		if(strlen($newUserProviderKey) > 96) {
			throw(new \RangeException("user name is too long"));
		}

		//store the user name
		$this->userName = $newUserName;
	}

	/**
	 * inserts this user into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		//enforce the user login id is null (dont insert a user id that already exists)
		if($this->userId !== null) {
			throw(new \PDOException("not a new user"));
		}

		//create query template
		$query = "INSERT INTO User(userEmail, userLoginId, userName) VALUES(:userEmail, :userLoginId, :userName)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["userEmail" => $this->userEmail, "userLoginId" => $this->userLoginId, "userName" => $this->userName];
		$statement->execute($parameters);

		// update the null userId with what mySQL just gave us
		$this->userId = intval($pdo->lastInsertId());
	}


	/**
	 * deletes this user from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		//enforce the userId is not null (don't delete a user that hasn't been inserted)
		if($this->userId === null) {
			throw (new \PDOException("unable to delete a user that does not exist"));
		}

		//create query template
		$query = "DELETE FROM User WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		//bind member variables
		$parameters = ["userId" => $this->userId];
		$statement->execute($parameters);

	}


	/**
	 * updates this User in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 *
	 **/
	public function update(\PDO $pdo) {
		// enforce the userId is not null (i.e., don't update a user that hasn't been inserted)
		if($this->userId === null) {
			throw(new \PDOException("unable to update a user that does not exist"));
		}
		// create query template
		$query = "UPDATE User SET userId = :userId,  userEmail = :userEmail, userLoginId = :userLoginId, userName = :userName";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["userId" => $this->userId, "userEmail" => $this->userEmail, "userLoginId" => $this->userLoginId, "userName" => $this->userName];
		$statement->execute($parameters);
	}

	/**
	 * gets the user by their id
	 * @param \PDO $pdo PDO connection object
	 * @param int $userId
	 * @return \SplFixedArray SplFixedArray of id found
	 **/

	public
	static function getUserByUserId(\PDO $pdo, int $userId) {
		//sanitize the description before searching
		if($userId <= 0) {
			throw(new \RangeException("userId is not positive"));
		}
		if (empty($userId) === true) {
			throw(new \PDOException("User is invalid"));
		}
		//create query template
		$query = "SELECT userId, userEmail, userLoginId, userName FROM User WHERE userId LIKE :userId";
		$statement = $pdo->prepare($query);


		// bind the userId to the place holder in the template
		$parameters = array("userId" => $userId);
		$statement->execute($parameters);

		//grab the User from the database
		try {
			$user = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$user = new User($row["userId"], $row["userEmail"], $row["userLoginId"], $row["userName"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($user);
	}

	/**
	 * gets all users
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of users found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data types
	 **/
	public
	static function getAllUsers(\PDO $pdo) {
		// create query template
		$query = "SELECT userId, userEmail, userLoginId, userName FROM User";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of users
		$users = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$user = new User($row["userId"], $row["userEmail"], $row["userLoginId"], $row["userName"]);
				$users[$users->key()] = $user;
				$users->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($users);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}