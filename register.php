<?php

require_once 'core/init.php';

if (Input::exists()) {
	// echo Input::get('username');
	$validate = new Validate();
	$validation = $validate->check($_POST, [
		'username' => [
			'required' => true,
			'min' => 2,
			'max' => 20,
			'unique' => 'users'
		],
		'password' => [
			'required' => true,
			'min' => 6
		],
		'password_confirm' => [
			'required' => true,
			'matches' => 'password'
		],
		'name' => [
			'required' => true,
			'min' => 6,
			'max' => 50
		],
	]);

	if ($validation->passed()) {
		echo 'passed';
		// register user
	} else {
		echo '<pre>' , print_r($validation->errors()), '</pre>';
		// output errors
		// leave some form data
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
	<div class="field">
		<label for="password_confirm">password_confirm</label>
		<input type="password" name="password_confirm" id="password_confirm" value="">
	</div>
	<div class="field">
		<label for="name">name</label>
		<input type="text" name="name" id="name" value="<?= escape(Input::get('name'));?>">
	</div>

	<input type="submit" value="Register">
</form>