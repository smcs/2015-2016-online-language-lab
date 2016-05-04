<?php
require_once 'common.inc.php';

session_start();

var_dump($_SESSION['consumer']);

/* do lots of other prep work before displaying */
$smarty->display('StudentDashboard.tpl');
