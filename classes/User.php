<?php

class User
{
	private $_db;
	private $_data;
	private $_sessionName;

	public function __construct($user = null)
	{
		$this->_db = Database::getInstance();

		$this->_sessionName = Config::get('session/session_name');
	}

	public function create($fields = [])
	{
		if (!$this->_db->insert('users', $fields)) {
			throw new Exception('An error occurred while creating an account.');
		}
	}

	public function find($user = null)
	{
		if ($user) {
			// @TODO: FAILS WHEN USERNAME NUMBERS
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('users', [$field, '=', $user]);

			if ($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function login($username, $password)
	{
		$user = $this->find($username);
		
		if ($user && $this->data()->password === Hash::make($password, $this->data()->salt)) {
			Session::put($this->_sessionName, $this->data()->id);
			return true;
		}

		return false;	
	}

	public function data()
	{
		return $this->_data;
	}
}