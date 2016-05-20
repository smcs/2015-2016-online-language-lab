<?php

require_once 'common.inc.php';

/* do lots of other prep work before displaying */


$smarty->assign('id', (empty($_REQUEST['session']) ? '' : $_REQUEST['session']));
$smarty->display('teacherdash.tpl');
