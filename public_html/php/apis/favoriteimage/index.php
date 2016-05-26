<?php

require_once(dirname(__DIR__, 2) . "/classes/Autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\TeamCuriosity;

/**
 * api for the FavoriteImage class
 *
 * @author Ellen Liu <eliu1@cnm.edu>
 **/

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mars.ini");

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$favoriteImageImageId = filter_input(INPUT_GET, "favoriteImageImageId" ,FILTER_VALIDATE_INT);
	$favoriteImageUserId = filter_input(INPUT_GET, "favoriteImageUserId" ,FILTER_VALIDATE_INT);

	// handle GET request
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// get a specific favorite Image or all favorite images and update
		if(empty($favoriteImageImageId) === false && empty($favoriteImageUserId) === false) {
			$favoriteImage = TeamCuriosity\FavoriteImage::getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId($pdo, $favoriteImageImageId, $favoriteImageUserId);
			if($favoriteImage !== null) {
				$reply->data = $favoriteImage;

			} else if (empty($favoriteImageImageId) === false) {
				$favoriteImage = TeamCuriosity\FavoriteImage::getFavoriteImageByFavoriteImageImageId($pdo, $favoriteImageImageId);
				$reply->data = $favoriteImage;
			} else if (empty($favoriteImageUserId) === false) {
				$favoriteImage = TeamCuriosity\FavoriteImage::getFavoriteImageByFavoriteImageUserId($pdo, $favoriteImageUserId);
				$reply->data = $favoriteImage;
			}

	} else  {
		$favoriteImages = TeamCuriosity\FavoriteImage::getAllFavoriteImages($pdo);
		if($favoriteImages !== null) {
			$reply->data = $favoriteImages;
		}
		}
	} else
			if($method === "POST") {

				verifyXsrf();
				$requestContent = file_get_contents("php://input");
				$requestObject = json_decode($requestContent);

				//  make sure favoriteImageImageId and favoriteImageUserId are available
				if(empty($requestObject->favoriteImageImageId) === true || empty($requestObject->favoriteImageUserId)) {
					throw(new \InvalidArgumentException ("Id doesn't exist.", 405));
				}

				// create new favorite image and insert into the database
				$favoriteImage = new TeamCuriosity\FavoriteImage($requestObject->favoriteImageImageId, $requestObject->favoriteImageUserId, null);
				$favoriteImage->insert($pdo);

				// update reply
				$reply->message = "FavoriteImage created OK";
				

	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the favoriteImage to be deleted
		$favoriteImage = TeamCuriosity\FavoriteImage::getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId($pdo, $favoriteImageImageId, $favoriteImageUserId);
		if($favoriteImage === null) {
			throw(new RuntimeException("FavoriteImage does not exist", 404));
		}

		// delete favorite image
		$favoriteImage->delete($pdo);

		// update reply
		$reply->message = "Favorite image deleted OK";
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



