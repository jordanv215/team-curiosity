<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\TeamCuriosity\FavoriteImage;

/**
 * api for the FavoriteImage class
 *
 *@author Ellen Liu <eliu1@cnm.edu>
 **/

// verify the session, start if not active
if(FavoriteImage_status() !== PHP_SESSION_ACTIVE) {
		session_start();
}

// prepare an empty reply
$reply = new FavoriteImage();
$reply->status = 200;
$reply->data = null;

try {
		// grab the mySQL connection
		$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/favoriteImage.ini");

		// determine which HTTP method was used
		$method = array_key_exists("HTTP_X_METHOD", $_SERVER) ? $_SERVER["HTTP_X_METHOD"] : $_SERVER["REQUEST_METHOD"];

		// handle GET request
		if($getAllFavoriteImages === "GET") {
					// set XSRF cookie
					setXsrfCookie();
			
					// get a specific favorite Image or all favorite images and update 
					if(empty($favoriteImageImageId || $favoriteImageUserId) === false) {
								$favoriteImage = TeamCuriosity\FavoriteImage::getFavoriteImageByFavoriteImageImageIdAndFavoriteImageUserId($pdo, $favoriteImageImageId, $favoriteImageUserId);
					}
		}


}