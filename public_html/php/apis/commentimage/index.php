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
$reply