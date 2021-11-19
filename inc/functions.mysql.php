<?php

function createDB($conn, $dbName) {
		$sql = "CREATE DATABASE $dbName IF NOT EXISTS";
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
			echo $sql;
		}
	}
	
	function sqlInsert($conn, $sql) {
		if ($conn->query($sql) === TRUE) {
			$last_id = $conn->insert_id; //what is the last id we got
			//echo "Table queried successfully";
		} else {
			$last_id = 0;
			echo "Error with query: " . $conn->error;
		}
		return $last_id;
	}
	
	function select_return ($conn, $sql) {
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				return true;
			} else {
				return false;
			}
	}
	
	function returnExists ($conn, $sql) {
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
				//echo 'Success';
				return true;
			}
			} else {
			//echo "0 results";
			return false;
			}
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
	
	function check_login($conn, $username, $password) {
		$sql = "SELECT `id`, `username` FROM `sec_users` WHERE username='$username' AND `password`='$password'"; 
		
		$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$_SESSION['sessionID'] = $row['id'];
					return true;
				}
			} else {
				unset($_SESSION['sessionID']);
				return false;
			}
		return returnExists($conn, $sql);
	}