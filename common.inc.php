<?php

require_once 'vendor/autoload.php';

session_start();

$secrets = new Battis\ConfigXML(__DIR__ . '/secrets.xml');

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

?>
