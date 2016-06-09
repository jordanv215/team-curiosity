<?php

require_once (dirname(__DIR__, 2) . "/classes/Autoload.php");
require_once (dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\TeamCuriosity;
use Edu\Cnm\TeamCuriosity\ValidateDate;


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
	$newsArticleId = filter_input(INPUT_GET, "newsArticleId", FILTER_VALIDATE_INT);
	$newsArticleTitle = filter_input(INPUT_GET, "newsArticleTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$newsArticleDate = filter_input(INPUT_GET, "newsArticleDate", validateDate());
	$newsArticleSynopsis = filter_input(INPUT_GET, "newsArticleSynopsis", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$newsArticleUrl = filter_input(INPUT_GET, "newsArticleUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($newsArticleId) === true || $newsArticleId < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		//get a specific NewsArticle, multiple NewsArticles, or all NewsArticles, and update reply
		if(empty($newsArticleId) === false) {
			$newsArticle = TeamCuriosity\NewsArticle::getNewsArticleByNewsArticleId($pdo, $newsArticleId);
			if($newsArticle !== null) {
				$reply->data = $newsArticle;
			}
		} else if (empty($newsArticleTitle) === false) {
			$newsArticles = TeamCuriosity\NewsArticle::getNewsArticleByNewsArticleTitle($pdo, $newsArticleTitle);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		} else if (empty($newsArticleDate) === false) {
			$newsArticles = TeamCuriosity\NewsArticle::getNewsArticleByNewsArticleDate($pdo, $newsArticleDate);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		} else if (empty($newsArticleSynopsis) === false) {
			$newsArticles = TeamCuriosity\NewsArticle::getNewsArticleByNewsArticleSynopsis($pdo, $newsArticleSynopsis);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		} else if (empty($newsArticleUrl) === false) {
			$newsArticles = TeamCuriosity\NewsArticle::getNewsArticleByNewsArticleUrl($pdo, $newsArticleUrl);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		} else {
			$newsArticles = TeamCuriosity\NewsArticle::getAllNewsArticles($pdo);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		}
	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure newsArticle is available
		if(empty($requestObject->newsArticleId) === true) {
			throw(new \InvalidArgumentException ("No NewsArticle to update", 405));
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the newsArticle to update
			$newsArticle = TeamCuriosity\NewsArticle::getNewsArticleByNewsArticleId($pdo, $newsArticleId);
			if($newsArticle === null) {
				throw(new RuntimeException("NewsArticle does not exist", 404));
			}
			// put the new newsArticle synopsis into the newsArticle and update
			$newsArticle->setNewsArticleTitle($requestObject->newsArticleTitle);
			$newsArticle->setNewsArticleDate($requestObject->newsArticleDate);
			$newsArticle->setNewsArticleSynopsis($requestObject->newsArticleSynopsis);
			$newsArticle->setNewsArticleUrl($requestObject->newsArticleUrl);
			$newsArticle->update($pdo);

			// update reply
			$reply->message = "NewsArticle updated OK";
		} else if($method === "POST") {

			// make sure newsArticleId is available
			if(empty($requestObject->newsArticleId) === true) {
				throw(new \InvalidArgumentException ("No NewsArticle ID.", 405));
			}

			// create new newsArticle and insert into the database
			$newsArticle = new TeamCuriosity\NewsArticle(null, $requestObject->newsArticleTitle, null, $requestObject->newsArticleSynopsis, $requestObject->newsArticleUrl);
			$newsArticle->insert($pdo);

			// update reply
			$reply->message = "NewsArticle created OK";
		}
	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the newsArticle to be deleted
		$newsArticle = TeamCuriosity\NewsArticle::getNewsArticleByNewsArticleId($pdo, $newsArticleId);
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


/**
 * Utilize rss-php extension to retrieve news article objects from NASA RSS feed
 *
 * @see https://github.com/dg/rss-php
 **/

$url = "http://mars.nasa.gov/rss/news.cfm?s=msl";
$rss = Feed::loadRss($url);

foreach($rss->item as $item) { // does all of this need to be put in a function to be called on page load?
	$newsArticleTitle = $item->title;
	$newsArticleUrl = $item->link;
	$newsArticleDate = $item->pubDate;
	$newsArticleSynopsis = $item->description;

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mars.ini");

	$query = "SELECT * FROM NewsArticle";
	$statement = $pdo->prepare($query);



	if($newsArticleUrl === "newsArticleUrl") {
		// grab row and add to array
		// somehow
	}

	else {
		$newsArticle = new TeamCuriosity\NewsArticle(null, $newsArticleTitle, $newsArticleDate, $newsArticleSynopsis, $newsArticleUrl);
		// wat
		// how to access insert from here
		// does this whole thing need to be rewritten again?
	}
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);
