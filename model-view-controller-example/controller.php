<?php
	
require_once 'common.inc.php';

$model = new mysqli('localhost', $username, $password, $database);
$result = $model->query('SELECT * FROM `mvc-example`');
$data = array();
while ($row = $result->fetch_assoc()) {
	$data[] = $row;
}
$smarty->assign('data', $data);
$smarty->assign('row', $_REQUEST['row']);

$smarty->display('view.tpl');
