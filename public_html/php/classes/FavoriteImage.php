<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("Autoload.php");

/**
 * FavoriteImage class for the curiosity team
 *
 * This class will use the user's social media accounts to favorite certain images in order to view a list of the images they enjoyed most
 * @author Jordan Vinson <jvinson3@cnm.edu>
 * version 1.0.0
 */

class FavoriteImage implements \JsonSerializable {
	use ValidateDate;

	/**
	 * id for this favorited image; this is part of the composite key
	 * @var int $favoriteImageId
	 *
	 **/
	private $favoriteImageId;

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
	 * @param int|null $newFavoriteImageId id of this image or null if a new image
	 * @param int $newFavoriteImageUserId id of the user who favorited the image
	 * @param \DateTime|string|null $newFavoriteImageDateTime date and time image was posted or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newFavoriteImageId = null, int $newFavoriteImageUserId, $newFavoriteImageDateTime = null) {
		try {
			$this->setFavoriteImageId($newFavoriteImageId);
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
 */

	public function getFavoriteImageId() {
		return ($this->favoriteImageId);
	}

	/**
	 * mutator method for favoriteImageId
	 *
	 * @param int|null $favoriteImageId
	 * @throws \RangeException if $favoriteImageId is not positive
	 * @throws \TypeError if $newFavoriteImageId is not an integer
	 */
	public function setFavoriteImageId(int $newFavoriteImageId = null) {
		//base case: if the favorite image id is null, this is a new user
		if ($newFavoriteImageId === null) {
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
	 */

	public function getFavoriteImageUserId() {
		return($this->favoriteImageUserId);
	}

	/**
	 * mutator method for favoriteImageUserId
	 *
	 * @param int $newFavoriteImageUserId
	 * @throws \RangeException if $newFavoriteImageUserId is not positive
	 * @throws \TypeError if $newFavoriteImageUserId is not an integer
	 */
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
	 */
	public function getFavoriteImageDateTime() {
		return($this->favoriteImageDateTime);
	}

	/**
	 * mutator method for favoriteImageDateTime
	 *
	 * @param \DateTime|string|null $newFavoriteImageDateTime
	 * @throws \InvalidArgumentException if $newFavoriteImageDateTime is not a valid object or string
	 * @throws \RangeException if $newFavoriteImageDateTime is a date that does not exist
	 */
	public function setFavoriteImageDateTime($newFavoriteImageDateTime = null) {
		//base case: if the favoriteImageDateTime is null, use the current date and time
		if($newFavoriteImageDateTime === null) {
			$this->favoriteImageDateTime = new \DateTime();
			return;
		}

		//store the image date
		try {
			$newFavoriteImageDateTime = $this->validateDate($newFavoriteImageDateTime);
		} catch(\invalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range){
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
	 */
	public function insert(\PDO $pdo) {
		//enforce the favoriteImageId is null (i.e., don't insert an image id that already exists)
		if($this->favoriteImageId !== null) {
			throw(new \PDOException("not a new image"));
		}

		// create a query template
		$query ="INSERT INTO favoriteImage(favoriteImageImageId, favoriteImageUserId, favoriteImageDateTime) VALUES(:favoriteImageId, :favoriteImageUserID, :favoriteimageDateTime)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$formattedDate = $this->favoriteImageDateTime->format("Y-m-d H:i:s");
		$parameters = ["favoriteImageId" => $this->favoriteImageId, "favoriteImageUserId" => $this->favoriteImageUserId, "favoriteImageDateTime" => $formattedDate];
		$statement->execute($parameters);

		//update the null favoriteImageId with what mySQL just gave us
		$this->favoriteImageId = intval($pdo->lastInsertId());

	}

	/**
	 * deletes this image from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO Connection object
	 */
	public function delete(\PDO $pdo) {
		//enforce the favoriteImageId is not null (i.e., don't delete an image that hasn't been inserted)
		if($this->favoriteImageId === null) {
			throw(new \PDOException("unable to delete a favorite image that does not exist"));
		}

		//create query template
		$query = "DELETE FROM FavoriteImage WHERE favoriteImageImageId = :favoriteImageId";
		$statement = $pdo->prepare($query);

		//bind the members variables to the place holder in the template
		$parameters = ["favoriteImageId" => $this->favoriteImageId];
		$statement->execute($parameters);

	}

	/**
	 * updates this tweet in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {
		//enforce the favoriteImageId is not null (i.e., don't update an image that hasn't been inserted)
		if($this->favoriteImageId === null) {
			throw(new \PDOException("unable to update a favorite image that does not exist"));

		}

		//create query template
		$query = "UPDATE FavoriteImage SET favoriteImageUserId = :favoriteImageUserId, favoriteImageDateTime = :favoriteImageDateTime WHERE favoriteImageId = :favoriteImageId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$formattedDate = $this->favoriteImageDateTime->format("Y-m-d H:i:S");
		$parameters = ["favoriteImageUserId => $this->favoriteImageUserId, "]

	}









}
