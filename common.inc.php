<?php

require_once __DIR__ . '/vendor/autoload.php';

use smtech\LanguageLab\Application;
use Battis\ConfigXML;
use OpenTok\OpenTok;
use smtech\StMarksSmarty\StMarksSmarty;

session_start();

$secrets = new ConfigXML(__DIR__ . '/secrets.xml');
$opentok = $secrets->newInstanceOf(OpenTok::class, '//tokbox');
$app = new Application($secrets->newInstanceOf(mysqli::class, '//mysql'));
$smarty = StMarksSmarty::getSmarty(__DIR__ . '/templates');
$smarty->setFramed(true);

$app->metadata['APP_URL'] = (
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
$smarty->assign('rootURL', $app->metadata['APP_URL']);
$smarty->assign('title', 'Language Lab | St. Mark&rsquo;s School');
$smarty->assign('category', 'Beta');
