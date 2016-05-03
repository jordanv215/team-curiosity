<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("autoload.php");

/**A section for users to like their favorite article of news
 * 
 * This favoriteNewsArticle can be considered a small example of what services like favoriteNewsArticle store when NewsArticle are favorited and received by using favoriteNewsArticle.
 * */
class favoriteNewsArticle implements \JsoonSerializable {
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
 * @param \DateTime/string/null $newFavoriteNewsArticleDateTime date and time favoriteNewsArticle was sent or null if set to current date and time
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if data values are out of bounds (e.g., strings too long,negative integers)
 * @throw \TypeError if data types violate type hints
 * @throw \Exception if some other exception occurs
 **/
public function __construct(int $newFavoriteNewsArticleNewsArticleId =null, int $newFavoriteNewsArticleUserId, $newFavoriteNewsArticleDateTime = null){
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