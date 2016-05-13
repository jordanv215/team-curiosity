<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("Autoload.php");

/**
 * FavoriteImage class for the curiosity team
 *
 * This class will use the user's social media accounts to favorite certain images in order to view a list of the images they enjoyed most
 * @author Jordan Vinson <jvinson3@cnm.edu>
 * version 1.0.0
 **/
class FavoriteImage implements \JsonSerializable {
	use ValidateDate;

	/**
	 * id for this favorited image; this is part of the composite key
	 * @var int $favoriteImageId
	 *
	 **/
	private $favoriteImageImageId;

	/**
	 * id for the user id who favorites image; this is part of the composite key
	 * @var int $favoriteImageUserId
	 *
	 **/
	private $favoriteImageUserId;

	/**
	 * date and time for the image; this is a foreign key
	 * @var \DateTime $favoriteImageDateTime
	 **/
	private $favoriteImageDateTime;


	/**
	 * constructor for this favoriteImage
	 *
	 * @param int|null $newFavoriteImageImageId id of this image or null if a new image
	 * @param int $newFavoriteImageUserId id of the user who favorited the image
	 * @param \DateTime|string|null $newFavoriteImageDateTime date and time image was posted or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newFavoriteImageImageId = null, int $newFavoriteImageUserId, $newFavoriteImageDateTime = null) {
		try {
			$this->setFavoriteImageImageId($newFavoriteImageImageId);
			$this->setFavoriteImageUserId($newFavoriteImageUserId);
			$this->setFavoriteImageDateTime($newFavoriteImageDateTime);
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
	 * Accessor method for favoriteImageId
	 *
	 * @return int|null value of image id
	 **/

	public function getFavoriteImageImageId() {
		return ($this->favoriteImageImageId);
	}

	/**
	 * mutator method for favoriteImageId
	 *
	 * @param int|null $newFavoriteImageId
	 * @throws \RangeException if $newFavoriteImageId is not positive
	 * @throws \TypeError if $newFavoriteImageId is not an integer
	 **/
	public function setFavoriteImageId(int $newFavoriteImageId = null) {
		//base case: if the favorite image id is null, this is a new user
		if($newFavoriteImageId === null) {
			$this->favoriteImageId = null;
			return;
		}

		//verify the image id is positive
		if($newFavoriteImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}
		//convert and store image id
		$this->favoriteImageId = $newFavoriteImageId;
	}

	/**
	 * accessor method for favoriteImageUserId
	 *
	 * @return int|null value for user id
	 **/

	public function getFavoriteImageUserId() {
		return ($this->favoriteImageUserId);
	}

	/**
	 * mutator method for favoriteImageUserId
	 *
	 * @param int $newFavoriteImageUserId
	 * @throws \RangeException if $newFavoriteImageUserId is not positive
	 * @throws \TypeError if $newFavoriteImageUserId is not an integer
	 **/
	public function setFavoriteImageUserId(int $newFavoriteImageUserId) {
		//verify the User Id is positive
		if($newFavoriteImageUserId <= 0) {
			throw(new \RangeException("User id for favorite image is not positive"));

		}

		//convert and store the favorite image user id
		$this->favoriteImageUserId = $newFavoriteImageUserId;
	}

	/**
	 * accessor method for favoriteImageDateTime
	 *
	 * @return \DateTime value for Image date and time
	 **/
	public function getFavoriteImageDateTime() {
		return ($this->favoriteImageDateTime);
	}

