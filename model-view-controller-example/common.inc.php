<?php
	
require_once __DIR__ . '/../Language\ Lab\ v1/vendor/autoload.php';
require_once __DIR__ . '/../database-example/secrets.inc.php';

$smarty = Battis\BootstrapSmarty\BootstrapSmarty::getSmarty();
$smarty->addTemplateDir(__DIR__ . '/templates');