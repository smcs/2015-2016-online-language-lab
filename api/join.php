<?php

/**
 * GET {language-lab instance url}/api/v1/join?context={LTI context ID}&user={LTI user ID}
 *
 * Returns
 * {
 * 	[api_key: {OpenTOK API key},
 * 	session_id: {OpenTok session ID},
 * 	token: {OpenTok subscriber token for `session_id`},
 * 	id: {Database ID for `session_id`}]
 * }
 */

require_once 'common.inc.php';

use OpenTok\Role;

requiredParameters([PARAM_CONTEXT, PARAM_USER, PARAM_USER_NAME]);

$apiResponse = [];

if (($groupSessions = $_SESSION['app']->sql->query("
    SELECT s.*
        FROM `group_memberships` AS m
            LEFT JOIN `groups` AS g ON m.`group` = g.`id`
            LEFT JOIN `sessions` AS s ON g.`session` = s.`id`
        WHERE
            m.`context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "' AND
            m.`user` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_USER]) . "'
        LIMIT 1
")) === false) {
    databaseError(__LINE__);
}
if ($group = $groupSessions->fetch_assoc()) {
    $apiResponse[API_DATABASE_ID] = $group['id'];
    $apiResponse[API_SESSION_ID] = $group['tokbox'];
} else {
    if (($classSessions = $_SESSION['app']->sql->query("
        SELECT *
            FROM `sessions`
            WHERE
                `type` = '" . TYPE_CLASS . "' AND
                `context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "'
            LIMIT 1
    ")) === false) {
        databaseError(__LINE__);
    }
    if ($classSession = $classSessions->fetch_assoc()) {
        $apiResponse[API_DATABASE_ID] = $classSession['id'];
        $apiResponse[API_SESSION_ID] = $classSession['tokbox'];
    } else {
        $apiResponse = [];
    }
}
if (!empty($apiResponse[API_SESSION_ID])) {
    $apiResponse[API_KEY] = $_SESSION['app']->config->toString('//tokbox/key');
    $apiResponse[API_SESSION_TOKEN] = $_SESSION['app']->opentok->generateToken(
        $apiResponse[API_SESSION_ID],
        [
            'role' => Role::PUBLISHER,
            'data' => json_encode([
                'context' => $_REQUEST[PARAM_CONTEXT],
                'user' => $_REQUEST[PARAM_USER],
                'user_name' => $_REQUEST[PARAM_USER_NAME]
            ])
        ]
    );
}

sendResponse($apiResponse);
