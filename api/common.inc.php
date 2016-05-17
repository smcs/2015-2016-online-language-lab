<?php

require_once __DIR__ . '/../common.inc.php';

define('PARAM_TYPE', 'type');
define('PARAM_CONTEXT', 'context');
define('PARAM_USER', 'user');
define('PARAM_GROUP', 'group');

define('TYPE_GROUP', 'group');
define('TYPE_CLASS', 'class');

define('API_KEY', 'api_key');
define('API_SESSION_ID', 'session_id');
define('API_SESSION_TOKEN', 'token');
define('API_DATABASE_ID', 'id');
define('API_GROUP_ID', 'group');

function requiredParameters($parameters) {
    $error = false;
    foreach ($parameters as $param) {
        if (empty($_REQUEST[$param])) {
            $smarty->addMessage("$param is a required parameter.");
            $error = true;
        }
    }
    if ($error) {
        $smarty->display('api/error.tpl');
        exit;
    }
}

function databaseError($line) {
    $smarty->appendMessage('Database error in ' . strtoupper(basename($_SERVER['SCRIPT_FILENAME'], '.php')) . ":$line");
    $smarty->display('api/error.tpl');
    exit;
}

function sendResponse($apiResponse) {
    header("Access-Control-Allow-Origin: {$_SERVER['SERVER_NAME']}");
    echo json_encode($apiResponse);
    exit;
}
