<?php

require_once __DIR__ . '/../common.inc.php';

define('PARAM_TYPE', 'type');
define('PARAM_CONTEXT', 'context');
define('PARAM_USER', 'user');
define('PARAM_USER_NAME', 'user_name');
define('PARAM_GROUP', 'group');
define('PARAM_ACTION', 'action');

define('TYPE_GROUP', 'group');
define('TYPE_CLASS', 'class');

define('ACTION_LIST', 'list');
define('ACTION_ADD', 'add');
define('ACTION_DELETE', 'delete');
define('ACTION_RESET', 'reset');

define('API_KEY', 'api_key');
define('API_SESSION_ID', 'session_id');
define('API_SESSION_TOKEN', 'token');
define('API_DATABASE_ID', 'id');
define('API_GROUP_ID', 'group');
define('API_USER_ID', 'user');
define('API_ACTION_RESULT', 'result');
define('API_MEMBERSHIP_ID', API_DATABASE_ID);

function requiredParameters($parameters) {
    global $smarty;
    $error = false;
    foreach ($parameters as $param) {
        if (empty($_REQUEST[$param])) {
            $smarty->addMessage("$param is a required parameter.");
            $error = true;
        }
    }
    if ($error) {
        $smarty->display('error.tpl');
        exit;
    }
}

function databaseError($line) {
    global $smarty;
    $smarty->addMessage('Database error in API ' . strtoupper(basename($_SERVER['SCRIPT_FILENAME'], '.php')) . ":$line");
    $smarty->display('error.tpl');
    exit;
}

function sendResponse($apiResponse) {
    header("Access-Control-Allow-Origin: {$_SERVER['SERVER_NAME']}");
    echo json_encode($apiResponse);
    exit;
}
