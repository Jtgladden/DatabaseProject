<?php 

	function createDB($conn, $dbName) {
		$sql = "CREATE DATABASE $dbName";
		if ($conn->query($sql) === TRUE) {
		echo "Database created successfully";
		} else {
		echo "Error creating database: " . $conn->error;
		}
	}
	
	function createTable($conn, $tableName) {
		$sql = "CREATE TABLE $tableName (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		firstname VARCHAR(30) NOT NULL,
		lastname VARCHAR(30) NOT NULL,
		email VARCHAR(50),
		whenCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		lastUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)";
		
		if ($conn->query($sql) === TRUE) {
			echo "Table $tableName created successfully";
		} else {
			echo "Error creating table: " . $conn->error;
		}
	}
	
	function sqlQuery($conn, $sql) {
		if ($conn->query($sql) === TRUE) {
			echo "Table queried successfully";
		} else {
			echo "Error with query: " . $conn->error;
		}
	}
	
	function sqlInsert($conn, $sql) {
		if ($conn->query($sql) === TRUE) {
			$last_id = $conn->insert_id;
			//echo "Table queried successfully";
		} else {
			$last_id = 0;
			echo "Error with query: " . $conn->error;
		}
		return $last_id;
	}
	
	function preparedInsert($conn) {
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $firstname, $lastname, $email);

		// set parameters and execute
		$firstname = "John";
		$lastname = "Doe";
		$email = "john@example.com";
		$stmt->execute();

		$firstname = "Mary";
		$lastname = "Moe";
		$email = "mary@example.com";
		$stmt->execute();

		$firstname = "Julie";
		$lastname = "Dooley";
		$email = "julie@example.com";
		$stmt->execute();

		echo "New records created successfully";
	}