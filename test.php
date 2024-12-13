<?php
session_start();

$servername = "127.0.0.1";
$username = "u510162695_pig"; 
$password = "1Pigdatabase"; 
$dbname = "u510162695_pig"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to update phone number
$sql = "UPDATE admin SET phone = '09481765599' WHERE id = 1";

if ($conn->query($sql) === TRUE) {
    echo "Phone number updated successfully!";
} else {
    echo "Error updating phone number: " . $conn->error;
}

// Close connection
$conn->close();
?>
