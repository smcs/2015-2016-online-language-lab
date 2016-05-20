<?php

require_once __DIR__ . '/vendor/autoload.php';

use smtech\LanguageLab\Application;
use smtech\StMarksSmarty\StMarksSmarty;

session_start();

$_SESSION['app'] = new Application(__DIR__ . '/secrets.xml');
$_SESSION['app']->metadata['APP_URL'] = (
	!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ?
		'http://' :
		'https://'
	) .
	$_SERVER['SERVER_NAME'] .
	$_SERVER['CONTEXT_PREFIX'] .
	str_replace(
		$_SERVER['CONTEXT_DOCUMENT_ROOT'],
		'',
		__DIR__
);

$smarty = StMarksSmarty::getSmarty(__DIR__ . '/templates');
$smarty->setFramed(true);

$smarty->assign('rootURL', $_SESSION['app']->metadata['APP_URL']);
$smarty->assign('title', 'Language Lab | St. Mark&rsquo;s School');
$smarty->assign('category', 'Beta');
$smarty->addStylesheet('../css/language-lab.css', 'language-lab');

if (!isset($_SESSION['user'])&& !defined('LAUNCHING_LTI')) {
	$smarty->addMessage('Authentication Error');
	$smarty->display('error.tpl');
	exit;
} elseif(!defined('LAUNCHING_LTI')) {
	$smarty->assign('context', $_SESSION['user']->getResourceLink()->lti_context_id);
	$smarty->assign('user', $_SESSION['user']->getId());
	$smarty->assign('firstName', $_SESSION['user']->firstname);
	$smarty->assign('lastName', $_SESSION['user']->lastname);
	$smarty->assign('fullName', $_SESSION['user']->fullname);
}
