<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("autoload.php");

/**A section for users to like their favorite article of news
 * 
 * This favoriteNewsArticle can be considered a small example of what services like favoriteNewsArticle store when NewsArticle are favorited and received by using favoriteNewsArticle.
 * */
class favoriteNewsArticle implements \JsonSerializable {
	use ValidateDate;
}
	/**
 	* id for this favoriteNewsArticle; this is the part of composite primary key
 	* @var int $favoriteNewsArticleNewsArticleId
 	**/
	private $favoriteNewsArticleNewsArticleId;
	/**id of the user who favorites this newsArticle; this is a composite primary key
	 *@var int $favoriteNewsArticleUserId
	 * */
	private $favoriteNewsArticleUserId;
	/**
	 * date and time this favoriteNewsArticle was sent, in a PHP DateTIme object
	 * @var \DateTime $favoriteNewsArticleDateTime
	 **/
	private $favoriteNewsArticleDateTime;

	/**
 	* constructor for this favoriteNewsArticle
 	* 
 	* @param int $newFavoriteNewArticleNewsArticleId id of this favoriteNewArticle
 	* @param int $newFavoriteNewArticleUserId id of the user who sent this favoriteNewArticle
 	* @param \DateTime/string/null $newFavoriteNewsArticleDateTime date and time favoriteNewsArticle was sent or null 	if set to current date and time
 	* @throws \InvalidArgumentException if data types are not valid
 	* @throws \RangeException if data values are out of bounds (e.g., strings too long,negative integers)
	 * @throw \TypeError if data types violate type hints
 	* @throw \Exception if some other exception occurs
	 **/
	public function __construct(int $newFavoriteNewsArticleNewsArticleId =null, int $newFavoriteNewsArticleUserId, 	$newFavoriteNewsArticleDateTime = null){
			try {
				$this->setFavoriteNewsArticleNewsArticleId($newFavoriteNewsArticleNewsArticleId);
				$this->setFavoriteNewsArticleUserId($newFavoriteNewsArticleUserId);
				$this->setFavoriteNewsArticleDateTime($newFavoriteNewsArticleDateTime);
			}	catch(\InvalidArgumentException $invalidArgument) {
				//rethrow the exception to the caller
				throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		}	catch(\RangeException $range) {
			// rethrow the exception to the caller
				throw(new \RangeException($range->getMessage(), 0, $range));
		}	catch(\TypeError $typeError){
			// rethrow the exception to the caller
				throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		}	catch(\Exception $exception){
			//	rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
 	* accessor method for favoriteNewsArticle id
 	* 
 	* @return int value of favoriteNewsArticle id
 	**/
	public function getFavoriteNewsArticleNewsArticleId() {
		return($this->favoriteNewsArticleNewArticleId);
	}

	/**
 	* mutator method for favoriteNewsArticle id
 	* 
 	* @param int $newFavoriteNewsArticleNewsArticleId new value of favoriteNewsArticle id
 	* @throws	\RangeException if $newFavoriteNewsArticleNewsArticleId is not positve
 	* @throws	\TypeError if $newFavoriteNewsArticleNewsArticleId is not an integer
 	**/
	public function setFavoriteNewsArticleNewsArticleId(int $newFavoriteNewsArticleNewsArticleId){
		// verify the favoriteNewsArticle id is positive
		if($newFavoriteNewsArticleNewsArticleId <= 0){
			throw(new \RangeException("favoriteNewsArticle id is not positive"));
	}
	
	// convert and store the favoriteNewsArticle id
	$this->favoriteNewsArticleNewsArticleId = $newFavoriteNewsArticleNewsArticleId;
	}

	/**
	 * accessor method for favoriteNewsArticleUserId
 	* 
 	* @return int value of favoriteNewsArticle user id
 	**/
	public function getFavoriteNewsArticleUserId(){
		return($this->favoriteNewsArticleUserId);
	}

	/** 
	 * mutator method for favoriteNewsArticle user id
	 * 
	 * @param int $newFavoriteNewsArticleUserId new value of favoriteNewsArticle user id
	 * @throws \RangeException if $newFavoriteNewsArticleUserId is not positive
	 * @throws \TypeError if $newFavoriteNewsArticleUserId is not an integer
	 **/
	public function setFavoriteNewsArticleUserId(int $newFavoriteNewsArticleUserId){
		//verify the favoriteNewsArticle user id is positive
		if($newFavoriteNewsArticleUserId <= 0){
			throw(new \RangeException("favoriteNewsArticle user id is not positive"));
		}
	
		//convert and store the favoriteNewsArticle user id
		$this->favoriteNewsArticleUserId = $newFavoriteNewsArticleUserId;
	}

	/**
	 * accessor method for favoriteNewsArticleDateTime
	 * 
	 * @return \DateTime value of favoriteNewsArticle date and time
	 **/
	public function getFavoriteNewsArticleDateTime(){
		return($this->favoriteNewsArticleDateTime);
	}

	/**
	 * mutator method for favoriteNewsArticle date and time
	 * @param \DateTime/string/null $newFavoriteNewsArticleDatetime favoriteNewsArticle date and time as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newFavoriteNewsArticleDateTime is nont a valid object or string
	 * @throws \RangeException if $newFavoriteNewsArticleDateTime is a date or time that does not exist
	 **/
	public function setFavoriteNewsArticleDateTime($newFavoriteNewsArticleDateTime = null){
		// base case: if the date is null, use the current date and time
		if($newFavoriteNewsArticleDateTime === null){
			$this->favoriteNewsArticleDateTime = new \DateTime();
			return;
		}
	
		// store the favoriteNewsArticleDateTime date
		try{
			$newFavoriteNewsArticleDateTime = $this->validateDate($newFavoriteNewsArticleDateTime);
		}	catch(\InvalidArgumentException $invalidArgument){
				throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		}	catch(\RangeException $range){
				throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->favoriteNewsArticleDateTime = $newFavoriteNewsArticleDateTime;
	}

