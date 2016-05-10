<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("Autoload.php");

/**
 * Comment Image Class
 *
 * This contains the accessor and mutator methods for the CommentImage table
 *
 * @author Kai Garrott <garrottkai@gmail.com>
 * @version 1.0.0
 */

class CommentImage implements \JsonSerializable {
	use ValidateDate;
	/**
	 * Unique ID of the image comment - this is the primary key
	 * @var int $commentImageId
	 */
	private $commentImageId;
	/**
	 * content of the image comment; maximum 1024B
	 * @var string $commentImageContent
	 */
	private $commentImageContent;
	/**
	 * timestamp of the image comment, as a DateTime object
	 * @var \DateTime $commentImageDateTime
	 */
	private $commentImageDateTime;
	/**
	 * ID of the image commented on - a foreign key
	 * @var $commentImageImageId
	 */
	private $commentImageImageId;
	/**
	 * ID of the user who created the comment - a foreign key
	 * @var $commentImageUserId
	 */
	private $commentImageUserId;

	/**
	 * Constructor for the image comment
	 * @param int|null $newCommentImageId new primary key assigned by mySQL; empty until inserted
	 * @param string $newCommentImageContent content of the new comment
	 * @param \DateTime|null $newCommentImageDateTime timestamp of the new comment as assigned by mySQL
	 * @param int $newCommentImageImageId id of the image newly commented on
	 * @param int $newCommentImageUserId id of the user who created the new comment
	 * @throws \InvalidArgumentException if entry is not valid
	 * @throws \RangeException if entry is negative or too long
	 * @throws \TypeError if type hint is violated
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newCommentImageId = null, string $newCommentImageContent, $newCommentImageDateTime = null, int $newCommentImageImageId, int $newCommentImageUserId) {
		try {
			$this->setCommentImageId($newCommentImageId);
			$this->setCommentImageContent($newCommentImageContent);
			$this->setCommentImageDateTime($newCommentImageDateTime);
			$this->setCommentImageImageId($newCommentImageImageId);
			$this->setCommentImageUserId($newCommentImageUserId);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for commentImageId
	 *
	 * @return int|null value of commentImageId
	 */
	public function getCommentImageId() {
		return ($this->commentImageId);
	}

	/**
	 * mutator method for commentImageId
	 *
	 * @param int|null $newCommentImageId new value of commentImageId
	 * @throws \RangeException if $newCommentImageId is not positive
	 * @throws \TypeError if $newCommentImageId is not an integer
	 */
	public function setCommentImageId(int $newCommentImageId = null) {
		// base case: comment not yet inserted into table; id is null
		if($newCommentImageId === null) {
			$this->commentImageId = null;
			return;
		}

		// verify the commentImageId is positive
		if($newCommentImageId <= 0) {
			throw(new \RangeException("commentImageId is not positive"));
		}

		// convert and store the commentImageId
		$this->commentImageId = $newCommentImageId;
	}

	/**
	 * accessor method for commentImageContent
	 *
	 * @return string value of $commentImageContent
	 */
	public function getCommentImageContent() {
		return ($this->commentImageContent);
	}

	/**
	 * mutator method for commentImageContent
	 *
	 * @param string $newCommentImageContent content of new comment
	 * @throws \InvalidArgumentException if $newCommentImageContent is not a string or is insecure
	 * @throws \RangeException if $newCommentImageContent is > 1024 characters
	 * @throws \TypeError if $newCommentImageContent is not a string
	 */
	public function setCommentImageContent(string $newCommentImageContent) {
		// verify the input is secure
		$newCommentImageContent = trim($newCommentImageContent);
		$newCommentImageContent = filter_var($newCommentImageContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCommentImageContent) === true) {
			throw(new \InvalidArgumentException("commentImageContent is empty or insecure"));
		}
		// verify the commentImageContent will fit in the table
		if(strlen($newCommentImageContent) > 1024) {
			throw(new \RangeException("commentImageContent is too long"));
		}
		// store the newCommentImageContent
		$this->commentImageContent = $newCommentImageContent;
	}
	
	/**
	 * accessor method for commentImageDateTime
	 * 
	 * @return \DateTime value of $commentImageDateTime
	 */
	public function getCommentImageDateTime() {
		return ($this->commentImageDateTime);
	}
	
	/**
	 * mutator method for commentImageDateTime
	 * 
	 * @param \DateTime|null $newCommentImageDateTime new timestamp from mySQL or null if not yet inserted
	 * @throws \InvalidArgumentException if $newCommentImageDateTime is not a valid object
	 * @throws \RangeException if $newCommentImageDateTime is a date that does not exist
	 */
	public function setCommentImageDateTime($newCommentImageDateTime = null) {
		// base case: if the value is null, the comment has not been inserted yet - use current timestamp
		if($newCommentImageDateTime === null) {
			$this->commentImageDateTime = new \DateTime();
			return;
		}
		// store the commentImageDateTime
		try {
			$newCommentImageDateTime = $this->ValidateDate($newCommentImageDateTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->commentImageDateTime = $newCommentImageDateTime;
	}

	/**
	 * inserts the datetime into table
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL-related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce that commentImageId is null (don't insert a row that already exists)
		if($this->commentImageId !== null) {
			throw(new \PDOException('not a new image comment'));
		}

		// create query template
		$query = "INSERT INTO CommentImage(commentImageContent, commentImageDateTime, commentImageImageId, commentImageUserId) VALUES(:commentImageContent, :commentImageDateTime, :commentImageImageId, :commentImageUserId)";

		// bind the member variables to the placeholders in the template
		$formattedDate = $this->commentImageDateTime->format("Y-m-d H:i:s");
		$parameters = ["commentImageContent" => $this->commentImageContent, "commentImageDateTime" => $formattedDate, "commentImageImageId" => $this->commentImageImageId, "commentImageUserId" => $this->commentImageUserId];
		$statement->execute($parameters);

		// update the null commentImageId with value generated by mySQL
		$this->commentImageId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this image comment from table
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL-related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		// enforce that commentImageId is not null (don't delete a comment that hasn't been inserted into table)
		if($this->commentImageId === null) {
			throw(new \PDOException("unable to delete a nonexistent comment"));
		}

		// create a query template
		$query = 
	}
}