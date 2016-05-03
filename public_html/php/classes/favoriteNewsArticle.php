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
	/**