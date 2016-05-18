<?php

session_start();

require_once 'vendor/autoload.php';

use OpenTok\OpenTok;

$secrets = new Battis\ConfigXML(__DIR__ . '/secrets.xml');

$opentok = $secrets->newInstanceOf(OpenTok::class, '//opentok');

$sql = $secrets->newInstanceOf(mysqli::class, '//mysql');

$smarty = Battis\BootstrapSmarty\BootstrapSmarty::getSmarty();
$smarty->assign(
    'rootURL',
    (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ?
        'http://' :
        'https://'
    ) .
    $_SERVER['SERVER_NAME'] .
    $_SERVER['CONTEXT_PREFIX'] .
    str_replace(
        $_SERVER['CONTEXT_DOCUMENT_ROOT'],
        '',
        __DIR__
    )
);
$smarty->addTemplateDir(__DIR__ . '/templates');

if (!isset($_SESSION['user'])&& !defined('LAUNCHING_LTI')) {
	$smarty->addMessage('Authentication Error', 'Failed to load user information.');
} elseif(!defined('LAUNCHING_LTI')) {
	$smarty->assign('context', $_SESSION['context']);
	$smarty->assign('user', $_SESSION['user']);
	$smarty->assign('firstName', $_SESSION['firstName']);
	$smarty->assign('lastName', $_SESSION['lastName']);
    $smarty->assign('fullName', $_SESSION['fullName']);
}
