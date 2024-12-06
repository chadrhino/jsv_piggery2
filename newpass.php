<?php
include 'setting/system.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the new password from the form
    $newPassword = htmlspecialchars(stripslashes(trim($_POST['new_password'])));

    // Hash the new password using bcrypt
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database where id = 1
    try {
        $updatePasswordQuery = $db->prepare("UPDATE admin SET password = :password WHERE id = 1");
        $updatePasswordQuery->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $updatePasswordQuery->execute();

        echo "Password updated successfully!";
    } catch (PDOException $e) {
        echo "Error updating password: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin Password</title>
</head>
<body>

    <h1>Update Admin Password</h1>

    <form method="post" action="">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required><br><br>
        
        <button type="submit">Update Password</button>
    </form>

</body>
</html>
