<?php

/* clear any existing session data */
if (session_status() == PHP_SESSION_ACTIVE) {
	session_destroy();
}
define('LAUNCHING_LTI', true);

require_once 'common.inc.php';

$_SESSION['app']->handle_request();
