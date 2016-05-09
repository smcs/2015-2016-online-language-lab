<?php
	
require_once 'common.inc.php';
$smarty->assign('name', 'API Error');
$smarty->assign('message', 'Undecipherable API request.');
$smarty->assign('dumps', array(
	'Endpoint: ' . preg_replace('%^.*(api/v1/[^\?]*)(\?.*)?$%', '$1', $_SERVER['REQUEST_URI']) ,
	'Params: ' . (empty($_REQUEST) ? 'none' : print_r($_REQUEST, true))	
));
$smarty->display('api/error.tpl');