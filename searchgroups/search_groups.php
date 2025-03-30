<?php
session_start();
require '../databaseconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$search_results = [];

$group_name = $_GET['group_name'] ?? '';
$location = $_GET['location'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "GET" && ($group_name || $location)) {
    $query = "
        SELECT * FROM groups 
        WHERE creator_id != ? 
        AND id NOT IN (SELECT group_id FROM group_memberships WHERE user_id = ?)
    ";
    $params = [$user_id, $user_id];

    if (!empty($group_name)) {
        $query .= " AND name LIKE ?";
        $params[] = '%' . $group_name . '%';
    }

    if (!empty($location)) {
        $query .= " AND location LIKE ?";
        $params[] = '%' . $location . '%';
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Friends-Board</title>
    <link rel="stylesheet" href="searchgroups.css">
</head>
<body>
    <a class="logo" href="../index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m640-480 80 80v80H520v240l-40 40-40-40v-240H240v-80l80-80v-280h-40v-80h400v80h-40v280Zm-286 80h252l-46-46v-314H400v314l-46 46Zm126 0Z"/></svg>Friends-Board</a>
    <h1>Search Groups</h1>
    <form method="GET" action="search_groups.php">
        <input type="text" name="group_name" placeholder="Group Name">
        <input type="text" name="location" placeholder="Location">
        <button class="search" type="submit">Search</button>
    </form>
    <hr>

    <?php if (!empty($search_results)): ?>
        <ul>
            <?php foreach ($search_results as $group): ?>
                <li>
                    <div class="name"><?= htmlspecialchars($group['name']) ?><br></div>
                    <?= htmlspecialchars(strlen($group['description']) > 50 ? substr($group['description'], 0, 50) . '...' : $group['description']) ?><br>
                    Location: <?= htmlspecialchars($group['location']) ?><br>
                    <form action="join_group.php" method="POST">
                        <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
                        <button class="join" type="submit">Join</button>
                    </form>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "GET"): ?>
        <p>No matching groups found.</p>
    <?php endif; ?>
</body>
</html>