<?php

require_once 'common.inc.php';

$smarty->addStylesheet('../css/student.css');
$smarty->assign('id', (empty($_REQUEST['session']) ? '' : $_REQUEST['session']));
$smarty->display(basename(__DIR__) . '/' . basename(__FILE__, '.php') . '.tpl');
