<?php
require_once 'test.php';

$phone = '09481765599';


$sql = "INSERT INTO admin (phone) VALUES (?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $phone);
    if ($stmt->execute()) {
        echo "Phone number inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
