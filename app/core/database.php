<?php

class Database
{

	function __construct()
	{
		$this->db_connect();
		$this->createTables();
	}

	public function db_connect()
	{
		try {
			$string = DB_TYPE . ":host=" . DB_HOST . ";";
			$db = new PDO($string, DB_USER, DB_PASS);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);

			$db->exec("USE " . DB_NAME);
			return $db;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function createTables()
	{
		$this->createUsersTable();
		$this->createProductsTable();
		$this->createCartTable();
	}


	private function createUsersTable()
	{
		$query = "
		CREATE TABLE IF NOT EXISTS users (
			id BIGINT AUTO_INCREMENT PRIMARY KEY,
			url_address VARCHAR(60),
			username VARCHAR(50),
			password VARCHAR(64),
			email VARCHAR(100),
			date DATETIME
            )
			";

		$this->write($query);
	}

	private function createProductsTable()
	{
		$query = "
			CREATE TABLE IF NOT EXISTS products (
				id BIGINT AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(100),
				description TEXT,
				price DECIMAL(10, 2),
				count INT,
				country VARCHAR(60),
				category VARCHAR(200),
				path_image VARCHAR(1024)
				)
				";

		$this->write($query);
	}
	private function createCartTable()
	{
		$query = "CREATE TABLE IF NOT EXISTS cart (
					id BIGINT AUTO_INCREMENT PRIMARY KEY,
					product_id BIGINT,
					quantity INT,
					user_id BIGINT,
					FOREIGN KEY (product_id) REFERENCES products(id),
					FOREIGN KEY (user_id) REFERENCES users(id)
				)
			";
		$this->write($query);
	}



	public function read($query, $data = [])
	{

		$DB = $this->db_connect();
		$stm = $DB->prepare($query);

		if (count($data) == 0) {
			$stm = $DB->query($query);
			$check = 0;
			if ($stm) {
				$check = 1;
			}
		} else {

			$check = $stm->execute($data);
		}

		if ($check) {
			$data = $stm->fetchAll(PDO::FETCH_OBJ);
			if (is_array($data) && count($data) > 0) {
				return $data;
			}

			return false;
		} else {
			return false;
		}
	}
	public function write($query, $data = [])
	{

		$DB = $this->db_connect();
		$stm = $DB->prepare($query);

		if (count($data) == 0) {
			$stm = $DB->query($query);
			$check = 0;
			if ($stm) {
				$check = 1;
			}
		} else {

			$check = $stm->execute($data);
		}

		if ($check) {
			return true;
		} else {
			return false;
		}
	}
}
