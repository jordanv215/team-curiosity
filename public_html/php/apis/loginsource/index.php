<?php

require_once(dirname(__DIR__, 2) . "/classes/Autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\TeamCuriosity;

/**
 * REST API for the LoginSource class of the redrovr project
 *
 * @author Kai Garrott <garrottkai@gmail.com>
 **/

// verify active session, start if none
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// create an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// connect to mySQL
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mars.ini");

	// determine the HTTP method used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$loginSourceId = filter_input(INPUT_GET, "loginSourceId", FILTER_VALIDATE_INT);
	$loginSourceProvider = filter_input(INPUT_GET, "loginSourceProvider", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// ensure the input is valid
	if(($method === "DELETE" || $method === "PUT") && (empty($loginSourceId) === true || $loginSourceId <= 0)) {
		throw(new \InvalidArgumentException("Input is empty or invalid"));
	}


	// handle GET request: return login source associated with the id; if none specified, return all
	if($method === "GET") {

		// set XSRF cookie
		setXsrfCookie();

		// grab the specified login source, or all login sources, and update reply
		if(empty($loginSourceId) === false) {
			$loginSource = TeamCuriosity\LoginSource::getLoginSourceByLoginSourceId($pdo, $loginSourceId);
			if($loginSource !== null) {
				$reply->data = $loginSource;
			}
		} else if(empty($loginSourceProvider) === false) {
			$loginSource = TeamCuriosity\LoginSource::getLoginSourceByLoginSourceProvider($pdo, $loginSourceProvider);
			if($loginSource !== null) {
				$reply->data = $loginSource;
			}
		} else {
			$loginSources = TeamCuriosity\LoginSource::getAllLoginSources($pdo);
			if($loginSources !== null) {
				$reply->data = $loginSources;
			}
		}

	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// make sure login source is present
		if(empty($requestObject->loginSourceId) === true) {
			throw(new \InvalidArgumentException("No login source to update"));
		}

		if($method === "PUT") {

			// retrieve the login source to update
			$loginSource = TeamCuriosity\LoginSource::getLoginSourceByLoginSourceId($pdo, $loginSourceId);
			if($loginSource === null) {
				throw(new \RuntimeException("No valid login source to update"));
			}

			// add the new data and update
			$loginSource->setLoginSourceProvider($requestObject->loginSourceProvider);
			$loginSource->update($pdo);

			// update the reply
			$reply->message = "Login source successfully updated";

		} else if($method === "POST") {

			// create new login source and insert into table
			$loginSource = new TeamCuriosity\LoginSource(null, $requestObject->loginSourceProvider);
			$loginSource->insert($pdo);

			// update the reply
			$reply->message = "Login source successfully created";

		}
	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the login source to delete
		$loginSource = TeamCuriosity\LoginSource::getLoginSourceByLoginSourceId($pdo, $loginSourceId);
		if($loginSource === null) {
			throw(new \RuntimeException("No valid login source to delete"));
		}

		// delete login source
		$loginSource->delete($pdo);

		// update the reply
		$reply->message = "Login source successfully deleted";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request"));
	}
	// update the reply with exception information
} catch
(Exception $exception) {
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

use TeamCuriosity\OAuth2\Client\Provider\Reddit;
$reddit = new Reddit([
	'client_Id'      => 'p-_k1lQpvSBZGQ',
	'clientSecret'  => '73dn0d7-kWFnQPhySFJCUSVOIo0',
	'response_type' => 'code',
	'state'         => 'A chosen string',
	'redirectUri'   => 'https://www.redrovr.io',
	'duration'      => 'temporary or permanent',
	'userAgent'     => 'web:redrovr:1.0, (by /u/TeamCuriosity)',
	'scopes'        => ['identity'],
]);

// request an access token
$url = $reddit->getAuthorizationUrl([
	'duration' => $duration, // "permanent" or "temporary" by default
]);

$accessToken = $reddit->getAccessToken('authorization_code', [
	'access_denied' => $error,
	'code'          => $code,
	'state'         => $state
]);

// refreshing an access token
// include the following information in your POST data(NOT as part of the URL "grant_type=refresh_token&refresh_token=TOKEN"

$grant_type = 'refresh_token';
$refreshToken = $reddit->getAccessToken('refresh_token', [
	'refresh_token'=> $accessToken->refreshToken
]);
$accessToken->accessToken = $refreshToken->accessToken;
$accessToken->expires = $refreshToken->expires;

// Remember to re-store the refreshed access token at this point
// "refresh_token" will only be present if one was requested. You may now make API requests to reddit's servers on behalf of that user, by including the following header in your HTTP requests:

//Authorization: bearer TOKEN

// using the access token

$reddit->getHeaders($token);
$client = $reddit->getHttpClient();





// encode and return the reply to the frontend caller
echo json_encode($reply);

