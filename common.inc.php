<?php

require_once 'vendor/autoload.php';

session_start();

$secrets = new Battis\ConfigXML(__DIR__ . '/secrets.xml');

$sql = $secrets->newInstanceOf(mysqli::class, '//mysql');

$smarty = Battis\BootstrapSmarty\BootstrapSmarty::getSmarty();
$smarty->addTemplateDir(__DIR__ . '/templates');

?>
