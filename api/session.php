<?php

require_once 'common.inc.php';

use Battis\BootstrapSmarty\NotificationMessage;

$apiResponse = array();

/* sample API request might look like...

https://roswell.stmarksschool.org/~language-lab/api/session.php?type=main&class=unique-id

*/

/* what type of session to create? ($_REQUEST['type']) */
$type = trim(
	strtoupper(
		(empty($_REQUEST['type']) ? '' : $_REQUEST['type'])
	)
);
switch($type) {
	case 'GROUP':
		$type = 'GROUP';
		break;
	case 'MAIN':
	default:
		$type = 'MAIN';
		break;
}

/* create that type of session */
// TODO we probably need to set some configuration options
$session = $opentok->createSession();

/* store session data in db...
	if main session, it needs to be associated with this class ($_REQUEST['class']), store into sessions table with type 'main', replacing any other main sessions for this class (and disable/delete old group sessions for this class)
	if group session, it needs to be associated with this class ($_REQUEST['class']), store into sessions table with type 'group'
*/
if ($sql->query("
	INSERT INTO `sessions`
		(
			`tokbox`,
			`type`
		) VALUES (
			'" . $sql->escape_string($session->getSessionId()) . "',
			'" . $type . "'
		)
") === false) {
	$smarty->addMessage(
		"Database error {$sql->errno}",
		$sql->error,
		NotificationMessage::ERROR
	);
	$smarty->display('api/error.tpl');
	exit;
}

/* put together AJAX response with apiKey, sessionId, token parameters */
$apiResponse['apiKey'] = $secrets->toString('//opentok/key');
$apiResponse['sessionId'] = $session->getSessionId();
$apiResponse['token'] = $opentok->generateToken($session->getSessionId());
$apiResponse['type'] = $type;
$apiResponse['id'] = $sql->insert_id;

/* send AJAX response */
header("Access-Control-Allow-Origin: {$_SERVER['SERVER_NAME']}");
echo json_encode($apiResponse);
exit;
