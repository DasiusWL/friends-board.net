<?php
session_start();
require '../databaseconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM groups WHERE creator_id = ?");
$stmt->execute([$user_id]);
$created_group = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $conn->prepare("
    SELECT g.* FROM groups g
    JOIN group_memberships gm ON g.id = gm.group_id
    WHERE gm.user_id = ? AND g.creator_id != ?
");
$stmt->execute([$user_id, $user_id]);
$joined_groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends-Board</title>
    <link rel="stylesheet" href="yourgroups.css"></link>
</head>
<body>
<a class="logo" href="../index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m640-480 80 80v80H520v240l-40 40-40-40v-240H240v-80l80-80v-280h-40v-80h400v80h-40v280Zm-286 80h252l-46-46v-314H400v314l-46 46Zm126 0Z"/></svg>Friends-Board</a>
    <h1>Your Groups</h1>
    <hr>
    <h2>Created Groups</h2>
    <?php if ($created_group): ?>
        <div class="createdgroup">
            <div class="nameloc">
        <p class="groupname"><?= htmlspecialchars($created_group['name']) ?></p>
        <p>Location: <?= htmlspecialchars($created_group['location']) ?></p>
        </div>
        <a class="viewbtn" href="group.php?id=<?= $created_group['id'] ?>">View</a>
        <a class="deletebtn" href="delete_group.php?id=<?= $created_group['id'] ?>" onclick="return confirm('Delete this group?')">Delete</a>
        </div>
    <?php else: ?>
        <p>You haven't created a group yet.</p>
        <a class="create_btn"href="create_group.php">Create Group</a>
    <?php endif; ?>
    <hr>
    <h2>Joined Groups</h2>
    <?php if (count($joined_groups) === 0): ?>
        <p>You haven't joined any groups yet.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($joined_groups as $group): ?>
                <li>
                <div class="createdgroup">
                <div class="nameloc">
                <p class="groupname"> <?= htmlspecialchars($group['name']) ?><br> </p>
                <p>Location: <?= htmlspecialchars($group['location'])?></p>
                </div>
                <a class="viewbtn" href="group.php?id=<?= $group['id'] ?>">View</a>
                <a class="deletebtn" href="leave_group.php?id=<?= $group['id'] ?>" onclick="return confirm('Leave this group?')">Leave</a>
                
              </div>
                </li>
                <hr class="hrbetween">

            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>