<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/teamcuriosity-mysql/encrypted-config.php");

use Edu\Cnm\TeamCuriosity;


/**
 * api for the favoriteNewsArticle class
 *
 * @author Anthony Williams <awilliams144@cnm.edu>
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}