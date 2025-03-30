<?php
session_start();
require '../databaseconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $conn->prepare("SELECT group_id FROM events WHERE id = ? AND created_by = ?");
        $stmt->execute([$event_id, $user_id]);
        $event = $stmt->fetch();

        if ($event && isset($event['group_id'])) {
            $delete = $conn->prepare("DELETE FROM events WHERE id = ?");
            $delete->execute([$event_id]);

            header("Location: group.php?id=" . $event['group_id']);
            exit();
        } else {
            echo "<script>alert('You are not allowed to delete this event.'); window.history.back();</script>";
            exit();
        }

    } catch (PDOException $e) {
        echo "Error deleting event: " . $e->getMessage();
        exit();
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
    exit();
}
?>