<?php

require_once 'core/init.php';

if (Input::exists() && Token::check(Input::get('token'))) {
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
		$user = new User;
		$salt = Hash::salt(32);
		try {
			$user->create([
				'username' => Input::get('username'),
				'password' => Hash::make(Input::get('password'), $salt),
				'salt' => $salt,
				'name' => Input::get('name'),
				'joined' => date('Y-m-d H:i:s'),
				'group' => 1,
			]);
		} catch (Exception $e) {
			die($e->getMessage());
		}

		Session::flash('success', 'Registration was processed successfully.');
		Redirect::to('index.php');
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
	<div class="field">
		<label for="password_confirm">password_confirm</label>
		<input type="password" name="password_confirm" id="password_confirm" value="">
	</div>
	<div class="field">
		<label for="name">name</label>
		<input type="text" name="name" id="name" value="<?= escape(Input::get('name'));?>">
	</div>

	<input type="hidden" name="token" value="<?= Token::generate(); ?>">
	<input type="submit" value="Register">
</form>