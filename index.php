<?php

require_once 'core/init.php';

$user = $db = Database::getInstance()->update('users', 2, [
	'password' => 'newpassword',
	'name' => 'Foo Bar'
]);