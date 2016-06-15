<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("Autoload.php");

/**
 * News Article
 *
 * This class accesses and manipulates the News Article table to provide a feed of scientific news articles related to the Curiosity Mars rover
 * @author Anthony Williams <awilliams144@cnm.edu>
 * @version 1.0.0
 **/
class NewsArticle implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for the Article; this is the primary key
	 * @var int $newsArticleId
	 **/
	private $newsArticleId;
	/**
	 * title of the news article
	 * @var string $newsArticleTitle
	 **/
	private $newsArticleTitle;
	/**
	 * date and time that this Article was sent, in a PHP DateTime object
	 * @var \DateTime|null $newsArticleDate
	 **/
	private $newsArticleDate;
	/**
	 * actual textual Synopsis of the Article
	 * @var string $newsArticleSynopsis
	 **/
	private $newsArticleSynopsis;
	/**
	 * the actual Url of the Article
	 * @var string $newsArticleUrl
	 **/
	private $newsArticleUrl;

	/**
	 * constructor for this NewsArticle
	 * @param int|null $newNewsArticleId id of this NewsArticle or Null if a new NewsArticle
	 * @param string $newNewsArticleTitle title of this NewsArticle
	 * @param \DateTime|string|null $newNewsArticleDate Date and Time NewsArticle was sent or null if set to current Date and Time
	 * @param string $newNewsArticleSynopsis string containing a brief synopsis
	 * @param string $newNewsArticleUrl string containing the location to newsArticleUrl
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newNewsArticleId = null, string $newNewsArticleTitle, \DateTime $newNewsArticleDate = null, string $newNewsArticleSynopsis, string $newNewsArticleUrl) {
		try {
			$this->setNewsArticleId($newNewsArticleId);
			$this->setNewsArticleTitle($newNewsArticleTitle);
			$this->setNewsArticleDate($newNewsArticleDate);
			$this->setNewsArticleSynopsis($newNewsArticleSynopsis);
			$this->setNewsArticleUrl($newNewsArticleUrl);
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
	 * accessor method for newsArticleId
	 *
	 * @return int|null value of  newsArticleId
	 **/
	public function getNewsArticleId() {
		return ($this->newsArticleId);
	}

	/**
	 * mutator method for newsArticleId
	 *
	 * @param int|null $newNewsArticleId new value of newsArticleId
	 * @throws \RangeException if $newNewsArticleId is not positive
	 * @throws \TypeError if $newNewsArticleId is not an integer
	 **/
	public function setNewsArticleId(int $newNewsArticleId = null) {
		//base case: if the newsArticleId is null, this is a new newsArticleId without a mySQL assigned id (yet)
		if($newNewsArticleId === null) {
			$this->newsArticleId = null;
			return;
		}

		//verify the newsArticleId is positive
		if($newNewsArticleId <= 0) {
			throw(new \RangeException("newsArticleId is not positive"));
		}

		//convert and store the newsArticleId
		$this->newsArticleId = $newNewsArticleId;
	}

	/**
	 * accessor method for newsArticleTitle
	 *
	 * @return string value of newsArticleTitle
	 **/
	public function getNewsArticleTitle() {
		return ($this->newsArticleTitle);
	}

	/**
	 * mutator method for newsArticleTitle
	 * @param string $newNewsArticleTitle
	 * @throws \InvalidArgumentException if $newNewsArticleTitle is not a string or is insecure
	 * @throws \RangeException if $newNewsArticleTitle is > 128 characters
	 * @throws \TypeError if $newNewsArticleTitle is not a string
	 **/
	public function setNewsArticleTitle(string $newNewsArticleTitle) {
		// verify the newsArticleTitle is secure
		$newNewsArticleTitle = trim($newNewsArticleTitle);
		$newNewsArticleTitle = filter_var($newNewsArticleTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newNewsArticleTitle) === true) {
			throw(new \InvalidArgumentException("newsArticleTitle is empty or insecure"));
		}
		// verify the newsArticleTitle will fit in the database
		if(strlen($newNewsArticleTitle) > 128) {
			throw(new \RangeException("newsArticleTitle is too large"));
		}

		// store the newsArticleTitle;
		$this->newsArticleTitle = $newNewsArticleTitle;
	}

	/**
	 * accessor method for newsArticleDate
	 *
	 * @return \DateTime value of the newsArticleDate
	 **/
	public function getNewsArticleDate() {
		return ($this->newsArticleDate);
	}

	/**
	 * mutator method for newsArticleDate
	 * @param \DateTime|string|null $newNewsArticleDate newsArticleDate as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newNewsArticleDate is not a valid object or string
	 * @throws \RangeException if $newNewsArticleDate is a date that does not exist
	 **/
	public function setNewsArticleDate(\DateTime $newNewsArticleDate = null) {
		//base case: if the date is null, use the current date and time
		if($newNewsArticleDate === null) {
			$this->newsArticleDate = new \DateTime();
			return;
		}
		// store the newsArticleDate
		try {
			$newNewsArticleDate = $this->validateDate($newNewsArticleDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->newsArticleDate = $newNewsArticleDate;
	}

	/**
	 * accessor method for newsArticleSynopsis
	 *
	 * @return string value of newsArticleSynopsis
	 **/
	public function getNewsArticleSynopsis() {
		return ($this->newsArticleSynopsis);
	}

	/**
	 * mutator method for newsArticleSynopsis
	 * @param string $newNewsArticleSynopsis new value of News Article Synopsis
	 * @throws \InvalidArgumentException if $newNewsArticleSynopsis is not a string or insecure
	 * @throws \RangeException if $newNewsArticleSynopsis is > 256 characters
	 * @throws \TypeError if $newNewsArticleSynopsis is not a string
	 **/

	public function setNewsArticleSynopsis(string $newNewsArticleSynopsis) {
		// verify the newsArticleSynopsis is secure
		$newNewsArticleSynopsis = trim($newNewsArticleSynopsis);
		$newNewsArticleSynopsis = filter_var($newNewsArticleSynopsis, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newNewsArticleSynopsis) === true) {
			throw(new \InvalidArgumentException("newsArticleSynopsis is empty or insecure"));
		}
		// verify the newsArticleSynopsis will fit in the database
		if(strlen($newNewsArticleSynopsis) > 256) {
			throw(new \RangeException("newsArticleSynopsis too large"));
		}

		// store the newsArticleSynopsis;
		$this->newsArticleSynopsis = $newNewsArticleSynopsis;
	}


	/**
	 * accessor method for newsArticleUrl
	 *
	 * @return string value of newsArticleUrl
	 **/
	public
	function getNewsArticleUrl() {
		return ($this->newsArticleUrl);
	}

	/**
	 * mutator method for newsArticleUrl
	 * @param string $newNewsArticleUrl new value of newsArticleUrl
	 * @throws \InvalidArgumentException if $newNewsArticleUrl is not a string or insecure
	 * @throws \RangeException if $newNewsArticleUrl is > 256 characters
	 * @throws \TypeError if $newNewsArticleUrl is not a string
	 **/

	public
	function setNewsArticleUrl(string $newNewsArticleUrl) {
		// verify the newsArticleUrl is secure
		$newNewsArticleUrl = trim($newNewsArticleUrl);
		$newNewsArticleUrl = filter_var($newNewsArticleUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newNewsArticleUrl) === true) {
			throw(new \InvalidArgumentException("newsArticleUrl is empty or insecure"));
		}
		//verify the newsArticleUrl will fit in the database
		if(strlen($newNewsArticleUrl) > 256) {
			throw(new \RangeException("newsArticleUrl too large"));
		}

		// store the newsArticleUrl;
		$this->newsArticleUrl = $newNewsArticleUrl;

	}

	/**
	 * inserts this Article into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the newsArticleId is null (i.e., don't insert a newsArticleId that already exists)
		if($this->newsArticleId !== null) {
			throw(new \PDOException("not a new newsArticle"));
		}

		// create query template
		$query = "INSERT INTO NewsArticle(newsArticleTitle, newsArticleDate, newsArticleSynopsis, newsArticleUrl) VALUES(:newsArticleTitle, :newsArticleDate, :newsArticleSynopsis, :newsArticleUrl)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->newsArticleDate->format("Y-m-d H:i:s");
		$parameters = ["newsArticleTitle" => $this->newsArticleTitle, "newsArticleDate" => $formattedDate, "newsArticleSynopsis" => $this->newsArticleSynopsis, "newsArticleUrl" => $this->newsArticleUrl];
		$statement->execute($parameters);

		// update the null articleId with what mySQL just gave us
		$this->newsArticleId = intval($pdo->lastInsertId());

	}

	/**
	 * deletes this Article from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 **/
	public function delete(\PDO $pdo) {
		// enforce the newsArticleId is not null (i.e., don't delete a newsArticle that hasn't been inserted)
		if($this->newsArticleId === null) {
			throw(new \PDOException("unable to delete a newsArticle that does not exist"));
		}
		//create query template
		$query = "DELETE FROM NewsArticle WHERE newsArticleId = :newsArticleId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["newsArticleId" => $this->newsArticleId];
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
	 **/
	public function update(\PDO $pdo) {
		// enforce the newsArticleId is not null (i.e., don't update a newsArticleId hasn't been inserted)
		if($this->newsArticleId === null) {
			throw(new \PDOException("unable to update a NewsArticle that does not exist"));
		}
		// create query template
		$query = "UPDATE NewsArticle SET newsArticleTitle = :newsArticleTitle, newsArticleDate = :newsArticleDate, newsArticleSynopsis = :newsArticleSynopsis, newsArticleUrl = :newsArticleUrl";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->newsArticleDate->format("Y-m-d H:i:s");
		$parameters = ["newsArticleTitle" => $this->newsArticleTitle, "newsArticleDate" => $formattedDate, "newsArticleSynopsis" => $this->newsArticleSynopsis, "newsArticleUrl" => $this->newsArticleUrl];
		$statement->execute($parameters);
	}

	/**
	 * gets the NewsArticle by Synopsis
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $newsArticleSynopsis News Article Synopsis to search for
	 * @return \SplFixedArray SplFixedArray of NewsArticles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getNewsArticleByNewsArticleSynopsis(\PDO $pdo, string $newsArticleSynopsis) {
		//sanitize the description before searching
		$newsArticleSynopsis = trim($newsArticleSynopsis);
		$newsArticleSynopsis = filter_var($newsArticleSynopsis, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if
		(empty($newsArticleSynopsis) === true
		) {
			throw(new \PDOException("newsArticleSynopsis is invalid"));
		}
		// create query template
		$query = "SELECT newsArticleId, newsArticleTitle, newsArticleDate, newsArticleSynopsis, newsArticleUrl FROM NewsArticle WHERE newsArticleSynopsis LIKE :newsArticleSynopsis";
		$statement = $pdo->prepare($query);

		// bind the newsArticleSynopsis to the place holder in the template
		$newsArticleSynopsis = "%$newsArticleSynopsis%";
		$parameters = array("newsArticleSynopsis" => $newsArticleSynopsis);
		$statement->execute($parameters);
		// build an array of NewsArticles
		$newsArticles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$newsArticle = new NewsArticle($row["newsArticleId"], $row["newsArticleTitle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["newsArticleDate"]), $row["newsArticleSynopsis"], $row["newsArticleUrl"]);
				$newsArticles[$newsArticles->key()] = $newsArticle;
				$newsArticles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return ($newsArticles);

	}

	/**
	 * gets the newsArticle by newsArticleId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $newsArticleId newsArticleId to search for
	 * @return NewsArticle|null newsArticle found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getNewsArticleByNewsArticleId(\PDO $pdo, int $newsArticleId) {
		// sanitize the tweetId before searching
		if($newsArticleId <= 0) {
			throw(new \PDOException("Article id is not positive"));
		}

		// create query template
		$query = "SELECT newsArticleId, newsArticleTitle, newsArticleDate, newsArticleSynopsis, newsArticleUrl FROM NewsArticle WHERE newsArticleId = :newsArticleId";
		$statement = $pdo->prepare($query);

		// bind the tweet id to the place holder in the template
		$parameters = array("newsArticleId" => $newsArticleId);
		$statement->execute($parameters);

		// grab the NewsArticle from mySQL
		try {
			$newsArticle = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$newsArticle = new NewsArticle($row["newsArticleId"], $row["newsArticleTitle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["newsArticleDate"]), $row["newsArticleSynopsis"], $row["newsArticleUrl"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($newsArticle);
	}

	/**
	 * gets the NewsArticle by Title
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $newsArticleTitle News Article Title to search for
	 * @return \SplFixedArray SplFixedArray of NewsArticles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getNewsArticleByNewsArticleTitle(\PDO $pdo, string $newsArticleTitle) {
		//sanitize the input before searching
		$newsArticleTitle = trim($newsArticleTitle);
		$newsArticleTitle = filter_var($newsArticleTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if
		(empty($newsArticleTitle) === true
		) {
			throw(new \PDOException("newsArticleTitle is invalid"));
		}
		// create query template
		$query = "SELECT newsArticleId, newsArticleTitle, newsArticleDate, newsArticleSynopsis, newsArticleUrl FROM NewsArticle WHERE newsArticleTitle LIKE :newsArticleTitle";
		$statement = $pdo->prepare($query);

		// bind the newsArticleTitle to the place holder in the template
		$newsArticleTitle = "%$newsArticleTitle%";
		$parameters = array("newsArticleTitle" => $newsArticleTitle);
		$statement->execute($parameters);
		// build an array of NewsArticles
		$newsArticles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$newsArticle = new NewsArticle($row["newsArticleId"], $row["newsArticleTitle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["newsArticleDate"]), $row["newsArticleSynopsis"], $row["newsArticleUrl"]);
				$newsArticles[$newsArticles->key()] = $newsArticle;
				$newsArticles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return ($newsArticles);

	}


	/**
	 * gets the newsArticle by newsArticleDate
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param \DateTime $newsArticleDate newsArticleDate to search for
	 * @return NewsArticle|null newsArticle found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getNewsArticleByNewsArticleDate(\PDO $pdo, \DateTime $newsArticleDate) {
		// sanitize the newsArticleDate before searching
		try {
			$newsArticleDate = self::validateDate($newsArticleDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}

		// create query template
		$query = "SELECT newsArticleId, newsArticleTitle, newsArticleDate, newsArticleSynopsis, newsArticleUrl FROM NewsArticle WHERE newsArticleDate = :newsArticleDate";
		$statement = $pdo->prepare($query);

		// bind the tweet id to the place holder in the template
		$parameters = array("newsArticleDate" => $newsArticleDate->format("Y-m-d H:i:s"));
		$statement->execute($parameters);

		// grab the NewsArticle from mySQL
		$newsArticles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$newsArticle = new NewsArticle($row["newsArticleId"], $row["newsArticleTitle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["newsArticleDate"]), $row["newsArticleSynopsis"], $row["newsArticleUrl"]);
				$newsArticles[$newsArticles->key()] = $newsArticle;
				$newsArticles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return ($newsArticles);
	}

	/**
	 * gets the NewsArticle by URL
	 * sanitization unnecessary because this method is strictly internal
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $newsArticleUrl News Article URL to search for
	 * @return NewsArticle if found or null if none
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getNewsArticleByNewsArticleUrl(\PDO $pdo, string $newsArticleUrl) {

		// create query template
		$query = "SELECT newsArticleId, newsArticleTitle, newsArticleDate, newsArticleSynopsis, newsArticleUrl FROM NewsArticle WHERE newsArticleUrl = :newsArticleUrl";
		$statement = $pdo->prepare($query);
		$newsArticleUrl = trim($newsArticleUrl);
		// bind the newsArticleUrl to the place holder in the template
		$parameters = array("newsArticleUrl" => $newsArticleUrl);
		$statement->execute($parameters);

		try {
			$newsArticle = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$newsArticle = new NewsArticle($row["newsArticleId"], $row["newsArticleTitle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["newsArticleDate"]), $row["newsArticleSynopsis"], $row["newsArticleUrl"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		return ($newsArticle);

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
		$query = "SELECT newsArticleId, newsArticleTitle, newsArticleDate, newsArticleSynopsis, newsArticleUrl FROM NewsArticle";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of NewsArticles
		$newsArticles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$newsArticle = new NewsArticle($row["newsArticleId"], $row["newsArticleTitle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["newsArticleDate"]), $row["newsArticleSynopsis"], $row["newsArticleUrl"]);
				$newsArticles[$newsArticles->key()] = $newsArticle;
				$newsArticles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($newsArticles);
	}

	public static function getNewsArticles(\PDO $pdo) {
		$query = "SELECT newsArticleId, newsArticleTitle, newsArticleDate, newsArticleSynopsis, newsArticleUrl FROM NewsArticle ORDER BY newsArticleDate DESC LIMIT 25";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of NewsArticles
		$newsArticles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$newsArticle = new NewsArticle($row["newsArticleId"], $row["newsArticleTitle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["newsArticleDate"]), $row["newsArticleSynopsis"], $row["newsArticleUrl"]);
				$newsArticles[$newsArticles->key()] = $newsArticle;
				$newsArticles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($newsArticles);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["newsArticleDate"] = intval($this->newsArticleDate->format("U")) * 1000;
		return ($fields);
	}
}

