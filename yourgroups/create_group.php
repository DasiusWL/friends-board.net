<?php
session_start();
require '../databaseconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT COUNT(*) FROM groups WHERE creator_id = ?");
$stmt->execute([$user_id]);
$hasGroup = $stmt->fetchColumn();

if ($hasGroup > 0) {
    echo "<script>alert('Only one group per User allowed.'); window.location.href='yourgroups.php';</script>";
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $groupName = $_POST['group_name'];
    $groupDesc = $_POST['group_description'];
    $location = $_POST['location'];

    if (empty($groupName)) {
        echo "<script>alert('Group name is required');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO groups (name, description, location, creator_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$groupName, $groupDesc, $location, $user_id]);
        

        echo "<script>alert('Group created successfully!'); window.location.href='yourgroups.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends-Board</title>
    <link rel="stylesheet" href="creategroup.css"></link>
</head>
<body>
<a class="logo" href="../index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m640-480 80 80v80H520v240l-40 40-40-40v-240H240v-80l80-80v-280h-40v-80h400v80h-40v280Zm-286 80h252l-46-46v-314H400v314l-46 46Zm126 0Z"/></svg>Friends-Board</a>
    <h1>Create a New Group</h1>
    <hr>
    <form method="POST" action="create_group.php">
        <label for="group_name">Group Name:</label><br>
        <input type="text" name="group_name" id="group_name" class="group_name" maxlength="35" placeholder="Insert Group Name(Max Lenght:35 Charachters)" required><br><br>
        <label for="group_description">Group Description:</label><br>
        <textarea name="group_description" id="group_description" class="group_desc" rows="5" cols="40" maxlength="300" placeholder="Insert Description (Max Lenght:300 Characters)"></textarea><br><br>
        <label for="location">Location:</label><br>
        <input type="text" id="location" name="location" class="group_loc" maxlength="20" required><br><br>
        <button class="button" type="submit">Create Group</button>
    </form>
    <br>
    <hr>
    <a class="backbtn" href="yourgroups.php">Back to Your Groups</a>
</body>
</html>