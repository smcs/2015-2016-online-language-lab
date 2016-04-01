<?php
	
require_once 'secrets.inc.php';

// open a connection to the database
$sql = new mysqli('localhost', $username, $password, $database);
if ($sql->connect_error !== false) {
	echo $sql->connect_error;
}

// ask the database for some information
$result = $sql->query("SELECT * FROM `users` WHERE `username` = 'minjaekim'");
$user = $result->fetch_assoc();

// use that information
if ($user['password'] == 'abc123') {
	echo 'yay!';
} else {
	echo 'boo!';
}

// store some data in the database
$sql->query("INSERT INTO `users` (`username`, `password`) VALUES ('" . time() . "', '" . md5(time()) . "')");