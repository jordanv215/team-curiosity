<?php

require_once(dirname(__DIR__, 2) . "/classes/Autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\TeamCuriosity\Image;
use Edu\Cnm\TeamCuriosity\ValidateDate;


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
	$imageCamera = filter_input(INPUT_GET, "imageCamera", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$imageDescription = filter_input(INPUT_GET, "imageDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$imageEarthDate = filter_input(INPUT_GET, "imageEarthDate", validateDate());
	$imageSol = filter_input(INPUT_GET, "imageSol", FILTER_VALIDATE_INT);
	$imageTitle = filter_input(INPUT_GET, "imageTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$imageUrl = filter_input(INPUT_GET, "imageUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($imageId) === true || $imageId <= 0)) {
		throw(new InvalidArgumentException("Image id cannot be empty or negative", 405));
	}


	//handle GET request - if id is present, that image is returned, otherwise all images are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific image and update reply
		if(empty($imageId) === false) {
			$image = Image::getImageByImageId($pdo, $imageId);
			if($image !== null) {
				$reply->data = $image;
			}

		} else if(empty($imageCamera) === false) {
			$images = Image::getImageByImageCamera($pdo, $imageCamera);
			if($images !== null) {
				$reply->data = $images;
			}
		} else if(empty($imageDescription) === false) {
			$images = Image::getImageByImageDescription($pdo, $imageDescription);
			if($images !== null) {
				$reply->data = $images;
			}
		} else if(empty($imageEarthDate) === false) {
			$images = Image::getImagesByImageEarthDate($pdo, $imageEarthDate);
			if($images !== null) {
				$reply->data = $images;
			}

		} else if(empty($imageSol) === false) {
			$images = Image::getImagesByImageSol($pdo, $imageSol);
			if($images !== null) {
				$reply->data = $images;
			}

		} else if(empty($imageTitle) === false) {
			$images = Image::getImageByImageTitle($pdo, $imageTitle);
			if($images !== null) {
				$reply->data = $images;
			}

		} else if(empty($imageUrl) === false) {
			$images = Image::getImageByImageUrl($pdo, $imageUrl);
			if($images !== null) {
				$reply->data = $images;
			}

		} else {
			$images = Image::getAllImages($pdo);
			if($images !== null) {
				$reply->data = $images;
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
			throw(new \InvalidArgumentException ("No camera for this Image.", 405));
		}

		//make sure image type is available
		if(empty($requestObject->imageType) === true) {
			throw(new \InvalidArgumentException ("No MIME type for this Image.", 405));
		}

		//make sure image earth date is available
		if(empty($requestObject->imageEarthDate) === true) {
			throw(new \InvalidArgumentException ("No Earth date for this Image.", 405));
		}

		//make sure image local path is available
		if(empty($requestObject->imagePath) === true) {
			throw(new \InvalidArgumentException ("No file path for this Image.", 405));
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
			$image->setImageType($requestObject->imageType);
			$image->setImageUrl($requestObject->imageUrl);
			$image->update($pdo);

			//update reply
			$reply->message = "Image Updated Ok";

		} else if($method === "POST") {
			//create new Image and insert into the database
			$image = new Image(null, $requestObject->imageCamera, $requestObject->imageDescription, null, $requestObject->imagePath, $requestObject->imageSol, $requestObject->imageTitle, $requestObject->imageType, $requestObject->imageUrl);
			$image->insert($pdo);

			//update reply
			$reply->message = "Image created OK";

		} else if($method === "DELETE") {
			verifyXsrf();

			// retrieve the image to be deleted
			$image = Image::getImageByImageId($pdo, $imageId);
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

public function NasaCall() {
	$baseUrl = "https://api.nasa.gov/mars-photos/api/v1/rovers/curiosity/photos";
	$apiKey = ""; // how is this accessed again?
	$camera = "";
	$earthDate = "";
	$sol = "";
}




header("Content-Type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and return reply to front end caller
echo json_encode($reply);