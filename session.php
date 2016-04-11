<?php
	
require_once 'common.inc.php';

$smarty->assign('id', $_REQUEST['session']);
$smarty->display('session.tpl');