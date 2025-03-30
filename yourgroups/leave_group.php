<?php
session_start();
require '../databaseconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $group_id = $_GET['id'];

    try {
        $check = $conn->prepare("SELECT * FROM group_memberships WHERE user_id = ? AND group_id = ?");
        $check->execute([$user_id, $group_id]);
        $isMember = $check->fetch();

        if ($isMember) {
            $stmt = $conn->prepare("DELETE FROM group_memberships WHERE user_id = ? AND group_id = ?");
            $stmt->execute([$user_id, $group_id]);

            echo "<script>alert('You have left the group.'); window.location.href='yourgroups.php';</script>";
            exit();
        } else {
            echo "<script>alert('You are not a member of this group.'); window.location.href='yourgroups.php';</script>";
            exit();
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='yourgroups.php';</script>";
    exit();
}
?>