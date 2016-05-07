<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("Autoload.php");

/**
 *This newsArticle can be a small example of what services
 *The Mars Curiosity Rover will send.  These can easily be extended
 * @author Anthony Williams <ailliams144@bootcamp-coders.cnm.edu>
 * @version 2.0.0
 **/
class CommentNewsArticle implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for the CommentNewsArticle; this is the primary key
	 * @var int $commentNewsArticleId
	 */
	private $commentNewsArticleId;
	/**
	 * date and time that this Article was sent, in a PHP DateTime object
	 * @var \DateTime $commentNewsArticleDateTime
	 **/
	private $commentNewsArticleDateTime;
	/**
	 * actual textual Content of the CommentNewsArticle
	 * @var string $CommentNewsArticleContent
	 **/
	private $commentNewsArticleContent;
	/**
	 * the actual id of the CommentNewsArticleNewsArticleId
	 * @var int $commentNewsArticleNewsArticleId
	 */
	private $commentNewsArticleNewsArticleId;
	/**
	 * the actual id of the user who commented on NewsArticle foreign key
	 * @var int $commentNewsArticleUserId
	 */
	private $commentNewsArticleUserId;

	/**
	 * constructor for this CommentNewsArticle
	 * @param int|null $commentNewsArticleId id of this CommentNewsArticle or Null if a new CommentNewsArticle
	 * @param int|null $commentNewsArticleUserId id of the user who Commented on the NewsArticle
	 * @param int|null $commentNewsArticleNewsArticleId id of the commentNewsArticleNewsArticleId
	 * @param \DATETIME|string|null $commentNewsArticleDate date and time CommentNewsArticle was sent or null if set to current date and time
	 * @param string $commentNewsArticleContent string containing content
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $commentNewsArticleId = null, $commentNewsArticleDate = null, string $commentNewsArticleContent, int $commentNewsArticleNewsArticleId, int $commentNewsArticleUserId) {
	try{
			$this->setCommentNewsArticleUserId($commentNewsArticleUserId);
			$this->setCommentNewsArticleId($commentNewsArticleId);
			$this->setCommentNewsArticleDate($commentNewsArticleDate);
			$this->setCommentNewsArticleContent($commentNewsArticleContent);
			$this->setCommentNewsArticleNewsArticleId($commentNewsArticleNewsArticleId);
			} catch(\InvalidArgumentException $invalidArgument) {
					// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
			} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
			} catch(\TypeError $typeError) {
		// rethrow the exception to the caller
		throw(new \TypeError($typeError->getMessage(), 0, $typeError));
	catch
		(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
		}
	/**
	 * accessor method for commentNewsArticleId
	 *
	 * @return int|null value of  commentNewsArticleId
	 **/
	public function getCommentNewsArticleId() {
		return ($this->commentNewsArticleId);
	}

	/**
	 * mutator method for commentNewsArticleId
	 *
	 * @param int|null $commentNewsArticleId new value of commentNewsArticleId
	 * @throws \RangeException if $CommentNewsArticleId is not positive
	 * @throws \TypeError if $CommentNewsArticleId is not an integer
	 **/
	public function setCommentNewsArticleId(int $commentNewsArticleId = null) {
		//base case: if the commentNewsArticleId is null, this is a new commentNewsArticleId without a mySQL assigned id (yet)
		if($commentNewsArticleId === null) {
			$this->commentNewsArticleId = null;
			return;
		}

		//verify the commentNewsArticleId is positive
		if($commentNewsArticleId <= 0) {
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
	function setCommentNewsArticleDateTime($newCommentNewsArticleDateTime = null) {
		//base case: if the date is null, use the current date and time
		if($newCommentNewsArticleDateTime === null) {
			$this->commentNewsArticleDateTime = new \DateTime();
			return;
		}
		// store the commentNewsArticleDateTime
		try {
			$newcommentNewsArticleDateTime = $this->validateDate($newCommentNewsArticleDateTime);
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
		// verify the CommentNewsArticleContent is secure
		$newCommentNewsArticleContent = trim($newCommentNewsArticleContent);
		$newCommentNewsArticleContent = filter_var($newCommentNewsArticleContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCommentNewsArticleContent) === true) {
			throw(new \InvalidArgumentException(" is empty or insecure"));
		}
		// verify the CommentNewsArticleContent will fit in the database
		if(strlen($newCommentNewsArticleContent) > 1024) {
			throw(new \RangeException("commentNewsArticleContent too large"));
		}

		// store the newCommentNewsArticleContent;
		$this->newCommentNewsArticleContent = $newCommentNewsArticleContent;
	}
	/**
	 * accessor method for commentNewsArticleNewsArticleId
	 *
	 * @return int|null value of  commentNewsArticleNewsArticleId
	 **/
	public function getCommmentNewsArticleNewsArticleId() {
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
		//base case: if the commentNewsArticleNewsArticleId is null, this is a new commentNewsArticleNewsArticleId without a mySQL assigned id (yet)
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
		//base case: if the commentNewsArticleUserId is null, this is a new CommentNewsArticleUserId without a mySQL assigned id (yet)
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
	 * inserts this Article into mySQL
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
		$query = "INSERT INTO commentNewsArticleId(commentNewsArticleDateTime, commentNewsArticleContent, commentNewsArticleNewsArticleId, commentNewsArticleUserId) VALUES(:commentNewsArticleDateTime, :commentNewsArticleContent, :commentNewsArticleNewsArticleId, :commentNewsArticleUserId)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->commentNewsArticleDateTime->format("Y-m-d H:i:s");
		$parameters = ["commentNewsArticleId" => $this->commentNewsArticleId, "CommentNewsArticleContent" => $this->commentNewsArticleContent, "commentNewsArticleUserId" => $this->commentNewsArticleUserId, "commentNewsArticleNewsArticleId" => $this->commentNewsArticleNewsArticleId,"commentNewsArticleDateTime" => $formattedDate];
		$statement->execute($parameters);

		// update the null ArticleId with what mySQL just gave us
		$this->commentNewsArticleId = intval($pdo->lastInsertId());

	}
	/**
	 * deletes this CommentNewsArticle from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 */
	public function delete(\PDO $pdo) {
		//enforce the CommentNewsArticle is not null (i.e., don't delete a CommentNewsArticle that hasn't been inserted)
		if($this->commentNewsArticleId === null) {
			throw(new \PDOException("unable to delete a CommentNewsArticle that does not exist"));
		}
		//create query template
		$query = "DELETE FROM commentNewsArticleId WHERE commentNewsArticleId = :commentNewsArticleId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["commentNewsArticleId" => $this->commentNewsArticleId];
		$statement->execute($parameters);
	}

	/**
	 * updates this NewsArticle in mySQL
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
			throw(new \PDOException("unable to update a CommentNewsArticle that does not exist"));
		}
		// create query template
		$query = "UPDATE CommentNewsArticle SET commentNewsArticleId = :commentNewsArticleId, commentNewsArticleDateTime = :commentNewsArticleDateTime, commentNewsArticleContent = :commentNewsArticleContent, commentNewsArticleNewsArticleId = :CommentNewsArticleNewsArticleId, commentNewsArticleUserId = :commentNewsArticleUserId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->commentNewsArticleDateTime->format("Y-m-d H:i:s");
		$parameters = ["commentNewsArticleId" => $this->commentNewsArticleId, "commentNewsArticleContent" => $this->commentNewsArticleContent, "commentNewsArticleNewsArticleId" => $this->commentNewsArticleNewsArticleId, "commentNewsArticleUserId" => $this->commentNewsArticleUserId, "commentNewsArticleDateTime" => $this->$formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * gets the commentNewsArticleContent by Contents
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $commentNewsArticleContent News Article Content to search for
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
		$query = "SELECT commentNewsArticleId, commentNewsArticleDateTime, commentNewsArticleContent, commentNewsArticleNewsArticleId, commentNewsArticleUserId FROM CommentNewsArticle WHERE commentNewsArticleContent LIKE :commentNewsArticleContent";
		$statement = $pdo->prepare($query);

		// bind the commentNewsArticleContent to the place holder in the template
		$commentNewsArticleContent = "%$commentNewsArticleContent%";
		$parameters = array("commentNewsArticleContent" => $commentNewsArticleContent);
		$statement->execute($parameters);
		// build an array of NewsArticles
		$CommentNewsArticle = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$CommentNewsArticle = new CommentNewsArticle($row["commentNewsArticleId"], $row["commentNewsArticleDateTime"], $row["commentNewsArticleContent"], $row["commentNewsArticleUserId"], $row["commentNewsArticleNewsArticleId"]);
				$CommentNewsArticle[$CommentNewsArticle->key()] = $CommentNewsArticle;
				$CommentNewsArticle->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return ($CommentNewsArticle);

	}
	/**
	 * gets the CommentNewsArticle by commentNewsArticleId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $commentNewsArticleId Comment id to search for
	 * @return CommentNewsArticle|null CommentNewsArticle found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public
	static function getCommentNewsArticleByCommentNewsArticleId(\PDO $pdo, int $commentNewsArticleId) {
		// sanitize the CommentId before searching
		if($commentNewsArticleId <= 0) {
			throw(new \PDOException("CommentArticle id is not positive"));
		}

		// create query template
		$query = "SELECT commentNewsArticleId, commentNewsArticleDateTime, commentNewsArticleUserId, commentNewsArticleNewsArticleId, commentNewsArticleContent FROM CommentNewsArticle WHERE commentNewsArticleId = :commentNewsArticleId";
		$statement = $pdo->prepare($query);

		// bind the CommmentArticle id to the place holder in the template
		$parameters = array("commentNewsArticleId" => $commentNewsArticleId);
		$statement->execute($parameters);

		// grab the CommentNewsArticle from mySQL
		try {
			$CommentNewsArticle = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$CommentNewsArticle = new CommentNewsArticle($row["commentNewsArticleId"], $row["commentNewsArticleDateTime"], $row["commentNewsArticleContent"], $row["commentNewsArticleNewsArticleId"], $row["commentNewsArticleUserId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($CommentNewsArticle);
	}

	/**
	 * gets all CommentNewsArticles
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of CommentNewsArticles found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllCommentNewsArticles(\PDO $pdo) {
		// create query template
		$query = "SELECT commentNewsArticleId, commentNewsArticleDateTime, commentNewsArticleContent, commentNewsArticleNewsArticleId, commentNewsArticleUserId FROM CommentNewsArticle";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of CommentNewsArticles
		$CommentNewsArticles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$CommentNewsArticle = new CommentNewsArticle($row["commentNewsArticleId"], $row["commentNewsArticleDateTime"], $row["CommentNewsArticleContent"], $row["CommentNewsArticleNewsArticleId], $row["commentNewsArticleUserId"]);
				$CommentNewsArticles[$CommentNewsArticles->key()] = $CommentNewsArticle;
				$CommentNewsArticles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($CommentNewsArticles);
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

