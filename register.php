<?php

require_once 'core/init.php';

if (Input::exists()) {
	echo Input::get('username');
}

?>

<form action="" method="post" autocomplete="off">
	<div class="field">
		<label for="username">username</label>
		<input type="text" name="username" id="username" value="">
	</div>
	<div class="field">
		<label for="password">password</label>
		<input type="text" name="password" id="password" value="">
	</div>
	<div class="field">
		<label for="password_confirm">password_confirm</label>
		<input type="text" name="password_confirm" id="password_confirm" value="">
	</div>
	<div class="field">
		<label for="name">name</label>
		<input type="text" name="name" id="name" value="">
	</div>

	<input type="submit" value="Register">
</form>