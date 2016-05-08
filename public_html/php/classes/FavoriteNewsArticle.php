<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("Autoload.php");

/** Favorite News Article
 *
 * This class provides functionality to the FavoriteNewsArticle table, which records when a user favorites an article, in order to display all of their favorite items in one place and determine the most popular items
 * @author Team Curiosity
 * */
class FavoriteNewsArticle implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for this FavoriteNewsArticle; this is the part of composite primary key
	 * @var int $favoriteNewsArticleNewsArticleId
	 **/
	private $favoriteNewsArticleNewsArticleId;
	/**id of the user who favorites this newsArticle; this is a composite primary key
	 * @var int $favoriteNewsArticleUserId
	 * */
	private $favoriteNewsArticleUserId;
	/**
	 * date and time this favoriteNewsArticle was sent, in a PHP DateTIme object
	 * @var \DateTime $favoriteNewsArticleDateTime
	 **/
	private $favoriteNewsArticleDateTime;

	/**
	 * constructor for this FavoriteNewsArticle
	 *
	 * @param int $newFavoriteNewsArticleNewsArticleId id of this favoriteNewsArticle
	 * @param int $newFavoriteNewsArticleUserId id of the user who sent this favoriteNewsArticle
	 * @param \DateTime|string|null $newFavoriteNewsArticleDateTime date and time FavoriteNewsArticle was sent or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long,negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newFavoriteNewsArticleNewsArticleId = null, int $newFavoriteNewsArticleUserId, $newFavoriteNewsArticleDateTime = null) {
		try {
			$this->setFavoriteNewsArticleNewsArticleId($newFavoriteNewsArticleNewsArticleId);
			$this->setFavoriteNewsArticleUserId($newFavoriteNewsArticleUserId);
			$this->setFavoriteNewsArticleDateTime($newFavoriteNewsArticleDateTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//	rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for favoriteNewsArticle id
	 *
	 * @return int value of favoriteNewsArticle id
	 **/
	public function getFavoriteNewsArticleNewsArticleId() {
		return ($this->favoriteNewsArticleNewsArticleId);
	}

	/**
	 * mutator method for favoriteNewsArticle id
	 *
	 * @param int $newFavoriteNewsArticleNewsArticleId new value of favoriteNewsArticle id
	 * @throws \RangeException if $newFavoriteNewsArticleNewsArticleId is not positve
	 * @throws \TypeError if $newFavoriteNewsArticleNewsArticleId is not an integer
	 **/
	public function setFavoriteNewsArticleNewsArticleId(int $newFavoriteNewsArticleNewsArticleId) {
		// verify the favoriteNewsArticle id is positive
		if($newFavoriteNewsArticleNewsArticleId <= 0) {
			throw(new \RangeException("favoriteNewsArticle id is not positive"));
		}

		// convert and store the favoriteNewsArticle id
		$this->favoriteNewsArticleNewsArticleId = $newFavoriteNewsArticleNewsArticleId;
	}

	/**
	 * accessor method for favoriteNewsArticleUserId
	 *
	 * @return int value of favoriteNewsArticle user id
	 **/
	public function getFavoriteNewsArticleUserId() {
		return ($this->favoriteNewsArticleUserId);
	}

	/**
	 * mutator method for favoriteNewsArticle user id
	 *
	 * @param int $newFavoriteNewsArticleUserId new value of favoriteNewsArticle user id
	 * @throws \RangeException if $newFavoriteNewsArticleUserId is not positive
	 * @throws \TypeError if $newFavoriteNewsArticleUserId is not an integer
	 **/
	public function setFavoriteNewsArticleUserId(int $newFavoriteNewsArticleUserId) {
		//verify the favoriteNewsArticle user id is positive
		if($newFavoriteNewsArticleUserId <= 0) {
			throw(new \RangeException("favoriteNewsArticle user id is not positive"));
		}

		//convert and store the favoriteNewsArticle user id
		$this->favoriteNewsArticleUserId = $newFavoriteNewsArticleUserId;
	}

	/**
	 * accessor method for favoriteNewsArticleDateTime
	 *
	 * @return \DateTime value of favoriteNewsArticle date and time
	 **/
	public function getFavoriteNewsArticleDateTime() {
		return ($this->favoriteNewsArticleDateTime);
	}

	/**
	 * mutator method for favoriteNewsArticle date and time
	 * @param \DateTime|string|null $newFavoriteNewsArticleDateTime favoriteNewsArticle date and time as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newFavoriteNewsArticleDateTime is nont a valid object or string
	 * @throws \RangeException if $newFavoriteNewsArticleDateTime is a date or time that does not exist
	 **/
	public function setFavoriteNewsArticleDateTime($newFavoriteNewsArticleDateTime = null) {
		// base case: if the date is null, use the current date and time
		if($newFavoriteNewsArticleDateTime === null) {
			$this->favoriteNewsArticleDateTime = new \DateTime();
			return;
		}

		// store the favoriteNewsArticleDateTime date
		try {
			$newFavoriteNewsArticleDateTime = $this->validateDate($newFavoriteNewsArticleDateTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->favoriteNewsArticleDateTime = $newFavoriteNewsArticleDateTime;
	}

	/**
	 * inserts this FavoriteNewsArticle into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		//enforce the favoriteNewsArticleNewsArticleId is null (ie., don't insert a favoriteNewsArticle that already exists)
		if($this->favoriteNewsArticleNewsArticleId !== null) {
			throw(new \PDOException("not a new FavoriteNewsArticle"));
		}

		//create query template
		$query = "INSERT INTO FavoriteNewsArticle(favoriteNewsArticleUserId, favoriteNewsArticleDateTime) VALUES (:favoriteNewsArticleUserId, :favoriteNewsArticleDateTime)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->favoriteNewsArticleDateTime->format("Y-m-d H:i:s");
		$parameters = ["favoriteNewsArticleNewsArticleId" => $this->favoriteNewsArticleNewsArticleId, "favoriteNewsArticleUserId" => $this->favoriteNewsArticleUserId, "favoriteNewsArticleDateTime" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * deletes this FavoriteNewsArticle from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related error occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		// enforce the favoriteNewsArticleNewsArticleId is not null (i.e., don't delete a favoriteNewsArticle that hasn't been inserted)
		if($this->favoriteNewsArticleNewsArticleId === null) {
			throw(new \PDOException("unable to delete a favoriteNewsArticle that does not exist"));
		}

		//create query template
		$query = "DELETE FROM FavoriteNewsArticle WHERE favoriteNewsArticleNewsArticleId = :favoriteNewsArticleNewsArticleId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["favoriteNewsArticleNewsArticleId" => $this->favoriteNewsArticleNewsArticleId];
		$statement->execute($parameters);
	}

	/**
	 * updates this FavoriteNewsArticle in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) {
		// enforce the favoriteNewsArticleNewsArticleId is not null (i.e., don't update a FavoriteNewsArticle that hasn't been inserted)
		if($this->favoriteNewsArticleNewsArticleId === null) {
			throw(new \PDOException("unable to update a FavoriteNewsArticle that does not exist"));
		}

		//create query template
		$query = "UPDATE FavoriteNewsArticle SET favoriteNewsArticleNewsArticleId = :favoriteNewsArticleNewsarticleId, favoriteNewsArticleUserId = :favoriteNewsArticleUserId, favoriteNewsArticleDateTime = :favoriteNewsArticleDateTime";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$formattedDate = $this->favoriteNewsArticleDateTime->format("Y-m-d H:i:s");
		$parameters = ["favoriteNewsArticleNewsArticleId" => $this->favoriteNewsArticleNewsArticleId, "favoriteNewsArticleUserId" => $this->favoriteNewsArticleUserId, "favoriteNewsArticleDateTime" => $this->favoriteNewsArticleDateTime];
		$statement->execute($parameters);
	}

	/**
	 * gets the FavoriteNewsArticle by favoriteNewsArticleNewsArticle id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteNewsArticleNewsArticleId favoriteNewsArticle id to search for
	 * @return favoriteNewsArticle | null favoriteNewArticle found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleId(\PDO $pdo, int $favoriteNewsArticleNewsArticleId) {
		//sanitize the favoriteNewsArticleNewsArticleId before searching
		if($favoriteNewsArticleNewsArticleId <= 0) {
			throw(new \PDOException("favoriteNewsArticle newsArticle id is not positive"));
		}

		// create query template
		$query = "SELECT favoriteNewsArticleNewsArticleId, favoriteNewsArticleUserId, favoriteNewsArticleDateTime FROM FavoriteNewsArticle WHERE favoriteNewsArticleNewsArticleId = :favoriteNewsArticleNewsArticleId";
		$statement = $pdo->prepare($query);

		//bind the favoriteNewsArticle newsArticle id to the place holder in the template
		$parameters = array("favoriteNewsArticleNewsArticleId" => $favoriteNewsArticleNewsArticleId);
		$statement->execute($parameters);

		// grab the FavoriteNewsArticle from mySQL
		try {
			$FavoriteNewsArticle = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$FavoriteNewsArticle = new FavoriteNewsArticle($row["favoriteNewsArticleNewsArticleId"], $row["favoriteNewsArticleUserId"], $row["favoriteNewsArticleDateTime"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($FavoriteNewsArticle);
	}

	/**gets the FavoriteNewsArticle by favoriteNewsArticleUserId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteNewsArticleUserId favoriteNewsArticle user id to search for
	 * @return FavoriteNewsArticle|null FavoriteNewsArticle found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoriteNewsArticleByFavoriteNewsArticleUserId(\PDO $pdo, int $favoriteNewsArticleUserId) {
		// sanitize the favoriteNewsArticleUserId before searching
		if($favoriteNewsArticleUserId <= 0) {
			throw(new \PDOException("favoriteNewsArticle user id is not positive"));
		}

		// create query template
		$query = "SELECT favoriteNewsArticleUserId, favoriteNewsArticleNewsArticleId, favoriteNewsArticleDateTime FROM FavoriteNewsArticle WHERE favoriteNewsArticleUserId = :favoriteNewsArticleUserId";
		$statement = $pdo->prepare($query);
		//bind the favoriteNewsArticle  user id to the place holder in the template
		$parameters = array("favoriteNewsArticleUserId" => $favoriteNewsArticleUserId);
		$statement->execute($parameters);

		// grab the FavoriteNewsArticle from mySQL
		try {
			$FavoriteNewsArticle = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$FavoriteNewsArticle = new FavoriteNewsArticle($row["favoriteNewsArticleUserId"], $row["favoriteNewsArticleNewsArticleId"], $row["favoriteNewsArticleDateTime"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($FavoriteNewsArticle);
	}

	/**
	 * gets the FavoriteNewsArticle by NewsArticle id and User id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteNewsArticleNewsArticleId news article id to search for
	 * @param int $favoriteNewsArticleUserId user id to search for
	 * @return FavoriteNewsArticle|null FavoriteNewsArticle found or null if not found
	 * @throws \RangeException when $favoriteNewsArticleNewsArticleId or $favoriteNewsArticleUserId is not positive
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoriteNewsArticleByFavoriteNewsArticleIdAndFavoriteNewsArticleUserId(\PDO $pdo, int $favoriteNewsArticleNewsArticleId, int $favoriteNewsArticleUserId) {
		// sanitize the favoriteNewsArticleNewsArticleId and favoriteNewsArticleUserId before searching
		if($favoriteNewsArticleNewsArticleId <= 0) {
			throw(new \RangeException("favoriteNewsArticleNewsArticleId is not positive"));
		}
		if($favoriteNewsArticleUserId <= 0) {
			throw(new \RangeException("favoriteNewsArticleUserId is not positive"));
		}

		//create query template
		$query = "SELECT favoriteNewsArticleNewsArticleId, favoriteNewsArticleUserId, favoriteNewsArticleDateTime FROM FavoriteNewsArticle WHERE favoriteNewsArticleNewsArticleId = :favoriteNewsArticleNewsArticleId AND favoriteNewsArticleUserId = :favoriteNewsArticleUserId";
		$statement = $pdo->prepare($query);

		//bind the data to the place holder in the template
		$favoriteNewsArticleNewsArticleId = "%favoriteNewsArticleNewsArticleId%";
		$favoriteNewsArticleUserId = "%favoriteNewsArticleUserId%";
		$parameters = array("favoriteNewsArticleNewsArticleId" => $favoriteNewsArticleNewsArticleId, "favoriteNewsArticleUserId => $favoriteNewsArticleUserId");
		$statement->execute($parameters);
	}	
	
		/**
		 * gets all FavoriteNewsArticles
		 *
		 * @param \PDO $pdo PDO connection object
		 * @return \SplFixedArray SplFixedArray of FavoriteNewsArticle found or null if not found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 **/
		public static function getAllFavoriteNewsArticles(\PDO $pdo) {
			// create query template
			$query = "SELECT favoriteNewsArticleNewsArticleId, favoriteNewsArticleUserId, newsArticleIdAndUserId,favoriteNewsArticleDateTime FROM FavoriteNewsArticle";
			$statement = $pdo->prepare($query);
			$statement->execute();

			//build an array of FavoriteNewsArticle
			$favoriteNewsArticles = new \SplFixedArray($statement->rowCount());
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while(($row = $statement->fetch()) !== false) {
				try {
					$FavoriteNewsArticle = new FavoriteNewsArticle($row["favoriteNewsArticleNewsArticleId"], $row["favoriteNewsArticleUserId"], $row["favoriteNewsArticleDateTime"], $row["newsArticleIdAndUserId"]);
					$favoriteNewsArticles[$favoriteNewsArticles->key()] = $FavoriteNewsArticle;
					$favoriteNewsArticles->next();
				} catch(\Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
			}
			return ($favoriteNewsArticles);
		}

		/**
		 * formats the state variables for JSON serialization
		 *
		 * @return array resulting state variables to serialize
		 **/
		public
		function jsonSerialize() {
			$fields = get_object_vars($this);
			$fields["favoriteNewsArticleDateTime"] = intval($this->favoriteNewsArticleDateTime->format("U")) * 1000;
			return ($fields);
		}
	}
