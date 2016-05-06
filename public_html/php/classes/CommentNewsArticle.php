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
	 * @param \DateTime|string|null $CommentnewNewsArticleDateTime CommentNewsArticleDateTime as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $CommentnewNewsArticleDateTime is not a valid object or string
	 * @throws \RangeException if $CommentNewsArticleDateTime is a date that does not exist
	 **/
	public
	function setCommentNewsArticleDateTime($newCommentNewsArticleDateTime = null) {
		//base case: if the date is null, use the current date and time
		if($CommentnewNewsArticleDateTime === null) {
			$this->CommentNewsArticleDateTime = new \DateTime();
			return;
		}
		// store the CommentNewsArticleDateTime
		try {
			$newCommentNewsArticleDateTime = $this->validateDate($CommentnewNewsArticleDateTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->CommentNewsArticleDateTime = $CommentnewNewsArticleDateTime;
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
		// verify the NewsArticleSynopsis will fit in the database
		if(strlen($newNewsArticleSynopsis) > 256) {
			throw(new \RangeException("NewsArticleSynopsis too large"));
		}

		// store the NewsArticleSynopsis;
		$this->NewsArticleSynopsis = $newNewsArticleSynopsis;
	}



	/**
	 * accessor method for NewsArticleUrl
	 *
	 * @return string value of NewsArticleUrl
	 **/
	public
	function getNewsArticleUrl() {
		return ($this->NewsArticleUrl);
	}

	/**
	 * mutator method for NewsArticleUrl
	 * @param string $newNewsArticleUrl new value of NewsArticleUrl
	 * @throws \InvalidArgumentException if $newNewsArticleUrl is not a string or insecure
	 * @throws \RangeException if $newNewsArticleUrl is > 256 characters
	 * @throws \TypeError if $newNewsArticleUrl is not a string
	 **/

	public
	function setNewsArticleUrl(string $newNewsArticleUrl) {
		// verify the NewsArticleUrl is secure
		$newNewsArticleUrl = trim($newNewsArticleUrl);
		$newNewsArticleUrl = filter_var($newNewsArticleUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newNewsArticleUrl) === true) {
			throw(new \InvalidArgumentException("NewsArticleUrl is empty or insecure"));
		}
		//verify the NewsArticleUrl will fit in the database
		if(strlen($newNewsArticleUrl) > 256){
			throw(new \RangeException("NewsArticleUrl too large"));
		}

		// store the NewsArticleUrl;
		$this->NewsArticleUrl = $newNewsArticleUrl;

	}

	/**
	 * inserts this Article into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the NewsArticleId is null (i.e., don't insert a NewsArticleId that already exists)
		if($this->NewsArticleId !== null) {
			throw(new \PDOException("not a new NewsArticle"));
		}

		// create query template
		$query = "INSERT INTO NewsArticle(NewsArticleDate, NewsArticleSynopsis, NewsArticleUrl) VALUES(:NewsArticleDate, :NewsArticleSynopsis, :NewsArticleUrl)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->NewsArticleDate->format("Y-m-d H:i:s");
		$parameters = ["NewsArticleId" => $this->NewsArticleId, "NewsArticleSynopsis" => $this->NewsArticleSynopsis, "NewsArticleUrl" => $this->NewsArticleUrl, "NewsArticleDate" => $formattedDate];
		$statement->excecute($parameters);

		// update the null ArticleId with what mySQL just gave us
		$this->NewsArticleId = intval($pdo->lastInsertId());

	}

	/**
	 * deletes this Article from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 */
	public function delete(\PDO $pdo) {
		// enforce the NewsArticleId is not null (i.e., don't delete a NewsArticle that hasn't been inserted)
		if($this->NewsArticleId === null) {
			throw(new \PDOException("unable to delete a NewsArticle that does not exist"));
		}
		//create query template
		$query = "DELETE FROM NewsArticleId WHERE NewsArticleId = :NewsArticleId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["NewsArticleId" => $this->NewsArticleId];
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
		// enforce the NewsArticleId is not null (i.e., don't update a NewsArticleId hasn't been inserted)
		if($this->NewsArticleId === null) {
			throw(new \PDOException("unable to update a NewsArticle that does not exist"));
		}
		// create query template
		$query = "UPDATE NewsArticle SET NewsArticleId = :NewsArticleId, NewsArticleDate = :NewsArticleDate, NewsArticleSynopsis = :NewsArticleSynopsis, NewsArticleUrl = :NewArticleUrl";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->NewsArticleDate->format("Y-m-d H:i:s");
		$parameters = ["NewsArticleId" => $this->NewsArticleId, "NewsArticleSynopsis" => $this->NewsArticleSynopsis, "NewsArticleUrl" => $this->NewsArticleUrl, "NewsArticleDate" => $this->$formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * gets the NewsArticle by Synopsis
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $NewsArticleSynopsis News Article Synopsis to search for
	 * @return \SplFixedArray SplFixedArray of NewsArticles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getNewsArticleByNewsArticleSynopsis(\PDO $pdo, string $NewsArticleSynopsis) {
		//sanitize the description before searching
		$NewsArticleSynopsis = trim($NewsArticleSynopsis);
		$NewsArticleSynopsis = filter_var($NewsArticleSynopsis, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if
		(empty($NewsArticleSynopsis) === true
		) {
			throw(new \PDOException("NewsArticleSynopsis is invalid"));
		}
		// create query template
		$query = "SELECT NewsArticleId, NewsArticleDate, NewsArticleSynopsis, NewsArticleUrl FROM NewsArticle WHERE NewsArticleSynopsis LIKE :NewsArticleSynopsis";
		$statement = $pdo->prepare($query);

		// bind the NewsArticleSynopsis to the place holder in the template
		$NewsArticleSynopsis = "%$NewsArticleSynopsis%";
		$parameters = array("NewsArticleSynopsis" => $NewsArticleSynopsis);
		$statement->execute($parameters);
		// build an array of NewsArticles
		$NewsArticle = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$NewsArticle = new NewsArticle($row["NewsArticleId"], $row["NewsArticleDate"], $row["NewsArticleSynopsis"], $row["NewsArticleUrl"]);
				$NewsArticle[$NewsArticle->key()] = $NewsArticle;
				$NewsArticle->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return ($NewsArticle);

	}
	/**
	 * gets the NewsArticle by NewsArticleId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $NewsArticleId tweet id to search for
	 * @return NewsArticle|null NewsArticle found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public
	static function getNewsArticleByNewsArticleId(\PDO $pdo, int $NewsArticleId) {
		// sanitize the tweetId before searching
		if($NewsArticleId <= 0) {
			throw(new \PDOException("Article id is not positive"));
		}

		// create query template
		$query = "SELECT NewsArticleId, NewsArticleDate, NewsArticleSynopsis, NewsArticleUrl FROM NewsArticle WHERE NewsArticleId = :NewsArticleId";
		$statement = $pdo->prepare($query);

		// bind the tweet id to the place holder in the template
		$parameters = array("NewsArticleId" => $NewsArticleId);
		$statement->execute($parameters);

		// grab the NewsArticle from mySQL
		try {
			$NewsArticle = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$NewsArticle = new NewsArticle($row["NewsArticleId"], $row["NewsArticleDate"], $row["NewsArticleSynopsis"], $row["NewsArticleUrl"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($NewsArticle);
	}

	/**
	 * gets all NewsArticles
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of NewsArticles found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllNewsArticles(\PDO $pdo) {
		// create query template
		$query = "SELECT NewsArticleId, NewsArticleDate, NewsArticleSynopsis, NewsArticleUrl FROM NewsArticle";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of NewsArticles
		$NewsArticles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$NewsArticle = new NewsArticle($row["NewsArticleId"], $row["NewsArticleDate"], $row["NewsArticleSynopsis"], $row["NewsArticleUrl"]);
				$NewsArticles[$NewsArticles->key()] = $NewsArticle;
				$NewsArticles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($NewsArticles);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["CommentNewsArticleDate"] = intval($this->CommentNewsArticleDate->format("U")) * 1000;
		return ($fields);
	}
}

