<?php
require_once 'common.inc.php';

var_dump($_SESSION['consumer']);

/* do lots of other prep work before displaying */
$smarty->display('StudentDashboard.tpl');
