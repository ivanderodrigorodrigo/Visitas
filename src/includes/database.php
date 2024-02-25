<?php
$host = "localhost";
$db_name = "db_piis";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($host, $username, $password, $db_name);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>  