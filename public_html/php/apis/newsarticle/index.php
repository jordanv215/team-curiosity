<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/teamcuriosity-mysql/encrypted-config.php");

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
	$pdo = connectToEncryptedMySQL("/etc/apache2/teamcuriosity-mysql/newsArticle.ini");
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
		}  else {
			$newsArticles = TeamCuriosity\NewsArticle::getAllNewsArticles($pdo);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		}
	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

	}


