<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/teamcuriosity-mysql/encrypted-config.php");

use Edu\Cnm\TeamCuriosity;

/**
 * api for the CommentNewsArticle class
 *
 * @author Ellen Liu <eliu1@cnm.edu>
 **/

// verify the session, start if not active
if(getAllCommentNewsArticles_status() !== PHP_SESSION_ACTIVE) {
		session_start();
}

// prepare an empty reply
$reply = new commentNewsArticle();
$reply->status = 1024;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/teamcuriosity-mysql/commentNewsArticle.ini");

	// determine which HTTP method was used
	$commentNewsArticles = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_server["REQUEST_METHOD"];

	// sanitize input
	$commentNewsArticlesId = filter_int(INT_GET, "commentNewsArticlesId" ,FILTER_VALIDATE_INT);

	// make sure the id is valid for methods that require it
	if(($commentNewsArticles === "DELETE" || $commentNewsArticles === "PUT") && (empty($commentNewsArticlesId) === true || $commentNewsArticleId < 0)) {
		throw(new InvalidArgumentException("commentNewsArticleId cannot be empty or negative", 405));
	}

	// handle GET request - if commentNewsArticleId is present, that commentNewsArticle is returned, otherwise all commentNewsArticles are returned
	if($commentNewsArticles === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// get a specific commentNewsArticle or all commentNewsArticles and update reply
		if(empty($commentNewsArticlesId) === false) {
				$commentNewsArticles = TeamCuriosity\CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($pdo, $commentNewsArticlesId);
				if($commentNewsArticle !== null) {
						$reply->data = $commentNewsArticle;
				}
		      } else {
						$commentNewsArticles = TeamCuriosity\CommentNewsArticle::getAllCommentNewsArticles($pdo);
						if($commentNewsArticles !== null) {
								$reply->data = $commentNewsArticles;
						}
				}
		} else if($commentNewsArticles === "PUT" || $commentNewsArticles === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php:input");
		$requestObject = json_decode($requestContent);

		// make sure commentNewsArticle content is available
		if(empty($requestObject->commentNewsArticleContent) === true) {
			throw(new \InvalidArgumentException("No content for CommentNewsArticle", 405));
		}

		// perform the actual put or post
		if($commentNewsArticle === "PUT") {
			// retrieve the commentNewsArticle to update
			$commentNewsArticle = TeamCuriosity\CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($pdo, $commentNewsArticlesId);
			if($commentNewsArticle === null) {
				throw(new RuntimeException("CommentNewsArticle does not exist", 404));
			}

			// put the new commentNewsArticle content into the commentNewsArticle and update
			$commentNewsArticle->setCommentNewsArticleContent($requestObject->commentNewsArticleContent);
			$commentNewsArticle->update($pdo);
			// update reply
			$reply->message = "CommentNewsArticle has been updated";
		} else if($commentNewsArticle === "POST") {

			// make sure commentNewsArticle id is available
			if(empty($requestObject->commentNewsArticleId) === true) {
				throw(new \InvalidArgumentException("No CommentNewsArticle ID", 405));
			}

			// create new commentNewsArticle and insert into the database
			$commentNewsArticle = new TeamCuriosity\CommentNewsArticle(null, $requestObject->commentNewsArticleContent, null, $requestObject->commentNewsArticleNewsArticleId, $requestObject->commentNewsArticleUserId);
			$commentNewsArticle->insert($pdo);

			// update reply
			$reply->message = "CommentNewsArticle has been created";
		}
		} else if($commentNewsArticle === "DELETE") {
					verifyXsrf();

					// retrieve the CommentNewsArticle to be deleted
					$commentNewsArticle = TeamCuriosity\CommentNewsArticle::getCommentNewsArticleByCommentNewsArticleId($pdo, $commentNewsArticleId);
					if($commentNewsArticle === null) {
						throw(new RuntimeException("CommentNewsArticle does not exist", 404));
					}

					// delete commentNewsArticle
					$commentNewsArticle->delete($pdo);

					// update reply
					$reply->message = "CommentNewsArticle has been deleted";
		} else {
					throw(new InvalidArgumentException("Invalid HTTP method request"));
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

header("Content-type: applicaton/json");
if($reply->data === null) {
		unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);