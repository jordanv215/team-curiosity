<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("Autoload.php");

/**
 *This commentNewsArticle class provides accessors and mutators for the commentNewsArticle database table
 * 
 * @author Anthony Williams <awilliams144@cnm.edu>
 * @version 1.0.0
 **/
class CommentNewsArticle implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for the commentNewsArticle; this is the primary key
	 * @var int $commentNewsArticleId
	 **/
	private $commentNewsArticleId;
	/**
	 * date and time that this Article was sent, in a PHP DateTime object
	 * @var \DateTime $commentNewsArticleDateTime
	 **/
	private $commentNewsArticleContent;
	/**
	 * the actual id of the commentNewsArticleNewsArticleId
	 * @var int $commentNewsArticleNewsArticleId
	 **/
	private $commentNewsArticleDateTime;
	/**
	 * actual textual Content of the commentNewsArticle
	 * @var string $commentNewsArticleContent
	 **/
	private $commentNewsArticleNewsArticleId;
	/**
	 * the actual id of the user who commented on NewsArticle foreign key
	 * @var int $commentNewsArticleUserId
	 **/
	private $commentNewsArticleUserId;

	/**
	 * constructor for this commentNewsArticle
	 * @param int|null $newCommentNewsArticleId id of this commentNewsArticle or Null if a new CommentNewsArticle
	 * @param int|null $newCommentNewsArticleUserId id of the user who commented on the NewsArticle
	 * @param int|null $newCommentNewsArticleNewsArticleId id of the commentNewsArticleNewsArticleId
	 * @param \DATETIME|string|null $newCommentNewsArticleDateTime date and time commentNewsArticle was sent or null if set to current date and time
	 * @param string $newCommentNewsArticleContent string containing content
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newCommentNewsArticleId = null, string $newCommentNewsArticleContent, \DateTime $newCommentNewsArticleDateTime = null,  int $newCommentNewsArticleNewsArticleId, int $newCommentNewsArticleUserId = null) {
		try {
			$this->setCommentNewsArticleId($newCommentNewsArticleId);
			$this->setCommentNewsArticleContent($newCommentNewsArticleContent);
			$this->setCommentNewsArticleDateTime($newCommentNewsArticleDateTime);
			$this->setCommentNewsArticleNewsArticleId($newCommentNewsArticleNewsArticleId);
			$this->setCommentNewsArticleUserId($newCommentNewsArticleUserId);
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
	 * accessor method for commentNewsArticleId
	 *
	 * @return int|null value of commentNewsArticleId
	 **/
	public function getCommentNewsArticleId() {
		return ($this->commentNewsArticleId);
	}

	/**
	 * mutator method for commentNewsArticleId
	 *
	 * @param int|null $newCommentNewsArticleId new value of commentNewsArticleId
	 * @throws \RangeException if $newCommentNewsArticleId is not positive
	 * @throws \TypeError if $commentNewsArticleId is not an integer
	 **/
	public function setCommentNewsArticleId(int $newCommentNewsArticleId = null) {
		//base case: if the commentNewsArticleId is null, this is a new commentNewsArticleId without a mySQL assigned id (yet)
		if($newCommentNewsArticleId === null) {
			$this->commentNewsArticleId = null;
			return;
		}

		//verify the commentNewsArticleId is positive
		if($newCommentNewsArticleId <= 0) {
			throw(new \RangeException("commentNewsArticleId is not positive"));
		}

		//convert and store the commentNewsArticleId
		$this->commentNewsArticleId = $newCommentNewsArticleId;
	}

	/**
	 * accessor method for commentNewsArticleDateTime
	 *
	 * @return \DateTime value of the commentNewsArticleDateTime
	 **/
	public function getCommentNewsArticleDateTime() {
		return ($this->commentNewsArticleDateTime);
	}

	/**
	 * mutator method for commentNewsArticleDateTime
	 * @param \DateTime|string|null $newCommentNewsArticleDateTime commentNewsArticleDateTime as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newCommentNewsArticleDateTime is not a valid object or string
	 * @throws \RangeException if $newCommentNewsArticleDateTime is a date that does not exist
	 **/
	public
	function setCommentNewsArticleDateTime(\DateTime $newCommentNewsArticleDateTime = null) {
		//base case: if the date is null, use the current date and time
		if($newCommentNewsArticleDateTime === null) {
			$this->commentNewsArticleDateTime = new \DateTime();
			return;
		}
		// store the commentNewsArticleDateTime
		try {
			$newCommentNewsArticleDateTime = $this->validateDate($newCommentNewsArticleDateTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->commentNewsArticleDateTime = $newCommentNewsArticleDateTime;
	}

	/**
	 * accessor method for commentNewsArticleContent
	 *
	 * @return string value of commentNewsArticleContent
	 **/
	public
	function getCommentNewsArticleContent() {
		return ($this->commentNewsArticleContent);
	}

	/**
	 * mutator method for commentNewsArticleContent
	 * @param string $newCommentNewsArticleContent new value of News Article Content
	 * @throws \InvalidArgumentException if $newCommentNewsArticleContent is not a string or insecure
	 * @throws \RangeException if $newCommentNewsArticleContent is > 256 characters
	 * @throws \TypeError if $newCommentNewsArticleContent is not a string
	 **/

	public function setCommentNewsArticleContent(string $newCommentNewsArticleContent) {
		// verify the commentNewsArticleContent is secure
		$newCommentNewsArticleContent = trim($newCommentNewsArticleContent);
		$newCommentNewsArticleContent = filter_var($newCommentNewsArticleContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCommentNewsArticleContent) === true) {
			throw(new \InvalidArgumentException("commentNewsArticleContent is empty or insecure"));
		}
		// verify the commentNewsArticleContent will fit in the database
		if(strlen($newCommentNewsArticleContent) > 1024) {
			throw(new \RangeException("commentNewsArticleContent too large"));
		}

		// store the newCommentNewsArticleContent;
		$this->commentNewsArticleContent = $newCommentNewsArticleContent;
	}
	/**
	 * accessor method for commentNewsArticleNewsArticleId
	 *
	 * @return int|null value of  commentNewsArticleNewsArticleId
	 **/
	public function getCommentNewsArticleNewsArticleId() {
		return ($this->commentNewsArticleNewsArticleId);
	}

	/**
	 * mutator method for commentNewsArticleNewsArticleId
	 *
	 * @param int|null $newCommentNewsArticleNewsArticleId new value of newCommentNewsArticleNewsArticleId
	 * @throws \RangeException if $newCommentNewsArticleNewsArticleId is not positive
	 * @throws \TypeError if $newCommentNewsArticleId is not an integer
	 **/
	public function setCommentNewsArticleNewsArticleId(int $newCommentNewsArticleNewsArticleId = null) {
		//base case: if the commentNewsArticleNewsArticleId is null, this is a new commentNewsArticle without a mySQL assigned id (yet)
		if($newCommentNewsArticleNewsArticleId === null) {
			$this->commentNewsArticleNewsArticleId = null;
			return;
		}

		//verify the commentNewsArticleNewsArticleId is positive
		if($newCommentNewsArticleNewsArticleId <= 0) {
			throw(new \RangeException("commentNewsArticleNewsArticleId is not positive"));
		}

		//convert and store the commentNewsArticleNewsArticleId
		$this->commentNewsArticleNewsArticleId = $newCommentNewsArticleNewsArticleId;
	}
	/**
	 * accessor method for commentNewsArticleUserId
	 *
	 * @return int|null value of  commentNewsArticleUserId
	 **/
	public function getCommentNewsArticleUserId() {
		return ($this->commentNewsArticleUserId);
	}

	/**
	 * mutator method for CommentNewsArticleUserId
	 *
	 * @param int|null $newCommentNewsArticleUserId new value of newCommentNewsArticleUserId
	 * @throws \RangeException if $newCommentNewsArticleUserId is not positive
	 * @throws \TypeError if $newCommentNewsArticleUserId is not an integer
	 **/
	public function setCommentNewsArticleUserId(int $newCommentNewsArticleUserId = null) {
		//base case: if the commentNewsArticleUserId is null, this is a new commentNewsArticleUserId without a mySQL assigned id (yet)
		if($newCommentNewsArticleUserId === null) {
			$this->commentNewsArticleUserId = null;
			return;
		}

		//verify the commentNewsArticleUserId is positive
		if($newCommentNewsArticleUserId <= 0) {
			throw(new \RangeException("commentNewsArticleUserId is not positive"));
		}

		//convert and store the commentNewsArticleUserId
		$this->commentNewsArticleUserId = $newCommentNewsArticleUserId;
	}


	/**
	 * inserts this commentArticle into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the commentNewsArticleId is null (i.e., don't insert a commentNewsArticleId that already exists)
		if($this->commentNewsArticleId !== null) {
			throw(new \PDOException("not a new commentNewsArticleId"));
		}

		// create query template
		$query = "INSERT INTO CommentNewsArticle(commentNewsArticleContent, commentNewsArticleDateTime, commentNewsArticleNewsArticleId, commentNewsArticleUserId ) VALUES(:commentNewsArticleContent, :commentNewsArticleDateTime, :commentNewsArticleNewsArticleId, :commentNewsArticleUserId)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->commentNewsArticleDateTime->format("Y-m-d H:i:s");
		$parameters = ["commentNewsArticleContent" => $this->commentNewsArticleContent, "commentNewsArticleNewsArticleId" => $this->commentNewsArticleNewsArticleId, "commentNewsArticleUserId" => $this->commentNewsArticleUserId, "commentNewsArticleDateTime" => $formattedDate];
		$statement->execute($parameters);

		// update the null ArticleId with what mySQL just gave us
		$this->commentNewsArticleId = intval($pdo->lastInsertId());

	}
	/**
	 * deletes this commentNewsArticle from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 */
	public function delete(\PDO $pdo) {
		//enforce the commentNewsArticle is not null (i.e., don't delete a commentNewsArticle that hasn't been inserted)
		if($this->commentNewsArticleId === null) {
			throw(new \PDOException("unable to delete a commentNewsArticle that does not exist"));
		}
		//create query template
		$query = "DELETE FROM CommentNewsArticle WHERE commentNewsArticleId = :commentNewsArticleId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["commentNewsArticleId" => $this->commentNewsArticleId];
		$statement->execute($parameters);
	}

	/**
	 * updates this commentNewsArticle in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 *
	 */
	public function update(\PDO $pdo) {
		// enforce the commentNewsArticleId is not null (i.e., don't update a commentNewsArticleId hasn't been inserted)
		if($this->commentNewsArticleId === null) {
			throw(new \PDOException("unable to update a commentNewsArticle that does not exist"));
		}
		// create query template
		$query = "UPDATE CommentNewsArticle SET commentNewsArticleContent = :commentNewsArticleContent, commentNewsArticleDateTime = :commentNewsArticleDateTime, commentNewsArticleNewsArticleId = :commentNewsArticleNewsArticleId, commentNewsArticleUserId = :commentNewsArticleUserId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->commentNewsArticleDateTime->format("Y-m-d H:i:s");
		$parameters = ["commentNewsArticleContent" => $this->commentNewsArticleContent, "commentNewsArticleNewsArticleId" => $this->commentNewsArticleNewsArticleId, "commentNewsArticleUserId" => $this->commentNewsArticleUserId, "commentNewsArticleDateTime" => $formattedDate];
		$statement->execute($parameters);
	}

	/** 
	 * get the commentNewsArticle by contents
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $commentNewsArticleContent News Article content to search for
	 * @return \SplFixedArray SplFixedArray of commentNewsArticleContent found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCommentNewsArticleContentByCommentNewsArticleContent(\PDO $pdo, string $commentNewsArticleContent) {
		//sanitize the description before searching
		$commentNewsArticleContent = trim($commentNewsArticleContent);
		$commentNewsArticleContent = filter_var($commentNewsArticleContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if
		(empty($commentNewsArticleContent) === true
		) {
			throw(new \PDOException("commentNewsArticleContent is invalid"));
		}
		// create query template
		$query = "SELECT commentNewsArticleId, commentNewsArticleContent, commentNewsArticleDateTime, commentNewsArticleNewsArticleId, commentNewsArticleUserId FROM CommentNewsArticle WHERE commentNewsArticleContent LIKE :commentNewsArticleContent";
		$statement = $pdo->prepare($query);

		// bind the commentNewsArticleContent to the place holder in the template
		$commentNewsArticleContent = "%$commentNewsArticleContent%";
		$parameters = array("commentNewsArticleContent" => $commentNewsArticleContent);
		$statement->execute($parameters);
		// build an array of NewsArticles
		$commentNewsArticles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$commentNewsArticle = new CommentNewsArticle($row["commentNewsArticleId"], $row["commentNewsArticleContent"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["commentNewsArticleDateTime"]), $row["commentNewsArticleNewsArticleId"], $row["commentNewsArticleUserId"]);
				$commentNewsArticles[$commentNewsArticles->key()] = $commentNewsArticle;
				$commentNewsArticles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return ($commentNewsArticles);

	}
	/**
	 * gets the commentNewsArticle by commentNewsArticleId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $commentNewsArticleId comment id to search for
	 * @return commentNewsArticle|null commentNewsArticle found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public
	static function getCommentNewsArticleByCommentNewsArticleId(\PDO $pdo, int $commentNewsArticleId) {
		// sanitize the commentNewsArticleId before searching
		if($commentNewsArticleId <= 0) {
			throw(new \PDOException("commentArticle id is not positive"));
		}

		// create query template
		$query = "SELECT commentNewsArticleId, commentNewsArticleContent, commentNewsArticleDateTime, commentNewsArticleNewsArticleId, commentNewsArticleUserId FROM CommentNewsArticle WHERE commentNewsArticleId = :commentNewsArticleId";
		$statement = $pdo->prepare($query);

		// bind the commentArticle id to the place holder in the template
		$parameters = array("commentNewsArticleId" => $commentNewsArticleId);
		$statement->execute($parameters);

		// grab the commentNewsArticle from mySQL
		try {
			$commentNewsArticle = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$commentNewsArticle = new CommentNewsArticle($row["commentNewsArticleId"], $row["commentNewsArticleContent"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["commentNewsArticleDateTime"]), $row["commentNewsArticleNewsArticleId"], $row["commentNewsArticleUserId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($commentNewsArticle);
	}

	/**
	 * gets all commentNewsArticles
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of commentNewsArticles found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllCommentNewsArticles(\PDO $pdo) {
		// create query template
		$query = "SELECT commentNewsArticleId, commentNewsArticleContent, commentNewsArticleDateTime, commentNewsArticleNewsArticleId, commentNewsArticleUserId FROM CommentNewsArticle";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of commentNewsArticles
		$commentNewsArticles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				 $commentNewsArticle = new CommentNewsArticle($row["commentNewsArticleId"], $row["commentNewsArticleContent"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["commentNewsArticleDateTime"]), $row["commentNewsArticleNewsArticleId"], $row["commentNewsArticleUserId"]);
				$commentNewsArticles[$commentNewsArticles->key()] = $commentNewsArticle;
				$commentNewsArticles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($commentNewsArticles);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["commentNewsArticleDateTime"] = intval($this->commentNewsArticleDateTime->format("U")) * 1000;
		return ($fields);
	}
}

