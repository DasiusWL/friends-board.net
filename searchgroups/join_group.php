<?php
session_start();
require '../databaseconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['group_id'])) {
    $group_id = $_POST['group_id'];
    $stmt = $conn->prepare("SELECT COUNT(*) FROM group_memberships WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $joined_count = $stmt->fetchColumn();

    if ($joined_count >= 3) {
        echo "<script>alert('You can only join up to 3 groups.'); window.location.href='search_groups.php';</script>";
        exit();
    }
    $stmt = $conn->prepare("SELECT * FROM groups WHERE id = ? AND creator_id = ?");
    $stmt->execute([$group_id, $user_id]);
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('You are the creator of this group.'); window.location.href='search_groups.php';</script>";
        exit();
    }
    $stmt = $conn->prepare("SELECT * FROM group_memberships WHERE user_id = ? AND group_id = ?");
    $stmt->execute([$user_id, $group_id]);
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Already joined this group.'); window.location.href='search_groups.php';</script>";
        exit();
    }
    $stmt = $conn->prepare("INSERT INTO group_memberships (user_id, group_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $group_id]);

    echo "<script>alert('Successfully joined the group!'); window.location.href='../yourgroups/yourgroups.php';</script>";
    exit();
}
?>