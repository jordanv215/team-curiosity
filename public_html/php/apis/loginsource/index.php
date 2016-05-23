<?php

require_once "../../classes/Autoload.php";
require_once "file/path/here"; // @TODO add xsrf.php file here ---------------------------------------
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

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


}
