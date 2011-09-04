<?php
/*
 * Class that handles the database connections using MySqli
 */
class Db {
	private $connection;
	
	// Constructor
	public function __construct($host, $username, $password, $database) {
		$this->connection = new mysqli($host, $username, $password, $database);
	}
	
	// Performs an INSERT query
	public function insertData($query, $params) {
		foreach($params as $key => $value) {
			$query = str_replace('{' . $key . '}', str_replace("'", "''", $value), $query);
		}

		$this->connection->real_query($query);
	}
	
	// Performs a SELECT query and returns the entire result set as an array
	public function getData($query) {
		$data = array();
		
		if ($this->connection->real_query($query)) {
			if($result = $this->connection->use_result()) {
				while ($row = $result->fetch_array()) {
					array_push($data, $row);
				}
				
				$result->close();
			}
		}
		
		return $data;
	}
	
	// Retrieves the last inserted ID (auto increment) from the current connection
	public function getLastInsertedId() {
		return $this->connection->insert_id;
	}
	
	// Closes the current connection
	public function close() {
		$this->connection->close();
	}
}
?>