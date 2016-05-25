<?php

require_once(dirname(__DIR__, 2) . "/classes/Autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\TeamCuriosity\CommentImage;


/**
 * REST api for the CommentImage class
 *
 * @author Jordan Vinson <jvinson3@cnm.edu>
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
	//grab my mySQL Connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mars.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$commentImageId = filter_input(INPUT_GET, "CommentImageId", FILTER_VALIDATE_INT);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($commentImageId) === true || $commentImageId <= 0)) {
		throw(new InvalidArgumentException("Comment id cannot be empty or negative", 405));
	}


	//handle GET request - if id is present, that image comment is returned, otherwise all image comments are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific comment or all comments and update reply
		if(empty($commentImageId) === false) {
			$commentImage = CommentImage::getCommentImageByCommentImageId($pdo, $commentImageId);
			if($commentImage !== null) {
				$reply->data = $commentImage;
			}

		} else {
			$commentImages = CommentImage::getAllCommentImage($pdo);
			if($commentImages !== null) {
				$reply->data = $commentImages;
			}
		}
	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure comment image content is available
		if(empty($requestObject->commentImageContent) === true) {
			throw(new \InvalidArgumentException ("No content for this Image Comment.", 405));
		}

		//make sure comment image dateTime is available
		if(empty($requestObject->commentImageDateTime) === true) {
			throw(new \invalidArgumentException ("No DateTime for this image comment.", 405));
		}

		/**retrieve the image id to update
		$commentImage = CommentImage::getCommentImageByCommentImageId($pdo, $commentImageId);
		if($commentImage === null) {
			throw(new \RuntimeException("No valid image to update"));
		}
		**/

		//perform the actual put or post
		if($method === "PUT") {
			// retrieve the commentImage to update
			$commentImage = Edu\Cnm\TeamCuriosity\CommentImage::getCommentImageByCommentImageId($pdo, $commentImageId);
			if($commentImage === null) {
				throw(new RuntimeException("Image comment does not exist", 404));
			}

			// put the new commentImage content into the comment and update
			$commentImage->setCommentImageContent($requestObject->commentImageContent);
			$commentImage->update($pdo);

			//update reply
			$reply->message = "Image Content Updated Ok";

		} else if($method === "POST") {
			//make sure commentImageUserId is available
			if(empty($requestObject->commentImageId) === true) {
				throw(new \InvalidArgumentException ("No User ID.", 405));
			}

			//create new user and insert into the database
			$commentImage = new CommentImage(null, $requestObject->userId, $requestObject->commentImageContent, null);
			$commentImage->insert($pdo);

			//update reply
			$reply->message = "Image Comment created OK";
		} else if($method === "DELETE") {
			verifyXsrf();

			// retrieve the image comment to be deleted
			$commentImage = CommentImage::getCommentImageByCommentImageId($pdo, $userId);
			if($commentImage === null) {
				throw(new RuntimeException("Image comment does not exist", 404));
			}

			//delete the comment
			$commentImage->delete($pdo);

			//update reply
			$reply->message = "Comment deleted OK";
		} else {
			throw (new InvalidArgumentException("Invalid HTTP method request"));
		}
		// update reply with exception information
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-Type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and return reply to front end caller
echo json_encode($reply);