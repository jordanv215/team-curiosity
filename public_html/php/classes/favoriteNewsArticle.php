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
 * id for this favoriteNewsArticle; this is the primary key
 * @var int $favoriteNewsArticleNewsArticleId
 **/
	private $favoriteNewsArticleNewsArticleId;
	/**id of the user who favorites this newsArticle; this is a foreign key
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
 * @param int/null $newFavoriteNewArticleNewsArticleId id of this favoriteNewArticle or null if a new favoriteNewsArticle
 * @param int $newFavoriteNewArticleUserId id of the user who sent this favoriteNewArticle
 * @param \DateTime/string/null $newFavoriteNewsArticleDateTime date and time favoriteNewsArticle was sent or null if set to current date and time
 * 
 */ 