<?php

require_once 'vendor/autoload.php';

$smarty = Battis\BootstrapSmarty\BootstrapSmarty::getSmarty();
$smarty->addTemplatesDir(__DIR__ . '/template');

?>