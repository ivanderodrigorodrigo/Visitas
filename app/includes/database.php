<?php

if(file_exists(__DIR__."/../../config/server.php")){
    require_once __DIR__."/../../config/server.php";
}


$host = DB_SERVER;
$db_name = DB_NAME; 
$username = DB_USER;
$password = DB_PASS;

// Create connection
$conn = mysqli_connect($host, $username, $password, $db_name);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>  