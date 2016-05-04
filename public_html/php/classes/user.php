<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("autoload.php");

/**
 * user class of the Curiosity team ERD
 *
 * this user class will use social media log ins in order to allow users to share and save pictures to their social media site and keep their login data off of our direct database
 * @author Jordan Vinson <jvinson3@cnm.edu>
 * version 1.0.0
 **/
class User implements \JsonSerializable {

	/**
	 * id for this user; this is the primary key
	 * @var int $userId
	 **/
	private $userId;

	/**
	 * login id for this user; this is a foreign key
	 * @var int userLoginId
	 **/
	private $userLoginId;

	/**
	 * username for this user;
	 * @var int userName
	 **/
	private $userName;

	/**
	 * email for this user
	 * @var int userEmail
	 **/
	private $userEmail;

	/**
	 * constructor for this user
	 *
	 * @param int|null $newUserId id of this user or null if a new user
	 * @param int $newLoginId of the person logging in to this site
	 * @param string $newUserName username of new user
	 * @param \DateTime|string|null $newUserEmail email login info of user or null
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newUserId = null, int $newLoginId, string $newUserName, $newUserEmail) {
		try {
			$this->setUserId($newUserId);
			$this->setLoginId($newLoginId);
			$this->setUserName($newUserName);
			$this->setUserEmail($newUserEmail);
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
	 * @param int|null $newUserId new id of user id
	 * @throws \RangeException if $newUserId is not positive
	 * @throws \TypeError if $newUserId is not an integer
	 **/
	public function setUserId(INT $newUserId = null) {
		//base case: if the user id is null, this is a new user without an assigned mySQL id (yet)
		if($newUserId === null) {
			$this->UserId = null;
			return;
		}

		//verify the user id is positive
		if($newUserId <= 0) {
			throw(new \RangeException("user id is not positive"));
		}
		//convert and store user id
		//this->userId = $newUserId;
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
	 * @return int value for username
	 **/
	public function getUserName() {
		return ($this->userName);
	}

	/**
	 * mutator method for userName
	 *
	 * @param int $newUserName new value for username
	 * @throws \RangeException if $newUserName is not positive
	 * @throws \TypeError if $newUserName is not a string
	 **/
	public function setUserName(int $newUserName) {
		//verify the username is positive
		if($newUserName <= 0) {
			throw(new \RangeException("username is not positive"));
		}

		//convert and store username
		$this->userName = $newUserName;
	}

	/** accessor method for user email
	 *
	 * @return int value for email
	 **/
	public function getUserEmail() {
		return ($this->userEmail);
	}

	/**
	 * mutator method for userEmail
	 *
	 * @param int $newUserEmail new value for user email
	 * @throws \RangeException if $newUserEmail is not positive
	 * @throws \TypeError if $newUserEmail is not a string
	 **/
	public function setUserEmail(int $newUserEmail) {
		//verify the user email is positive
		if($newUserEmail <= 0) {
			throw(new \RangeException("user email is not positive"));
		}

		//convert and store username
		$this->userEmail = $newUserEmail;
	}

	/**
	 * formats JSON
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["newUserEmail"] = intval($this->userEmail->format("U")) * 1000;
		return ($fields);
	}

	/**
	 * inserts this user into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param $userEmail
	 */
	public function insert(\PDO $pdo, $userEmail) {
		//enforce the user login id is null (dont insert a login id that already exists)
		if($this->userLoginId !== null) {
			throw(new \PDOException("not a new user login"));
		}

		//create query template
		$query = "INSERT INTO user(userLoginId, userName, userEmail) VALUES(:userLoginId, userName, userEmail)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["userLoginId" => $this->userLoginId, "userName" => $this->userName, "userEmail" => $userEmail];
		$statement->execute($parameters);
	}


	/**
	 * deletes this user from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public
	function delete(\PDO $pdo) {
		//enforce the userId is not null (don't delete a user that hasn't been inserted)
		if($this->userId === null) {
			throw (new \PDOException("unable to delete a user that does not exist"));
		}

		//create query template
		$query = "DELETE FROM user WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		//bind member variables
		$parameters = ["userId" => $this->userId];
		$statement->execute($parameters);

	}

	/**
	 * gets the user by content
	 * @param \PDO $pdo PDO connection object
	 * @param int $userId to search for
	 * @return \SplFixedArray SplFixedArray of id found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */

	public
	static function getAllUserId(\PDO $pdo) {

		//create query template
		$query = "SELECT userId, userLoginId, userName, userEmail FROM data";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build array of users
		$users = new \SplFixedArray($statement->rowCount());
		$statement = $pdo->prepare($query);
		$statement->execute();
		while(($row = $statement->fetch()) !== false) {
			try {
				$user = new user($row["userId"], $row["userLoginId"], $row["userName"], $row["userEmail"]);
				$users[$users->key()] = $users;
				$users->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($users);

	}
}