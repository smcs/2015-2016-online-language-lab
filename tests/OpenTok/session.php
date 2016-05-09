<?php
	
require_once 'common.inc.php';
$smarty->addStylesheet('css/session.css.php');
$smarty->assign('id', (empty($_REQUEST['session']) ? '' : $_REQUEST['session']));
$smarty->display('session.tpl');