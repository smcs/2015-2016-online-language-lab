<?php
require_once 'common.inc.php';

$smarty->assign('fullname', $_SESSION['user']->fullname);
$smarty->display('StudentDashboard.tpl');
