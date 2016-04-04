<?php

require_once 'common.inc.php';

/* do lots of other prep work before displaying */


$smarty->display('login.tpl');
+$sql->query("INSERT INTO `users` (`username`, `password`) VALUES ('" . time() . "', '" . md5(time()) . "')");