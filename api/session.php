<?php

require_once 'common.inc.php';

use Battis\BootstrapSmarty\NotificationMessage;

requiredParameters([PARAM_CONTEXT, PARAM_USER]);

/* default to TYPE_CLASS if none (or nonexistent) specified */
switch (trim(strtolower((empty($_REQUEST[PARAM_TYPE]) ? TYPE_CLASS : $_REQUEST[PARAM_TYPE])))) {
	case TYPE_GROUP:
		$type = TYPE_GROUP;
		break;
	case TYPE_CLASS:
	default:
		$type = TYPE_CLASS;
		if ($_SESSION['app']->sql->query("
			DELETE
				FROM `sessions`
				WHERE
					`context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "' AND
					`type` = '" . TYPE_CLASS . "'
		") === false) {
			databaseError(__LINE__);
		}
		break;
}

// TODO set teacher as moderator
$openTokSession = $_SESSION['app']->opentok->createSession();
if ($_SESSION['app']->sql->query("
	INSERT INTO `sessions`
		(
			`context`,
			`user`,
			`tokbox`
		) VALUES (
			'" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "',
			'" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_USER]) . "',
			'" . $_SESSION['app']->sql->escape_string($openTokSession->getSessionId()) . "'
		)
") === false) {
	databaseError(__LINE__);
}
$apiResponse[API_KEY] = $_SESSION['app']->config->toString('//tokbox/key');
$apiResponse[API_SESSION_ID] = $openTokSession->getSessionId();
$apiResponse[API_SESSION_TOKEN] = $_SESSION['app']->opentok->generateToken($openTokSession->getSessionId());
$apiResponse[API_DATABASE_ID] = $_SESSION['app']->sql->insert_id;

// TODO deal with residual group sessions (should probably be cleared when class session is created)
if ($type === TYPE_GROUP) {
	if ($_SESSION['app']->sql->query("
		INSERT INTO `groups`
			(
				`context`,
				`session`
			) VALUES (
				'" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "',
				'" . $apiResponse[API_DATABASE_ID] . "'
			)
	") === false) {
		databaseError(__LINE__);
	}
}

sendResponse($apiResponse);
