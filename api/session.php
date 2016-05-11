<?php

require_once 'common.inc.php';

use Battis\BootstrapSmarty\NotificationMessage;

$apiResponse = array();

/* sample API request might look like...

https://roswell.stmarksschool.org/~language-lab/api/session.php?type=main&class=unique-id

*/

/* what type of session to create? ($_REQUEST['type']) */
/* create that type of session */
/* store session data in db...
	if main session, it needs to be associated with this class ($_REQUEST['class']), store into sessions table with type 'main', replacing any other main sessions for this class (and disable/delete old group sessions for this class)
	if group session, it needs to be associated with this class ($_REQUEST['class']), store into sessions table with type 'group'
*/
/* put together AJAX response with apiKey, sessionId, token parameters */
/* send AJAX response */

if (empty($_REQUEST['id'])) {
	$session = $opentok->createSession();
	$result = $sql->query("
		INSERT INTO `sessions`
			(
				`creator`,
				`tokbox`
			)
			VALUES (
				'-1',
				'" . $sql->escape_string($session->getSessionId()) . "'
			)
	");
	if ($result == false) {
		$smarty->addMessage(
			"Database error {$sql->errno}",
			$sql->error,
			NotificationMessage::ERROR
		);
		$smarty->display('api/error.tpl');
	}
	$apiResponse['apiKey'] = $secrets->toArray('//opentok/key')[0][0];
	$apiResponse['sessionId'] = $session->getSessionId();
	$apiResponse['token'] = $opentok->generateToken($session->getSessionId());
	$apiResponse['id'] = $sql->insert_id;
} else {
	$response = $sql->query("
		SELECT *
			FROM `sessions`
			WHERE
				`id` = '" . $sql->escape_string($_REQUEST['id']) . "'
	");
	if ($response) {
		$session = $response->fetch_assoc();
		$apiResponse['apiKey'] = $secrets->toArray('//opentok/key')[0][0];
		$apiResponse['sessionId'] = $session['tokbox'];
		$apiResponse['token'] = $opentok->generateToken($session['tokbox']);
		$apiResponse['id'] = $session['id'];
	} else {
		$smarty->addMessage(
			"Database error {$sql->errno}",
			$sql->error,
			NotificationMessage::ERROR
		);
		$smarty->display('api/error.tpl');
	}
}

header("Access-Control-Allow-Origin: {$_SERVER['SERVER_NAME']}");
echo json_encode($apiResponse);
exit;
