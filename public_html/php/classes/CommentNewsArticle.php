<?php
namespace Edu\Cnm\Awilliams144\TeamCuriosity;

require_once("autoload.php");

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
	 * @var int $CommentNewsArticleId
	 */
	private $CommentNewsArticleId;
	/**
	 * date and time that this Article was sent, in a PHP DateTime object
	 * @var \DateTime $CommentNewsArticleDateTime
	 **/
	private $CommentNewsArticleDateTime;
	/**
	 * actual textual Content of the CommentNewsArticle
	 * @var string $CommentNewsArticleContent
	 **/
	private $CommentNewsArticleContent;
	/**
	 * the actual id of the CommentNewsArticleNewsArticleId
	 * @var int $commentNewsArticleNewsArticleId
	 */
	private $CommentNewsArticleNewsArticleId;
	/**
	 * the actual id of the user who commented on NewsArticle foreign key
	 * @var int $CommentNewsArticleUserId
	 */
	private $CommentNewsArticleUserId;

	/**
	 * constructor for this CommentNewsArticle
	 * @param int|null $CommentNewsArticleId id of this CommentNewsArticle or Null if a new CommentNewsArticle
	 * @param int|null $CommentNewsArticleUserId id of the user who Commented on the NewsArticle
	 * @param int|null $CommentNewsArticleNewsArticleId id of the CommentNewsArticleNewsArticleId
	 * @param \DATETIME|string|null $CommentNewsArticleDate date and time CommentNewsArticle was sent or null if set to current date and time
	 * @param string $CommentNewsArticleContent string containing content
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $CommentNewsArticleId = null, $CommentNewsArticleDate = null, string $CommentNewsArticleContent, int $CommentNewsArticleNewsArticleId, int $CommentNewsArticleUserId)
	try{
			$this->setCommentNewsArticleUserId($CommentNewsArticleUserId);
			$this->setCommentNewsArticleId($CommentNewsArticleId);
			$this->setCommentNewsArticleDate($CommentNewsArticleDate);
			$this->setCommentNewsArticleContent($CommentNewsArticleContent);
			$this->setCommentNewsArticleNewsArticleId($CommentNewsArticleNewsArticleId);
			} catch(\InvalidArgumentException $invalidArgument) {
					// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
			} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
			} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
				throw(new \TypeError($typeError->getMessage(), 0, $typeError));
			 catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
				}
	/**
	 * accessor method for CommentNewsArticleId
	 *
	 * @return int|null value of  CommentNewsArticleId
	 **/
	public function getCommentNewsArticleId() {
		return ($this->CommentNewsArticleId);
	}

	/**
	 * mutator method for CommentNewsArticleId
	 *
	 * @param int|null $CommentNewsArticleId new value of CommentNewsArticleId
	 * @throws \RangeException if $CommentNewsArticleId is not positive
	 * @throws \TypeError if $CommentNewsArticleId is not an integer
	 **/
	public function setCommentNewsArticleId(int $CommentNewsArticleId = null) {
		//base case: if the CommentNewsArticleId is null, this is a new CommentNewsArticleId without a mySQL assigned id (yet)
		if($CommentNewsArticleId === null) {
			$this->CommentNewsArticleId = null;
			return;
		}

		//verify the CommentNewsArticleId is positive
		if($CommentNewsArticleId <= 0) {
			throw(new \RangeException("CommentNewsArticleId is not positive"));
		}

		//convert and store the CommentNewsArticleId
		$this->CommentNewsArticleId = $newCommentNewsArticleId;
	}

	/**
	 * accessor method for CommentNewsArticleDateTime
	 *
	 * @return \DateTime value of the CommentNewsArticleDateTime
	 **/
	public function getCommentNewsArticleDateTime() {
		return ($this->CommentNewsArticleDateTime);
	}

	/**
	 * mutator method for CommentNewsArticleDateTime
	 * @param \DateTime|string|null $newCommentNewsArticleDateTime CommentNewsArticleDateTime as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newCommentNewsArticleDateTime is not a valid object or string
	 * @throws \RangeException if $newCommentNewsArticleDateTime is a date that does not exist
	 **/
	public
	function setCommentNewsArticleDateTime($newCommentNewsArticleDateTime = null) {
		//base case: if the date is null, use the current date and time
		if($newCommentNewsArticleDateTime === null) {
			$this->CommentNewsArticleDateTime = new \DateTime();
			return;
		}
		// store the CommentNewsArticleDateTime
		try {
			$newCommentNewsArticleDateTime = $this->validateDate($newCommentNewsArticleDateTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->CommentNewsArticleDateTime = $newCommentNewsArticleDateTime;
	}

	/**
	 * accessor method for CommentNewsArticleContent
	 *
	 * @return string value of CommentNewsArticleContent
	 **/
	public
	function getCommentNewsArticleContent() {
		return ($this->CommentNewsArticleContent);
	}

	/**
	 * mutator method for CommentNewsArticleContent
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
			throw(new \RangeException("CommentNewsArticleContent too large"));
		}

		// store the newCommentNewsArticleContent;
		$this->newCommentNewsArticleContent = $newCommentNewsArticleContent;
	}
	/**
	 * accessor method for CommentNewsArticleNewsArticleId
	 *
	 * @return int|null value of  CommentNewsArticleNewsArticleId
	 **/
	public function getCommmentNewsArticleNewsArticleId() {
		return ($this->CommentNewsArticleNewsArticleId);
	}

	/**
	 * mutator method for CommentNewsArticleNewsArticleId
	 *
	 * @param int|null $newCommentNewsArticleNewsArticleId new value of newCommentNewsArticleNewsArticleId
	 * @throws \RangeException if $newCommentNewsArticleNewsArticleId is not positive
	 * @throws \TypeError if $newCommentNewsArticleId is not an integer
	 **/
	public function setCommentNewsArticleNewsArticleId(int $newCommentNewsArticleNewsArticleId = null) {
		//base case: if the CommentNewsArticleNewsArticleId is null, this is a new CommentNewsArticleNewsArticleId without a mySQL assigned id (yet)
		if($newCommentNewsArticleNewsArticleId === null) {
			$this->CommentNewsArticleNewsArtcileId = null;
			return;
		}

		//verify the CommentNewsArticleNewsArticleId is positive
		if($newCommentNewsArticleNewsArticleId <= 0) {
			throw(new \RangeException("CommentNewsArticleNewsArticleId is not positive"));
		}

		//convert and store the CommentNewsArticleNewsArticleId
		$this->CommentNewsArticleNewsArticleId = $newCommentNewsArticleNewsArticleId;
	}
	/**
	 * accessor method for CommentNewsArticleUserId
	 *
	 * @return int|null value of  CommentNewsArticleUserId
	 **/
	public function getCommentNewsArticleUserId() {
		return ($this->CommentNewsArticleUserId);
	}

	/**
	 * mutator method for CommentNewsArticleUserId
	 *
	 * @param int|null $newCommentNewsArticleUserId new value of newCommentNewsArticleUserId
	 * @throws \RangeException if $newCommentNewsArticleUserId is not positive
	 * @throws \TypeError if $newCommentNewsArticleUserId is not an integer
	 **/
	public function setCommentNewsArticleUserId(int $newCommentNewsArticleUserId = null) {
		//base case: if the CommentNewsArticleUserId is null, this is a new CommentNewsArticleUserId without a mySQL assigned id (yet)
		if($newCommentNewsArticleUserId === null) {
			$this->CommentNewsArticleUserId = null;
			return;
		}

		//verify the CommentNewsArticleUserId is positive
		if($newCommentNewsArticleUserId <= 0) {
			throw(new \RangeException("CommentNewsArticleUserId is not positive"));
		}

		//convert and store the CommentNewsArticleUserId
		$this->CommentNewsArticleUserId = $newCommentNewsArticleUserId;
	}


	/**
	 * inserts this Article into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the CommentNewsArticleId is null (i.e., don't insert a CommentNewsArticleId that already exists)
		if($this->CommentNewsArticleId !== null) {
			throw(new \PDOException("not a new CommentNewsArticleId"));
		}

		// create query template
		$query = "INSERT INTO CommentNewsArticleId(CommentNewsArticleDateTime, CommentNewsArticleContent, CommentNewsArticleNewsArticleId, CommentNewsArticleUserId) VALUES(:CommentNewsArticleDateTime, :CommentNewsArticleContent, :CommentNewsArticleNewsArticleId, :CommentNewsArticleUserId)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->CommentNewsArticleDateTime->format("Y-m-d H:i:s");
		$parameters = ["CommentNewsArticleId" => $this->CommentNewsArticleId, "CommentNewsArticleContent" => $this->CommentNewsArticleContent, "CommentNewsArticleUserId" => $this->CommentNewsArtcileUserId, "CommentNewsArticleNewsArticleId" => $this->CommentNewsArticleNewsArticleId,"CommentNewsArticleDateTime" => $formattedDate];
		$statement->excecute($parameters);

		// update the null ArticleId with what mySQL just gave us
		$this->CommentNewsArticleId = intval($pdo->lastInsertId());

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
		if($this->NewsArticleId === null) {
			throw(new \PDOException("unable to delete a CommentNewsArticle that does not exist"));
		}
		//create query template
		$query = "DELETE FROM CommentNewsArticleId WHERE CommentNewsArticleId = :CommentNewsArticleId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["CommentNewsArticleId" => $this->CommentNewsArticleId];
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
		// enforce the CommentNewsArticleId is not null (i.e., don't update a CommentNewsArticleId hasn't been inserted)
		if($this->CommentNewsArticleId === null) {
			throw(new \PDOException("unable to update a CommentNewsArticle that does not exist"));
		}
		// create query template
		$query = "UPDATE CommentNewsArticle SET CommentNewsArticleId = :CommentNewsArticleId, CommentNewsArticleDateTime = :CommentNewsArticleDateTime, CommentNewsArticleContent = :CommentNewsArticleContent, CommentNewsArticleNewsArticleId = :CommentNewsArticleNewsArticleId, CommentNewsArticleUserId = :CommentNewsArticleUserId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->CommentNewsArticleDateTime->format("Y-m-d H:i:s");
		$parameters = ["CommentNewsArticleId" => $this->CommentNewsArticleId, "CommentNewsArticleContent" => $this->CommentNewsArticleContent, "CommentNewsArticleNewsArticleId" => $this->CommentNewsArticleNewsArticleId, "CommentNewsArticleUserId" => $this->CommentNewsArticleUserId, "CommentNewsArticleDateTime" => $this->$formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * gets the CommentNewsArticleContent by Contents
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $CommentNewsArticleContent News Article Content to search for
	 * @return \SplFixedArray SplFixedArray of CommentNewsArticleContent found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCommentNewsArticleContentByCommentNewsArticleContent(\PDO $pdo, string $CommentNewsArticleContent) {
		//sanitize the description before searching
		$CommentNewsArticleContent = trim($CommentNewsArticleContent);
		$CommentNewsArticleContent = filter_var($CommentNewsArticleContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if
		(empty($CommentNewsArticleContent) === true
		) {
			throw(new \PDOException("CommentNewsArticleContent is invalid"));
		}
		// create query template
		$query = "SELECT CommentNewsArticleId, CommentNewsArticleDateTime, CommentNewsArticleContent, CommentNewsArticleNewsArticleId, CommentNewsArticleUserId FROM CommentNewsArticle WHERE CommentNewsArticleContent LIKE :CommentNewsArticleContent";
		$statement = $pdo->prepare($query);

		// bind the CommentNewsArticleContent to the place holder in the template
		$CommentNewsArticleContent = "%$CommentNewsArticleContent%";
		$parameters = array("CommentNewsArticleContent" => $CommentNewsArticleContent);
		$statement->execute($parameters);
		// build an array of NewsArticles
		$CommentNewsArticle = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$CommentNewsArticle = new CommentNewsArticle($row["CommentNewsArticleId"], $row["CommentNewsArticleDateTime"], $row["CommentNewsArticleContent"], $row["CommentNewsArticleUserId"], $row["CommentNewsArticleNewsArticleId"]);
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
	 * gets the CommentNewsArticle by CommentNewsArticleId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $CommentNewsArticleId Comment id to search for
	 * @return CommentNewsArticle|null CommentNewsArticle found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public
	static function getCommentNewsArticleByCommentNewsArticleId(\PDO $pdo, int $CommentNewsArticleId) {
		// sanitize the CommentId before searching
		if($CommentNewsArticleId <= 0) {
			throw(new \PDOException("CommentArticle id is not positive"));
		}

		// create query template
		$query = "SELECT NewsArticleId, NewsArticleDate, NewsArticleSynopsis, NewsArticleUrl FROM NewsArticle WHERE NewsArticleId = :NewsArticleId";
		$statement = $pdo->prepare($query);

		// bind the Commment Article id to the place holder in the template
		$parameters = array("CommentNewsArticleId" => $CommentNewsArticleId);
		$statement->execute($parameters);

		// grab the CommentNewsArticle from mySQL
		try {
			$CommentNewsArticle = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$CommentNewsArticle = new CommentNewsArticle($row["CommentNewsArticleId"], $row["CommentNewsArticleDateTime"], $row["CommentNewsArticleContent"], $row["CommentNewsArticleNewsArticleId"], $row["CommentNewsArticleUserId"]);
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
		$query = "SELECT CommentNewsArticleId, CommentNewsArticleDateTime, CommentNewsArticleContent, CommentNewsArticleNewsArticleId, CommentNewsArticleUserId FROM CommentNewsArticle";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of CommentNewsArticles
		$CommentNewsArticles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$CommentNewsArticle = new CommentNewsArticle($row["CommentNewsArticleId"], $row["CommentNewsArticleDateTime"], $row["CommentNewsArticleContent"], $row["CommentNewsArticleNewsArticleId], $row["CommentNewsArticleUserId"]);
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
		$fields["CommentNewsArticleDateTime"] = intval($this->CommentNewsArticleDateTime->format("U")) * 1000;
		return ($fields);
	}
}

