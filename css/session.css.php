<?php
	
require_once __DIR__ . '/../vendor/autoload.php';

use smtech\StMarksColors as SM;

header('Content-type: text/css');

?>

#carousel-publisher {
	border: solid 0.5em <?= SM::get(SM::STMARKS_BLUE)->light()->hex() ?>;
	border-radius: 0.5em;
}