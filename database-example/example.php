<?php
	
require_once 'secrets.inc.php';

// open a connection to the database
$sql = new mysqli('localhost', $username, $password, $database);

// ask the database for some information
$result = $sql->query("SELECT * `users` WHERE `username` = 'minjaekim'");
$user = $result->fetch_assoc();

// use that information
if ($user['password'] == 'abc123') {
	echo 'yay!';
} else {
	echo 'boo!';
}