<?php
	
require_once 'common.inc.php';
$response = $sql->query("
	SELECT *
		FROM `sessions`
");
$sessions = array();
if ($response) {
	while ($session = $response->fetch_assoc()) {
		$sessions[] = $session;
	}
}
$smarty->assign('sessions', $sessions);
$smarty->display('dashboard.tpl');