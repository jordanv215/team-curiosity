<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\TeamCuriosity;


/**
 * api for the commentImage class
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/commentimage.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" ||  $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}


	//handle GET request - if id is present, that image comment is returned, otherwise all image comments are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific comment or all comments and update reply
		if(empty($id) === false) {
			$commentImage = TeamCuriosity\commentImage::getCommentImageByCommentImageId($pdo, $id);
			if($commentImage !== null) {
				$reply->data = $commentImage;
			}
		} else {
			$commentImage = TeamCuriosity\commentImage::getAllCommentImage($pdo);
			if($commentImage !== null) {
				$reply->data = $commentImage;
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

	//perform the actual put or post
	if($method === "PUT") {
		// retrieve the commentImage to update
		$commentImage = TeamCuriosity::getCommentImageByCommentImageId($pdo, $id);
		if($commentImage === null) {
			throw(new RuntimeException("commentImag does not exist", 404));
		}

		// put the new commentImage content into the comment and update
		$commentImage->set
	}
	}

}