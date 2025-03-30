<?php
require '../databaseconnect.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {    
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo "<script>alert('Error: Email already in use. Please use a different one.'); window.history.back();</script>";
            exit();
        }
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);

        echo "<script>alert('Signup successful! Redirecting to login...'); window.location.href='login2.html';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>