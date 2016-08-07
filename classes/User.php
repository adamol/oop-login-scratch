<?php

class User
{
	private $_db;

	public function __construct($user = null)
	{
		$this->_db = Database::getInstance();
	}

	public function create($fields = [])
	{
		if (!$this->_db->insert('users', $fields)) {
			throw new Exception('An error occurred while creating an account.');
		}
	}
}