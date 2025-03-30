<?php
session_start();
require '../databaseconnect.php';

$stmt = $conn->prepare("SELECT username, email, password FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends-Board</title>
    <link rel="stylesheet" href="account.css">
    <script src="account.js" defer></script>
</head>
<body>
<a class="logo" href="../index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m640-480 80 80v80H520v240l-40 40-40-40v-240H240v-80l80-80v-280h-40v-80h400v80h-40v280Zm-286 80h252l-46-46v-314H400v314l-46 46Zm126 0Z"/></svg>Friends-Board</a>
    <div class="account">
        <h2>Account-Details</h2>
        <form action="update_account.php" method="POST" onsubmit="return validatePasswords()">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <label>New Password:</label>
            <input type="password" id="new-password" name="new_password" placeholder="Enter new password">
            <label>Confirm New Password:</label>
            <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm new password">
            <button type="submit" class="update-btn">Update Account</button>
        </form>
        <form action="delete_account.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action can not be undone.')">
            <button type="submit" class="delete-btn">Delete Account</button>
        </form>
    </div>
</body>
</html>