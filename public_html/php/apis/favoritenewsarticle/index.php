<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/teamcuriosity-mysql/encrypted-config.php");

use Edu\Cnm\TeamCuriosity;


/**
 * api for the favoriteNewsArticle class
 *
 * @author Anthony Williams <awilliams144@cnm.edu>
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/teamcuriosity-mysql/favoriteNewsArticle.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
// handle GET request - if id is present, that favoriteNewsArticle is returned, otherwise all favoriteNewsArticles are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//get a specific favoriteNewsArticle or all favoriteNewsArticles and update reply
		if(empty($id) === false) {
			$favoriteNewsArticle = TeamCuriosity\FavoriteNewsArticle::getFavoriteNewsArticleByNewsArticleId($pdo, $id);
			if($favoriteNewsArticle !== null) {
				$reply->data = $favoriteNewsArticle;
			}
		} else {
			$favoriteNewsArticles = TeamCuriosity\FavoriteNewsArticle::getAllFavoriteNewsArticles($pdo);
			if($favoriteNewsArticles !== null) {
				$reply->data = $favoriteNewsArticles;
			}
		}
	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestUrl = file_get_contents("php://input");
		$requestObject = json_decode($requestUrl);
		//make sure favoriteNewsArticle Url is available
		if(empty($requestObject->favoriteNewsArticleUrl) === true) {
			throw(new \InvalidArgumentException ("No Url for FavoriteNewsArticle.", 405));
		}
		//perform the actual put or post
		if($method === "PUT") {
			// retrieve the favoriteNewsArticle to update
			$favoriteNewsArticle = TeamCuriosity\FavoriteNewsArticle::getFavoriteNewsArticleByNewsArticleId($pdo, $id);
			if($favoriteNewsArticle === null) {
				throw(new RuntimeException("FavoriteNewsArticle does not exist", 404));
			}
			// put the new favoriteNewsArticle Url into the favoriteNewsArticle and update
		$favoriteNewsArticle->setFavoriteNewsArticleUrl($requestObject->favoriteNewsArticleUrl);
		$favoriteNewsArticle->update($pdo);
			// update reply
			$reply->message = "FavoriteNewsArticle updated OK";

		} else if($method === "POST"){
		}
	}
