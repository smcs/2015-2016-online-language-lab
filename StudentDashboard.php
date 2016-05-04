<?php
require_once 'common.inc.php';

$smarty->assing('fullname', $_SESSION['user']->fullname);
$smarty->display('StudentDashboard.tpl');
