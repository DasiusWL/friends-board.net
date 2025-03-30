<?php
session_start();
require '../databaseconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    try {
        $stmt = $conn->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $stmt->execute([$username, $email, $user_id]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($existingUser) {
            echo "<script>alert('Username or email already exists. Please choose a different one.'); window.history.back();</script>";
            exit();
        }
        if (!empty($new_password)) {
            if ($new_password !== $confirm_password) {
                echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
                exit();
            }
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$username, $email, $hashed_password, $user_id]);
        } else {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            $stmt->execute([$username, $email, $user_id]);
        }
        $_SESSION['username'] = $username;

        echo "<script>alert('Account updated successfully!'); window.location.href='account.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error updating account: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>