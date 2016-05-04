<?php
require_once 'common.inc.php';

$smarty->assing('name', $_SESSION['user']->fullname);
$smarty->display('StudentDashboard.tpl');
