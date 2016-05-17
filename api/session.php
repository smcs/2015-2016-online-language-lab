<?php

require_once 'common.inc.php';

use Battis\BootstrapSmarty\NotificationMessage;

define('PARAM_TYPE', 'type');
define('PARAM_CLASS', 'class');
define('PARAM_CREATOR', 'creator');

define ('TYPE_GROUP', 'group');
define ('TYPE_CLASS', 'class');

/* default to TYPE_CLASS if none (or nonexistent) specified */
switch (trim(strtolower((empty($_REQUEST[PARAM_TYPE]) ? TYPE_CLASS : $_REQUEST[PARAM_TYPE])))) {
	case TYPE_GROUP:
		$type = TYPE_GROUP;
		break;
	case TYPE_CLASS:
	default:
		$type = TYPE_CLASS;
		break;
}

$error = false;
if (empty($_REQUEST[PARAM_CLASS])) {
	$smarty->addMessage(PARAM_CLASS . ' is a required parameter');
	$error = true;
}
if (empty($_REQUEST[PARAM_CREATOR])) {
	$smarty->addMessage(PARAM_CREATOR . ' is a required parameter');
	$error = true;
}
if ($error) {
	$smarty->display('api/error.tpl');
	exit;
}

$apiResponse = array();
if (empty($_REQUEST['id'])) {
	$openTokSession = $_SESSION['app']->opentok->createSession();
	if ($_SESSION['app']->sql->query("
		INSERT INTO `sessions`
			(
				`creator`,
				`tokbox`
			)
			VALUES (
				'-1',
				'" . $_SESSION['app']->sql->escape_string($openTokSession->getSessionId()) . "'
			)
	") == false) {
		$smarty->addMessage(
			"Database error {$_SESSION['app']->sql->errno}",
			$_SESSION['app']->sql->error,
			NotificationMessage::ERROR
		);
		$smarty->display('api/error.tpl');
	}
	$apiResponse['apiKey'] = $_SESSION['app']->config->toArray('//tokbox/key')[0];
	$apiResponse['sessionId'] = $openTokSession->getSessionId();
	$apiResponse['token'] = $_SESSION['app']->opentok->generateToken($openTokSession->getSessionId());
	$apiResponse['id'] = $_SESSION['app']->sql->insert_id;
} else {
	$response = $_SESSION['app']->sql->query("
		SELECT *
			FROM `sessions`
			WHERE
				`id` = '" . $_SESSION['app']->sql->escape_string($_REQUEST['id']) . "'
	");
	if ($response) {
		$openTokSession = $response->fetch_assoc();
		$apiResponse['apiKey'] = $_SESSION['app']->config->toString('//tokbox/key');
		$apiResponse['sessionId'] = $openTokSession['tokbox'];
		$apiResponse['token'] = $_SESSION['app']->opentok->generateToken($openTokSession['tokbox']);
		$apiResponse['id'] = $openTokSession['id'];
	} else {
		$smarty->addMessage(
			"Database error {$_SESSION['app']->sql->errno}",
			$_SESSION['app']->sql->error,
			NotificationMessage::ERROR
		);
		$smarty->display('api/error.tpl');
	}
}

header("Access-Control-Allow-Origin: {$_SERVER['SERVER_NAME']}");
echo json_encode($apiResponse);
exit;
