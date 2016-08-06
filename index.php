<?php

require_once 'core/init.php';

$user = $db = Database::getInstance()->get('users', array('username', '=', 'adam'));

if (!$user->count()) {
	echo 'No users';
} else {
	echo 'ok';
}
