<?php
session_start();
require '../databaseconnect.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: yourgroups.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$group_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM groups WHERE id = ? AND creator_id = ?");
$stmt->execute([$group_id, $user_id]);
$group = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $conn->prepare("DELETE FROM groups WHERE id = ?");
$stmt->execute([$group_id]);

echo "<script>alert('Group deleted successfully.'); window.location.href='yourgroups.php';</script>";
?>