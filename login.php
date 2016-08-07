<?php

require_once 'core/init.php';

if (Input::exists() && Token::check(Input::get('token'))) {
	$validate = new Validate;
	$validation = $validate->check($_POST, [
		'username' => ['required' => true],
		'password' => ['required' => true],
	]);
	if ($validation->passed()) {
		$user = new User;
		$login = $user->login(Input::get('username'), Input::get('password'));
		if ($login) {
			echo 'Success';
		} else {
			echo 'Sorry, login failed.';
		}
	} else {
		echo '<pre>';
		print_r($validation->errors());
		echo '</pre>';
	}
}

?>

<form action="" method="post" autocomplete="off">
	<div class="field">
		<label for="username">username</label>
		<input type="text" name="username" id="username" value="<?= escape(Input::get('username'));?>">
	</div>
	<div class="field">
		<label for="password">password</label>
		<input type="password" name="password" id="password" value="">
	</div>

	<input type="hidden" name="token" value="<?= Token::generate(); ?>">
	<input type="submit" value="Login">
</form>