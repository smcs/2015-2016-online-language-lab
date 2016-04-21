<?php

require_once __DIR__ . '/vendor/autoload.php';

use Battis\ConfigXML;
use OpenTok\OpenTok;
use smtech\StMarksSmarty\StMarksSmarty;

$secrets = new ConfigXML(__DIR__ . '/secrets.xml');
$opentok = $secrets->newInstanceOf(OpenTok::class, '//tokbox');
$sql = $secrets->newInstanceOf(mysqli::class, '//mysql');
$smarty = StMarksSmarty::getSmarty(__DIR__ . '/templates');

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
$smarty->assign('title', 'Language Lab | St. Mark&rsquo;s School');
$smarty->assign('category', 'Beta');
