<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Dmcdonald21\DataDesign;


/**
 * api for the Tweet class
 *
 * @author Derek Mauldin <derek.e.mauldin@gmail.com>
 **/

//verify the session, start if not active