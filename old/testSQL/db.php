<?php
$servername = "localhost";
$username = "root";
$password = "4SQL$";
$dbname = "colors";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

//$conn->close();
?>

<!-- comment -->