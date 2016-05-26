<?php

require_once (dirname(__DIR__, 2) . "/classes/Autoload.php");
require_once (dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\TeamCuriosity;


/**
 * api for the NewsArticle class
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
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
// handle GET request - if id is present, that NewsArticle is returned, otherwise all NewsArticles are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//get a specific NewsArticle or all NewsArticles and update reply
		if(empty($id) === false) {
			$newsArticle = TeamCuriosity\NewsArticle::getNewsArticleByNewsArticleId($pdo, $id);
			if($newsArticle !== null) {
				$reply->data = $newsArticle;
			}
		} else {
			$newsArticles = TeamCuriosity\NewsArticle::getAllNewsArticles($pdo);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		}
	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestSynopsis = file_get_contents("php://input");
		$requestObject = json_decode($requestSynopsis);
		//make sure newsArticle synopsis is available
		if(empty($requestObject->newsArticleSynopsis) === true) {
			throw(new \InvalidArgumentException ("No synopsis for NewsArticle.", 405));
		}
		//perform the actual put or post
		if($method === "PUT") {
			// retrieve the newsArticle to update
			$newsArticle = TeamCuriosity\NewsArticle::getNewsArticleByNewsArticleId($pdo, $id);
			if($newsArticle === null) {
				throw(new RuntimeException("NewsArticle does not exist", 404));
			}
			// put the new newsArticle synopsis into the newsArticle and update
			$newsArticle->setNewsArticleSynopsis($requestObject->newsArticleSynopsis);
			$newsArticle->update($pdo);
			// update reply
			$reply->message = "NewsArticle updated OK";
		} else if($method === "POST") {
			// make sure newsArticleId is available
			if(empty($requestObject->newsArticleId) === true) {
				throw(new \InvalidArgumentException ("No NewsArticle ID.", 405));
			}

			// create new newsArticle and insert into the database
			$newsArticle = new TeamCuriosity\NewsArticle(null, $requestObject->NewsArticleId, $requestObject->newsArticleDate, null);
			$requestObject->newsArticleSynopsis;
			$requestObject->newsArticleUrl;
			$newsArticle->insert($pdo);
			// update reply
			$reply->message = "NewsArticle created OK";
		}
	} else if($method === "DELETE") {
		verifyXsrf();
		// retrieve the newsArticle to be deleted
		$newsArticle = TeamCuriosity\NewsArticle::getNewsArticleByNewsArticleId($pdo, $id);
		if($newsArticle === null) {
			throw(new RuntimeException("NewsArticle does not exist", 404));
		}
		// delete newsArticle
		$newsArticle->delete($pdo);
		// update reply
		$reply->message = "NewsArticle deleted OK";
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







