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

	public function query($sql, $params = [])
	{
		$this->_error = false;
		if ($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if (count($params)) {
				foreach ($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			if ($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}

		return $this;
	}

	private function action($action, $table, $where = [])
	{
		if (count($where) === 3) {
			$operators = ['=', '>', '<', '>=', '<='];

			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];

			if (in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if (!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		}

		return false;
	}

	public function get($table, $where)
	{
		return $this->action('SELECT *', $table, $where);
	}

	public function delete($table, $where)
	{
		return $this->action('DELETE', $table, $where);
	}

	public function error()
	{
		return $this->_error;
	}

	public function count()
	{
		return $this->_count;
	}
}