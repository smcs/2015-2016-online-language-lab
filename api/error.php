<?php
	
require_once 'common.inc.php';

use Battis\BootstrapSmarty\NotificationMessage;

$smarty->addMessage(
	'API Error',
	'Undecipherable API request.
	
	Endpoint: `' . preg_replace('%^.*(api/v1/.*)(\?.*)?$%', '$1', $_SERVER['REQUEST_URI']) . '`
	Params: `' . (empty($_REQUEST) ? 'none' : print_r($_REQUEST, true)) . '`'
);
$smarty->display('api/error.tpl');