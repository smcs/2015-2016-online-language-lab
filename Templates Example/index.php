<?php

require 'vendor/autoload.php';

$smarty = Battis\BootstrapSmarty\BootstrapSmarty::getSmarty();
$smarty->addTemplateDir(__DIR__ . '/templates');

// ...do some stuff...

$smarty->assign('title', 'Whoopti-doo!');
$smarty->assign('paragraph', 'The quick brown fox jumps over the lazy dog.');
$smarty->assign('list', array(1, 1, 2, 3, 5, 8, 13, 21));
$smarty->display('example.tpl');
	
?>