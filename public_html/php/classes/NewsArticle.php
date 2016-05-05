<?php
namespace Edu\Cnm\Awilliams144\TeamCuriosity;

require_once("Autoload.php");

/**
 *This newsArticles can be a small example of what services
 *The Mars Curiosity Rover will send.  These can easily be extended
 * @author Anthony Williams <ailliams144@bootcamp-coders.cnm.edu>
 * @version 2.0.0
 **/
class NewsArticle implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for the Article; this is the primary key
	 * @var int $NewsArticleId
	 */
	private $NewsArticleId;
	/**
	 * date and time that this Article was sent, in a PHP DateTime object
	 * @var \DateTime $NewsArticleDate
	 **/
	private $NewsArticleDate;
	/**
	 * actual textual Synopsis of the Article
	 * @var string $NewsArticleSynopsis
	 **/
	private $NewsArticleSynopsis;
	/**
	 * the actual Url of the Article
	 * @var string $NewsArticleUrl
	 */
	private $newsArticleUrl;

	/**
	 * constructor for this NewsArticle
	 * @param int|null $NewsArticleId id of this NewsArticle or Null if a new NewsArticle
	 * @param \DATETIME|string|null $ NewsArticleDate date and time NewsArticle was sent or null if set to current date and time
	 * @param string $NewsArticleSynopsis string containing a brief synopsis
	 * @param string $NewsArticleUrl string containing the location to NewsArticleUrl
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $NewsArticleId = null, $NewsArticleDate = null, string $NewsArticleSynopsis, string $NewsArticleUrl) {
		try {
			$this->setNewsArticleId($NewsArticleId);
			$this->setNewsArticleDate($NewsArticleDate);
			$this->setNewsArticleSynopsis($NewsArticleSynopsis);
			$this->setNewsArticleUrl($NewsArticleUrl);
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
	 * accessor method for NewsArticleId
	 *
	 * @return int|null value of  NewsArticleId
	 **/
	public function getNewsArticleId() {
		return ($this->NewsArticleId);
	}

	/**
	 * mutator method for NewsArticleId
	 *
	 * @param int|null $NewsArticleId new value of NewsArticleId
	 * @throws \RangeException if $NewsArticleId is not positive
	 * @throws \TypeError if $NewsArticleId is not an integer
	 **/
	public function setNewsArticleId(int $NewsArticleId = null) {
		//base case: if the NewsArticleId is null, this is a new NewsArticleId without a mySQL assigned id (yet)
		if($NewsArticleId === null) {
			$this->NewsArticleId = null;
			return;
		}

		//verify the NewsArticleId is positive
		if($NewsArticleId <= 0) {
			throw(new \RangeException("NewsArticleId is not positive"));
		}

		//convert and store the NewsArticleId
		$this->NewsArticleId = $NewsArticleId;
	}

	/**
	 * accessor method for NewsArticleDate
	 *
	 * @return \DateTime value of the NewsArticleDate
	 **/
	public function getNewsArticleDate() {
		return ($this->NewsArticleDate);
	}

	/**
	 * mutator method for NewsArticleDate
	 * @param \DateTime|string|null $NewsArticleDate NewsArticleDate as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $NewsArticleDate is not a valid object or string
	 * @throws \RangeException if $NewsArticleDate is a date that does not exist
	 **/
	public
	function setNewsArticleDate($NewsArticleDate = null) {
		//base case: if the date is null, use the current date and time
		if($NewsArticleDate === null) {
			$this->NewsArticleDate = new \DateTime();
			return;
		}
		// store the newsArticleDate
		try {
			$NewsArticleDate = $this->validateDate($NewsArticleDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->NewsArticleDate = $NewsArticleDate;
	}

	/**
	 * accessor method for NewsArticleSynopsis
	 *
	 * @return string value of NewsArticleSynopsis
	 **/
	public
	function getNewsArticleSynopsis() {
		return ($this->NewsArticleSynopsis);
	}

	/**
	 * mutator method for NewsArticleSynopsis
	 * @param string $NewsArticleSynopsis new value of NewsArticleSynopsis
	 * @throws \InvalidArgumentException if $NewsArticleSynopsis is not a string or insecure
	 * @throws \RangeException if $NewsArticleSynopsis is > 256 characters
	 * @throws \TypeError if $NewsArticleSynopsis is not a string
	 **/

	public
	function setNewsArticleSynopsis(string $NewsArticleSynopsis) {
		if(strlen($NewsArticleSynopsis) > 256) {
			// verify the NewsArticleSynopsis is secure
			$NewsArticleSynopsis = trim($NewsArticleSynopsis);
			$NewsArticleSynopsis = filter_var($NewsArticleSynopsis, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($NewsArticleSynopsis) === true) {
				throw(new \InvalidArgumentException("NewsArticleSynopsis is empty or insecure"));
			}

			// store the NewsArticleSynopsis;
			$this->NewsArticleSynopsis = $NewsArticleSynopsis;
		}
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
	 * @param string $NewsArticleUrl new value of NewsArticleUrl
	 * @throws \InvalidArgumentException if $NewsArticleUrl is not a string or insecure
	 * @throws \RangeException if $NewsArticleUrl is > 256 characters
	 * @throws \TypeError if $NewsArticleUrl is not a string
	 **/

	public
	function setNewsArticleUrl(string $NewsArticleUrl) {
		if(strlen($NewsArticleUrl) > 256) {
			// verify the NewsArticleUrl is secure
			$NewsArticleUrl = trim($NewsArticleUrl);
			$NewsArticleUrl = filter_var($NewsArticleUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($NewsArticleUrl) === true) {
				throw(new \InvalidArgumentException("NewsArticleUrl is empty or insecure"));
			}
			// store the NewsArticleUrl;
			$this->NewsArticleUrl = $NewsArticleUrl;
			{
			}
		}

	}

	/**
	 * inserts this Article into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo){
			// enforce the NewsArticleId is null (i.e., don't insert a NewsArticleId that already exists)
			if($this->NewsArticleId !== null){
				throw(new \PDOException("not a new NewsArticle"));
			}

		// create query template
		$query = "INSERT INTO NewsArticle(NewsArticleDate, NewsArticleSynopsis, NewsArticleUrl) VALUES(:NewsArticleDate, :NewsArticleSynopsis, :NewsArticleUrl)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->NewsArticleDate->format("Y-m-d H:i:s");
		$parameters = ["NewsArticleDate" => $this->NewsArticleDate, "NewsArticleSynopsis" => $this->NewsArticleSynopsis, $formattedDate];
		$statement = $pdo->prepare($query);

	}


}