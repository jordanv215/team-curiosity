<?php
namespace Edu\Cnm\Awilliams144\TeamCuriosity;

require_once("Autoload.php");

/**
 *This newsArticles can be a small example of what services
 *The Mars Curiosity Rover will send.  These can easily be extended
 * @author Anthony Williams <ailliams144@bootcamp-coders.cnm.edu>
 * @version 2.0.0
 **/
class newsArticle implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for the Article; this is the primary key
	 * @var int $newsArticleId
	 */
	private $newsArticleId;
	/**
	 * date and time that this Article was sent, in a PHP DateTime object
	 * @var \DateTime $newsArticleDate
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
	 */
	private $newsArticleUrl;

	/**
	 * constructor for this newsArticle
	 * @param int|null $newsArticleId id of this newsArticle or Null if a new newsArticle
	 * @param \DATETIME|string|null $ newsArticleDate date and time newsArticle was sent or null if set to current date and time
	 * @param string $newsArticleSynopsis string containing a brief synopsis
	 * @param string $newsArticleUrl string containing the location to newsArticleUrl
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newsArticleId = null, $newsArticleDate = null, string $newsArticleSynopsis, string $newsArticleUrl) {
		try {
			$this->setNewsArticleId($newsArticleId);
			$this->setNewsArticleDate($newsArticleDate);
			$this->setNewsArticleSynopsis($newsArticleSynopsis);
			$this->setNewsArticleUrl($newsArticleUrl);
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
	 * @param int|null $newsArticleId new value of newsArticleId
	 * @throws \RangeException if $newsArticleId is not positive
	 * @throws \TypeError if $newsArticleId is not an integer
	 **/
	public function setNewsArticleId(int $newsArticleId = null) {
		//base case: if the newsArticleId is null, this is a new newsArticleId without a mySQL assigned id (yet)
		if($newsArticleId === null) {
			$this->newsArticleId = null;
			return;
		}

		//verify the newsArticleId is positive
		if($newsArticleId <= 0) {
			throw(new \RangeException("newsArticleId is not positive"));
		}

		//convert and store the newsArticleId
		$this->newsArticleId = $newsArticleId;
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
	 * @param \DateTime|string|null $newsArticleDate newsArticleDate as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newsArticleDate is not a valid object or string
	 * @throws \RangeException if $newsArticleDate is a date that does not exist
	 **/
	public
	function setNewsArticleDate($newsArticleDate = null) {
		//base case: if the date is null, use the current date and time
		if($newsArticleDate === null) {
			$this->newsArticleDate = new \DateTime();
			return;
		}
		// store the newsArticleDate
		try {
			$newsArticleDate = $this->validateDate($newsArticleDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->newsArticleDate = $newsArticleDate;
	}

	/**
	 * accessor method for newsArticleSynopsis
	 *
	 * @return string value of newsArticleSynopsis
	 **/
	public
	function getNewsArticleSynopsis() {
		return ($this->newsArticleSynopsis);
	}

	/**
	 * mutator method for newsArticleSynopsis
	 * @param string $newsArticleSynopsis new value of newsArticleSynopsis
	 * @throws \InvalidArgumentException if $newsArticleSynopsis is not a string or insecure
	 * @throws \RangeException if $newsArticleSynopsis is > 256 characters
	 * @throws \TypeError if $newsArticleSynopsis is not a string
	 **/

	public
	function setNewsArticleSynopsis(string $newsArticleSynopsis) {
		if(strlen($newsArticleSynopsis) > 256) {
			// verify the newsArticleSynopsis is secure
			$newsArticleSynopsis = trim($newsArticleSynopsis);
			$newsArticleSynopsis = filter_var($newsArticleSynopsis, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newsArticleSynopsis) === true) {
				throw(new \InvalidArgumentException("newsArticleSynopsis is empty or insecure"));
			}

			// store the newsArticleSynopsis;
			$this->newsArticleSynopsis = $newsArticleSynopsis;
		}
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
	 * @param string $newsArticleUrl new value of newsArticleUrl
	 * @throws \InvalidArgumentException if $newsArticleUrl is not a string or insecure
	 * @throws \RangeException if $newsArticleUrl is > 256 characters
	 * @throws \TypeError if $newsArticleUrl is not a string
	 **/

	public
	function setNewsArticleUrl(string $newsArticleUrl) {
		if(strlen($newsArticleUrl) > 256) {
			// verify the newsArticleUrl is secure
			$newsArticleUrl = trim($newsArticleUrl);
			$newsArticleUrl = filter_var($newsArticleUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newsArticleUrl) === true) {
				throw(new \InvalidArgumentException("newsArticleUrl is empty or insecure"));
			}
			// store the newsArticleUrl;
			$this->newsArticleUrl = $newsArticleUrl;
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
			// enforce the newsArticleId is null (i.e., don't insert a newsArticleId that already exists)
			if($this->newsArticleId !== null){
				throw(new \PDOException("not a new newsArticle"));
			}

		// create query template
		$query = "INSERT INTO newsArticle(newsArticleDate, newsArticleSynopsis, newsArticleUrl) VALUES(:newsArticleDate, :newsArticleSynopsis, :newsArticleUrl)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->newsArticleDate->format("Y-m-d H:i:s");
		$parameters = ["newsArticleDate" => $this->newsArticleDate, "newsArticleSynopsis" => $this->newsArticleSynopsis, $formattedDate];
		$statement = $pdo->prepare($query);

	}


}