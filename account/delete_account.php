<?php
session_start();
require '../databaseconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.html");
    exit();
}

try {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    session_destroy();
    echo "<script>alert('Your account has been deleted.'); window.location.href='../index.html';</script>";
} catch (PDOException $e) {
    echo "<script>alert('Error deleting account: " . $e->getMessage() . "'); window.history.back();</script>";
}
?>