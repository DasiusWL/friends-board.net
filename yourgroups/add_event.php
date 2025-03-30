<?php
session_start();
require '../databaseconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.html");
    exit();
}
$user_id = $_SESSION['user_id'];
$group_id = $_POST['group_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$event_time = $_POST['event_time'];
$stmt = $conn->prepare("
    SELECT * FROM groups 
    WHERE id = ? AND (creator_id = ? 
    OR id IN (SELECT group_id FROM group_memberships WHERE user_id = ?))
");
$stmt = $conn->prepare("SELECT COUNT(*) FROM events WHERE group_id = ?");
$stmt->execute([$group_id]);
$eventCount = $stmt->fetchColumn();
$maxEvents = 5;
if ($eventCount >= $maxEvents) {
    echo "<script>alert('This group has reached the maximum number of events allowed.'); window.location.href='group.php?id=$group_id';</script>";
    exit();
}


$stmt = $conn->prepare("INSERT INTO events (group_id, title, description, event_time, created_by) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$group_id, $title, $description, $event_time, $user_id]);

header("Location: group.php?id=$group_id");
exit();
?>