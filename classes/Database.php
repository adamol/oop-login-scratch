<?php

class Database
{
	private static $_instance = null;
	private $_pdo;
	private $_query;
	private $_error = false;
	private $_results;
	private $_count = 0;

	private function __construct()
	{
		try {
			$this->_pdo = new PDO(
				'mysql:host='. Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'),
				Config::get('mysql/username'),
				Config::get('mysql/password')
			);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public static function getInstance()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new Database;
		}

		return self::$_instance;
	}
}