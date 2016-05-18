<?php

require_once 'common.inc.php';

requiredParameters([PARAM_CONTEXT, PARAM_USER]);

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
    if ($classSession = $classSessions->fetch_assoc) {
        $apiResponse[API_DATABASE_ID] = $classSession['id'];
        $apiResponse[API_SESSION_ID] = $classSession['tokbox'];
    } else {
        $apiResponse = [];
    }
}
if (!empty($apiResponse[API_SESSION_ID])) {
    $apiResponse[API_KEY] = $_SESSION['app']->config->toString('//tokbox/key');
    $apiResponse[API_SESSION_TOKEN] = $_SESSION['app']->openTok->generateToken($apiResponse[API_SESSION_ID]);
}

sendResponse($apiResponse);
