<?php

require 'vendor/autoload.php';

$smarty = Battis\BootstrapSmarty\BootstrapSmarty::getSmarty();

// ...do some stuff...

$smarty->assign('content', '<p>whatever content you want displayed</p>');
$smarty->display();
	
?>