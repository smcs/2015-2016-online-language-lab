<?php

require_once 'common.inc.php';

$smarty->addStylesheet('../css/jquery-ui.min.css', 'jquery-ui');
$smarty->addStylesheet('../css/jquery-ui.structure.min.css', 'jquery-ui.structure');
$smarty->addStylesheet('../css/teacher.css', 'teacher');
$smarty->assign('id', (empty($_REQUEST['session']) ? '' : $_REQUEST['session']));
$smarty->display(basename(__DIR__) . '/' . basename(__FILE__, '.php') . '.tpl');
