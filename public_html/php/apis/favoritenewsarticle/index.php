<?php

require_once (dirname(__DIR__, 2) . "/classes/Autoload.php");
require_once (dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mars.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$favoriteNewsArticleNewsArticleId = filter_input(INPUT_GET, "favoriteNewsArticleNewsArticleId", FILTER_VALIDATE_INT);
	$favoriteNewsArticleUserId = filter_input(INPUT_GET, "favoriteNewsArticleUserId", FILTER_VALIDATE_INT);

	//make sure the IDs are valid for methods that require them
	if(($method === "DELETE" || $method === "PUT") && ((empty($favoriteNewsArticleNewsArticleId) === true || $favoriteNewsArticleNewsArticleId < 0) || (empty($favoriteNewsArticleUserId) === true || $favoriteNewsArticleUserId < 0))) {
		throw(new InvalidArgumentException("IDs cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that favoriteNewsArticle is returned, otherwise all favoriteNewsArticles are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//get a specific favoriteNewsArticle or all favoriteNewsArticles and update reply
		if(empty($id) === false) {
			$favoriteNewsArticle = TeamCuriosity\FavoriteNewsArticle::getFavoriteNewsArticleByFavoriteNewsArticleNewsArticleId($pdo, $id);
			if($favoriteNewsArticle !== null) {
				$reply->data = $favoriteNewsArticle;
			}
		} else {
			$favoriteNewsArticles = TeamCuriosity\FavoriteNewsArticle::getAllFavoriteNewsArticles($pdo);
			if($favoriteNewsArticles !== null) {
				$reply->data = $favoriteNewsArticles;
			}
		}
	} else if($method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// make sure favoriteNewsArticleUserId is available
		if(empty($requestObject->favoriteNewsArticleUserId) === true) {
			throw(new \InvalidArgumentException ("No user ID for FavoriteNewsArticle.", 405));
		}
		// make sure favoriteNewsArticleNewsArticleId is available
		if(empty($requestObject->favoriteNewsArticleNewsArticleId) === true) {
			throw(new \InvalidArgumentException ("No news article ID for FavoriteNewsArticle.", 405));
		}

		//perform the actual post

		 if($method === "POST") {
			//  make sure favoriteNewsArticleUserId is available
			if(empty($requestObject->favoriteNewsArticleUserId) === true) {
				throw(new \InvalidArgumentException ("No FavoriteNewsArticleUser ID.", 405));
				// create new favoriteNewsArticle and insert into the database
				$favoriteNewsArticle = new TeamCuriosity\FavoriteNewsArticle(null, $requestObject->favoriteNewsArticleNewsArticleId);
				$requestObject->favoriteNewsArticleDateTime;
				$requestObject->favoriteNewsArticleUserId;
				$favoriteNewsArticle->insert($pdo);
				// update reply
				$reply->message = "FavoriteNewsArticle created OK";
			}

		} else if($method === "DELETE") {
			verifyXsrf();
			// retrieve the FavoriteNewsArticle to be deleted
			$favoriteNewsArticle = TeamCuriosity\FavoriteNewsArticle::getFavoriteNewsArticleByNewsArticleId($pdo, $id);
			if($favoriteNewsArticle === null) {
				throw(new RuntimeException("FavoriteNewsArticle does not exist", 404));
			}
			// delete favoriteNewsArticle
			$favoriteNewsArticle->delete($pdo);
		}
		// update reply
		$reply->message = "FavoriteNewsArticle deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}
// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);
