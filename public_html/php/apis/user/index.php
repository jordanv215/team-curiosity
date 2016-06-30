<?php

require_once(dirname(__DIR__, 2) . "/classes/Autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once "/etc/apache2/redrovr-conf/encrypted-config.php";

use Edu\Cnm\TeamCuriosity;

/**
 * REST API for the User class of the redrovr project
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/redrovr-conf/mars.ini");

	// determine the HTTP method used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$userId = filter_input(INPUT_GET, "userId", FILTER_VALIDATE_INT);

	// ensure the input is valid
	if(($method === "DELETE" || $method === "PUT") && (empty($userId) === true || $userId <= 0)) {
		throw(new \InvalidArgumentException("Input is empty or invalid"));
	}


	// handle GET request: return user associated with the id; if none specified, return all
	if($method === "GET") {

		// set XSRF cookie
		setXsrfCookie();

		// grab the specified user, or all users, and update reply
		if(empty($userId) === false) {
			$user = TeamCuriosity\User::getUserByUserId($pdo, $userId);
			if($user !== null) {
				$reply->data = $user;
			}
		} else {
			$users = TeamCuriosity\User::getAllUsers($pdo);
			if($users !== null) {
				$reply->data = $users;
			}
		}

	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// make sure user login id is present
		if(empty($requestObject->userLoginId) === true) {
			throw(new \InvalidArgumentException("No login id to update"));
		}

		// make sure user name is present
		if(empty($requestObject->userName) === true) {
			throw(new \InvalidArgumentException("No name to update"));
		}

		if($method === "PUT") {

			// retrieve the user to update
			$user = TeamCuriosity\User::getUserByUserId($pdo, $userId);
			if($user === null) {
				throw(new \RuntimeException("No valid user to update"));
			}

			// add the new data and update
			$user->setUserEmail($requestObject->userEmail);
			$user->update($pdo);

			$user->setUserLoginId($requestObject->userLoginId);
			$user->update($pdo);

			$user->setUserName($requestObject->userName);
			$user->update($pdo);

			// update the reply
			$reply->message = "User successfully updated";

		} else if($method === "POST") {

			// create new user and insert into table
			$user = new TeamCuriosity\User(null, $requestObject->userEmail, $requestObject->userLoginId, $requestObject->userName);
			$user->insert($pdo);

			// update the reply
			$reply->message = "User successfully created";

		} else if($method === "DELETE") {
			verifyXsrf();

			// retrieve the user to delete
			$user = TeamCuriosity\User::getUserByUserId($pdo, $userId);
			if($user === null) {
				throw(new \RuntimeException("No valid user to delete"));
			}

			// delete user
			$user->delete($pdo);

			// update the reply
			$reply->message = "User successfully deleted";
		} else {
			throw(new \InvalidArgumentException("Invalid HTTP method request"));
		}
	}
	// update the reply with exception information
}
catch
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

// encode and return the reply to the frontend caller
echo json_encode($reply);

