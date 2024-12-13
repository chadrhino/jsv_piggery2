<?php
session_start();
require_once 'conn.php';

// Ensure the user has verified their OTP before proceeding
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header("Location: sms_send.php");
    exit();
}

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user input
    $newPassword = trim($_POST['new']);
    $confirmPassword = trim($_POST['confirm']);

    // Validate input
    if (strlen($newPassword) < 8) {
        $error = 'Password must be at least 8 characters long';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'Passwords do not match';
    } else {
        // Update password based on user session (admin or user)
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
            // Update admin password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $db->prepare("UPDATE admin SET password = :password WHERE id = :id");
            $updateStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $updateStmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        } else {
            // Update user password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
            $updateStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $updateStmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        }

        if ($updateStmt->execute()) {
            $success = "Password changed successfully. Redirecting in 3 seconds...";
            unset($_SESSION['otp_verified']); // Clear OTP session
            ?>
            <script>
                setTimeout(() => {
                    window.location.href = "index.php";
                }, 3000);
            </script>
            <?php
        } else {
            $error = 'Failed to update password. Please try again.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 400px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">Reset Your Password</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="new">New Password:</label>
            <input type="password" class="form-control" id="new" name="new" required placeholder="Enter new password" minlength="8">
        </div>
        <div class="form-group">
            <label for="confirm">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm" name="confirm" required placeholder="Confirm new password" minlength="8">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
    </form>
</div>

</body>
</html>