	/**
	 * mutator method for favoriteImageDateTime
	 *
	 * @param \DateTime|string|null $newFavoriteImageDateTime
	 * @throws \InvalidArgumentException if $newFavoriteImageDateTime is not a valid object or string
	 * @throws \RangeException if $newFavoriteImageDateTime is a date that does not exist
	 **/
	public function setFavoriteImageDateTime($newFavoriteImageDateTime = null) {
		//base case: if the favoriteImageDateTime is null, use the current date and time
		if($newFavoriteImageDateTime === null) {
			$this->favoriteImageDateTime = new \DateTime();
			return;
		}

		//store the image date
		try {
			$newFavoriteImageDateTime = $this->validateDate($newFavoriteImageDateTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->favoriteImageDateTime = $newFavoriteImageDateTime;

	}

	/**
	 * inserts this favoriteImage into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		//enforce the favoriteImageImageId is null (i.e., don't insert an image id that already exists)
		if($this->favoriteImageImageId !== null) {
			throw(new \PDOException("not a new image"));
		}

		// create a query template
		$query = "INSERT INTO FavoriteImage(favoriteImageImageId, favoriteImageUserId, favoriteImageDateTime) VALUES(:favoriteImageImageId, :favoriteImageUserID, :favoriteImageDateTime)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$formattedDate = $this->favoriteImageDateTime->format("Y-m-d H:i:s");
		$parameters = ["favoriteImageImageId" => $this->favoriteImageImageId, "favoriteImageImageUserId" => $this->favoriteImageUserId, "favoriteImageDateTime" => $formattedDate];
		$statement->execute($parameters);

		//update the null favoriteImageImageId with what mySQL just gave us
		$this->favoriteImageImageId = intval($pdo->lastInsertId());

	}

	/**
	 * deletes this image favorite from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO Connection object
	 **/
	public function delete(\PDO $pdo) {
		//enforce the favoriteImageImageId is not null (i.e., don't delete an image that hasn't been inserted)
		if($this->favoriteImageImageId === null) {
			throw(new \PDOException("unable to delete a favorite image that does not exist"));
		}

		//create query template
		$query = "DELETE FROM FavoriteImage WHERE favoriteImageImageId = :favoriteImageImageId";
		$statement = $pdo->prepare($query);

		//bind the members variables to the place holder in the template
		$parameters = ["favoriteImageImageId" => $this->favoriteImageImageId];
		$statement->execute($parameters);

	}

	/**
	 * updates this tweet in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) {
		//enforce the favoriteImageImageId is not null (i.e., don't update an image that hasn't been inserted)
		if($this->favoriteImageImageId === null) {
			throw(new \PDOException("unable to update a favorite image that does not exist"));

		}

		//create query template
		$query = "UPDATE FavoriteImage SET favoriteImageUserId = :favoriteImageUserId, favoriteImageDateTime = :favoriteImageDateTime WHERE favoriteImageImageId = :favoriteImageImageId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$formattedDate = $this->favoriteImageDateTime->format("Y-m-d H:i:S");
		$parameters = ["favoriteImageUserId" => $this->favoriteImageUserId, "favoriteImageDateTime" => $formattedDate, "favoriteImageImageID" => $this->favoriteImageImageId];
		$statement->execute($parameters);
	}

	/**
	 * THESE ARE NOTES FOR WHAT I NEED TO ADD. IGNORE THEM
	 * get favorite image by favorite image image id
	 * get favorite image by favorite image userId
	 * get favorite image by favorite image image id and favorite image image id
	 **/

	/**
	 * gets favoriteImage by favoriteImageImageId
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteImageImageId image id to search for
	 * @return \SplFixedArray SplFixedArray of images found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoriteImageByFavoriteImageImageId(\PDO $pdo, int $favoriteImageImageId) {
		//sanitize the description before searching
		if($favoriteImageImageId <= 0) {
			throw(new \PDOException("image id is not positive"));
		}

		//create query template
		$query = "SELECT favoriteImageImageId, favoriteImageUserId, favoriteImageDateTime FROM FavoriteImage WHERE favoriteImage.favoriteImageImageId = :favoriteImageImageId";
		$statement = $pdo->prepare($query);

		//bind the favoriteImage to the place holder in the template
		$parameters = array("favoriteImageImageId" => $favoriteImageImageId);
		$statement->execute($parameters);

		//grab the favorite image from mySQL
			$favoriteImage = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while(($row = $statement->fetch()) !== false) {
				try {
					$favoriteImage = new favoriteImage($row["favoriteImageImageId"], $row["favoriteImageUserId"], $row["favoriteImageDateTime"]);
					$favoriteImage[$favoriteImage->key()] = $favoriteImage;
					$favoriteImage->next();
				} catch(\Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
			}
			return ($favoriteImage);
		}
			/**$row = $statement->fetch();
			 * if($row !== false) {
			 * $favoriteImage = new favoriteImage($row["favoriteImageImageId"], $row["favoriteImageUserId"], $row["favoriteImageDateTime"]);
			 * }
			 * } catch(\Exception $exception) {
			 * // if row couldn't be converted, rethrow it
			 * throw(new \PDOException($exception->getMessage(), 0, $exception));
			 * }
			 * return($favoriteImage);
			 * }
			 **/


	/** get favoriteImage by favoriteImageByFavoriteImageUserId
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteImageImageId image id to search for
	 * @param int $favoriteImageUserId user id to search for
	 * @return \SplFixedArray SplFixedArray of images found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getFavoriteImageByFavoriteImageUserId(\PDO $pdo, int $favoriteImageUserId, $return) {
			//sanitize the description before searching
			if($favoriteImageUserId <= 0) {
				throw(new \PDOException("user id is not positive"));
			}

			//create query template
			$query = "SELECT favoriteImageUserId, favoriteImageImageId, favoriteImageDateTime FROM favoriteImage WHERE favoriteImageUserId = :favoriteImageImageId";
			$statement = $pdo->prepare($query);

			//bind the favoriteImageUserId to the place holder in the template
			$parameters = array("favoriteImageUserId" => $favoriteImageUserId);
			$statement->execute($parameters);

			//grab the favorite image from mySQL
			try {
				$favoriteImage = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$favoriteImageUserId = new favoriteImage($row["favoriteImageImageId"], $row["favoriteImageUserId"], $row["favoriteImageDateTime"]);
				}
			} catch(\Exception $exception) {
				// if row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			$return($favoriteImage);
		}


	/**
	 * gets the favoriteImage by favoriteImageId and favoriteImageUserId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteImageImageId favorite image id to search for
	 * @param int $favoriteImageUserId user id to search for
	 * @return FavoriteImage|null FavoriteImage found or null if not found
	 * @throws \RangeException when $favoriteImageImageId or $favoriteImageUserId is not positive
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId(\PDO $pdo, int $favoriteImageImageId, int $favoriteImageUserId) {
		// sanitize the favoriteImageImageId and favoriteImageUserId before searching
		if($favoriteImageImageId <= 0) {
			throw(new \RangeException("favoriteImageImageId is not positive"));
		}
		if($favoriteImageUserId <= 0) {
			throw(new \RangeException("favoriteImageUserId is not positive"));
		}

		// create query template
		$query = "SELECT favoriteImageImageId, favoriteImageUserId, favoriteImageDateTime FROM FavoriteImage WHERE favoriteImageImageId = :favoriteImageImageId AND favoriteImageUserId = :favoriteImageUserId";
		$statement = $pdo->prepare($query);

		// bind the data to the place holder in the template
		$parameters = array("favoriteImageImageId" => $favoriteImageImageId, "favoriteImageUserId => $favoriteImageUserId");
		$statement->execute($parameters);


		// build an array of favoriteImage entries
		$favoriteImage = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$FavoriteImage = new FavoriteImage($row["favoriteImageImageId"], $row["favoriteImageUserId"], $row["favoriteImageDateTime"]);
				$favoriteImage[$favoriteImage->key()] = $FavoriteImage;
				$favoriteImage->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($favoriteImage);
	}
	/**
	 * gets all FavoriteImage
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of FavoriteImage found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllFavoriteImage(\PDO $pdo) {
		// create query template
		$query = "SELECT favoriteImageImageId, favoriteImageUserId,favoriteImageDateTime FROM FavoriteImage";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of FavoriteImage
		$favoriteImage = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$FavoriteImage = new FavoriteImage($row["favoriteImageImageId"], $row["favoriteImageUserId"], $row["favoriteImageDateTime"]);
				$favoriteImage[$favoriteImage->key()] = $FavoriteImage;
				$favoriteImage->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($favoriteImage);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["favoriteNewsArticleDateTime"] = intval($this->favoriteImageDateTime->format("U")) * 1000;
		return ($fields);
	}



}
