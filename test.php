<?php
session_start();

$servername = "127.0.0.1";
$username = "u510162695_pig"; 
$password = "1Pigdatabase"; 
$dbname = "u510162695_pig"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>