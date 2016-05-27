<?php

require_once(dirname(__DIR__, 2) . "/classes/Autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\TeamCuriosity\Image;


/**
 * REST api for the Image class
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
	$imageId = filter_input(INPUT_GET, "imageId", FILTER_VALIDATE_INT);


	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($imageId) === true || $imageId <= 0)) {
		throw(new InvalidArgumentException("Image id cannot be empty or negative", 405));
	}


	//handle GET request - if id is present, that image is returned, otherwise all images are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific image and update reply
		if(empty($ImageId) === false) {
			$image = Image::getImageByImageId($pdo, $imageId);
			if($image !== null) {
				$reply->data = $image;
			}

		} else if(empty($imageCamera) === false) {
			$image = Image::getImageByImageCamera($pdo, $imageCamera);
			if($image !== null) {
				$reply->data = $image;
			}

		} else if(empty($imageDescription) === false) {
			$image = Image::getImageByImageDescription($pdo, $imageDescription);
			if($image !== null) {
				$reply->data = $image;
			}

		} else if(empty($imageTitle) === false) {
			$image = Image::getImageByImageTitle($pdo, $imageTitle);
			if($image !== null) {
				$reply->data = $image;
			}


		} else {
			$Images = Image::getAllImages($pdo);
			if($Images !== null) {
				$reply->data = $Images;
			}
		}
	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure image url is available
		if(empty($requestObject->imageUrl) === true) {
			throw(new \InvalidArgumentException ("No url for this Image.", 405));
		}

		//make sure image title is available
		if(empty($requestObject->imageTitle) === true) {
			throw(new \InvalidArgumentException ("No title for this Image.", 405));
		}

		//make sure image camera is available
		if(empty($requestObject->imageCamera) === true) {
			throw(new \InvalidArgumentException ("No listen camera for this Image.", 405));
		}

		//make sure image type is available
		if(empty($requestObject->imageType) === true) {
			throw(new \InvalidArgumentException ("No type for this Image.", 405));
		}


		//make sure image sol is available
		if(empty($requestObject->imageSol) === true) {
			throw(new \InvalidArgumentException ("No Mars Sol for this Image.", 405));
		}

		//make sure image earth date is available
		if(empty($requestObject->imageEarthDate) === true) {
			throw(new \InvalidArgumentException ("No Earth date for this Image.", 405));
		}

		//make sure image local path is available
		if(empty($requestObject->imagePath) === true) {
			throw(new \InvalidArgumentException ("No path for this Image.", 405));
		}





		//perform the actual put or post
		if($method === "PUT") {
			// retrieve the Image to update
			$image = Edu\Cnm\TeamCuriosity\Image::getImageByImageId($pdo, $imageId);
			if($image === null) {
				throw(new RuntimeException("Image does not exist", 404));
			}

			// put the new image functions
			$image->setImageTitle($requestObject->imageTitle);
			$image->setImageDescription($requestObject->imageDescription);
			$image->setImageCamera($requestObject->imageCamera);
			$image->setImageEarthDate($requestObject->imageEarthDate);
			$image->setImageSol($requestObject->imageSol);
			$image->setImagePath($requestObject->imagePath);
			$image->setImageType($requestObject->imageObject);
			$image->setImageUrl($requestObject->imageUrl);
			$image->update($pdo);

			//update reply
			$reply->message = "Image Updated Ok";

		} else if($method === "POST") {
			//make sure imageId is available
			if(empty($requestObject->imageId) === true) {
				throw(new \InvalidArgumentException ("No image ID.", 405));
			}

			//create new Image and insert into the database
			$image = new Image(null, $requestObject->imageId, $requestObject->image, null);
			$image->insert($pdo);

			//update reply
			$reply->message = "Image created OK";
		} else if($method === "DELETE") {
			verifyXsrf();

			// retrieve the image to be deleted
			$image = Image::getImageByImageId($pdo, $userId);
			if($image === null) {
				throw(new RuntimeException("Image does not exist", 404));
			}

			//delete the Image
			$image->delete($pdo);

			//update reply
			$reply->message = "Image deleted OK";
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